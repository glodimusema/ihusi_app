<?php

namespace App\Models\Vehicule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tcar_emballage extends Model
{
    protected $fillable=['id','refEnteteMvt','refProduit','puEmballage','qteEmballage','devise','taux','author'];
    protected $table = 'tcar_emballage';
}