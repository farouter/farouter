<?php

namespace Farouter\Models;

use App\Farouter\Locale;
use Farouter\Models\Node\Path;
use Farouter\Traits\LoadsRelationsWithoutRecursion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class Node
 *
 * Represents a node in the system which may have multiple paths (localized URLs)
 * and can be associated with a polymorphic "nodeable" model.
 *
 * @property int|null $parent_id The ID of the parent node, if any.
 * @property bool $solid Indicates whether the node is solid (immutable).
 * @property string $nodeable_type The type of the polymorphic relationship.
 * @property int|string $nodeable_id The ID of the polymorphic relationship.
 *
 * @method static \Illuminate\Database\Eloquent\Builder|static whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereSolid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereNodeableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereNodeableId($value)
 */
class Node extends Model
{
    use LoadsRelationsWithoutRecursion;

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'solid',
        'nodeable_type',
        'nodeable_id',
    ];

    /**
     * Визначає відносини, які повинні завантажуватись завжди.
     *
     * @var array
     */
    protected $defaultRelations = [
        'nodeable',
    ];

    /**
     * Temporary variable to store the parent instance during save.
     *
     * This is used to avoid unnecessary database queries when accessing the parent node.
     */
    protected ?Node $__parentNode = null;

    /**
     * Set the parent node instance to avoid extra database queries.
     */
    public function setParentNode(?Node $parentNode): void
    {
        $this->__parentNode = $parentNode;
    }

    /**
     * Define a polymorphic relationship with the nodeable model.
     */
    public function nodeable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get all paths associated with the node, optionally filtered by locale.
     *
     * @param  Locale|null  $locale  The locale to filter the paths by.
     * @return HasMany The relationship query builder for the paths.
     */
    public function paths(?Locale $locale = null): HasMany
    {
        $query = $this->hasMany(Path::class);

        if ($locale) {
            $query->where('locale', $locale);
        }

        return $query;
    }

    /**
     * Get the single path associated with the node for a specific locale.
     *
     * If no locale is provided, the current application locale is used.
     *
     * @param  Locale|null  $locale  The locale to filter the path by.
     * @return HasOne The relationship query builder for the single path.
     */
    public function path(?Locale $locale = null): HasOne
    {
        $locale = ($locale ?: Locale::fromString(app()->getLocale()));

        return $this->hasOne(Path::class)->where('locale', $locale);
    }

    /**
     * Define a self-referencing "belongs to" relationship with the parent node.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Define a self-referencing "has many" relationship with child nodes.
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Define a "many-to-many" relationship with ancestor nodes.
     */
    public function ancestors(): BelongsToMany
    {
        return $this->belongsToMany(
            related: self::class,
            table: 'node_relations',
            foreignPivotKey: 'node_id',
            relatedPivotKey: 'parent_node_id',
            parentKey: 'id',
            relatedKey: 'id'
        )->withPivot('depth');
    }

    /**
     * Define a "many-to-many" relationship with descendant nodes.
     */
    public function descendants(): BelongsToMany
    {
        return $this->belongsToMany(
            related: self::class,
            table: 'node_relations',
            foreignPivotKey: 'parent_node_id',
            relatedPivotKey: 'node_id',
            parentKey: 'id',
            relatedKey: 'id'
        )->withPivot('depth');
    }

    public function scopeRoot(Builder $query)
    {
        $query->whereNull('parent_id');
    }
}
