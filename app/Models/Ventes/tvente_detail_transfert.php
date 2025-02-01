<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_detail_transfert extends Model
{
    protected $fillable=['id','refEnteteTransfert','refProduit','refDestination','idStockService','puTransfert','qteTransfert',
    'uniteTransfert','puBase','qteBase','uniteBase','author','refUser','idStockService'];
    protected $table = 'tvente_detail_transfert';     
}











