<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_paie_projet extends Model
{
    protected $fillable=['id','activite_id', 'montant_projet', 'author'];
    protected $table = 'tperso_paie_projet';
}

//id, activite_id, montant_projet, author   tperso_paie_projet
//id, activite_id, affectation_id, date_affect_tache, author  tperso_affectation_tache


 