<?php

declare(strict_types=1);

namespace Modules\Reference\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dun extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'zz_duns';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'parliament_id',
        'new_code',
        'ddsa_code',
        'name',
        'sort',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'sort' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Parliament, $this>
     */
    public function parliament(): BelongsTo
    {
        return $this->belongsTo( Parliament::class );
    }

    /**
     * Scope: search by name, ddsa_code, or new_code.
     */
    public function scopeSearch( Builder $query, ?string $term ): Builder
    {
        if ( ! $term ) {
            return $query;
        }

        return $query->where( function ( Builder $q ) use ( $term ) {
            $q->where( 'name', 'like', "%{$term}%" )
                ->orWhere( 'ddsa_code', 'like', "%{$term}%" )
                ->orWhere( 'new_code', 'like', "%{$term}%" );
        } );
    }

    /**
     * Scope: order by sort column, then by name.
     */
    public function scopeOrdered( Builder $query ): Builder
    {
        return $query->orderBy( 'sort' )->orderBy( 'name' );
    }
}
