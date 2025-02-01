<?php

namespace App\Models\Patients;

use Illuminate\Database\Eloquent\Model;

class tdata_malade extends Model
{
    //
    protected $fillable = [
        "nom_maladie","nom_categoriemaladie","plainte","historique","antecedent","complementanamnese","examenphysique",
        "diagnostiquePres","dateDetailCons","TypeConsultation",
        'dateConsultation',"matricule_agent","noms_agent","sexe_agent","datenaissance_agent",
        "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent",
        "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
        "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
        "Poids","Taille","TA","Temperature","FC","FR","Oxygene",
        "dateTriage","dateMouvement","numroBon","Statut","dateSortieMvt","motifSortieMvt",
        "Typemouvement","noms","contact","mail","Categorie","photo","nomAvenue",
        "nomQuartier","nomCommune","nomVille","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade","PrixCons",'age_malade',"exames_labo","prescription_medicaments",
        "maladie_chronique","hopital"
    ];
    protected $table = 'tdata_malade';
}
