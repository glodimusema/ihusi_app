<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_affectation_tache extends Model
{
    protected $fillable=['id','activite_id', 'affectation_id', 'date_affect_tache', 'author'];
    protected $table = 'tperso_affectation_tache';
}

///id, activite_id, affectation_id, date_affect_tache, author  tperso_affectation_tache


 