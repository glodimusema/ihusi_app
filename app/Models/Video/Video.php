<?php

namespace App\Models\Video;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    //
    protected $fillable = [
        'titre', 'description', 'url'
    ];
}
