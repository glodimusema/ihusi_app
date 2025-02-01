<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_parametre_salairebase extends Model
{
    protected $fillable=['id','categorie_id','projet_id','salaire_base','salaire_prevu','author'];
    protected $table = 'tperso_parametre_salairebase';
}

///tperso_parametre_salairebase id,categorie_id,projet_id,salaire_base,author


 