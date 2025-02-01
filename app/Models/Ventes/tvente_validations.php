<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_validations extends Model
{
    protected $fillable=['id','user_id','module_id','niveau','codeOperation','author','refUser'];
    protected $table = 'tvente_validations';
}



