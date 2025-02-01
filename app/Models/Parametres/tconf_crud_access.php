<?php

namespace App\Models\Parametres;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tconf_crud_access extends Model
{
    protected $fillable=['id','refRole','insert','update','delete','load','author'];
    protected $table = 'tconf_crud_access';
}
