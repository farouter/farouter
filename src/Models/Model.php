<?php

namespace Farouter\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Whitecube\LaravelTimezones\Casts\TimezonedDatetime;

/**
 * Class Model
 *
 * Base model for the Farouter package, providing common functionality such as UUIDs
 * for primary keys and timezone-aware casting for timestamps.
 *
 * @property string $id The UUID primary key.
 * @property \Illuminate\Support\Carbon|null $created_at The creation timestamp with timezone support.
 * @property \Illuminate\Support\Carbon|null $updated_at The update timestamp with timezone support.
 * @property \Illuminate\Support\Carbon|null $deleted_at The deletion timestamp with timezone support (for soft deletes).
 */
abstract class Model extends EloquentModel
{
    use HasUuids;

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
}
