<?php

namespace App\Models\Gaz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tgaz_parametre_lot extends Model
{
    protected $fillable=['id','refProduit','refLot','pu_param','qte_param',
    'autre_detail','author','refUser'];
    protected $table = 'tgaz_parametre_lot';
}
