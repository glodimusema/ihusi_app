<?php

namespace App\Models\Vehicule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tcar_vehicule extends Model
{
    protected $fillable=['id','nom_vehicule','marque','couleur','numPlaque','author'];
    protected $table = 'tcar_vehicule';
}
