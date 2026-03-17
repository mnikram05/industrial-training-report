<?php

namespace Modules\PortalAdministration\Models;

use App\Modules\User\Models\User;
use Modules\Reference\Models\DataReference;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Menu extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'portal_menus';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'parent_id',
        'title_my',
        'title_en',
        'type_id',
        'status_id',
        'icon',
        'sort',
        'url',
        'slug',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by',
    ];

    /**
     * @param  array{status?: int}  $attributes
     */
    // protected function casts(): array
    // {
    //     return [
    //         'status' => 'boolean',
    //         'sort'   => 'integer',
    //     ];
    // }

    /**
     * Scope: search by name, ddsa_code, fullname, or iso_code.
     */
    // public function scopeSearch( Builder $query, ?string $term ): Builder
    // {
    //     if ( ! $term ) {
    //         return $query;
    //     }

    //     return $query->where( function ( Builder $q ) use ( $term ) {
    //         $q->where( 'name', 'like', "%{$term}%" )
    //             ->orWhere( 'fullname', 'like', "%{$term}%" )
    //             ->orWhere( 'ddsa_code', 'like', "%{$term}%" )
    //             ->orWhere( 'iso_code', 'like', "%{$term}%" );
    //     } );
    // }

    /**
     * Scope: order by sort column, then by name.
     */
    public function scopeOrdered( Builder $query ): Builder
    {
        return $query->orderBy( 'sort' )->orderBy( 'name' );
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

    public function parent()
    {
        return $this->belongsTo( self::class, 'parent_id' );
    }

    public function type()
    {
        return $this->belongsTo( DataReference::class, 'type_id' );
    }

    public function status()
    {
        return $this->belongsTo( DataReference::class, 'status_id' );
    }

    


}
