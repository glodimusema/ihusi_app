<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thotel_billard extends Model
{
    protected $fillable=['id','refClient','montant_paie','devise','taux',
    'date_paie','modepaie','libellepaie','refBanque','numeroBordereau','heure_debut','heure_fin',
    'libelle','author','refUser'];
    protected $table = 'thotel_billard';
}
