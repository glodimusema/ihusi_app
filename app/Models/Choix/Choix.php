<?php

namespace App\Models\Choix;

use Illuminate\Database\Eloquent\Model;

class Choix extends Model
{
    //
    protected $fillable = [
        'titre', 'description', 'photo',
    ];
}
