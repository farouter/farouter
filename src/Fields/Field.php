<?php

namespace Farouter\Fields;

use Farouter\Makeable;
use Illuminate\Support\Str;
use JsonSerializable;

#[\AllowDynamicProperties]
abstract class Field implements JsonSerializable
{
    use Makeable;

    /**
     * The displayable name of the field.
     */
    public string $name;

    /**
     * The attribute / column name of the field.
     */
    public string $attribute;

    /**
     * The field's resolved value.
     */
    public mixed $value = null;

    /**
     * The callback to be used to resolve the field's value.
     */
    public mixed $resolveCallback;

    /**
     * The callback to be used for the field's default value.
     */
    protected mixed $defaultCallback;

    /**
     * The callback used to determine if the field is readonly.
     */
    public mixed $readonlyCallback;

    /**
     * The callback used to determine if the field is required.
     */
    public mixed $requiredCallback;

    /**
     * The resource associated with the field.
     */
    public mixed $resource;

    /**
     * Indicates whether the field is visible.
     */
    public bool $visible = true;

    /**
     * The placeholder for the field.
     *
     * @var string|null
     */
    public $placeholder;

    /**
     * The field's component.
     */
    public string $component;

    /**
     * Create a new field.
     *
     * @param  string  $name
     * @param  string|\Closure|callable|object|null  $attribute
     * @param  (callable(mixed, mixed, ?string):(mixed))|null  $resolveCallback
     * @return void
     */
    public function __construct($name, $attribute = null, ?callable $resolveCallback = null)
    {
        $this->name = $name;
        $this->resolveCallback = $resolveCallback;

        $this->default(null);

        $this->attribute = $attribute ?? str_replace(' ', '_', Str::lower($name));
    }

    /**
     * Set the callback to be used for determining the field's default value.
     *
     * @param  (\Closure(\Laravel\Nova\Http\Requests\NovaRequest):(mixed))|mixed  $callback
     * @return $this
     */
    public function default($callback)
    {
        $this->defaultCallback = $callback;

        return $this;
    }

    /**
     * Set the value for the field.
     */
    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }

    /**
     * Get the component name for the field.
     *
     * @return string
     */
    public function component()
    {
        return $this->component;
    }

    /**
     * Prepare the field for JSON serialization.
     */
    public function jsonSerialize(): array
    {
        return [
            'attribute' => $this->attribute,
            'component' => $this->component(),
            'name' => $this->name,
            'placeholder' => $this->placeholder,
            'uniqueKey' => sprintf(
                '%s-%s',
                $this->attribute,
                $this->component(),
            ),
            'value' => $this->value,
        ];
    }
}
