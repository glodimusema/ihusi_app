<?php

namespace App\Models\Gaz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tgaz_detail_vente extends Model
{
    

    protected $fillable=['id','refEnteteVente','compte_vente','compte_variationstock',
'compte_perte','compte_produit','compte_destockage','idStockService','idParamLot','qte_kit',
'puVente','qteVente','uniteVente','cmupVente','devise','taux','montanttva',
'montantreduction','priseencharge','active','author','refUser'];
    protected $table = 'tgaz_detail_vente';
}
