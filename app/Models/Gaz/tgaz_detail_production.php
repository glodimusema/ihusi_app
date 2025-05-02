<?php

namespace App\Models\Gaz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tgaz_detail_production extends Model
{
    protected $fillable=['id','refEnteteProduction','compte_achat','compte_variationstock',
    'compte_produit','compte_stockage','idStockService','puProduction','qteProduction',
    'uniteProduction','cmupProduction','devise','taux','montanttva','montantreduction',
    'active','author','refUser'];
    protected $table = 'tgaz_detail_production';
}
