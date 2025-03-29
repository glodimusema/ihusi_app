<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_detail_requisition extends Model
{
    protected $fillable=['id','refEnteteCmd','refProduit','idStockService','compte_achat',
    'compte_produit','puCmd','qteCmd','qteTempo','uniteCmd','puBase','qteBase','uniteBase',
    'devise','taux','montanttva','montantreduction',
    'active','author','refUser'];
    protected $table = 'tvente_detail_requisition';
}


