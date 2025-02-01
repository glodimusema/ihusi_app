<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_entete_transfert extends Model
{
    protected $fillable=['id','refService','date_transfert','module_id','author','refUser'];
    protected $table = 'tvente_entete_transfert';     
}






