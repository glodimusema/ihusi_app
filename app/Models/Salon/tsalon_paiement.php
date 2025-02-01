<?php

namespace App\Models\Salon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tsalon_paiement extends Model
{
    protected $fillable=['id','refEnteteVente','montant_paie','devise','taux',
    'date_paie','modepaie','libellepaie','refBanque','numeroBordereau','author'];
    protected $table = 'tsalon_paiement';
}
