<?php

namespace App\Models\Patients;

use Illuminate\Database\Eloquent\Model;

class tdata_rapportmedical extends Model
{
    //
    protected $fillable = [
        'id','refPatient','plainte_med','historique_med','antecedent_med',
        'examenphysique_med','diagnostic_med','examenparaclinique_med','traitement_med',
        'evolution_med','libelle_med','date_med','medecin_med','specialite_med','cnom_med','author',"Hopital"
    ];
    protected $table = 'tdata_rapportmedical';
}
