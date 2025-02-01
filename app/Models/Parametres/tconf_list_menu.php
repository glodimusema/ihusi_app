<?php

namespace App\Models\Parametres;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tconf_list_menu extends Model
{
    protected $fillable=['id','name_menu','numero_menu'];
    protected $table = 'tconf_list_menu';
}
