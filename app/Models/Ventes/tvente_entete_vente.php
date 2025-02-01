<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_entete_vente extends Model
{
    protected $fillable=['id','code','refClient','refService','refReservation','module_id',
    'dateVente','libelle','serveur_id','table_id','etat_facture','montant','paie','reduction',
    'date_paie_current','nombre_print','totaltva','author','refUser'];
    protected $table = 'tvente_entete_vente';
}

