<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Image;

class Obituary extends Model
{
    //
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'used_age',
        'age',
        'specie_type',
        'dead_type',
        'dead_type_detail',
        'status',
        'images',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $casts = [
        'images'=>"array",
    ];

    public function getImagesAttribute($value)
    {
        return Image::getImagesByJsonArray($value);
    }
}
