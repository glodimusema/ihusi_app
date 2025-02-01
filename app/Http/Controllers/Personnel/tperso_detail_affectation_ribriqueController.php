<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_detail_affectation_ribrique;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tperso_detail_affectation_ribriqueController extends Controller
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
            $data = DB::table('tperso_detail_affectation_ribrique')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_detail_affectation_ribrique.refAffectation')
            ->join('tperso_parametre_rubrique','tperso_parametre_rubrique.id','=','tperso_detail_affectation_ribrique.refParametre')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=', 'tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_rubrique','tperso_rubrique.id','=', 'tperso_parametre_rubrique.refRubrique')
            ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=', 'tperso_rubrique.refCatRubrique') 
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_detail_affectation_ribrique.id","name_categorie_agent","name_rubrique","name_categorie_rubrique",
            "montant","refAffectation","refParametre","tperso_affectation_agent.refCategorieAgent","dateAffectation","codeAgent","numCNSS","autresDetail",
            "refAgent","refServicePerso","matricule_agent","noms_agent","sexe_agent",
            "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent') 
            ->selectRaw('CONCAT("",name_rubrique," (",montant,"$)") as libelles')   
            ->where([
                ['noms_agent', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_detail_affectation_ribrique.id", "desc")          
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tperso_detail_affectation_ribrique')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_detail_affectation_ribrique.refAffectation')
            ->join('tperso_parametre_rubrique','tperso_parametre_rubrique.id','=','tperso_detail_affectation_ribrique.refParametre')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=', 'tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_rubrique','tperso_rubrique.id','=', 'tperso_parametre_rubrique.refRubrique')
            ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=', 'tperso_rubrique.refCatRubrique') 
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_detail_affectation_ribrique.id","name_categorie_agent","name_rubrique","name_categorie_rubrique",
            "montant","refAffectation","refParametre","tperso_affectation_agent.refCategorieAgent","dateAffectation","codeAgent","numCNSS","autresDetail",
            "refAgent","refServicePerso","matricule_agent","noms_agent","sexe_agent",
            "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent') 
            ->selectRaw('CONCAT("",name_rubrique," (",montant,"$)") as libelles')      
            ->orderBy("tperso_detail_affectation_ribrique.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }


    public function fetch_affect_detail(Request $request,$refAffectation)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_detail_affectation_ribrique')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_detail_affectation_ribrique.refAffectation')
            ->join('tperso_parametre_rubrique','tperso_parametre_rubrique.id','=','tperso_detail_affectation_ribrique.refParametre')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=', 'tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_rubrique','tperso_rubrique.id','=', 'tperso_parametre_rubrique.refRubrique')
            ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=', 'tperso_rubrique.refCatRubrique') 
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_detail_affectation_ribrique.id","name_categorie_agent","name_rubrique","name_categorie_rubrique",
            "montant","refAffectation","refParametre","tperso_affectation_agent.refCategorieAgent","dateAffectation","codeAgent","numCNSS","autresDetail",
            "refAgent","refServicePerso","matricule_agent","noms_agent","sexe_agent",
            "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent') 
            ->selectRaw('CONCAT("",name_rubrique," (",montant,"$)") as libelles')               
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['refAffectation',$refAffectation]
            ])                    
            ->orderBy("tperso_detail_affectation_ribrique.id", "desc")
            ->paginate(10);

            return response($data, 200);         

        }
        else{
      
            $data = DB::table('tperso_detail_affectation_ribrique')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_detail_affectation_ribrique.refAffectation')
            ->join('tperso_parametre_rubrique','tperso_parametre_rubrique.id','=','tperso_detail_affectation_ribrique.refParametre')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=', 'tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_rubrique','tperso_rubrique.id','=', 'tperso_parametre_rubrique.refRubrique')
            ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=', 'tperso_rubrique.refCatRubrique') 
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_detail_affectation_ribrique.id","name_categorie_agent","name_rubrique","name_categorie_rubrique",
            "montant","refAffectation","refParametre","tperso_affectation_agent.refCategorieAgent","dateAffectation","codeAgent","numCNSS","autresDetail",
            "refAgent","refServicePerso","matricule_agent","noms_agent","sexe_agent",
            "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent') 
            ->selectRaw('CONCAT("",name_rubrique," (",montant,"$)") as libelles')             
            ->Where('refAffectation',$refAffectation)    
            ->orderBy("tperso_detail_affectation_ribrique.id", "desc")
            ->paginate(10);
            return response($data, 200);          
 
        }

    }    
    

    function fetch_single($id)
    {

        $data = DB::table('tperso_detail_affectation_ribrique')
        ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_detail_affectation_ribrique.refAffectation')
        ->join('tperso_parametre_rubrique','tperso_parametre_rubrique.id','=','tperso_detail_affectation_ribrique.refParametre')
        ->join('tperso_categorie_agent','tperso_categorie_agent.id','=', 'tperso_affectation_agent.refCategorieAgent')
        ->join('tperso_rubrique','tperso_rubrique.id','=', 'tperso_parametre_rubrique.refRubrique')
        ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=', 'tperso_rubrique.refCatRubrique') 
        ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
        ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
        ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_detail_affectation_ribrique.id","name_categorie_agent","name_rubrique","name_categorie_rubrique",
        "montant","refAffectation","refParametre","tperso_affectation_agent.refCategorieAgent","dateAffectation","codeAgent","numCNSS","autresDetail",
        "refAgent","refServicePerso","matricule_agent","noms_agent","sexe_agent",
        "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
        "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
        "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
        "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent') 
        ->selectRaw('CONCAT("",name_rubrique," (",montant,"$)") as libelles') 
        ->where('tperso_detail_affectation_ribrique.id', $id)
        ->get();

        return response($data, 200);
    }



    function fetch_detail_affectation_affect_agent($refAffectation)
    {

        $data = DB::table('tperso_detail_affectation_ribrique')
        ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_detail_affectation_ribrique.refAffectation')
        ->join('tperso_parametre_rubrique','tperso_parametre_rubrique.id','=','tperso_detail_affectation_ribrique.refParametre')
        ->join('tperso_categorie_agent','tperso_categorie_agent.id','=', 'tperso_affectation_agent.refCategorieAgent')
        ->join('tperso_rubrique','tperso_rubrique.id','=', 'tperso_parametre_rubrique.refRubrique')
        ->join('tperso_categorie_rubrique','tperso_categorie_rubrique.id','=', 'tperso_rubrique.refCatRubrique') 
        ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
        ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
        ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_detail_affectation_ribrique.id","name_categorie_agent","name_rubrique","name_categorie_rubrique",
        "montant","refAffectation","refParametre","dateAffectation","codeAgent","numCNSS","autresDetail",
        "refAgent","refServicePerso","tperso_affectation_agent.refCategorieAgent","matricule_agent","noms_agent","sexe_agent",
        "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
        "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
        "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
        "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent') 
        ->selectRaw('CONCAT("",name_rubrique," (",montant,"$)") as libelles')
        ->where('tperso_detail_affectation_ribrique.refAffectation', $refAffectation)
        ->get();

        return response($data, 200);
    }



//id,refAffectation,refParametre,author
    function insert_data(Request $request)
    {      
        $data = tperso_detail_affectation_ribrique::create([
            'refAffectation'       =>  $request->refAffectation,
            'refParametre'    =>  $request->refParametre,
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_data(Request $request, $id)
    {
        $data = tperso_detail_affectation_ribrique::where('id', $id)->update([
            'refAffectation'       =>  $request->refAffectation,
            'refParametre'    =>  $request->refParametre,
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!"
        ]);
    }


    function delete_data($id)
    {
        $data = tperso_detail_affectation_ribrique::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès"
        ]);
        
    }
}
