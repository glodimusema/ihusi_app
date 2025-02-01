<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_tables extends Model
{
    protected $fillable=['id','nom_table','code_table','active'];
    protected $table = 'tvente_tables'; 

    
}
