<?php

declare(strict_types=1);

namespace Modules\Reference\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// use Modules\Reference\Database\Factories\CategoryFactory;

class Category extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'zz_categories';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'state_id',
        'ddsa_code',
        'name',
        'fullname',
    ];
    // protected static function newFactory(): DistrictFactory
    // {
    //     // return DistrictFactory::new();
    // }
}
