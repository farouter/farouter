<?php

namespace Farouter\Configuration;

use Farouter\Models\Node as NodeModel;

/**
 * Abstract class Node
 *
 * This class provides a base implementation for Node configurations.
 * Each specific Node configuration should extend this class and implement the abstract methods.
 */
abstract class Node
{
    /**
     * A unique key identifier for the Node.
     * This should be set in the child class to distinguish the Node type.
     */
    public static string $key;

    /**
     * Constructor for the Node configuration.
     *
     * @param  NodeModel  $node  The Node model instance associated with this configuration.
     */
    public function __construct(
        public NodeModel $node,
    ) {}

    /**
     * Define the controller configuration for the Node.
     *
     * This method can be overridden by child classes to return specific controller-related configurations.
     *
     * @return array An empty array by default; child classes can provide their own implementation.
     */
    public function controller(): array
    {
        return [];
    }

    /**
     * Define the dependencies required by the Node.
     *
     * This abstract method must be implemented by any class extending this base class.
     * It should return an array of dependencies required for the Node to function.
     *
     * @return array An array of dependencies.
     */
    abstract public function dependencies(): array;
}
