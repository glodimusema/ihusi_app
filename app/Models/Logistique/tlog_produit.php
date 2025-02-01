<?php

namespace App\Models\Logistique;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tlog_produit extends Model
{
    protected $fillable=['id','designation','pu','devise','taux','unite','refCategorie','refEmplacement','author'];
    protected $table = 'tlog_produit';
}
