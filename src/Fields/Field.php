<?php

namespace Farouter\Fields;

use Farouter\Traits\Makeable;
use Illuminate\Support\Str;
use JsonSerializable;

/**
 * Abstract base class for defining a field.
 *
 * Provides functionality for rendering, resolving values, and serializing fields for the frontend.
 *
 * @property string $component The field's component identifier, used for rendering on the frontend.
 * @property string $name The displayable name of the field.
 * @property string $attribute The underlying attribute or column name associated with the field.
 * @property mixed $value The resolved value of the field from the resource.
 * @property ?string $placeholder The placeholder text for the field (optional).
 */
abstract class Field implements JsonSerializable
{
    use Makeable;

    /**
     * The field's component identifier for rendering.
     */
    public string $component;

    /**
     * The displayable name of the field.
     */
    public string $name;

    /**
     * The attribute or column name associated with the field.
     */
    public string $attribute;

    /**
     * The resolved value of the field from the resource.
     */
    public mixed $value = null;

    /**
     * The placeholder text for the field.
     */
    public ?string $placeholder = null;

    /**
     * Create a new field instance.
     *
     * @param  string  $name  The displayable name of the field.
     * @param  ?string  $attribute  The attribute or column name (optional). Defaults to a slugified version of the name.
     */
    public function __construct(string $name, ?string $attribute = null)
    {
        $this->name = $name;
        $this->attribute = $attribute ?? str_replace(' ', '_', Str::lower($name));
    }

    /**
     * Resolve the field's value from the given resource.
     *
     * @param  object  $resource  The resource object containing the field's data.
     */
    public function resolve($resource): void
    {
        $this->value = $resource->{$this->attribute};
    }

    /**
     * Prepare the field for JSON serialization.
     *
     * @return array<string, mixed> The field's data for JSON output.
     */
    public function jsonSerialize(): array
    {
        return [
            'component' => $this->component,
            'name' => $this->name,
            'attribute' => $this->attribute,
            'value' => $this->value,
        ];
    }
}
