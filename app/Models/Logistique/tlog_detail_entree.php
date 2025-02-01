<?php

namespace App\Models\Logistique;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tlog_detail_entree extends Model
{
    protected $fillable=['id','refEnteteEntree','refProduit','puEntree','devise','taux','qteEntree','author'];
    protected $table = 'tlog_detail_entree';
}
