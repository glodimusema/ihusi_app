<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thotel_paiement_chambre extends Model
{
    protected $fillable=['id','refReservation','montant_paie','devise','taux','date_paie',
    'modepaie','libellepaie','refBanque','numeroBordereau','author','refUser'];
    protected $table = 'thotel_paiement_chambre';
}
