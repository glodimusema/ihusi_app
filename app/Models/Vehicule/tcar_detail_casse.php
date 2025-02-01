<?php

namespace App\Models\Vehicule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tcar_detail_casse extends Model
{
    protected $fillable=['id','refEnteteMvt','refProduit','puCasse','qteCasse','devise','taux','author'];
    protected $table = 'tcar_detail_casse';
}