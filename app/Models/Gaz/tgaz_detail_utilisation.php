<?php

namespace App\Models\Gaz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tgaz_detail_utilisation extends Model
{ 
    protected $fillable=['id','refEnteteVente','idStockService','puVente','qteVente',
    'uniteVente','cmupVente','devise','taux','montanttva','montantreduction','type_sortie',
    'active','author','refUser'];
    protected $table = 'tgaz_detail_utilisation';
}



