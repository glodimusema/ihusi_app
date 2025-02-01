<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_categorie_circonstance extends Model
{
    protected $fillable=['id','nom_categorie'];
    protected $table = 'tperso_categorie_circonstance';
}


  