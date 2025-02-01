<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_unite extends Model
{
    protected $fillable=['id','nom_unite','code_unite','active'];
    protected $table = 'tvente_unite'; 

    
}
