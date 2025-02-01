<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_annee_stage extends Model
{
    protected $fillable=['id','name_annee','author'];
    protected $table = 'tperso_annee_stage';
}


 