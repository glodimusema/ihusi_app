<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_demandeconge;
use App\Models\Personnel\tperso_affectation_agent;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;

class tperso_demandecongeController extends Controller
{
    use GlobalMethod, Slug  ;

    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }
//
//id,affectation_id,typecircintance_id,description_conge,date_demande,date_depart,
//br_joursollicite,date_reprise,superviseur_conge,interimaire_conge,resumetache_conge
//rh_conge, coordinateur_conge,directeur_conge,congess,author   tperso_demandeconge

//SELECT id,name_annee FROM `tperso_annee` WHERE 1 annee_id
    public function all(Request $request)
    {    
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);
            $data = DB::table('tperso_demandeconge')
            ->join('tperso_annee','tperso_annee.id','=','tperso_demandeconge.annee_id')            
            ->join('tperso_typecirconstanceconge','tperso_typecirconstanceconge.id','=','tperso_demandeconge.typecircintance_id')
            ->join('tperso_categorie_circonstance','tperso_categorie_circonstance.id','=','tperso_typecirconstanceconge.categorie_id')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_demandeconge.affectation_id')
            ->join('tperso_parametre_salairebase','tperso_parametre_salairebase.id','=','tperso_affectation_agent.param_salaire_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
            ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
            ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_demandeconge.id",'affectation_id','annee_id','name_annee','typecircintance_id','description_conge',
            'date_demande','date_depart','nbr_joursollicite','date_reprise','superviseur_conge','interimaire_conge',
            'resumetache_conge','nom_circontstance','description_circons','rh_conge', 'coordinateur_conge','directeur_conge',
            'congess','admin_fin_conge','date_debut_accord','date_fin_accord','nbr_jouraccord','cumul_conge_annee',
            'solde_conge_datedu','solde_conge_reprise','nbrjour_cirscons','nom_categorie',
            'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
            "tagent.photo as photo_agent","tagent.slug as slug_agent","name_serv_perso","name_categorie_service",
            "name_categorie_agent",'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle',
            'description_mutuelle','nom_contrat','code_contrat','param_salaire_id','fammiliale','logement',
            'tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission',"tperso_typecirconstanceconge.categorie_id","projet_id","salaire_base",
            "partenaire_id","description_projet","chef_projet","date_debut_projet","date_fin_projet","nom_org",
            "adresse_org","contact_org","rccm_org", "idnat_org")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            ->selectRaw('TIMESTAMPDIFF(MONTH, dateDebutEssaie, dateFinEssaie) as dureeessaie')  
            ->where([
                ['noms_agent', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_demandeconge.id", "desc")          
            ->paginate(10);
            return response($data, 200);
           

        }
        else{
            $data = DB::table('tperso_demandeconge')
            ->join('tperso_annee','tperso_annee.id','=','tperso_demandeconge.annee_id')            
            ->join('tperso_typecirconstanceconge','tperso_typecirconstanceconge.id','=','tperso_demandeconge.typecircintance_id')
            ->join('tperso_categorie_circonstance','tperso_categorie_circonstance.id','=','tperso_typecirconstanceconge.categorie_id')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_demandeconge.affectation_id')
            ->join('tperso_parametre_salairebase','tperso_parametre_salairebase.id','=','tperso_affectation_agent.param_salaire_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
            ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
            ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_demandeconge.id",'affectation_id','annee_id','name_annee','typecircintance_id','description_conge',
            'date_demande','date_depart','nbr_joursollicite','date_reprise','superviseur_conge','interimaire_conge',
            'resumetache_conge','nom_circontstance','description_circons','rh_conge', 'coordinateur_conge','directeur_conge',
            'congess','admin_fin_conge','date_debut_accord','date_fin_accord','nbr_jouraccord','cumul_conge_annee',
            'solde_conge_datedu','solde_conge_reprise','nbrjour_cirscons','nom_categorie',
            'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
            "tagent.photo as photo_agent","tagent.slug as slug_agent","name_serv_perso","name_categorie_service",
            "name_categorie_agent",'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle',
            'description_mutuelle','nom_contrat','code_contrat','param_salaire_id','fammiliale','logement',
            'tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission',"tperso_typecirconstanceconge.categorie_id","projet_id","salaire_base",
            "partenaire_id","description_projet","chef_projet","date_debut_projet","date_fin_projet","nom_org",
            "adresse_org","contact_org","rccm_org", "idnat_org")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            ->selectRaw('TIMESTAMPDIFF(MONTH, dateDebutEssaie, dateFinEssaie) as dureeessaie')   
            ->orderBy("tperso_demandeconge.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }


    public function fetch_detail_entete(Request $request,$affectation_id)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_demandeconge')
            ->join('tperso_annee','tperso_annee.id','=','tperso_demandeconge.annee_id')            
            ->join('tperso_typecirconstanceconge','tperso_typecirconstanceconge.id','=','tperso_demandeconge.typecircintance_id')
            ->join('tperso_categorie_circonstance','tperso_categorie_circonstance.id','=','tperso_typecirconstanceconge.categorie_id')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_demandeconge.affectation_id')
            ->join('tperso_parametre_salairebase','tperso_parametre_salairebase.id','=','tperso_affectation_agent.param_salaire_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
            ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
            ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_demandeconge.id",'affectation_id','annee_id','name_annee','typecircintance_id','description_conge',
            'date_demande','date_depart','nbr_joursollicite','date_reprise','superviseur_conge','interimaire_conge',
            'resumetache_conge','nom_circontstance','description_circons','rh_conge', 'coordinateur_conge','directeur_conge',
            'congess','admin_fin_conge','date_debut_accord','date_fin_accord','nbr_jouraccord','cumul_conge_annee',
            'solde_conge_datedu','solde_conge_reprise','nbrjour_cirscons','nom_categorie',
            'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
            "tagent.photo as photo_agent","tagent.slug as slug_agent","name_serv_perso","name_categorie_service",
            "name_categorie_agent",'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle',
            'description_mutuelle','nom_contrat','code_contrat','param_salaire_id','fammiliale','logement',
            'tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission',"tperso_typecirconstanceconge.categorie_id","projet_id","salaire_base",
            "partenaire_id","description_projet","chef_projet","date_debut_projet","date_fin_projet","nom_org",
            "adresse_org","contact_org","rccm_org", "idnat_org")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            ->selectRaw('TIMESTAMPDIFF(MONTH, dateDebutEssaie, dateFinEssaie) as dureeessaie') 
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['affectation_id',$affectation_id]
            ])                    
            ->orderBy("tperso_demandeconge.id", "desc")
            ->paginate(10);

            return response($data, 200);        

        }
        else{
      
            $data = DB::table('tperso_demandeconge')
            ->join('tperso_annee','tperso_annee.id','=','tperso_demandeconge.annee_id')            
            ->join('tperso_typecirconstanceconge','tperso_typecirconstanceconge.id','=','tperso_demandeconge.typecircintance_id')
            ->join('tperso_categorie_circonstance','tperso_categorie_circonstance.id','=','tperso_typecirconstanceconge.categorie_id')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_demandeconge.affectation_id')
            ->join('tperso_parametre_salairebase','tperso_parametre_salairebase.id','=','tperso_affectation_agent.param_salaire_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
            ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
            ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_demandeconge.id",'affectation_id','annee_id','name_annee','typecircintance_id','description_conge',
            'date_demande','date_depart','nbr_joursollicite','date_reprise','superviseur_conge','interimaire_conge',
            'resumetache_conge','nom_circontstance','description_circons','rh_conge', 'coordinateur_conge','directeur_conge',
            'congess','admin_fin_conge','date_debut_accord','date_fin_accord','nbr_jouraccord','cumul_conge_annee',
            'solde_conge_datedu','solde_conge_reprise','nbrjour_cirscons','nom_categorie',
            'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
            "tagent.photo as photo_agent","tagent.slug as slug_agent","name_serv_perso","name_categorie_service",
            "name_categorie_agent",'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle',
            'description_mutuelle','nom_contrat','code_contrat','param_salaire_id','fammiliale','logement',
            'tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission',"tperso_typecirconstanceconge.categorie_id","projet_id","salaire_base",
            "partenaire_id","description_projet","chef_projet","date_debut_projet","date_fin_projet","nom_org",
            "adresse_org","contact_org","rccm_org", "idnat_org")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            ->selectRaw('TIMESTAMPDIFF(MONTH, dateDebutEssaie, dateFinEssaie) as dureeessaie')             
            ->Where('affectation_id',$affectation_id)    
            ->orderBy("tperso_demandeconge.id", "desc")
            ->paginate(10);

            return response($data, 200);         
 
        }

    }    


    function fetch_single($id)
    {

        $data = DB::table('tperso_demandeconge')
        ->join('tperso_annee','tperso_annee.id','=','tperso_demandeconge.annee_id')            
        ->join('tperso_typecirconstanceconge','tperso_typecirconstanceconge.id','=','tperso_demandeconge.typecircintance_id')
        ->join('tperso_categorie_circonstance','tperso_categorie_circonstance.id','=','tperso_typecirconstanceconge.categorie_id')
        ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_demandeconge.affectation_id')
        ->join('tperso_parametre_salairebase','tperso_parametre_salairebase.id','=','tperso_affectation_agent.param_salaire_id')
        ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
        ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
        ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
        ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
        ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
        ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
        ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
        ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
        ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_demandeconge.id",'affectation_id','annee_id','name_annee','typecircintance_id','description_conge',
        'date_demande','date_depart','nbr_joursollicite','date_reprise','superviseur_conge','interimaire_conge',
        'resumetache_conge','nom_circontstance','description_circons','rh_conge', 'coordinateur_conge','directeur_conge',
        'congess','admin_fin_conge','date_debut_accord','date_fin_accord','nbr_jouraccord','cumul_conge_annee',
        'solde_conge_datedu','solde_conge_reprise','nbrjour_cirscons','nom_categorie',
        'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
        'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
        'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
        'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
        'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
        "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
        "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
        "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
        "tagent.photo as photo_agent","tagent.slug as slug_agent","name_serv_perso","name_categorie_service",
        "name_categorie_agent",'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle',
        'description_mutuelle','nom_contrat','code_contrat','param_salaire_id','fammiliale','logement',
        'tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
        'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission',"tperso_typecirconstanceconge.categorie_id","projet_id","salaire_base",
        "partenaire_id","description_projet","chef_projet","date_debut_projet","date_fin_projet","nom_org",
        "adresse_org","contact_org","rccm_org", "idnat_org")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
        ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
        ->selectRaw('TIMESTAMPDIFF(MONTH, dateDebutEssaie, dateFinEssaie) as dureeessaie')  
        ->where('tperso_demandeconge.id', $id)
        ->get();

        return response($data, 200);
    }





//id,affectation_id,typecircintance_id,description_conge,date_demande,date_depart,
//br_joursollicite,date_reprise,superviseur_conge,interimaire_conge,resumetache_conge
//rh_conge, coordinateur_conge,directeur_conge,congess,author   tperso_demandeconge

//admin_fin_conge,annee_id,'date_debut_accord','date_fin_accord','nbr_jouraccord','cumul_conge_annee','solde_conge_datedu','solde_conge_reprise'

    function insert_data(Request $request)
    {
        $currentDate = Carbon::parse($request->date_depart);
        $duree = (int)$request->nbr_joursollicite;
        $newDate = $currentDate->addDays($duree);

        $currentDateAccord = Carbon::parse($request->date_debut_accord);
        $dureeAccord = (int)$request->nbr_jouraccord;
        $newDateAccord = $currentDateAccord->addDays($dureeAccord);

        $conge_total=0;
        $cumule_annee=0;
        $solde_conge_datedu=0;
        $solde_conge_reprise=0;
        $count_conge=0;

        $data5 =  DB::table('tperso_demandeconge')        
        ->select(DB::raw('IFNULL(COUNT(tperso_demandeconge.id),0) as nombre'))
        ->where([
           ['tperso_demandeconge.annee_id','=', $request->annee_id],
           ['affectation_id','=', $request->affectation_id],
           ['typecircintance_id','=', $request->typecircintance_id]
       ])    
        ->get(); 
        $output='';
        foreach ($data5 as $row) 
        {                                
            $count_conge=(int)$row->nombre;                          
        } 
        
        if($count_conge > 0)
        {
            $data2 =  DB::table('tperso_demandeconge')
            ->join('tperso_annee','tperso_annee.id','=','tperso_demandeconge.annee_id')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_demandeconge.affectation_id')
            ->select(DB::raw('IFNULL(ROUND(SUM(TIMESTAMPDIFF(DAY, date_debut_accord, date_fin_accord)),0),0) as totalconge'))
            ->where([
               ['tperso_demandeconge.annee_id','=', $request->annee_id],
               ['affectation_id','=', $request->affectation_id],
               ['typecircintance_id','=', $request->typecircintance_id]
           ])    
            ->get(); 
            $output='';
            foreach ($data2 as $row) 
            {                                
                $cumule_annee=(int)$row->totalconge;                          
            }
        }
        else
        {
            $cumule_annee=0;
        }
 
        $data3 =  DB::table('tperso_typecirconstanceconge')
        ->select(DB::raw('nbrjour_cirscons'))
        ->where([
           ['tperso_typecirconstanceconge.id','=', $request->typecircintance_id]
       ])    
        ->get(); 
        $output='';
        foreach ($data3 as $row) 
        {                               
            $conge_total=$row->nbrjour_cirscons;                          
        }
        $solde_conge_datedu=(((int)$conge_total)-((int)$cumule_annee));
        $solde_conge_reprise=(((int)$solde_conge_datedu)-((int)$dureeAccord));

        $data = tperso_demandeconge::create([
            'affectation_id'       =>  $request->affectation_id,
            'typecircintance_id'    =>  $request->typecircintance_id,
            'description_conge'    =>  $request->description_conge,
            'date_demande'    =>  $request->date_demande,
            'date_depart'    =>  $request->date_depart,
            'nbr_joursollicite'    =>  $request->nbr_joursollicite,
            'date_reprise'    =>  $newDate,
            'superviseur_conge'    =>  $request->superviseur_conge, 
            'interimaire_conge'    =>  $request->interimaire_conge,
            'resumetache_conge'    =>  $request->resumetache_conge,
            'admin_fin_conge'    =>  $request->admin_fin_conge,
            'rh_conge'    =>  $request->rh_conge,
            'coordinateur_conge'    =>  $request->coordinateur_conge,
            'directeur_conge'    =>  $request->directeur_conge,
            'congess'       =>  'OUI',

            'date_debut_accord'    =>  $request->date_debut_accord,
            'nbr_jouraccord'    =>  $request->nbr_jouraccord,
            'date_fin_accord'    =>  $newDateAccord,
            'annee_id'    =>  $request->annee_id,

            'cumul_conge_annee'    =>  $cumule_annee,
            'solde_conge_datedu'    =>  $solde_conge_datedu,
            'solde_conge_reprise'    =>  $solde_conge_reprise,

            'author'       =>  $request->author,
        ]);

        $data = tperso_affectation_agent::where('id', $request->affectation_id)->update([
            'conge'       =>  'OUI'
        ]);

        return $this->msgJson('Information ajoutée avec succès');
    }


    function update_data(Request $request, $id)
    {
        $currentDate = Carbon::parse($request->date_depart);
        $duree = (int)$request->nbr_joursollicite;
        $newDate = $currentDate->addDays($duree);

        $currentDateAccord = Carbon::parse($request->date_debut_accord);
        $dureeAccord = (int)$request->nbr_jouraccord;
        $newDateAccord = $currentDateAccord->addDays($dureeAccord);

        $conge_total=0;
        $cumule_annee=0;
        $solde_conge_datedu=0;
        $solde_conge_reprise=0;

        $count_conge=0;

        $data5 =  DB::table('tperso_demandeconge')        
        ->select(DB::raw('IFNULL(COUNT(tperso_demandeconge.id),0) as nombre'))
        ->where([
           ['tperso_demandeconge.annee_id','=', $request->annee_id],
           ['affectation_id','=', $request->affectation_id],
           ['typecircintance_id','=', $request->typecircintance_id]
       ])    
        ->get(); 
        $output='';
        foreach ($data5 as $row) 
        {                                
            $count_conge=(int)$row->nombre;                          
        } 
        
        if($count_conge > 0)
        {
            $data2 =  DB::table('tperso_demandeconge')
            ->join('tperso_annee','tperso_annee.id','=','tperso_demandeconge.annee_id')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_demandeconge.affectation_id')
            ->select(DB::raw('IFNULL(ROUND(SUM(TIMESTAMPDIFF(DAY, date_debut_accord, date_fin_accord)),0),0) as totalconge'))
            ->where([
               ['tperso_demandeconge.annee_id','=', $request->annee_id],
               ['affectation_id','=', $request->affectation_id],
               ['typecircintance_id','=', $request->typecircintance_id]
           ])    
            ->get(); 
            $output='';
            foreach ($data2 as $row) 
            {                                
                $cumule_annee=(int)$row->totalconge;                          
            }
        }
        else
        {
            $cumule_annee=0;
        }



        $data3 =  DB::table('tperso_typecirconstanceconge')
        ->select(DB::raw('nbrjour_cirscons'))
        ->where([
           ['tperso_typecirconstanceconge.id','=', $request->typecircintance_id]
       ])    
        ->get(); 
        $output='';
        foreach ($data3 as $row) 
        {                               
            $conge_total=$row->nbrjour_cirscons;                          
        }
        $solde_conge_datedu=(((int)$conge_total)-((int)$cumule_annee));
        $solde_conge_reprise=(((int)$solde_conge_datedu)-((int)$dureeAccord));


        $data = tperso_demandeconge::where('id', $id)->update([
            'affectation_id'       =>  $request->affectation_id,
            'typecircintance_id'    =>  $request->typecircintance_id,
            'description_conge'    =>  $request->description_conge,
            'date_demande'    =>  $request->date_demande,
            'date_depart'    =>  $request->date_depart,
            'nbr_joursollicite'    =>  $request->nbr_joursollicite,
            'date_reprise'    =>  $newDate,
            'superviseur_conge'    =>  $request->superviseur_conge, 
            'interimaire_conge'    =>  $request->interimaire_conge,
            'resumetache_conge'    =>  $request->resumetache_conge,
            'admin_fin_conge'    =>  $request->admin_fin_conge,
            'rh_conge'    =>  $request->rh_conge,
            'coordinateur_conge'    =>  $request->coordinateur_conge,
            'directeur_conge'    =>  $request->directeur_conge,
            'congess'       =>  'OUI',

            'date_debut_accord'    =>  $request->date_debut_accord,
            'nbr_jouraccord'    =>  $request->nbr_jouraccord,
            'date_fin_accord'    =>  $newDateAccord,
            'annee_id'    =>  $request->annee_id,

            'cumul_conge_annee'    =>  $cumule_annee,
            'solde_conge_datedu'    =>  $solde_conge_datedu,
            'solde_conge_reprise'    =>  $solde_conge_reprise,

            'author'       =>  $request->author,
        ]);
        $data = tperso_affectation_agent::where('id', $request->affectation_id)->update([
            'conge'       =>  $request->congess
        ]);
        return $this->msgJson('Information ajoutée avec succès');
    }


    function delete_data(Request $request, $id)
    {
        $data = tperso_demandeconge::where('id',$id)->delete();
        $data = tperso_affectation_agent::where('id', $request->affectation_id)->update([
            'conge'       =>  'NON'
        ]);
        return $this->msgJson('Information ajoutée avec succès');
        
    }
}
