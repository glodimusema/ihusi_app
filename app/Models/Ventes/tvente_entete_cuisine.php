<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_entete_cuisine extends Model
{
    protected $fillable=['id','code','refClient','refService','refReservation','module_id',
    'serveur_id','table_id','estServie','dateVente','libelle','author','refUser',
    'montant','reduction','totaltva'];
    protected $table = 'tvente_entete_cuisine'; 
}

