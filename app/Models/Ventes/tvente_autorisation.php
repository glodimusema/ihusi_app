<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_autorisation extends Model
{
    protected $fillable=['id','role_id','module_id','niveau','author','refUser'];
    protected $table = 'tvente_autorisation';
}



