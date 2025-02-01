<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_entete_utilisation extends Model
{
    protected $fillable=['id','code','refService','module_id','agent_id','dateUse','libelle','author','refUser'];
    protected $table = 'tvente_entete_utilisation';
}

