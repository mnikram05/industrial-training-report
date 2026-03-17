<?php

declare(strict_types=1);

namespace Modules\Reference\Models;

use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataReference extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'zz_data_references';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'parent_id',
        'label_my',
        'label_en',
        'name',
        'sort',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'sort'   => 'integer',
            'status' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<self, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo( self::class, 'parent_id' );
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
     * Scope: search by name, label_my, or label_en.
     */
    public function scopeSearch( Builder $query, ?string $term ): Builder
    {
        if ( ! $term ) {
            return $query;
        }

        return $query->where( function ( Builder $q ) use ( $term ) {
            $q->where( 'name', 'like', "%{$term}%" )
                ->orWhere( 'label_my', 'like', "%{$term}%" )
                ->orWhere( 'label_en', 'like', "%{$term}%" );
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
