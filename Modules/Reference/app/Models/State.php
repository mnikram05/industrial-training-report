<?php

declare(strict_types=1);

namespace Modules\Reference\Models;

use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'zz_states';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'ddsa_code',
        'name',
        'fullname',
        'iso_code',
        'sort',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * @param  array{status?: int}  $attributes
     */
    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'sort'   => 'integer',
        ];
    }

    /**
     * Scope: search by name, ddsa_code, fullname, or iso_code.
     */
    public function scopeSearch( Builder $query, ?string $term ): Builder
    {
        if ( ! $term ) {
            return $query;
        }

        return $query->where( function ( Builder $q ) use ( $term ) {
            $q->where( 'name', 'like', "%{$term}%" )
                ->orWhere( 'fullname', 'like', "%{$term}%" )
                ->orWhere( 'ddsa_code', 'like', "%{$term}%" )
                ->orWhere( 'iso_code', 'like', "%{$term}%" );
        } );
    }

    /**
     * Scope: order by sort column, then by name.
     */
    public function scopeOrdered( Builder $query ): Builder
    {
        return $query->orderBy( 'sort' )->orderBy( 'name' );
    }

    /**
     * @return HasMany<Parliament, $this>
     */
    public function parliaments(): HasMany
    {
        return $this->hasMany( Parliament::class );
    }

    /**
     * @return HasMany<District, $this>
     */
    public function districts(): HasMany
    {
        return $this->hasMany( District::class );
    }

    public function createdBy()
    {
        return $this->belongsTo( User::class, 'created_by' );
    }

    public function updatedBy()
    {
        return $this->belongsTo( User::class, 'updated_by' );
    }

    public function deletedBy()
    {
        return $this->belongsTo( User::class, 'deleted_by' );
    }
}
