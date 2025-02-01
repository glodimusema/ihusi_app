<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_stock_service extends Model
{
    protected $fillable=['id','refService','refProduit','pu','qte','uniteBase','cmup','devise',
    'taux','active','refUser','author','unitePivot','qtePivot'];
    protected $table = 'tvente_stock_service';



    

}
