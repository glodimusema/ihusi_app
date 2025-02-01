<?php

namespace App\Models\Patients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vcarte extends Model
{
    protected $fillable=['id','refUser','dateExpiration','numeroCarte','codeSecret','noms_profil',
    'adresse_profil','telephone_profil','datenaissance_profil','groupesanguin','sexe_profil','mail_profil','photo_profil'];
    protected $table = 'vcarte';
}
