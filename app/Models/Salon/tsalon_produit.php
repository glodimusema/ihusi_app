<?php

namespace App\Models\Salon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tsalon_produit extends Model
{
    protected $fillable=['id','designation','pu','devise','taux','unite','author'];
    protected $table = 'tsalon_produit';
}
