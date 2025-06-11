<?php

namespace App\Models\Gaz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tgaz_entete_utilisation extends Model
{ 
    protected $fillable=['id','code','refService','module_id','agent_id','dateUse',
'libelle','author','refUser'];
    protected $table = 'tgaz_entete_utilisation';
}



