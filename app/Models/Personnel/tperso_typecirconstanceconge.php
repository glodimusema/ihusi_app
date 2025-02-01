<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_typecirconstanceconge extends Model
{
    protected $fillable=['id','nom_circontstance','description_circons','categorie_id','nbrjour_cirscons'];
    protected $table = 'tperso_typecirconstanceconge';
}
