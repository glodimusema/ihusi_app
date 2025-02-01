<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_mouvement_stock extends Model
{
    protected $fillable=['id','idStockService','compte_vente','compte_variationstock','compte_perte','compte_produit',
    'compte_destockage','compte_achat','compte_stockage','dateMvt','type_mouvement','libelle_mouvement','nom_table',
    'id_data','puMvt','qteMvt','uniteMvt','puBase','qteBase','uniteBase','cmupMvt','devise','taux','author','refUser'];
    protected $table = 'tvente_mouvement_stock';
}
