<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_tva extends Model
{
    protected $fillable=['id','montant_tva','libelle_tva','active'];
    protected $table = 'tvente_tva';
}
