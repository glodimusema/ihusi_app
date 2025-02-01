<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_detail_entree extends Model
{
    protected $fillable=['id','refEnteteEntree','refProduit','idStockService','compte_achat',
    'compte_variationstock','compte_produit','compte_stockage','puEntree','qteEntree','uniteEntree',
    'puBase','qteBase','uniteBase','devise','taux','montanttva','montantreduction','active','author','refUser'];
    protected $table = 'tvente_detail_entree'; 
}

// refEnteteEntree,refProduit,refService,compte_achat,compte_variationstock,compte_produit,compte_stockage,
// puEntree,qteEntree,uniteEntree,puBase,qteBase,uniteBase,devise,taux,montanttva,montantreduction,active,author,refUser


// 'id','refEnteteCmd','refProduit','compte_achat','compte_produit','puCmd',
//     'qteCmd','uniteCmd','puBase','qteBase','uniteBase','devise','taux','montanttva','montantreduction',
//     'active','author','refUser'


