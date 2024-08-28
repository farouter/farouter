<?php

namespace Farouter\Traits;

use Farouter\Models\Node;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasNode
{
    public ?int $___node_parent_id = null;

    /**
     * Get the fillable attributes for the model.
     *
     * @return array<string>
     */
    public function getFillable()
    {
        return [
            ...$this->fillable,
            'node_parent_id',
        ];
    }

    public function node()
    {
        return $this->morphOne(Node::class, 'nodal');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->___node_parent_id = $model->node_parent_id;

            unset($model->node_parent_id);
        });

        static::created(function (Model $model) {
            $model->node()->create([
                'parent_id' => $model->___node_parent_id,
                'path' => Str::slug($model->name),
            ]);
        });
    }
}
