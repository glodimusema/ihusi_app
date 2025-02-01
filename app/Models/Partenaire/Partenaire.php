<?php

namespace App\Models\Partenaire;

use Illuminate\Database\Eloquent\Model;

class Partenaire extends Model
{
    //
    protected $fillable = [
        'nom', 'url', 'photo'
    ];
}
