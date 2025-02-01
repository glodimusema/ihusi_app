<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_partenaire extends Model
{
    protected $fillable=['id','nom_org','adresse_org','contact_org','mail_org','rccm_org','idnat_org','author','photo'];
    protected $table = 'tperso_partenaire';
}

    //id,nom_org, adresse_org, contact_org, rccm_org, idnat_org, author, photo  tperso_partenaire
    //id,partenaire_id, typecontrat_id, description_projet, chef_projet, date_debut_projet, date_fin_projet, author   tperso_projets
    //id, projet_id, description_tache, date_debut_tache, date_fin_tache, nbr_heureJour, cout_heure, author   tperso_activites_projet
    //id, activite_id, designation_livrable, description_livrable, fichiers, statut_livrable, author   tperso_livrables
    //id, activite_id, montant_projet, author   tperso_paie_projet
    //id, activite_id, affectation_id, date_affect_tache, author  tperso_affectation_tache


 