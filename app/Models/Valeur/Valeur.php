<?php

namespace App\Models\Valeur;

use Illuminate\Database\Eloquent\Model;

class Valeur extends Model
{
    //
    protected $fillable = [
        'nom','titre', 'description', 'photo',
    ];
}
