<?php

namespace App\Models\Gaz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tgaz_affectation_kit extends Model
{ 
    protected $fillable=['id','id_kit_lot','id_gaz','qte_gaz','author','refUser'];
    protected $table = 'tgaz_affectation_kit';
}
