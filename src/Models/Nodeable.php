<?php

namespace Farouter\Models;

use Farouter\Traits\LoadsRelationsWithoutRecursion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Whitecube\LaravelTimezones\Casts\TimezonedDatetime;

abstract class Nodeable extends Model
{
    use LoadsRelationsWithoutRecursion;

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
