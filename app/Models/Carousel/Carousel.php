<?php

namespace App\Models\Carousel;

use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    //
    protected $fillable = [
        'titre', 'description', 'photo',
    ];
}
