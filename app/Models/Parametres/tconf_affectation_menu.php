<?php

namespace App\Models\Parametres;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tconf_affectation_menu extends Model
{
    
    protected $fillable=['id','refRole','refMenu','author'];
    protected $table = 'tconf_affectation_menu';
}
