<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_mutuelle extends Model
{
    protected $fillable=['id','nom_mutuelle','description_mutuelle'];
    protected $table = 'tperso_mutuelle';

    // tperso_poste  id,nom_poste,description_poste
    // tperso_lieuaffectation  id,nom_lieu,description_lieu
    // tperso_mutuelle  id,nom_mutuelle,description_mutuelle
    // tperso_typecontrat  id,nom_contrat,code_contrat
}
