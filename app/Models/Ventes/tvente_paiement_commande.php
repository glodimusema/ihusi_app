<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_paiement_commande extends Model
{
    protected $fillable=['id','code','refEntetepaie','refCommande','refBanque','montant_paie','devise',
    'taux','date_paie','modepaie','libellepaie','numeroBordereau','author','refUser','active'];
    protected $table = 'tvente_paiement_commande'; 
}




