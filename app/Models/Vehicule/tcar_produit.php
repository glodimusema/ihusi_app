<?php

namespace App\Models\Vehicule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tcar_produit extends Model
{
    protected $fillable=['id','designation','pu','devise','taux','unite','author'];
    protected $table = 'tcar_produit';
}
