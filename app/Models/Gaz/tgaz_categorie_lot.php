<?php

namespace App\Models\Gaz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tgaz_categorie_lot extends Model
{ 
    protected $fillable=['id','nom_categorie_lot'];
    protected $table = 'tgaz_categorie_lot';
}
