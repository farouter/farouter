<?php

namespace Farouter\Models;

use App\Farouter\Locale;
use Farouter\Traits\LoadsRelationsWithoutRecursion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;
use Whitecube\LaravelTimezones\Casts\TimezonedDatetime;

abstract class Nodeable extends Model
{
    use LoadsRelationsWithoutRecursion;

    protected static array $translatable = [];

    protected array $loadedTranslations = []; // Кеш перекладів

    /**
     * Temporary variable to store the parent node instance during model creation.
     *
     * This is used to set the `parent_id` for the automatically created node.
     */
    protected ?Node $__creatingParentNode = null;

    /**
     * Temporary variable to store the solid value during creation.
     */
    protected static ?string $__solid = null;

    /**
     * Constructor of the model.
     * Automatically adds the `parentNode` attribute to `$fillable` for all child models.
     *
     * @param  array  $attributes  Attributes passed for model initialization.
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Dynamically add `parentNode` to the fillable attributes
        if (! in_array('parentNode', $this->fillable)) {
            $this->fillable[] = 'parentNode';
        }
    }

    /**
     * Adds a solid value for the node during creation.
     */
    public static function solid(string $value): static
    {
        static::$__solid = $value;

        return new static;
    }

    /**
     * Визначає відносини, які повинні завантажуватись завжди.
     *
     * @var array
     */
    protected $defaultRelations = [
        'node',
    ];

    /**
     * Boot method to initialize model events.
     *
     * This method:
     * - Handles the `parentNode` attribute before the model is created.
     * - Automatically creates an associated node after the model is created.
     */
    protected static function boot(): void
    {
        parent::boot();

        // Automatically add the `node` relation to all queries
        // static::addGlobalScope('withNode', function (Builder $builder) {
        //     $builder->with('node');
        // });

        static::creating(function (Model $model): void {
            DB::transaction(function () use ($model) {
                // Check if `parentNode` was passed during model creation
                if (array_key_exists('parentNode', $model->getAttributes())) {
                    $parentNode = $model->getAttribute('parentNode');

                    // Handle different types of `parentNode` inputs
                    if ($parentNode instanceof Node) {
                        // Direct Node instance
                        $model->__creatingParentNode = $parentNode;
                    } elseif ($parentNode instanceof Model && method_exists($parentNode, 'node')) {
                        // Check if the `node` relationship is loaded
                        if ($parentNode->relationLoaded('node')) {
                            $model->__creatingParentNode = $parentNode->node;
                        } else {
                            // Throw an exception if the relationship is not loaded
                            throw new RuntimeException(
                                sprintf(
                                    "The 'node' relationship for the model '%s' is not loaded. Consider using eager loading.",
                                    get_class($parentNode)
                                )
                            );
                        }
                    }

                    // Remove `parentNode` from attributes to prevent saving it to the database
                    unset($model->attributes['parentNode']);
                }

                // Use the solid value and then reset it
                $model->createNode(static::$__solid);
                static::$__solid = null; // Reset for future usage
            });
        });
    }

    /**
     * Creates and associates a node (Node) for the current model.
     *
     * This method:
     * - Generates a `slug` for the node based on the model's `getSlugSource` method.
     * - Links the node to its parent (if provided).
     * - Saves the node in the database.
     */
    public function createNode(?string $solid = null): void
    {
        $node = new Node([
            'nodeable_type' => static::class,
            'nodeable_id' => $this->getKey(),
            'parent_id' => $this->__creatingParentNode?->id,
            'solid' => $solid, // Assign solid to 'solid' field
        ]);

        // Pass the parent instance to avoid extra database queries
        $node->setParentNode($this->__creatingParentNode);

        try {
            $node->save();
        } catch (QueryException $e) {
            // Викидаємо виключення, щоб зупинити виконання
            throw new RuntimeException('Node creation failed due to unique constraint violation.');
        }
    }

    /**
     * Реляція з таблицею translations.
     */
    public function translations(): MorphMany
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    /**
     * Завантаження перекладів для поточної локалі.
     */
    public function loadTranslations(Locale $locale): void
    {
        if (! isset($this->loadedTranslations[$locale->value])) {
            $this->loadedTranslations[$locale->value] = $this->translations()
                ->where('locale', $locale->value)
                ->get()
                ->pluck('value', 'attribute')
                ->toArray();
        }
    }

    /**
     * Отримання перекладу для конкретного атрибута.
     */
    public function translate(string $field, Locale $locale): ?string
    {
        if (! isset($this->loadedTranslations[$locale->value])) {
            $this->loadTranslations($locale);
        }

        return $this->loadedTranslations[$locale->value][$field] ?? null;
    }

    protected function setTranslationsBatch(string $key, string $value, array $locales): void
    {
        $translations = [];
        $timestamp = now();

        foreach ($locales as $localeEnum) {
            $translations[] = [
                'id' => Str::uuid(),
                'translatable_type' => $this->getMorphClass(),
                'translatable_id' => $this->getKey(),
                'locale' => $localeEnum->value,
                'attribute' => $key,
                'value' => $value,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        }

        // Використання `upsert` для збереження перекладів (Laravel 8+)
        DB::table('translations')->upsert(
            $translations,
            ['translatable_type', 'translatable_id', 'locale', 'attribute'], // Унікальні поля
            ['value', 'updated_at'] // Поля для оновлення
        );

        // Оновлення кешу локалізованих даних
        foreach ($locales as $localeEnum) {
            $this->loadedTranslations[$localeEnum->value][$key] = $value;
        }
    }

    /**
     * Збереження перекладу для конкретного атрибута.
     */
    public function setTranslation(string $field, string $value, Locale $locale): void
    {
        $this->translations()->updateOrCreate(
            ['attribute' => $field, 'locale' => $locale->value],
            ['value' => $value]
        );

        $this->loadedTranslations[$locale->value][$field] = $value;
    }

    /**
     * Масове збереження перекладів.
     */
    public function setTranslations(array $translations): void
    {
        $batchInsert = [];
        foreach ($translations as $field => $values) {
            if (is_array($values) && in_array($field, $this->translatable)) {
                foreach ($values as $locale => $value) {
                    $localeEnum = $locale instanceof Locale ? $locale : Locale::from($locale);
                    $batchInsert[] = [
                        'translatable_type' => $this->getMorphClass(),
                        'translatable_id' => $this->getKey(),
                        'locale' => $localeEnum->value,
                        'attribute' => $field,
                        'value' => $value,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        if (! empty($batchInsert)) {
            DB::table('translations')->insert($batchInsert);
        }
    }

    /**
     * Перехоплення доступу до локалізованих атрибутів.
     */
    public function __get($key)
    {
        // Перевіряємо, чи ключ є локалізованим атрибутом
        if (isset(static::$translatable) && in_array($key, static::$translatable)) {
            // Отримуємо поточну локаль
            $localeString = app()->getLocale(); // Поточна локаль як рядок (наприклад, 'en')
            $localeEnum = Locale::fromString(strtoupper($localeString)); // Конвертуємо в Enum

            // Повертаємо переклад
            return $this->translate($key, $localeEnum);
        }

        // Якщо атрибут не локалізований, викликаємо стандартний доступ
        return parent::__get($key);
    }

    /**
     * Перехоплення встановлення локалізованих атрибутів.
     */
    public function __set($key, $value)
    {
        // Перевіряємо, чи є ключ локалізованим атрибутом
        if (isset(static::$translatable) && in_array($key, static::$translatable)) {
            if (is_array($value)) {
                // Якщо значення передано як масив локалей
                foreach ($value as $locale => $translationValue) {
                    $localeEnum = $locale instanceof Locale ? $locale : Locale::from($locale);
                    $this->setTranslation($key, $translationValue, $localeEnum);
                }
            } else {
                $this->setTranslationsBatch($key, $value, Locale::cases());
            }
        } else {
            // Якщо атрибут не є локалізованим, використовуємо стандартну логіку
            parent::__set($key, $value);
        }
    }

    public static function create(array $attributes = [])
    {
        // Витягуємо локалізовані дані
        $translatableData = array_intersect_key(
            $attributes,
            array_flip(static::$translatable ?? [])
        );

        // Видаляємо локалізовані дані з основного масиву
        foreach ($translatableData as $key => $value) {
            unset($attributes[$key]);
        }

        // Створюємо модель
        $model = static::query()->create($attributes);

        // Обробка локалізованих даних
        foreach ($translatableData as $field => $translations) {
            if (! is_array($translations)) {
                // Якщо значення не є масивом, створюємо записи для всіх локалей
                $model->setTranslationsBatch($key, $value, Locale::cases());
            } else {
                // Якщо значення є масивом, обробляємо його як набір перекладів
                foreach ($translations as $locale => $value) {
                    $localeEnum = $locale instanceof Locale ? $locale : Locale::from($locale);
                    $model->setTranslation($field, $value, $localeEnum);
                }
            }
        }

        return $model;
    }

    public function update(array $attributes = [], array $options = [])
    {
        // Витягуємо локалізовані атрибути
        $translatableData = array_intersect_key(
            $attributes,
            array_flip(static::$translatable ?? [])
        );

        // Видаляємо локалізовані атрибути з основного масиву
        foreach ($translatableData as $key => $value) {
            unset($attributes[$key]);
        }

        // Оновлюємо звичайні атрибути
        $updated = parent::update($attributes, $options);

        // Оновлюємо локалізовані атрибути
        foreach ($translatableData as $field => $translations) {
            if (! is_array($translations)) {
                // Якщо значення не є масивом, зберігаємо для поточної локалі
                $this->setTranslationsBatch($key, $value, Locale::cases());
            } else {
                // Якщо значення є масивом, зберігаємо для відповідних локалей
                foreach ($translations as $locale => $value) {
                    $localeEnum = $locale instanceof Locale ? $locale : Locale::from($locale);
                    $this->setTranslation($field, $value, $localeEnum);
                }
            }
        }

        return $updated;
    }

    /**
     * Get the attributes that should be cast.
     *
     * Casts timestamps to timezone-aware DateTime objects using TimezonedDatetime.
     *
     * @return array<string, string> The array of attributes and their corresponding casts.
     */
    protected function casts(): array
    {
        return [
            'created_at' => TimezonedDatetime::class,
            'updated_at' => TimezonedDatetime::class,
            'deleted_at' => TimezonedDatetime::class,
        ];
    }

    /**
     * Defines a polymorphic relationship with a node (Node).
     *
     * Each model extending BaseModel will have a corresponding node automatically created.
     */
    public function node(): MorphOne
    {
        return $this->morphOne(Node::class, 'nodeable');
    }
}
