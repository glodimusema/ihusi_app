<?php

namespace App\Models\Gaz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tgaz_entete_production extends Model
{    
    protected $fillable=['id','code','module_id','refService','dateProduction',
    'libelle_production','montant','author','refUser'];
    protected $table = 'tgaz_entete_production';
}
