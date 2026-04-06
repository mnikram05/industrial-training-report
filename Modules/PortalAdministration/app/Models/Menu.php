<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Models;

use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Modules\Reference\Models\DataReference;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'menus';

    protected $fillable = [
        'parent_id',
        'title_ms',
        'title_en',
        'type_id',
        'status_id',
        'icon',
        'sort',
        'url',
        'slug',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'sort'      => 'integer',
            'type_id'   => 'integer',
            'status_id' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<self, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo( self::class, 'parent_id' );
    }

    /**
     * @return HasMany<self, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany( self::class, 'parent_id' )->ordered();
    }

    /**
     * @return BelongsTo<DataReference, $this>
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo( DataReference::class, 'type_id' );
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo( User::class, 'created_by' );
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo( User::class, 'updated_by' );
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo( User::class, 'deleted_by' );
    }

    /**
     * Scope: search by title_ms, title_en, or slug.
     */
    public function scopeSearch( Builder $query, ?string $term ): Builder
    {
        if ( ! $term ) {
            return $query;
        }

        return $query->where( function ( Builder $q ) use ( $term ) {
            $q->where( 'title_ms', 'like', "%{$term}%" )
                ->orWhere( 'title_en', 'like', "%{$term}%" )
                ->orWhere( 'slug', 'like', "%{$term}%" );
        } );
    }

    /**
     * Scope: order by sort column, then by title_en.
     */
    public function scopeOrdered( Builder $query ): Builder
    {
        return $query->orderBy( 'sort' )->orderBy( 'title_en' );
    }
}
