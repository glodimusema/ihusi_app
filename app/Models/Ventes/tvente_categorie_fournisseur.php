<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_categorie_fournisseur extends Model
{
    protected $fillable=['id','code','nom_categoriefss','compte_fss_bl','active'];
    protected $table = 'tvente_categorie_fournisseur';
}


