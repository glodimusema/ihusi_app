<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_detail_unite extends Model
{
    protected $fillable=['id','refProduit','refUnite','puUnite','qteUnite','puBase',
    'qteBase','estunite','estpivot','active','author','refUser'];
    protected $table = 'tvente_detail_unite';
}






