<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_param_systeme extends Model
{
    protected $fillable=['id','module_id','maxid'];
    protected $table = 'tvente_param_systeme';
}



