<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_module extends Model
{
    protected $fillable=['id','nom_module','active'];
    protected $table = 'tvente_module';
}





