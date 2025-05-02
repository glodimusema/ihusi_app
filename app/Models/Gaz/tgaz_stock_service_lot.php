<?php

namespace App\Models\Gaz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tgaz_stock_service_lot extends Model
{
    protected $fillable=['id','refService','refLot','pu_lot','qte_lot','cmup_lot',
    'devise','taux','active','refUser','author'];
    protected $table = 'tgaz_stock_service_lot';
}
