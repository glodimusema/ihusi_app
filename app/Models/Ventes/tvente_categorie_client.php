<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_categorie_client extends Model
{
    //tvente_devise
    protected $fillable=['id','designation','compte_client','author'];
    protected $table = 'tvente_categorie_client';
}
