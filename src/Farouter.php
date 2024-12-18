<?php

namespace Farouter;

use Farouter\Models\Node;
use Farouter\Models\Nodeable;

class Farouter
{
    /**
     * Resolve the resource class associated with the given model.
     *
     * @return string|null
     */
    public static function resolveResourceForModel(Nodeable $model)
    {
        // Шлях до директорії ресурсів
        $resourceNamespace = 'App\\Farouter\\Resources';
        $resourcePath = app_path('Farouter/Resources');

        // Знайти всі PHP файли у директорії ресурсів
        $resourceFiles = glob($resourcePath.'/*.php');

        foreach ($resourceFiles as $file) {
            // Get the class name based on the file path
            $className = $resourceNamespace.'\\'.pathinfo($file, PATHINFO_FILENAME);

            // Check if the class exists and is not abstract
            if (class_exists($className)) {
                $reflection = new \ReflectionClass($className);

                if ($reflection->isAbstract()) {
                    continue;
                }

                // Check for the 'model' property and compare it with the model class
                if ($reflection->hasProperty('model')) {
                    $property = $reflection->getProperty('model');

                    if ($property->isStatic()) {
                        $resourceModel = $property->getValue();

                        if ($resourceModel === get_class($model)) {
                            return $className;
                        }
                    }
                }
            }
        }

        // Повертаємо null, якщо ресурс не знайдено
        return null;
    }

    /**
     * Resolve the resource class associated with the given model.
     */
    public static function resolveSolidForNode(Node $node): ?string
    {
        if (! $node->solid) {
            return null;
        }

        // Шлях до директорії вузлів
        $nodeNamespace = 'App\\Farouter\\Nodes';
        $nodePath = app_path('Farouter/Nodes');

        // Знайти всі PHP файли у директорії вузлів
        $nodeFiles = glob($nodePath.'/*.php');

        foreach ($nodeFiles as $file) {
            // Get the class name based on the file path
            $className = $nodeNamespace.'\\'.pathinfo($file, PATHINFO_FILENAME);

            // Check if the class exists and is not abstract
            if (class_exists($className)) {
                $reflection = new \ReflectionClass($className);

                if ($reflection->isAbstract()) {
                    continue;
                }

                // Use ReflectionProperty to access the static 'key' property
                if ($reflection->hasProperty('key')) {
                    $property = $reflection->getProperty('key');

                    if ($property->isStatic()) {
                        $resourceKey = $property->getValue();

                        if ($resourceKey === $node->solid) {
                            return $className;
                        }
                    }
                }
            }
        }

        // Повертаємо null, якщо ресурс не знайдено
        return null;
    }
}
