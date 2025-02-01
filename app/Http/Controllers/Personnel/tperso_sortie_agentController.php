<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_sortie_agent;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tperso_sortie_agentController extends Controller
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
            $data = DB::table('tperso_sortie_agent')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_sortie_agent.refAffectation')
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
            ->select("tperso_sortie_agent.id","heureSortie","heureRetourPrevue",
            "dateSortie","motif","heureRetour","dateRetour","annexeSortie","libelleannexe","viseBRH",
            "refAffectation","tperso_sortie_agent.author",
            "dateAffectation","codeAgent","numCNSS","autresDetail",
            "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
            "noms_agent","sexe_agent","datenaissance_agent",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->where([
                ['noms_agent', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_sortie_agent.id", "desc")          
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tperso_sortie_agent')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_sortie_agent.refAffectation')
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
            ->select("tperso_sortie_agent.id","heureSortie","heureRetourPrevue",
            "dateSortie","motif","heureRetour","dateRetour","annexeSortie","libelleannexe","viseBRH",
            "refAffectation","tperso_sortie_agent.author",
            "dateAffectation","codeAgent","numCNSS","autresDetail",
            "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
            "noms_agent","sexe_agent","datenaissance_agent",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent') 
            ->orderBy("tperso_sortie_agent.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }


    public function fetch_sortieAgent_affect(Request $request,$refAffectation)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_sortie_agent')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_sortie_agent.refAffectation')
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
            ->select("tperso_sortie_agent.id","heureSortie","heureRetourPrevue",
            "dateSortie","motif","heureRetour","dateRetour","annexeSortie","libelleannexe","viseBRH",
            "refAffectation","tperso_sortie_agent.author",
            "dateAffectation","codeAgent","numCNSS","autresDetail",
            "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
            "noms_agent","sexe_agent","datenaissance_agent",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent') 
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['refAffectation',$refAffectation]
            ])                    
            ->orderBy("tperso_sortie_agent.id", "desc")
            ->paginate(10);

            return response($data, 200);          

        }
        else{
      
            $data = DB::table('tperso_sortie_agent')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_sortie_agent.refAffectation')
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
            ->select("tperso_sortie_agent.id","heureSortie","heureRetourPrevue",
            "dateSortie","motif","heureRetour","dateRetour","annexeSortie","libelleannexe","viseBRH",
            "refAffectation","tperso_sortie_agent.author",
            "dateAffectation","codeAgent","numCNSS","autresDetail",
            "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
            "noms_agent","sexe_agent","datenaissance_agent",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent') 
            ->Where('refAffectation',$refAffectation)    
            ->orderBy("tperso_sortie_agent.id", "desc")
            ->paginate(10);

            return response($data, 200);          
 
        }

    }    

    

    function fetch_single($id)
    {

        $data = DB::table('tperso_sortie_agent')
        ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_sortie_agent.refAffectation')
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
        ->select("tperso_sortie_agent.id","heureSortie","heureRetourPrevue",
        "dateSortie","motif","heureRetour","dateRetour","annexeSortie","libelleannexe","viseBRH",
        "refAffectation","tperso_sortie_agent.author",
        "dateAffectation","codeAgent","numCNSS","autresDetail",
        "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
        "noms_agent","sexe_agent","datenaissance_agent",
        "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
        "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
        "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
        "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent') 
        ->where('tperso_sortie_agent.id', $id)
        ->get();

        return response($data, 200);
    }

//id,refAffectation,heureSortie,heureRetourPrevue,dateSortie,motif,heureRetour,dateRetour,annexeSortie,viseBRH,author

    function insert_data(Request $request)
    {
//libelleannexe
        if (!is_null($request->image)) 
        {
           $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();          
            $request->image->move(public_path('/fichier'), $imageName); 
   
            $data= tperso_sortie_agent::create([
                'refAffectation'       =>  $formData->refAffectation,
                'heureSortie'    =>  $formData->heureSortie,
                'heureRetourPrevue'    =>  $formData->heureRetourPrevue,
                'dateSortie'    =>  $formData->dateSortie,    
                'motif'    =>  $formData->motif,
                'heureRetour'    =>  $formData->heureRetour,       
                'dateRetour'       =>  $formData->dateRetour,
                'annexeSortie'       =>  $imageName,
                'libelleannexe'       =>  $formData->libelleannexe,
                'viseBRH'       =>  $formData->viseBRH,
                'author'       =>  $formData->author,            
            ]);
   
            return response()->json([
               'data'  =>  "Insertion avec succès!!!",
           ]);
        }
        else{
           $formData = json_decode($_POST['data']);
           $data= tperso_sortie_agent::create([
            'refAffectation'       =>  $formData->refAffectation,
            'heureSortie'    =>  $formData->heureSortie,
            'heureRetourPrevue'    =>  $formData->heureRetourPrevue,
            'dateSortie'    =>  $formData->dateSortie,    
            'motif'    =>  $formData->motif,
            'heureRetour'    =>  $formData->heureRetour,       
            'dateRetour'       =>  $formData->dateRetour,
            'annexeSortie'       =>  'avatar.png',
            'libelleannexe'       =>  $formData->libelleannexe,
            'viseBRH'       =>  $formData->viseBRH,
            'author'       =>  $formData->author,            
       ]);
            return response()->json([
               'data'  =>  "Insertion avec succès!!!",
           ]);
   
        }
 
    }


    function update_data(Request $request, $id)
    {
        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();          
            $request->image->move(public_path('/fichier'), $imageName);
         
           $data= tperso_sortie_agent::where('id',$formData->id)->update([
                'refAffectation'       =>  $formData->refAffectation,
                'heureSortie'    =>  $formData->heureSortie,
                'heureRetourPrevue'    =>  $formData->heureRetourPrevue,
                'dateSortie'    =>  $formData->dateSortie,    
                'motif'    =>  $formData->motif,
                'heureRetour'    =>  $formData->heureRetour,       
                'dateRetour'       =>  $formData->dateRetour,
                'annexeSortie'       =>  $imageName,
                'libelleannexe'       =>  $formData->libelleannexe,
                'viseBRH'       =>  $formData->viseBRH,
                'author'       =>  $formData->author,            
            ]);
   
            return response()->json([
               'data'  =>  "Modification avec succès!!",
           ]);
    
        }
        else{
            $formData = json_decode($_POST['data']);
            $data= tperso_sortie_agent::where('id',$formData->id)->update([
                'refAffectation'       =>  $formData->refAffectation,
                'heureSortie'    =>  $formData->heureSortie,
                'heureRetourPrevue'    =>  $formData->heureRetourPrevue,
                'dateSortie'    =>  $formData->dateSortie,    
                'motif'    =>  $formData->motif,
                'heureRetour'    =>  $formData->heureRetour,       
                'dateRetour'       =>  $formData->dateRetour,
                'annexeSortie'       =>  'avatar.png',
                'libelleannexe'       =>  $formData->libelleannexe,
                'viseBRH'       =>  $formData->viseBRH,
                'author'       =>  $formData->author,
            ]);
   
            return response()->json([
               'data'  =>  "Modification avec succès!!",
           ]);
    
   
        }
    }


    function delete_data($id)
    {
        $data = tperso_sortie_agent::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
