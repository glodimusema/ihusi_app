<?php

namespace App\Models\Gaz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tgaz_entete_inventaire extends Model
{ 
    protected $fillable=['id','code','refService','module_id','dateVente',
    'libelle','author','refUser'];
    protected $table = 'tgaz_entete_inventaire';
}



