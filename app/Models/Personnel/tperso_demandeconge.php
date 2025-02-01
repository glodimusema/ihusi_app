<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_demandeconge extends Model
{
    protected $fillable=['id','affectation_id','typecircintance_id','admin_fin_conge','annee_id','description_conge','date_demande','date_depart',
    'nbr_joursollicite','date_reprise','superviseur_conge','interimaire_conge','resumetache_conge',
    'rh_conge', 'coordinateur_conge','directeur_conge','congess','date_debut_accord',
    'date_fin_accord','nbr_jouraccord','cumul_conge_annee','solde_conge_datedu','solde_conge_reprise','author'];
    protected $table = 'tperso_demandeconge';
}
//SELECT id,name_annee FROM `tperso_annee` WHERE 1 annee_id
 
//id,affectation_id,typecircintance_id,description_conge,date_demande,date_depart,
//br_joursollicite,date_reprise,superviseur_conge,interimaire_conge,resumetache_conge
//rh_conge, coordinateur_conge,directeur_conge,congess,author   tperso_demandeconge


 