<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_detail_paiement_groupe extends Model
{
    protected $fillable=['id','refEntetepaieGroup','refEnteteVenteGroup','refBanque','montant_paie',
    'devise','taux','date_paie','modepaie','libellepaie','numeroBordereau','author','refUser','active'];
    protected $table = 'tvente_detail_paiement_groupe';
}
