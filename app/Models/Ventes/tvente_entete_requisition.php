<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_entete_requisition extends Model
{
    protected $fillable=['id','code','refFournisseur','module_id','refService','dateCmd','libelle',
    'niveau1','niveaumax','cloture','active','montant','paie','author','refUser'];
    protected $table = 'tvente_entete_requisition';
}
