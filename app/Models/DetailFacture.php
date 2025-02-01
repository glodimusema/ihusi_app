<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailFacture extends Model
{
    //

    protected $fillable=['id','facture_id','produit_id','puVente','devise','taux','qteVente','user_id'];
    protected $table = 'detail_factures';
    
}
