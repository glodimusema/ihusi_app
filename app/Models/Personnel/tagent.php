<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tagent extends Model
{
    protected $fillable=['id','matricule_agent','noms_agent','sexe_agent','datenaissance_agent',
    'lieunaissnce_agent','provinceOrigine_agent','etatcivil_agent','refAvenue_agent','nummaison_agent',
    'contact_agent','mail_agent','grade_agent','fonction_agent','specialite_agent',
    'Categorie_agent','niveauEtude_agent','anneeFinEtude_agent','Ecole_agent','conjoint_agent', 
    'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
    'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent','photo','slug','cartes','envie','author'];
    protected $table = 'tagent';
}
