<?php

namespace App\Models\Vehicule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tcar_detail_entree extends Model
{
    protected $fillable=['id','refEnteteMvt','refProduit','puEntree','qteEntree','devise','taux','author'];
    protected $table = 'tcar_detail_entree';
}