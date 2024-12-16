<?php

namespace Farouter\Models\Node;

use App\Farouter\Locale;
use Farouter\Models\Model;
use Farouter\Models\Node;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Path
 *
 * Represents a localized path (slug and URL) associated with a specific node.
 *
 * @property string $id The unique identifier of the path.
 * @property string $node_id The ID of the associated node.
 * @property Locale $locale The locale of the path.
 * @property string $slug The slug part of the path.
 * @property string $path The full path (URL).
 * @property \Illuminate\Support\Carbon|null $created_at The creation timestamp.
 * @property \Illuminate\Support\Carbon|null $updated_at The update timestamp.
 *
 * @method static \Illuminate\Database\Eloquent\Builder|static whereNodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|static whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|static wherePath($value)
 */
class Path extends Model
{
    /**
     * Attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'node_id',
        'locale',
        'slug',
        'path',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'locale' => Locale::class,
        ]);
    }

    /**
     * Get the node that this path belongs to.
     *
     * @return BelongsTo The relationship query builder for the associated node.
     */
    public function node(): BelongsTo
    {
        return $this->belongsTo(Node::class);
    }
}
