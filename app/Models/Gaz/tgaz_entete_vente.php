<?php

namespace App\Models\Gaz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tgaz_entete_vente extends Model
{
    
        
    protected $fillable=['id','code','refClient','refService','module_id','serveur_id',
        'etat_facture','dateVente','libelle','montant','reduction','totaltva','paie',
        'date_paie_current','nombre_print','author','refUser'];
    protected $table = 'tgaz_entete_vente';
}
