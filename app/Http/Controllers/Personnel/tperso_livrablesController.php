<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_livrables;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;

class tperso_livrablesController extends Controller
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
            $data = DB::table('tperso_livrables')
            ->join('tperso_activites_projet','tperso_activites_projet.id','=','tperso_livrables.activite_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_activites_projet.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
            ->select("tperso_livrables.id", "activite_id", "designation_livrable", "description_livrable", 
            "fichiers", "statut_livrable","projet_id", "description_tache", "date_debut_tache","duree_tache", 
            "date_fin_tache", "nbr_heureJour", "cout_heure","partenaire_id", "typecontrat_id","nom_contrat",
            "code_contrat","description_projet", "chef_projet","date_debut_projet", "date_fin_projet",
            "tperso_livrables.author","tperso_livrables.created_at","nom_org", "adresse_org", 
            "contact_org", "rccm_org", "idnat_org")   
            ->where([
                ['designation_livrable', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_livrables.id", "desc")          
            ->paginate(10);
            return response($data, 200);
        }
        else{
            $data = DB::table('tperso_livrables')
            ->join('tperso_activites_projet','tperso_activites_projet.id','=','tperso_livrables.activite_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_activites_projet.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
            ->select("tperso_livrables.id", "activite_id", "designation_livrable", "description_livrable", 
            "fichiers", "statut_livrable","projet_id", "description_tache", "date_debut_tache","duree_tache", 
            "date_fin_tache", "nbr_heureJour", "cout_heure","partenaire_id", "typecontrat_id","nom_contrat",
            "code_contrat","description_projet", "chef_projet","date_debut_projet", "date_fin_projet",
            "tperso_livrables.author","tperso_livrables.created_at","nom_org", "adresse_org", 
            "contact_org", "rccm_org", "idnat_org")    
            ->orderBy("tperso_livrables.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }


    public function fetch_detail_entete(Request $request,$activite_id)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_livrables')
            ->join('tperso_activites_projet','tperso_activites_projet.id','=','tperso_livrables.activite_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_activites_projet.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
            ->select("tperso_livrables.id", "activite_id", "designation_livrable", "description_livrable", 
            "fichiers", "statut_livrable","projet_id", "description_tache", "date_debut_tache","duree_tache", 
            "date_fin_tache", "nbr_heureJour", "cout_heure","partenaire_id", "typecontrat_id","nom_contrat",
            "code_contrat","description_projet", "chef_projet","date_debut_projet", "date_fin_projet",
            "tperso_livrables.author","tperso_livrables.created_at","nom_org", "adresse_org", 
            "contact_org", "rccm_org", "idnat_org") 
            ->where([
                ['designation_livrable', 'like', '%'.$query.'%'],
                ['activite_id',$activite_id]
            ])                    
            ->orderBy("tperso_livrables.id", "desc")
            ->paginate(10);

            return response($data, 200);        

        }
        else{
      
            $data = DB::table('tperso_livrables')
            ->join('tperso_activites_projet','tperso_activites_projet.id','=','tperso_livrables.activite_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_activites_projet.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
            ->select("tperso_livrables.id", "activite_id", "designation_livrable", "description_livrable", 
            "fichiers", "statut_livrable","projet_id", "description_tache", "date_debut_tache","duree_tache", 
            "date_fin_tache", "nbr_heureJour", "cout_heure","partenaire_id", "typecontrat_id","nom_contrat",
            "code_contrat","description_projet", "chef_projet","date_debut_projet", "date_fin_projet",
            "tperso_livrables.author","tperso_livrables.created_at","nom_org", "adresse_org", 
            "contact_org", "rccm_org", "idnat_org")                 
            ->Where('activite_id',$activite_id)    
            ->orderBy("tperso_livrables.id", "desc")
            ->paginate(10);

            return response($data, 200);         
 
        }

    }   
    
    public function downloadfile($filenamess)
    {
        $filepath = public_path('fichier/'.$filenamess.'');
        return response()->file($filepath);
    }


    function fetch_single($id)
    {

        $data =DB::table('tperso_livrables')
        ->join('tperso_activites_projet','tperso_activites_projet.id','=','tperso_livrables.activite_id')
        ->join('tperso_projets','tperso_projets.id','=','tperso_activites_projet.projet_id')
        ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
        ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
        ->select("tperso_livrables.id", "activite_id", "designation_livrable", "description_livrable", 
        "fichiers", "statut_livrable","projet_id", "description_tache", "date_debut_tache","duree_tache", 
        "date_fin_tache", "nbr_heureJour", "cout_heure","partenaire_id", "typecontrat_id","nom_contrat",
        "code_contrat","description_projet", "chef_projet","date_debut_projet", "date_fin_projet",
        "tperso_livrables.author","tperso_livrables.created_at","nom_org", "adresse_org", 
        "contact_org", "rccm_org", "idnat_org")  
        ->where('tperso_livrables.id', $id)
        ->get();

        return response($data, 200);
    }

//id, activite_id, designation_livrable, description_livrable, fichiers, statut_livrable, author

    function insert_data(Request $request)
    {    
        if (!is_null($request->image)) 
        {
           $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();          
            $request->image->move(public_path('/fichier'), $imageName); 
   
            $data= tperso_livrables::create([
               'activite_id'=>$formData->activite_id,
               'designation_livrable'=>$formData->designation_livrable,
               'description_livrable'=>$formData->description_livrable,
               'fichiers'=>$imageName,
               'statut_livrable'=> 'NON',
               'author'=>$formData->author          
            ]);
   
            return response()->json([
               'data'  =>  "Insertion avec succès!!!",
           ]);
        }
        else{
           $formData = json_decode($_POST['data']);
           $data= tperso_livrables::create([
                'activite_id'=>$formData->activite_id,
                'designation_livrable'=>$formData->designation_livrable,
                'description_livrable'=>$formData->description_livrable,
                'fichiers'=>'avatar.png',
                'statut_livrable'=> 'NON',
                'author'=>$formData->author        
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
         
           $data= tperso_livrables::where('id',$formData->id)->update([
                'activite_id'=>$formData->activite_id,
                'designation_livrable'=>$formData->designation_livrable,
                'description_livrable'=>$formData->description_livrable,
                'fichiers'=>$imageName,
                'statut_livrable'=> 'NON',
                'author'=>$formData->author    
            ]);
   
            return response()->json([
               'data'  =>  "Modification avec succès!!",
           ]);
    
        }
        else{
            $formData = json_decode($_POST['data']);
            $data= tperso_livrables::where('id',$formData->id)->update([
                'activite_id'=>$formData->activite_id,
                'designation_livrable'=>$formData->designation_livrable,
                'description_livrable'=>$formData->description_livrable,
                'fichiers'=>'avatar.png',
                'statut_livrable'=> 'NON',
                'author'=>$formData->author       
            ]);
   
            return response()->json([
               'data'  =>  "Modification avec succès!!",
           ]);
    
   
        }
   
    }


    function delete_data($id)
    {
        $data = tperso_livrables::where('id',$id)->delete();
        return $this->msgJson('Information ajoutée avec succès');
        
    }
}
