<?php

namespace App\Models\Vehicule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tcar_entete_mouvement extends Model
{
    protected $fillable=['id','refVehicule','refProvenance','dateMvt','numBS','numCD','numSR','Chauffeur','author'];
    protected $table = 'tcar_entete_mouvement';
}