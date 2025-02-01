<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_grande_categorie_produit extends Model
{
    //tvente_devise
    protected $fillable=['id','designation_groupe'];
    protected $table = 'tvente_grande_categorie_produit';
}
