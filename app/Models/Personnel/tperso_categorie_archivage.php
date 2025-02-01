<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_categorie_archivage extends Model
{
    protected $fillable=['id','name_categorie','description_categorie','author'];
    protected $table = 'tperso_categorie_archivage';
}


 