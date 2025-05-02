<?php

namespace App\Models\Gaz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tgaz_entete_paiement_vente extends Model
{
    protected $fillable=['id','code','date_entete_paie','refService',
    'module_id','author','refUser'];
    protected $table = 'tgaz_entete_paiement_vente';
}
