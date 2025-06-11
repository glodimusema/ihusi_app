<?php

namespace App\Models\Gaz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tgaz_detail_inventaire extends Model
{ 
    protected $fillable=['id','refEnteteVente','idStockService','puVente','qteVente',
    'qteObs','uniteVente','cmupVente','devise','taux','montanttva','montantreduction',
    'priseencharge','active','author','refUser'];
    protected $table = 'tgaz_detail_inventaire';
}






