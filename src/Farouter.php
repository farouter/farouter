<?php

namespace Farouter;

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
            // Отримати ім'я класу на основі шляху
            $className = $resourceNamespace.'\\'.pathinfo($file, PATHINFO_FILENAME);

            // Перевірити, чи клас існує та чи має статичну властивість $model
            if (class_exists($className) && property_exists($className, 'model')) {
                // Отримати значення статичної властивості $model
                $resourceModel = $className::$model;

                // Перевірити, чи збігається модель
                if ($resourceModel === get_class($model)) {
                    return $className;
                }
            }
        }

        // Повертаємо null, якщо ресурс не знайдено
        return null;
    }
}
