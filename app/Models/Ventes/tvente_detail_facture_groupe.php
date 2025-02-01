<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_detail_facture_groupe extends Model
{
    protected $fillable=['id','refEnteteGroup','id_vente','id_reservation','active','author','refUser'];
    protected $table = 'tvente_detail_facture_groupe';
}
