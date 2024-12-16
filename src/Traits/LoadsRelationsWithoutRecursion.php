<?php

namespace Farouter\Traits;

trait LoadsRelationsWithoutRecursion
{
    /**
     * Контроль рекурсивного завантаження.
     *
     * @var bool
     */
    protected static $preventRecursion = false;

    /**
     * Викликається після отримання моделі.
     */
    protected static function bootLoadsRelationsWithoutRecursion()
    {
        static::retrieved(function ($model) {
            $model->initializeWithRelations();
        });
    }

    /**
     * Завантаження відносин без рекурсії.
     */
    protected function initializeWithRelations()
    {
        if (! static::$preventRecursion) {
            static::$preventRecursion = true;

            foreach ($this->getDefaultRelations() as $relation) {
                // Завантажуємо тільки якщо зв'язок ще не завантажений
                if (! $this->relationLoaded($relation)) {
                    $this->load($relation);
                }
            }

            static::$preventRecursion = false;
        }
    }

    /**
     * Отримати список відносин для завантаження.
     */
    protected function getDefaultRelations(): array
    {
        return $this->defaultRelations ?? [];
    }
}
