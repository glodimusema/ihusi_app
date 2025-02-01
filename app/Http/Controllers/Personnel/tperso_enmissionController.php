<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_enmission;
use App\Models\Personnel\tperso_affectation_agent;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tperso_enmissionController extends Controller
{
    use GlobalMethod, Slug  ;

    public function index()
    {
        return 'hello';
    }

    //'id','affectation_id','date_depart','date_retour','objets','lieu','autres_details','author'
//tperso_enmission

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    public function all(Request $request)
    {    
        if (!is_null($request->get('query'))) {

           
            # code..s.
            $query = $this->Gquery($request);
            $data = DB::table('tperso_enmission')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_enmission.affectation_id')
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
            ->select("tperso_enmission.id",'date_depart','date_retour','objets','lieu','autres_details',
            "tperso_enmission.author","affectation_id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
            'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
            'nom_contrat','code_contrat','param_salaire_id','fammiliale','logement','transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission',"categorie_id","projet_id","salaire_base",
            "partenaire_id","description_projet","chef_projet","date_debut_projet","date_fin_projet","nom_org",
            "adresse_org","contact_org","statut_tache","rccm_org", "idnat_org")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            ->selectRaw('TIMESTAMPDIFF(DAY, date_depart, date_retour) as dureemission')
            ->where([
                ['noms_agent', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_enmission.id", "desc")          
            ->paginate(10);

            return response($data, 200);       
        }
        else{
            $data = DB::table('tperso_enmission')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_enmission.affectation_id')
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
            ->select("tperso_enmission.id",'date_depart','date_retour','objets','lieu','autres_details',
            "tperso_enmission.author","affectation_id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
            'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
            'nom_contrat','code_contrat','param_salaire_id','fammiliale','logement','transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission',"categorie_id","projet_id","salaire_base",
            "partenaire_id","description_projet","chef_projet","date_debut_projet","date_fin_projet","nom_org",
            "adresse_org","contact_org","statut_tache","rccm_org", "idnat_org")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            ->selectRaw('TIMESTAMPDIFF(MONTH, date_depart, date_retour) as dureemission')          
            ->paginate(10);


            return response($data, 200);
        }

    }


    public function fetch_affect_controle(Request $request,$affectation_id)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_enmission')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_enmission.affectation_id')
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
            ->select("tperso_enmission.id",'date_depart','date_retour','objets','lieu','autres_details',
            "tperso_enmission.author","affectation_id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
            'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
            'nom_contrat','code_contrat','param_salaire_id','fammiliale','logement','transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission',"categorie_id","projet_id","salaire_base",
            "partenaire_id","description_projet","chef_projet","date_debut_projet","date_fin_projet","nom_org",
            "adresse_org","contact_org","statut_tache","rccm_org", "idnat_org")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            ->selectRaw('TIMESTAMPDIFF(MONTH, date_depart, date_retour) as dureemission')                         
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['affectation_id',$affectation_id]
            ])                    
            ->orderBy("tperso_enmission.id", "desc")
            ->paginate(10);

            return response($data, 200);          

        }
        else{
      
            $data = DB::table('tperso_enmission')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_enmission.affectation_id')
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
            ->select("tperso_enmission.id",'date_depart','date_retour','objets','lieu','autres_details',
            "tperso_enmission.author","affectation_id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
            'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
            'nom_contrat','code_contrat','param_salaire_id','fammiliale','logement','transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission',"categorie_id","projet_id","salaire_base",
            "partenaire_id","description_projet","chef_projet","date_debut_projet","date_fin_projet","nom_org",
            "adresse_org","contact_org","statut_tache","rccm_org", "idnat_org")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            ->selectRaw('TIMESTAMPDIFF(MONTH, date_depart, date_retour) as dureemission')                           
            ->Where('affectation_id',$affectation_id)    
            ->orderBy("tperso_enmission.id", "desc")
            ->paginate(10);
            
            return response($data, 200);        
 
        }

    }    
    
    function fetch_single($id)
    {

        $data = DB::table('tperso_enmission')
        ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_enmission.affectation_id')
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
        ->select("tperso_enmission.id",'date_depart','date_retour','objets','lieu','autres_details',
        "tperso_enmission.author","affectation_id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
        'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
        'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
        'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
        'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
        "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
        "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
        "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
        "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
        'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
        'nom_contrat','code_contrat','param_salaire_id','fammiliale','logement','transport','sal_brut','sal_brut_imposable',
        'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission',"categorie_id","projet_id","salaire_base",
        "partenaire_id","description_projet","chef_projet","date_debut_projet","date_fin_projet","nom_org",
        "adresse_org","contact_org","statut_tache","rccm_org", "idnat_org")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')
        ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
        ->selectRaw('TIMESTAMPDIFF(MONTH, date_depart, date_retour) as dureemission')
        ->where('tperso_enmission.id', $id)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }

//              // //'id','affectation_id','date_depart','date_retour','objets','lieu','autres_details','author'

    function insert_data(Request $request)
    {      
        $data = tperso_enmission::create([
            'affectation_id'       =>  $request->affectation_id,
            'date_depart'    =>  $request->date_depart,
            'date_retour'    =>  $request->date_retour,
            'objets'    =>  $request->objets,
            'lieu'    =>  $request->lieu,
            'autres_details'    =>  $request->autres_details,
            'author'       =>  $request->author
        ]);

        $data = tperso_affectation_agent::where('id', $request->affectation_id)->update([
            'mission' => 'OUI',
        ]);

        return response()->json([
            'data'  =>  "Insertion avec succès!!!"
        ]);

    }


    function update_data(Request $request, $id)
    {
        $data = tperso_enmission::where('id', $id)->update([
            'affectation_id'       =>  $request->affectation_id,
            'date_depart'    =>  $request->date_depart,
            'date_retour'    =>  $request->date_retour,
            'objets'    =>  $request->objets,
            'lieu'    =>  $request->lieu,
            'autres_details'    =>  $request->autres_details,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!"
        ]);
    }


    function delete_data($id)
    {
        $data = tperso_enmission::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès"
        ]);
        
    }
}
