<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_domaine_stage extends Model
{
    protected $fillable=['id','name_domaine','author'];
    protected $table = 'tperso_domaine_stage';
}


 