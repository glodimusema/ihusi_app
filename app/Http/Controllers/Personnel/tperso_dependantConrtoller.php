<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_dependant;  
use App\Traits\{GlobalMethod,Slug};
use DB;

class tperso_dependantConrtoller extends Controller
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
            $data = DB::table('tperso_dependant')
            ->join('tagent','tagent.id','=','tperso_dependant.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_dependant.id","noms_dependant","sexe","date_naissance","etat_civile","degre_parente","annexe",
            "refAgent","matricule_agent",'tperso_dependant.author',
            "noms_agent","sexe_agent","datenaissance_agent",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->where([
                ['noms_agent', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_dependant.id", "desc")          
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tperso_dependant')
            ->join('tagent','tagent.id','=','tperso_dependant.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_dependant.id","noms_dependant","sexe","date_naissance","etat_civile","degre_parente","annexe",
            "refAgent","matricule_agent",'tperso_dependant.author',
            "noms_agent","sexe_agent","datenaissance_agent",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')            
            ->orderBy("tperso_dependant.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }


    public function fetch_depend_agent(Request $request,$refAgent)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_dependant')
            ->join('tagent','tagent.id','=','tperso_dependant.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_dependant.id","noms_dependant","sexe","date_naissance","etat_civile","degre_parente","annexe",
            "refAgent","matricule_agent",'tperso_dependant.author',
            "noms_agent","sexe_agent","datenaissance_agent",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')               
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['refAgent',$refAgent]
            ])                    
            ->orderBy("tperso_dependant.id", "desc")
            ->paginate(10);

            return response($data, 200);          

        }
        else{
      
            $data = DB::table('tperso_dependant')
            ->join('tagent','tagent.id','=','tperso_dependant.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_dependant.id","noms_dependant","sexe","date_naissance","etat_civile","degre_parente","annexe",
            "refAgent","matricule_agent",'tperso_dependant.author',
            "noms_agent","sexe_agent","datenaissance_agent",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')               
            ->Where('refAgent',$refAgent)    
            ->orderBy("tperso_dependant.id", "desc")
            ->paginate(10);

            return response($data, 200);          
 
        }

    }    

    
    function fetch_list_agent()
    {
        $data = DB::table('tagent')
        ->select("id",'matricule_agent',"noms_agent",'specialite_agent','fonction_agent')
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }
    

    function fetch_single($id)
    {

        $data = DB::table('tperso_dependant')
        ->join('tagent','tagent.id','=','tperso_dependant.refAgent')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_dependant.id","noms_dependant","sexe","date_naissance","etat_civile","degre_parente","annexe",
        "refAgent","matricule_agent",'tperso_dependant.author',
        "noms_agent","sexe_agent","datenaissance_agent",
        "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
        "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
        "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
        "tagent.slug as slug_agent")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
        ->where('tperso_dependant.id', $id)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }



    function insert_data(Request $request)
    {
        //id,noms_dependant,refAgent,sexe,date_naissance,etat_civile,degre_parente,annexe,author
        if (!is_null($request->image)) 
        {
           $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();          
            $request->image->move(public_path('/fichier'), $imageName); 

  
            $data= tperso_dependant::create([
                'noms_dependant'       =>  $formData->noms_dependant,
                'refAgent'       =>  $formData->refAgent,
                'sexe'    =>  $formData->sexe,
                'date_naissance'    =>  $formData->date_naissance,
                'etat_civile'    =>  $formData->etat_civile,    
                'degre_parente'    =>  $formData->degre_parente,
                'annexe'    =>  $imageName,
                'author'  =>  $formData->author        
            ]);
   
            return response()->json([
               'data'  =>  "Insertion avec succès!!!",
           ]);
        }
        else{
           $formData = json_decode($_POST['data']);
           $data= tperso_dependant::create([
            'noms_dependant'       =>  $formData->noms_dependant,
            'refAgent'       =>  $formData->refAgent,
            'sexe'    =>  $formData->sexe,
            'date_naissance'    =>  $formData->date_naissance,
            'etat_civile'    =>  $formData->etat_civile,    
            'degre_parente'    =>  $formData->degre_parente,
            'annexe'    =>  'avatar.png',
            'author'  =>  $formData->author        
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
         
           $data= tperso_dependant::where('id',$formData->id)->update([
                'noms_dependant'       =>  $formData->noms_dependant,
                'refAgent'       =>  $formData->refAgent,
                'sexe'    =>  $formData->sexe,
                'date_naissance'    =>  $formData->date_naissance,
                'etat_civile'    =>  $formData->etat_civile,    
                'degre_parente'    =>  $formData->degre_parente,
                'annexe'    =>  $imageName,
                'author'  =>  $formData->author      
            ]);
   
            return response()->json([
               'data'  =>  "Modification avec succès!!",
           ]);
    
        }
        else{
            $formData = json_decode($_POST['data']);
            $data= tperso_dependant::where('id',$formData->id)->update([
                'noms_dependant'       =>  $formData->noms_dependant,
                'refAgent'       =>  $formData->refAgent,
                'sexe'    =>  $formData->sexe,
                'date_naissance'    =>  $formData->date_naissance,
                'etat_civile'    =>  $formData->etat_civile,    
                'degre_parente'    =>  $formData->degre_parente,
                'author'  =>  $formData->author
            ]);
   
            return response()->json([
               'data'  =>  "Modification avec succès!!",
           ]);
    
   
        }
       }


    function delete_data($id)
    {
        $data = tperso_dependant::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
