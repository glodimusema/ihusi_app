<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_correspondance extends Model
{
    protected $fillable=['id','user_id','objet','messages','statut','author'];
    protected $table = 'tperso_correspondance';
}

// tperso_timesheet
// affectation_id
// user_id
// annee_id
// mois_id
// date_tache
// jour_preste
// perdieme
// activite
// heure_debut
// heure_fin
// temp_preste
// ateste_agent
// ateste_projet
// ateste_coordo
// ateste_rh
// author