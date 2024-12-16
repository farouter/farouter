<?php

namespace Farouter\Configuration;

use Farouter\Http\Requests\FarouterRequest;
use JsonSerializable;

/**
 * Abstract class representing a resource configuration.
 *
 * This class defines the structure and behavior of a resource
 * that can be serialized into JSON and used in the Farouter system.
 */
abstract class Resource implements JsonSerializable
{
    /**
     * The underlying nodeable model associated with the resource.
     *
     * @var mixed|null
     */
    public $nodeable;

    /**
     * The default attribute to be used as the title of the resource.
     */
    public static string $title = 'id';

    /**
     * Whether the resource should be displayed in navigation menus.
     */
    public static bool $displayInNavigation = true;

    /**
     * The fields associated with the resource.
     */
    public array $fields;

    /**
     * Constructor for the Resource class.
     *
     * @param  mixed|null  $nodeable  The nodeable model associated with the resource.
     */
    public function __construct($nodeable = null)
    {
        $this->nodeable = $nodeable;

        // Initialize fields by calling the fields() method with the resolved request.
        $this->fields = $this->fields(resolve(FarouterRequest::class));
    }

    /**
     * Get the title of the resource based on the nodeable model.
     *
     * @return string The title value as a string.
     */
    public function title(): string
    {
        return (string) data_get($this->nodeable, static::$title);
    }

    /**
     * Get the subtitle of the resource.
     *
     * This method can be overridden by subclasses to provide additional details.
     *
     * @return mixed|null The subtitle of the resource.
     */
    public function subtitle()
    {
        //
    }

    /**
     * Get the controller configuration for the resource.
     *
     * This method can be overridden by subclasses to define custom controller settings.
     *
     * @return array The controller configuration.
     */
    public function controller(): array
    {
        return [];
    }

    /**
     * Define the fields associated with the resource.
     *
     * This method must be implemented by subclasses.
     *
     * @param  FarouterRequest  $request  The current request instance.
     * @return array The array of fields for the resource.
     */
    abstract public function fields(FarouterRequest $request): array;

    /**
     * Define the dependencies required by the resource.
     *
     * This method must be implemented by subclasses.
     *
     * @return array The array of resource dependencies.
     */
    abstract public function dependencies(): array;

    /**
     * Prepare the resource for JSON serialization.
     *
     * Automatically resolves field values if a nodeable model is present.
     *
     * @return array<string, mixed> The resource's data for JSON output.
     */
    public function jsonSerialize(): array
    {
        if ($this->nodeable) {
            foreach ($this->fields as $field) {
                // Resolve each field's value based on the nodeable model.
                $field->resolve($this->nodeable);
            }
        }

        return [
            'title' => $this->title(),
            'fields' => $this->fields,
        ];
    }
}
