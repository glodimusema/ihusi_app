<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_activites_projet;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;

class tperso_activites_projetController extends Controller
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
            $data = DB::table('tperso_activites_projet')
            ->join('tperso_projets','tperso_projets.id','=','tperso_activites_projet.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
            ->select("tperso_activites_projet.id", "projet_id", "description_tache", "date_debut_tache","duree_tache", 
            "date_fin_tache", "nbr_heureJour", "cout_heure","partenaire_id", "typecontrat_id","nom_contrat",
            "code_contrat","description_projet", "chef_projet","date_debut_projet", "date_fin_projet",
            "tperso_activites_projet.author","nom_org", "adresse_org", "contact_org","statut_tache",
             "rccm_org", "idnat_org")   
            ->selectRaw('TIMESTAMPDIFF(DAY, CURDATE(), date_fin_tache) as dureerestante')
            ->where([
                ['description_tache', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_activites_projet.id", "desc")          
            ->paginate(10);
            return response($data, 200);
        }
        else{
            $data = DB::table('tperso_activites_projet')
            ->join('tperso_projets','tperso_projets.id','=','tperso_activites_projet.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
            ->select("tperso_activites_projet.id", "projet_id", "description_tache", "date_debut_tache","duree_tache", 
            "date_fin_tache", "nbr_heureJour", "cout_heure","partenaire_id", "typecontrat_id","nom_contrat",
            "code_contrat","description_projet", "chef_projet","date_debut_projet", "date_fin_projet",
            "tperso_activites_projet.author","nom_org", "adresse_org", "contact_org","statut_tache",
            "rccm_org","idnat_org")   
            ->selectRaw('TIMESTAMPDIFF(DAY, CURDATE(), date_fin_tache) as dureerestante')
            ->orderBy("tperso_activites_projet.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }


    public function fetch_detail_entete(Request $request,$projet_id)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_activites_projet')
            ->join('tperso_projets','tperso_projets.id','=','tperso_activites_projet.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
            ->select("tperso_activites_projet.id", "projet_id", "description_tache", "date_debut_tache","duree_tache", 
            "date_fin_tache", "nbr_heureJour", "cout_heure","partenaire_id", "typecontrat_id","nom_contrat",
            "code_contrat","description_projet", "chef_projet","date_debut_projet", "date_fin_projet",
            "tperso_activites_projet.author","nom_org", "adresse_org", "contact_org","statut_tache",
            "rccm_org", "idnat_org") 
            ->selectRaw('TIMESTAMPDIFF(DAY, CURDATE(), date_fin_tache) as dureerestante')
            ->where([
                ['description_tache', 'like', '%'.$query.'%'],
                ['projet_id',$projet_id]
            ])                    
            ->orderBy("tperso_activites_projet.id", "desc")
            ->paginate(10);

            return response($data, 200);        

        }
        else{
      
            $data = DB::table('tperso_activites_projet')
            ->join('tperso_projets','tperso_projets.id','=','tperso_activites_projet.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
            ->select("tperso_activites_projet.id", "projet_id", "description_tache", "date_debut_tache","duree_tache", 
            "date_fin_tache", "nbr_heureJour", "cout_heure","partenaire_id", "typecontrat_id","nom_contrat",
            "code_contrat","description_projet", "chef_projet","date_debut_projet", "date_fin_projet",
            "tperso_activites_projet.author","nom_org", "adresse_org", "contact_org","statut_tache",
            "rccm_org", "idnat_org")    
            ->selectRaw('TIMESTAMPDIFF(DAY, CURDATE(), date_fin_tache) as dureerestante')           
            ->Where('projet_id',$projet_id)    
            ->orderBy("tperso_activites_projet.id", "desc")
            ->paginate(10);

            return response($data, 200);         
 
        }

    }    


    function fetch_single($id)
    {

        $data = DB::table('tperso_activites_projet')
        ->join('tperso_projets','tperso_projets.id','=','tperso_activites_projet.projet_id')
        ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
        ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
        ->select("tperso_activites_projet.id", "projet_id", "description_tache", "date_debut_tache","duree_tache", 
        "date_fin_tache", "nbr_heureJour", "cout_heure","partenaire_id", "typecontrat_id","nom_contrat",
        "code_contrat","description_projet", "chef_projet","date_debut_projet", "date_fin_projet",
        "tperso_activites_projet.author","nom_org", "adresse_org", "contact_org","statut_tache",
        "rccm_org", "idnat_org")  
        ->selectRaw('TIMESTAMPDIFF(DAY, CURDATE(), date_fin_tache) as dureerestante')
        ->where('tperso_activites_projet.id', $id)
        ->get();

        return response($data, 200);
    }

//id, projet_id, description_tache, date_debut_tache,"duree_tache", date_fin_tache, nbr_heureJour, cout_heure,statut_tache, author   

    function insert_data(Request $request)
    {
        $currentDate = Carbon::parse($request->date_debut_tache);
        $duree = (int)$request->duree_tache;
        $newDate = $currentDate->addDays($duree);

        $data = tperso_activites_projet::create([
            'projet_id'       =>  $request->projet_id,
            'description_tache'    =>  $request->description_tache,
            'date_debut_tache'    =>  $request->date_debut_tache,
            'duree_tache'    =>  $request->duree_tache,
            'date_fin_tache'    =>  $newDate,
            'nbr_heureJour'    =>  $request->nbr_heureJour,
            'cout_heure'    =>  $request->cout_heure,
            'statut_tache'    =>  'Attente',
            'author'       =>  $request->author,
        ]);

        return $this->msgJson('Information ajoutée avec succès');
    }


    function update_data(Request $request, $id)
    {
        $currentDate = Carbon::parse($request->date_debut_tache);
        $duree = (int)$request->duree_tache;
        $newDate = $currentDate->addDays($duree);

        $data = tperso_activites_projet::where('id', $id)->update([
            'projet_id'       =>  $request->projet_id,
            'description_tache'    =>  $request->description_tache,
            'date_debut_tache'    =>  $request->date_debut_tache,
            'duree_tache'    =>  $request->duree_tache,
            'date_fin_tache'    =>  $newDate,
            'nbr_heureJour'    =>  $request->nbr_heureJour,
            'cout_heure'    =>  $request->cout_heure,
            'statut_tache'    =>  $request->statut_tache,
            'author'       =>  $request->author,
        ]);       
        return $this->msgJson('Information ajoutée avec succès');
    }


    function delete_data($id)
    {
        $data = tperso_activites_projet::where('id',$id)->delete();
        return $this->msgJson('Information ajoutée avec succès');
        
    }
}
