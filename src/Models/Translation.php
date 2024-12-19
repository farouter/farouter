<?php

namespace Farouter\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasUuids;

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'locale',
        'attribute',
        'value',
    ];

    public function translatable()
    {
        return $this->morphTo();
    }
}
