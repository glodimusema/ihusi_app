<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_activites_projet extends Model
{
    protected $fillable=['id','projet_id', 'description_tache', 'date_debut_tache', 
    'duree_tache','date_fin_tache', 'nbr_heureJour', 'cout_heure','statut_tache', 'author'];
    protected $table = 'tperso_activites_projet';
}

//id, projet_id, description_tache, date_debut_tache, date_fin_tache, nbr_heureJour, cout_heure, author   tperso_activites_projet
//id, activite_id, designation_livrable, description_livrable, fichiers, statut_livrable, author   tperso_livrables
//id, activite_id, montant_projet, author   tperso_paie_projet
//id, activite_id, affectation_id, date_affect_tache, author  tperso_affectation_tache


 