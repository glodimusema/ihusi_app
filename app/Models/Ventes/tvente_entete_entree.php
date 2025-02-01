<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_entete_entree extends Model
{
    protected $fillable=['id','code','refFournisseur','refRecquisition','module_id','refService','dateEntree',
    'libelle','transporteur','niveau1','niveaumax','active','author','refUser'];
    protected $table = 'tvente_entete_entree';
}

