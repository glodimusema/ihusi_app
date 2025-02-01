<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_services extends Model
{
    protected $fillable=['id','nom_service','status','active'];
    protected $table = 'tvente_services';
}




