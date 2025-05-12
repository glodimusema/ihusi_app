<?php

namespace App\Models\Gaz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tgaz_lot extends Model
{
    protected $fillable=['id','refCategorieLot','nom_lot','code_lot','unite_lot','stock_alerte','author','refUser'];
    protected $table = 'tgaz_lot';
}
