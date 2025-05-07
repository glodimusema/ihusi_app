<?php

namespace App\Models\Gaz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tgaz_detail_transfert extends Model
{
    protected $fillable=['id','refEnteteTransfert','refDestination','idStockService',
    'refLot','puTransfert','qteTransfert','uniteTransfert','author','refUser'];
    protected $table = 'tgaz_detail_transfert';
}
