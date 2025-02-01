<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_detail_utilisation extends Model
{
    protected $fillable=['id','refEnteteVente','refProduit','compte_vente','compte_variationstock',
    'compte_perte','compte_produit','compte_destockage','puVente','qteVente','uniteVente','puBase','qteBase',
    'uniteBase','cmupVente','devise','taux','montanttva','montantreduction','active','type_sortie',
    'idStockService','author','refUser'];
    protected $table = 'tvente_detail_utilisation';
}


