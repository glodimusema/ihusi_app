<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_entete_paiement;
use App\Models\Personnel\tperso_fiche_paie;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tperso_entete_paiementController extends Controller
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

    public function all(Request $request)
    {    
        if (!is_null($request->get('query'))) {
           
            # code..s.
            $query = $this->Gquery($request);
            $data = DB::table('tperso_entete_paiement')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_paiement.refAffectation')
            ->join('tperso_fiche_paie','tperso_fiche_paie.id','=','tperso_entete_paiement.refFichePaie')
            ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_fiche_paie.refMois')
            ->join('tperso_annee','tperso_annee.id','=', 'tperso_fiche_paie.refAnne')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_entete_paiement.id","refAffectation","name_mois","name_annee","dateFiche","refAnne",
            "refMois","dateAffectation","codeAgent","numCNSS","numcpteBanque",
            "numImpot","BanqueAgant","autresDetail",'refFichePaie',
            "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
            "noms_agent","sexe_agent","datenaissance_agent",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
            "tagent.photo as photo_agent","tagent.slug as slug_agent","name_serv_perso",
            "name_categorie_service","name_categorie_agent",'refBanque',
            "tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
            'refSousCompte','nom_ssouscompte','numero_ssouscompte')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->where([
                ['noms_agent', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_entete_paiement.id", "desc")          
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tperso_entete_paiement')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_paiement.refAffectation')
            ->join('tperso_fiche_paie','tperso_fiche_paie.id','=','tperso_entete_paiement.refFichePaie')
            ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_fiche_paie.refMois')
            ->join('tperso_annee','tperso_annee.id','=', 'tperso_fiche_paie.refAnne')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_entete_paiement.id","refAffectation","name_mois","name_annee","dateFiche","refAnne",
            "refMois","dateAffectation","codeAgent","numCNSS","numcpteBanque",
            "numImpot","BanqueAgant","autresDetail",'refFichePaie',
            "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
            "noms_agent","sexe_agent","datenaissance_agent",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
            "tagent.photo as photo_agent","tagent.slug as slug_agent","name_serv_perso",
            "name_categorie_service","name_categorie_agent",'refBanque',
            "tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
            'refSousCompte','nom_ssouscompte','numero_ssouscompte')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')         
            ->orderBy("tperso_entete_paiement.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }


    public function fetch_entete_paiement_fiche(Request $request,$refFichePaie)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_entete_paiement')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_paiement.refAffectation')
            ->join('tperso_fiche_paie','tperso_fiche_paie.id','=','tperso_entete_paiement.refFichePaie')
            ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_fiche_paie.refMois')
            ->join('tperso_annee','tperso_annee.id','=', 'tperso_fiche_paie.refAnne')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_entete_paiement.id","refAffectation","name_mois","name_annee","dateFiche","refAnne",
            "refMois","dateAffectation","codeAgent","numCNSS","numcpteBanque",
            "numImpot","BanqueAgant","autresDetail",'refFichePaie',
            "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
            "noms_agent","sexe_agent","datenaissance_agent",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
            "tagent.photo as photo_agent","tagent.slug as slug_agent","name_serv_perso",
            "name_categorie_service","name_categorie_agent",'refBanque',
            "tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
            'refSousCompte','nom_ssouscompte','numero_ssouscompte')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')     
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['refFichePaie',$refFichePaie]
            ])                    
            ->orderBy("tperso_entete_paiement.id", "desc")
            ->paginate(10);

            return response($data, 200);          

        }
        else{
      
            $data = DB::table('tperso_entete_paiement')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_paiement.refAffectation')
            ->join('tperso_fiche_paie','tperso_fiche_paie.id','=','tperso_entete_paiement.refFichePaie')
            ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_fiche_paie.refMois')
            ->join('tperso_annee','tperso_annee.id','=', 'tperso_fiche_paie.refAnne')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_entete_paiement.id","refAffectation","name_mois","name_annee","dateFiche","refAnne",
            "refMois","dateAffectation","codeAgent","numCNSS","numcpteBanque",
            "numImpot","BanqueAgant","autresDetail",'refFichePaie',
            "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
            "noms_agent","sexe_agent","datenaissance_agent",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
            "tagent.photo as photo_agent","tagent.slug as slug_agent","name_serv_perso",
            "name_categorie_service","name_categorie_agent",'refBanque',
            "tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
            'refSousCompte','nom_ssouscompte','numero_ssouscompte')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->Where('refFichePaie',$refFichePaie)    
            ->orderBy("tperso_entete_paiement.id", "desc")
            ->paginate(10);

            return response($data, 200);          
 
        }

    }    
    

    function fetch_single($id)
    {

        $data = DB::table('tperso_entete_paiement')
        ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_entete_paiement.refAffectation')
        ->join('tperso_fiche_paie','tperso_fiche_paie.id','=','tperso_entete_paiement.refFichePaie')
        ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tperso_mois','tperso_mois.id','=', 'tperso_fiche_paie.refMois')
        ->join('tperso_annee','tperso_annee.id','=', 'tperso_fiche_paie.refAnne')
        ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
        ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
        ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_entete_paiement.id","refAffectation","name_mois","name_annee","dateFiche","refAnne",
        "refMois","dateAffectation","codeAgent","numCNSS","numcpteBanque",
        "numImpot","BanqueAgant","autresDetail",'refFichePaie',
        "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
        "noms_agent","sexe_agent","datenaissance_agent",
        "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
        "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
        "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
        "tagent.photo as photo_agent","tagent.slug as slug_agent","name_serv_perso",
        "name_categorie_service","name_categorie_agent",'refBanque',
        "tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
        'refSousCompte','nom_ssouscompte','numero_ssouscompte')
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
        ->where('tperso_entete_paiement.id', $id)
        ->get();

        return response($data, 200);
    }

    //id,refAffectation,refFichePaie,author

    function insert_data(Request $request)
    { 
        $data = tperso_entete_paiement::create([
            'refAffectation'       =>  $request->refAffectation,
            'refFichePaie'    =>  $request->refFichePaie,
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_data(Request $request, $id)
    {
        $data = tperso_entete_paiement::where('id', $id)->update([
            'refAffectation'       =>  $request->refAffectation,
            'refFichePaie'    =>  $request->refFichePaie,
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!"
        ]);
    }


    function delete_data($id)
    {
        $data = tperso_entete_paiement::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès"
        ]);
        
    }
}
