<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    //
    protected $fillable = [
        'nom','email', 'titre', 'biographie','etat','facebook', 'twitter','linkedin','telephone', 'photo',
    ];
}
