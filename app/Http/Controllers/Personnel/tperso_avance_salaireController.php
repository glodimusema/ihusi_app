<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_avance_salaire;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tperso_avance_salaireController extends Controller
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
            $data = DB::table('tperso_avance_salaire')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_avance_salaire.refAffectation')
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_avance_salaire.refMois')
            ->join('tperso_annee','tperso_annee.id','=','tperso_avance_salaire.refAnne')
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
            ->select("tperso_avance_salaire.id","montant_avance","name_annee","tperso_avance_salaire.author",
            "refAffectation","refAnne",'refMois','name_mois',

            "dateAffectation","codeAgent","numCNSS","autresDetail",
            "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
            "noms_agent","lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->where([
                ['noms_agent', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_avance_salaire.id", "desc")          
            ->paginate(10);

            return response($data, 200);       
        }
        else{
            $data = DB::table('tperso_avance_salaire')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_avance_salaire.refAffectation')
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_avance_salaire.refMois')
            ->join('tperso_annee','tperso_annee.id','=','tperso_avance_salaire.refAnne')
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
            ->select("tperso_avance_salaire.id","montant_avance","name_annee","tperso_avance_salaire.author",
            "refAffectation","refAnne",'refMois','name_mois',

            "dateAffectation","codeAgent","numCNSS","autresDetail",
            "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
            "noms_agent","lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->orderBy("tperso_avance_salaire.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }


    public function fetch_affect_controle(Request $request,$refAffectation)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_avance_salaire')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_avance_salaire.refAffectation')
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_avance_salaire.refMois')
            ->join('tperso_annee','tperso_annee.id','=','tperso_avance_salaire.refAnne')
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
            ->select("tperso_avance_salaire.id","montant_avance","name_annee","tperso_avance_salaire.author",
            "refAffectation","refAnne",'refMois','name_mois',

            "dateAffectation","codeAgent","numCNSS","autresDetail",
            "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
            "noms_agent","lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")                         
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['refAffectation',$refAffectation]
            ])                    
            ->orderBy("tperso_avance_salaire.id", "desc")
            ->paginate(10);

            return response($data, 200);          

        }
        else{
      
            $data = DB::table('tperso_avance_salaire')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_avance_salaire.refAffectation')
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_avance_salaire.refMois')
            ->join('tperso_annee','tperso_annee.id','=','tperso_avance_salaire.refAnne')
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
            ->select("tperso_avance_salaire.id","montant_avance","name_annee","tperso_avance_salaire.author",
            "refAffectation","refAnne",'refMois','name_mois',

            "dateAffectation","codeAgent","numCNSS","autresDetail",
            "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
            "noms_agent","lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")                           
            ->Where('refAffectation',$refAffectation)    
            ->orderBy("tperso_avance_salaire.id", "desc")
            ->paginate(10);
            
            return response($data, 200);        
 
        }

    }    
    
    function fetch_single($id)
    {

        $data = DB::table('tperso_avance_salaire')
        ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_avance_salaire.refAffectation')
        ->join('tperso_mois','tperso_mois.id','=', 'tperso_avance_salaire.refMois')
        ->join('tperso_annee','tperso_annee.id','=','tperso_avance_salaire.refAnne')
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
        ->select("tperso_avance_salaire.id","montant_avance","name_annee","tperso_avance_salaire.author",
        "refAffectation","refAnne",'refMois','name_mois',

        "dateAffectation","codeAgent","numCNSS","autresDetail",
        "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
        "noms_agent","lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
        "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
        "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
        "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
        ->where('tperso_avance_salaire.id', $id)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }

//              //id,refAffectation,refAnne,refMois,montant_avance,author

    function insert_data(Request $request)
    {      
        $data = tperso_avance_salaire::create([
            'refAffectation'       =>  $request->refAffectation,
            'refAnne'    =>  $request->refAnne,
            'refMois'    =>  $request->refMois,
            'montant_avance'    =>  $request->montant_avance,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!"
        ]);

    }


    function update_data(Request $request, $id)
    {
        $data = tperso_avance_salaire::where('id', $id)->update([
            'refAffectation'       =>  $request->refAffectation,
            'refAnne'    =>  $request->refAnne,
            'refMois'    =>  $request->refMois,
            'montant_avance'    =>  $request->montant_avance,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!"
        ]);
    }


    function delete_data($id)
    {
        $data = tperso_avance_salaire::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès"
        ]);
        
    }
}
