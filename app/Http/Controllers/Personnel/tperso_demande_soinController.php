<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_demande_soin;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tperso_demande_soinController extends Controller
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
            $data = DB::table('tperso_demande_soin')
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_demande_soin.refMois')
            ->join('tperso_annee','tperso_annee.id','=','tperso_demande_soin.refAnnee')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_demande_soin.refAffectation')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_demande_soin.id","malade","sexe","datenaissance","degreparente","medecinConsultant",
            "divRH","AG","dateDemande","refAffectation","refMois","refAnnee","name_annee",'name_mois',            
            "dateAffectation","codeAgent","numCNSS","autresDetail","refAgent","refServicePerso","refCategorieAgent",
            "matricule_agent","noms_agent","sexe_agent","datenaissance_agent","factures",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance, CURDATE()) as age_dependant')
            ->where([
                ['noms_agent', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_demande_soin.id", "desc")          
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tperso_demande_soin')
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_demande_soin.refMois')
            ->join('tperso_annee','tperso_annee.id','=','tperso_demande_soin.refAnnee')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_demande_soin.refAffectation')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_demande_soin.id","malade","sexe","datenaissance","degreparente","medecinConsultant",
            "divRH","AG","dateDemande","refAffectation","refMois","refAnnee","name_annee",'name_mois',            
            "dateAffectation","codeAgent","numCNSS","autresDetail","refAgent","refServicePerso","refCategorieAgent",
            "matricule_agent","noms_agent","sexe_agent","datenaissance_agent","factures",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance, CURDATE()) as age_dependant') 
            ->orderBy("tperso_demande_soin.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }


    public function fetch_affect_dmdSoin(Request $request,$refAffectation)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_demande_soin')
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_demande_soin.refMois')
            ->join('tperso_annee','tperso_annee.id','=','tperso_demande_soin.refAnnee')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_demande_soin.refAffectation')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_demande_soin.id","malade","sexe","datenaissance","degreparente","medecinConsultant",
            "divRH","AG","dateDemande","refAffectation","refMois","refAnnee","name_annee",'name_mois',            
            "dateAffectation","codeAgent","numCNSS","autresDetail","refAgent","refServicePerso","refCategorieAgent",
            "matricule_agent","noms_agent","sexe_agent","datenaissance_agent","factures",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance, CURDATE()) as age_dependant')               
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['refAffectation',$refAffectation]
            ])                    
            ->orderBy("tperso_demande_soin.id", "desc")
            ->paginate(10);

            return response($data, 200);         

        }
        else{
      
            $data = DB::table('tperso_demande_soin')
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_demande_soin.refMois')
            ->join('tperso_annee','tperso_annee.id','=','tperso_demande_soin.refAnnee')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_demande_soin.refAffectation')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_demande_soin.id","malade","sexe","datenaissance","degreparente","medecinConsultant",
            "divRH","AG","dateDemande","refAffectation","refMois","refAnnee","name_annee",'name_mois',            
            "dateAffectation","codeAgent","numCNSS","autresDetail","refAgent","refServicePerso","refCategorieAgent",
            "matricule_agent","noms_agent","sexe_agent","datenaissance_agent","factures",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance, CURDATE()) as age_dependant') 
            ->Where('refAffectation',$refAffectation)    
            ->orderBy("tperso_demande_soin.id", "desc")
            ->paginate(10);

            return response($data, 200);          
 
        }

    }    
    

    function fetch_single($id)
    {
        $data = DB::table('tperso_demande_soin')
        ->join('tperso_mois','tperso_mois.id','=', 'tperso_demande_soin.refMois')
        ->join('tperso_annee','tperso_annee.id','=','tperso_demande_soin.refAnnee')
        ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_demande_soin.refAffectation')
        ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
        ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refCategorieAgent')
        ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
        ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_demande_soin.id","malade","sexe","datenaissance","degreparente","medecinConsultant",
        "divRH","AG","dateDemande","refAffectation","refMois","refAnnee","name_annee",'name_mois',            
        "dateAffectation","codeAgent","numCNSS","autresDetail","refAgent","refServicePerso","refCategorieAgent",
        "matricule_agent","noms_agent","sexe_agent","datenaissance_agent","factures",
        "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
        "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
        "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
        "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance, CURDATE()) as age_dependant')
        ->where('tperso_demande_soin.id', $id)
        ->get();

       return response($data, 200);
    }

//id,refAffectation,malade,sexe,datenaissance,degreparente,medecinConsultant,divRH,AG,dateDemande,author
//factures   refMois refAnnee
    function insert_data(Request $request)
    {
      
        $data = tperso_demande_soin::create([
            'refAffectation'       =>  $request->refAffectation,
            'refMois'       =>  $request->refMois,
            'refAnnee'       =>  $request->refAnnee,
            'malade'    =>  $request->malade,
            'sexe'    =>  $request->sexe,
            'datenaissance'    =>  $request->datenaissance,   
            'degreparente'    =>  $request->degreparente,    
            'medecinConsultant'    =>  $request->medecinConsultant,
            'divRH'    =>  $request->divRH,       
            'AG'       =>  $request->AG,
            'dateDemande'       =>  $request->dateDemande,
            'factures'       =>  $request->factures,
            'author'       =>  $request->author,
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_data(Request $request, $id)
    {
        $data = tperso_demande_soin::where('id', $id)->update([
            'refAffectation'       =>  $request->refAffectation,
            'refMois'       =>  $request->refMois,
            'refAnnee'       =>  $request->refAnnee,
            'malade'    =>  $request->malade,
            'sexe'    =>  $request->sexe,
            'datenaissance'    =>  $request->datenaissance,
            'degreparente'    =>  $request->degreparente,     
            'medecinConsultant'    =>  $request->medecinConsultant,
            'divRH'    =>  $request->divRH,       
            'AG'       =>  $request->AG,
            'dateDemande'       =>  $request->dateDemande,
            'factures'       =>  $request->factures,
            'author'       =>  $request->author,
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!"
        ]);
    }


    function delete_data($id)
    {
        $data = tperso_demande_soin::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès"
        ]);
        
    }
}
