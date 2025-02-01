<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_entete_paiement_groupe extends Model
{
    protected $fillable=['id','code','refFactureGroup','module_id','datePaieGroup',
    'libelle_paie_group','author','refUser'];
    protected $table = 'tvente_entete_paiement_groupe';
}
