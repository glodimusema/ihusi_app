<?php

namespace App\Models\Salon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tsalon_entete_vente extends Model
{
    protected $fillable=['id','refClient','dateVente','libelle','montant','paie','author'];
    protected $table = 'tsalon_entete_vente';
}
