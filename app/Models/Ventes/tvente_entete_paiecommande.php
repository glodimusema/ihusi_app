<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_entete_paiecommande extends Model
{
    protected $fillable=['id','code','date_entete_paie','refService','module_id','author','refUser'];
    protected $table = 'tvente_entete_paiecommande';
}







