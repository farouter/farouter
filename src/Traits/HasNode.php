<?php

namespace Farouter\Traits;

use Farouter\Models\Node;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasNode
{
    private $___PARENT_NODE = null;

    /**
     * Get the fillable attributes for the model.
     *
     * @return array<string>
     */
    public function getFillable()
    {
        return [
            ...$this->fillable,
            'parent_node',
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
            $model->___PARENT_NODE = $model->parent_node;

            unset($model->parent_node);
        });

        static::created(function (Model $model) {
            $parent_id = $model->___PARENT_NODE;
            $path = Str::slug($model->name);

            if ($model->___PARENT_NODE instanceof Model) {
                $parent_id = $model->___PARENT_NODE->id;
                $path = $model->___PARENT_NODE->path.'/'.$path;
            }

            $model->node()->create([
                'parent_id' => $parent_id,
                'path' => $path,
            ]);
        });
    }
}
