<?php

declare(strict_types=1);

namespace App\Support\Status;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $type
 * @property string $key
 * @property int|null $parent_id
 * @property string $name_en
 * @property string $name_ms
 */
class Status extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'type',
        'key',
        'parent_id',
        'name_en',
        'name_ms',
    ];

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeForType( Builder $query, StatusType $type ): Builder
    {
        return $query->where( 'type', $type->value );
    }

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeForParent( Builder $query, int $parentId ): Builder
    {
        return $query->where( 'parent_id', $parentId );
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
        return $this->hasMany( self::class, 'parent_id' );
    }

    public function label( ?string $locale = null ): string
    {
        $activeLocale = $locale ?? app()->getLocale();

        if ( $activeLocale === 'ms' ) {
            return $this->name_ms;
        }

        return $this->name_en;
    }
}
