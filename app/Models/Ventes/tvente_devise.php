<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_devise extends Model
{
    //tvente_devise
    protected $fillable=['id','designation','active'];
    protected $table = 'tvente_devise';
}
