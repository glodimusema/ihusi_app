<?php

namespace App\Models\Gaz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tgaz_mouvement_stock_service_lot extends Model
{
    

    protected $fillable=['id','idStockService','dateMvt','type_mouvement','libelle_mouvement',
    'nom_table','id_data','puMvt','qteMvt','uniteMvt','cmupMvt','devise','taux','author','refUser'];
    protected $table = 'tgaz_mouvement_stock_service_lot';
}
