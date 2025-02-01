<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_affectation_agent;
use App\Traits\{GlobalMethod,Slug};
use Illuminate\Support\Facades\Type;
use DB;
use Carbon\Carbon;

class tperso_affectation_agentController extends Controller
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
    public function all(Request $request)
    { 
        $current = Carbon::now(); 

        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);
            $data = DB::table('tperso_affectation_agent')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent",'fammiliale','logement','tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            ->where([
                ['noms_agent', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_affectation_agent.id", "desc")          
            ->paginate(5);
            return response($data, 200);
           

        }
        else{
            $data = DB::table('tperso_affectation_agent')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent",'fammiliale','logement','tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            ->orderBy("tperso_affectation_agent.id", "desc")          
            ->paginate(5);


            return response($data, 200);
        }

    }

    public function contrat_encours(Request $request)
    { 
        $current = Carbon::now();
           
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);
            $data = DB::table('tperso_affectation_agent')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent",'fammiliale','logement','tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['dateFin', '>=', $current]
            ])               
            ->orderBy("tperso_affectation_agent.id", "desc")          
            ->paginate(5);
            return response($data, 200);
           

        }
        else{
            $data = DB::table('tperso_affectation_agent')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent",'fammiliale','logement','tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            ->where([
                ['dateFin', '>=', $current]
            ])
            ->orderBy("tperso_affectation_agent.id", "desc")          
            ->paginate(5);


            return response($data, 200);
        }

    }


    public function contrat_encours_actif(Request $request)
    { 
        $current = Carbon::now();
           
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);
            $data = DB::table('tperso_affectation_agent')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent",'fammiliale','logement','tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['dateFin', '>=', $current],
                ['conge', '=', 'NON']
            ])               
            ->orderBy("tperso_affectation_agent.id", "desc")          
            ->paginate(5);
            return response($data, 200);
           

        }
        else{
            $data = DB::table('tperso_affectation_agent')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent",'fammiliale','logement','tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            ->where([
                ['dateFin', '>=', $current],
                ['conge', '=', 'NON']
            ])
            ->orderBy("tperso_affectation_agent.id", "desc")          
            ->paginate(5);


            return response($data, 200);
        }

    }

    public function contrat_encours_conge(Request $request)
    { 
        $current = Carbon::now();
           
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);
            $data = DB::table('tperso_affectation_agent')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent",'fammiliale','logement','tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['dateFin', '>=', $current],
                ['conge', '=', 'OUI']
            ])               
            ->orderBy("tperso_affectation_agent.id", "desc")          
            ->paginate(5);
            return response($data, 200);
           

        }
        else{
            $data = DB::table('tperso_affectation_agent')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent",'fammiliale','logement','tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            ->where([
                ['dateFin', '>=', $current],
                ['conge', '=', 'OUI']
            ])
            ->orderBy("tperso_affectation_agent.id", "desc")          
            ->paginate(5);


            return response($data, 200);
        }

    }


    public function contrat_fini(Request $request)
    { 
        $current = Carbon::now();
           
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);
            $data = DB::table('tperso_affectation_agent')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent",'fammiliale','logement','tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['dateFin', '<', $current]
            ])               
            ->orderBy("tperso_affectation_agent.id", "desc")          
            ->paginate(5);
            return response($data, 200);
           

        }
        else{
            $data = DB::table('tperso_affectation_agent')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent",'fammiliale','logement','tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            ->where([
                ['dateFin', '<', $current]
            ])
            ->orderBy("tperso_affectation_agent.id", "desc")          
            ->paginate(5);


            return response($data, 200);
        }

    }


    public function fetch_affect_agent(Request $request,$refAgent)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_affectation_agent')
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
            ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
            'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
            'nom_contrat','code_contrat','param_salaire_id','fammiliale','logement','tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission',"categorie_id","projet_id","salaire_base",
            "partenaire_id","description_projet","chef_projet","date_debut_projet","date_fin_projet","nom_org",
            "adresse_org","contact_org","rccm_org", "idnat_org","etat_contrat","salaire_prevu")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            //->selectRaw('((salaire_base +fammiliale + logement + tperso_affectation_agent.transport) - inss_qpo - ipr) as netPaie')
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['refAgent',$refAgent]
            ])                    
            ->orderBy("tperso_affectation_agent.id", "desc")
            ->paginate(5);

            return response($data, 200);        

        }
        else{
      
            $data = DB::table('tperso_affectation_agent')
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
            ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
            'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
            'nom_contrat','code_contrat','param_salaire_id','fammiliale','logement','tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission',"categorie_id","projet_id","salaire_base",
            "partenaire_id","description_projet","chef_projet","date_debut_projet","date_fin_projet","nom_org",
            "adresse_org","contact_org","rccm_org", "idnat_org","etat_contrat","salaire_prevu")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
            //->selectRaw('((salaire_base +fammiliale + logement + tperso_affectation_agent.transport) - inss_qpo - ipr) as netPaie')
            ->Where('refAgent',$refAgent)    
            ->orderBy("tperso_affectation_agent.id", "desc")
            ->paginate(5);

            return response($data, 200);         
 
        }

    }    

    
   

    function fetch_single($id)
    {

        $data = DB::table('tperso_affectation_agent')
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
        ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
        'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
        'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
        'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
        'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
        "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
        "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
        "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
        "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
        'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
        'nom_contrat','code_contrat','param_salaire_id','fammiliale','logement','tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
        'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission',"categorie_id","projet_id","salaire_base",
        "partenaire_id","description_projet","chef_projet","date_debut_projet","date_fin_projet","nom_org",
        "adresse_org","contact_org","rccm_org", "idnat_org","etat_contrat","salaire_prevu")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
        ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante')
        //->selectRaw('((salaire_base +fammiliale + logement + tperso_affectation_agent.transport) - inss_qpo - ipr) as netPaie')
        ->where('tperso_affectation_agent.id', $id)
        ->get();

        return response($data, 200);
    }



    function fetch_affectation_agent()
    {
        $current = Carbon::now();

        $data = DB::table('tperso_affectation_agent')
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
        ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
        'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
        'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
        'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
        'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
        "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
        "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
        "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
        "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
        'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
        'nom_contrat','code_contrat','param_salaire_id','fammiliale','logement','tperso_affectation_agent.transport','sal_brut','sal_brut_imposable',
        'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission',"categorie_id","projet_id","salaire_base",
        "partenaire_id","description_projet","chef_projet","date_debut_projet","date_fin_projet","nom_org",
        "adresse_org","contact_org","rccm_org", "idnat_org","etat_contrat","salaire_prevu")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')
        ->selectRaw('TIMESTAMPDIFF(MONTH, CURDATE(), dateFin) as dureerestante') 
        //->selectRaw('((salaire_base +fammiliale + logement + tperso_affectation_agent.transport) - inss_qpo - ipr) as netPaie')
        ->where('tperso_affectation_agent.dateFin','>=', $current)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }

    // ,"numcpteBanque","numImpot","BanqueAgant"
    // id,refAgent,refServicePerso,refCategorieAgent,dateAffectation,codeAgent,numCNSS,autresDetail,author

    // ,'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
    // 'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
    // 'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
    // 'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
    // 'BanqueAgant','autresDetail','conge'

    //,'param_salaire_id','fammiliale','logement','transport','sal_brut','sal_brut_imposable',
     //   'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission'

    function insert_data(Request $request)
    {
        $poste_id=0;
        $salaire_base=0;
        $nombre_enfant=0;
        $fammiliale=0;
        $logement=0;
        $transport=0;
        $sal_brut=0;
        $sal_brut_imposable=0;
        $inss_qpo=0;
        $inss_qpp=0;
        $cnss=0;
        $inpp=0;
        $onem=0;
        $ipr=0;

        $data2 =  DB::table('tperso_parametre_salairebase')       
        ->select("tperso_parametre_salairebase.id","tperso_parametre_salairebase.salaire_base",
        "tperso_parametre_salairebase.categorie_id")
        ->where('tperso_parametre_salairebase.id', '=', $request->param_salaire_id) 
        ->get(); 
        $output='';
        foreach ($data2 as $row) 
        {  
            $salaire_base=$row->salaire_base;   
            $poste_id=$row->categorie_id;               
        }

        $data3 = DB::table('tperso_dependant')            
        ->selectRaw('ROUND(COUNT(IFNULL(tperso_dependant.id,0)),0) as nbrEnfant')
        ->where([               
           ['refAgent','=', $request->refAgent]
        ])    
        ->get(); 
        $output='';
        foreach ($data3 as $row) 
        {                                
           $nombre_enfant=$row->nbrEnfant;
        }


        $data4 =  DB::table('tperso_poste')       
        ->select("tperso_poste.id","tperso_poste.transport")
        ->where('tperso_poste.id', '=', $request->refPoste) 
        ->get(); 
        $output='';
        foreach ($data4 as $row) 
        {  
            $transport=$row->transport;                  
        }

        $fammiliale = (int)$nombre_enfant * 5;
        $logement=((floatval($salaire_base)*30)/100);
        // $transport=0;
        $sal_brut=(($salaire_base)+($fammiliale)+($logement)+($transport));        
        $inss_qpo=((floatval($salaire_base)*5)/100);
        $inss_qpp=((floatval($salaire_base)*13)/100);
        $cnss=((floatval($salaire_base)*18)/100);
        $inpp=((floatval($salaire_base)*2)/100);
        $onem=((floatval($salaire_base)*0.2)/100);
        $sal_brut_imposable=((floatval($salaire_base))+(floatval($fammiliale))-(floatval($inss_qpo)));

        if($sal_brut_imposable >= 0 && $sal_brut_imposable<=96)
        {
            $ipr = (((floatval($sal_brut_imposable))*3)/100);
        }
        else if($sal_brut_imposable >= 96.1 && $sal_brut_imposable<=1067)
        {
            $ipr = (((((floatval($sal_brut_imposable) - 96))*15)/100)+2.88);
        }
        else if($sal_brut_imposable >= 1067.1 && $sal_brut_imposable<=2133)
        {
            $ipr = (((((floatval($sal_brut_imposable) - 1163))*30)/100)+148.49);
        }
        else if($sal_brut_imposable >= 2133.1 && $sal_brut_imposable<=3600000)
        {
            $ipr = (((((floatval($sal_brut_imposable) - 3296))*40)/100)+468.51);
        }
        else if($sal_brut_imposable > 3600000)
        {            
        }

        $currentDate = Carbon::parse($request->dateAffectation);
        $duree = (int)$request->dureecontrat;
        $newDate = $currentDate->addMonths($duree);

        $data = tperso_affectation_agent::create([
            'refAgent'       =>  $request->refAgent,
            'refServicePerso'    =>  $request->refServicePerso,
            'refCategorieAgent'    => $request->refCategorieAgent ,
            'refPoste'    =>    $poste_id,
            'refLieuAffectation'    =>  $request->refLieuAffectation,
            'refMutuelle'    =>  $request->refMutuelle,
            'refTypeContrat'    =>  $request->refTypeContrat,

            'param_salaire_id' => $request->param_salaire_id,
            'fammiliale' => $fammiliale,
            'logement' => $logement,
            'transport' => $transport,
            'sal_brut' => $sal_brut,
            'sal_brut_imposable' => $sal_brut_imposable,
            'inss_qpo' => $inss_qpo,
            'inss_qpp' => $inss_qpp,
            'cnss' => $cnss,
            'inpp' => $inpp,
            'onem' => $onem,
            'ipr' => $ipr,
            'mission' => 'NON',

            'dateAffectation'    =>  $request->dateAffectation, 
            'dureecontrat'    =>  $request->dureecontrat,
            'dureeLettre'    =>  $request->dureeLettre,
            'dateFin'    =>  $newDate,
            'dateDebutEssaie'    =>  $request->dateDebutEssaie,
            'dateFinEssaie'    =>  $request->dateFinEssaie,
            'JourTrail1'    =>  $request->JourTrail1,
            'JourTrail2'    =>  $request->JourTrail2,
            'heureTrail1'    =>  $request->heureTrail1,
            'heureTrail2'    =>  $request->heureTrail2,
            'TempsPause'    =>  $request->TempsPause,
            'nbrConge'    =>  $request->nbrConge,
            'nbrCongeLettre'    =>  $request->nbrCongeLettre,
            'nomOffice'    =>  $request->nomOffice,
            'postnomOffice'    =>  $request->postnomOffice,
            'qualifieOffice'    =>  $request->qualifieOffice,            
            'codeAgent'    =>  $request->codeAgent,
            'directeur'    =>  $request->directeur,
            'numCNSS'    =>  $request->numCNSS,
            'numImpot'    =>  $request->numImpot,
            'numcpteBanque'    =>  $request->numcpteBanque,
            'BanqueAgant'    =>  $request->BanqueAgant,       
            'autresDetail'       =>  $request->autresDetail,
            'conge'       =>  'NON',
            'etat_contrat'       =>  'Encours',
            'author'       =>  $request->author,
        ]);
        return $this->msgJson('Information ajoutée avec succès');
    }
//etat_contrat

    function update_data(Request $request, $id)
    {
        $poste_id=0;
        $nombre_enfant=0;
        $fammiliale=0;
        $logement=0;
        $transport=0;
        $sal_brut=0;
        $sal_brut_imposable=0;
        $inss_qpo=0;
        $inss_qpp=0;
        $cnss=0;
        $inpp=0;
        $onem=0;
        $ipr=0;

        $data2 =  DB::table('tperso_parametre_salairebase')       
        ->select("tperso_parametre_salairebase.id","tperso_parametre_salairebase.salaire_base",
        "tperso_parametre_salairebase.categorie_id")
        ->where('tperso_parametre_salairebase.id', '=', $request->param_salaire_id) 
        ->get(); 
        $output='';
        foreach ($data2 as $row) 
        {  
            $salaire_base=$row->salaire_base;   
            $poste_id=$row->categorie_id;               
        }

        $data3 = DB::table('tperso_dependant')            
        ->selectRaw('ROUND(COUNT(IFNULL(tperso_dependant.id,0)),0) as nbrEnfant')
        ->where([               
           ['refAgent','=', $request->refAgent]
        ])    
        ->get(); 
        $output='';
        foreach ($data3 as $row) 
        {                                
           $nombre_enfant=$row->nbrEnfant;
        }


        $data4 =  DB::table('tperso_poste')       
        ->select("tperso_poste.id","tperso_poste.transport")
        ->where('tperso_poste.id', '=', $request->refPoste) 
        ->get(); 
        $output='';
        foreach ($data4 as $row) 
        {  
            $transport=$row->transport;                  
        }

        $fammiliale = (int)$nombre_enfant * 5;
        $logement=((floatval($salaire_base)*30)/100);
        // $transport=0;
        $sal_brut=(($salaire_base)+($fammiliale)+($logement)+($transport));        
        $inss_qpo=((floatval($salaire_base)*5)/100);
        $inss_qpp=((floatval($salaire_base)*13)/100);
        $cnss=((floatval($salaire_base)*18)/100);
        $inpp=((floatval($salaire_base)*2)/100);
        $onem=((floatval($salaire_base)*0.2)/100);
        $sal_brut_imposable=((floatval($salaire_base))+(floatval($fammiliale))-(floatval($inss_qpo)));

        if($sal_brut_imposable >= 0 && $sal_brut_imposable<=96)
        {
            $ipr = (((floatval($sal_brut_imposable))*3)/100);
        }
        else if($sal_brut_imposable >= 96.1 && $sal_brut_imposable<=1067)
        {
            $ipr = (((((floatval($sal_brut_imposable) - 96))*15)/100)+2.88);
        }
        else if($sal_brut_imposable >= 1067.1 && $sal_brut_imposable<=2133)
        {
            $ipr = (((((floatval($sal_brut_imposable) - 1163))*30)/100)+148.49);
        }
        else if($sal_brut_imposable >= 2133.1 && $sal_brut_imposable<=3600000)
        {
            $ipr = (((((floatval($sal_brut_imposable) - 3296))*40)/100)+468.51);
        }
        else if($sal_brut_imposable > 3600000)
        {            
        }

        $currentDate = Carbon::parse($request->dateAffectation);
        $duree = (int)$request->dureecontrat;
        $newDate = $currentDate->addMonths($duree);

        $data = tperso_affectation_agent::where('id', $id)->update([
            'refAgent'       =>  $request->refAgent,
            'refServicePerso'    =>  $request->refServicePerso,
            'refCategorieAgent'    => $request->refCategorieAgent,
            'refPoste'    => $poste_id,
            'refLieuAffectation'    =>  $request->refLieuAffectation,
            'refMutuelle'    =>  $request->refMutuelle,
            'refTypeContrat'    =>  $request->refTypeContrat,

            'param_salaire_id' => $request->param_salaire_id,
            'fammiliale' => $fammiliale,
            'logement' => $logement,
            'transport' => $transport,
            'sal_brut' => $sal_brut,
            'sal_brut_imposable' => $sal_brut_imposable,
            'inss_qpo' => $inss_qpo,
            'inss_qpp' => $inss_qpp,
            'cnss' => $cnss,
            'inpp' => $inpp,
            'onem' => $onem,
            'ipr' => $ipr,
            'mission' => $request->mission,

            'dateAffectation'    =>  $request->dateAffectation, 
            'dureecontrat'    =>  $request->dureecontrat,
            'dureeLettre'    =>  $request->dureeLettre,
            'dateFin'    =>  $newDate,
            'dateDebutEssaie'    =>  $request->dateDebutEssaie,
            'dateFinEssaie'    =>  $request->dateFinEssaie,
            'JourTrail1'    =>  $request->JourTrail1,
            'JourTrail2'    =>  $request->JourTrail2,
            'heureTrail1'    =>  $request->heureTrail1,
            'heureTrail2'    =>  $request->heureTrail2,
            'TempsPause'    =>  $request->TempsPause,
            'nbrConge'    =>  $request->nbrConge,
            'nbrCongeLettre'    =>  $request->nbrCongeLettre,
            'nomOffice'    =>  $request->nomOffice,
            'postnomOffice'    =>  $request->postnomOffice,
            'qualifieOffice'    =>  $request->qualifieOffice,            
            'codeAgent'    =>  $request->codeAgent,
            'directeur'    =>  $request->directeur,
            'numCNSS'    =>  $request->numCNSS,
            'numImpot'    =>  $request->numImpot,
            'numcpteBanque'    =>  $request->numcpteBanque,
            'BanqueAgant'    =>  $request->BanqueAgant,       
            'autresDetail'       =>  $request->autresDetail,
            'etat_contrat'       =>  $request->etat_contrat,
            'author'       =>  $request->author,
        ]);
        return $this->msgJson('Information ajoutée avec succès');
    }


    function delete_data($id)
    {
        $data = tperso_affectation_agent::where('id',$id)->delete();
        return $this->msgJson('Information ajoutée avec succès');
        
    }
}
