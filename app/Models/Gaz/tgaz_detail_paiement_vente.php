<?php

namespace App\Models\Gaz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tgaz_detail_paiement_vente extends Model
{   

    protected $fillable=['id','refEntetepaie','refEnteteVente','refBanque','montant_paie',
'devise','taux','date_paie','modepaie','libellepaie','numeroBordereau','author','refUser'
,'active'];
    protected $table = 'tgaz_detail_paiement_vente';
}
