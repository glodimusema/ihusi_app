<?php

namespace App\Models\Vehicule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tcar_paiement extends Model
{
    protected $fillable=['id','refEnteteMvt','montant_paie','devise','taux',
    'date_paie','modepaie','libellepaie','refBanque','numeroBordereau','Info_devise','author'];
    protected $table = 'tcar_paiement';
}