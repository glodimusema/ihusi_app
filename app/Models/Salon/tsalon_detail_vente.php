<?php

namespace App\Models\Salon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tsalon_detail_vente extends Model
{
    protected $fillable=['id','refEnteteVente','refProduit','puVente','devise','taux','qteVente','author'];
    protected $table = 'tsalon_detail_vente';
}
