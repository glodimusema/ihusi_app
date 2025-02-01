<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_paie_projet;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;

class tperso_paie_projetController extends Controller
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
    {    //id, activite_id, montant_projet, author 
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);
            $data = DB::table('tperso_paie_projet')
            ->join('tperso_activites_projet','tperso_activites_projet.id','=','tperso_paie_projet.activite_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_activites_projet.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
            ->select("tperso_paie_projet.id", "activite_id", "montant_projet", "activite_id", "montant_projet",
            "projet_id", "description_tache", "date_debut_tache","duree_tache", 
            "date_fin_tache", "nbr_heureJour", "cout_heure","partenaire_id", "typecontrat_id","nom_contrat",
            "code_contrat","description_projet", "chef_projet","date_debut_projet", "date_fin_projet",
            "tperso_paie_projet.author","tperso_paie_projet.created_at","nom_org", "adresse_org", 
            "contact_org", "rccm_org", "idnat_org")   
            ->where([
                ['description_tache', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_paie_projet.id", "desc")          
            ->paginate(10);
            return response($data, 200);
        }
        else{
            $data = DB::table('tperso_paie_projet')
            ->join('tperso_activites_projet','tperso_activites_projet.id','=','tperso_paie_projet.activite_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_activites_projet.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
            ->select("tperso_paie_projet.id", "activite_id", "montant_projet", "activite_id", "montant_projet",
            "projet_id", "description_tache", "date_debut_tache","duree_tache", 
            "date_fin_tache", "nbr_heureJour", "cout_heure","partenaire_id", "typecontrat_id","nom_contrat",
            "code_contrat","description_projet", "chef_projet","date_debut_projet", "date_fin_projet",
            "tperso_paie_projet.author","tperso_paie_projet.created_at","nom_org", "adresse_org", 
            "contact_org", "rccm_org", "idnat_org")   
            ->orderBy("tperso_paie_projet.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }


    public function fetch_detail_entete(Request $request,$activite_id)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_paie_projet')
            ->join('tperso_activites_projet','tperso_activites_projet.id','=','tperso_paie_projet.activite_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_activites_projet.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
            ->select("tperso_paie_projet.id", "activite_id", "montant_projet", "activite_id", "montant_projet",
            "projet_id", "description_tache", "date_debut_tache","duree_tache", 
            "date_fin_tache", "nbr_heureJour", "cout_heure","partenaire_id", "typecontrat_id","nom_contrat",
            "code_contrat","description_projet", "chef_projet","date_debut_projet", "date_fin_projet",
            "tperso_paie_projet.author","tperso_paie_projet.created_at","nom_org", "adresse_org", 
            "contact_org", "rccm_org", "idnat_org") 
            ->where([
                ['description_tache', 'like', '%'.$query.'%'],
                ['activite_id',$activite_id]
            ])                    
            ->orderBy("tperso_paie_projet.id", "desc")
            ->paginate(10);

            return response($data, 200);        

        }
        else{
      
            $data = DB::table('tperso_paie_projet')
            ->join('tperso_activites_projet','tperso_activites_projet.id','=','tperso_paie_projet.activite_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_activites_projet.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
            ->select("tperso_paie_projet.id", "activite_id", "montant_projet", "activite_id", "montant_projet",
            "projet_id", "description_tache", "date_debut_tache","duree_tache", 
            "date_fin_tache", "nbr_heureJour", "cout_heure","partenaire_id", "typecontrat_id","nom_contrat",
            "code_contrat","description_projet", "chef_projet","date_debut_projet", "date_fin_projet",
            "tperso_paie_projet.author","tperso_paie_projet.created_at","nom_org", "adresse_org", 
            "contact_org", "rccm_org", "idnat_org")                
            ->Where('activite_id',$activite_id)    
            ->orderBy("tperso_paie_projet.id", "desc")
            ->paginate(10);

            return response($data, 200);         
 
        }

    }    


    function fetch_single($id)
    {

        $data =DB::table('tperso_paie_projet')
        ->join('tperso_activites_projet','tperso_activites_projet.id','=','tperso_paie_projet.activite_id')
        ->join('tperso_projets','tperso_projets.id','=','tperso_activites_projet.projet_id')
        ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
        ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
        ->select("tperso_paie_projet.id", "activite_id", "montant_projet", "activite_id", "montant_projet",
        "projet_id", "description_tache", "date_debut_tache","duree_tache", 
        "date_fin_tache", "nbr_heureJour", "cout_heure","partenaire_id", "typecontrat_id","nom_contrat",
        "code_contrat","description_projet", "chef_projet","date_debut_projet", "date_fin_projet",
        "tperso_paie_projet.author","tperso_paie_projet.created_at","nom_org", "adresse_org", 
        "contact_org", "rccm_org", "idnat_org")  
        ->where('tperso_paie_projet.id', $id)
        ->get();

        return response($data, 200);
    }

//id, //id, activite_id, montant_projet, author 

    function insert_data(Request $request)
    {
        $data = tperso_paie_projet::create([
            'activite_id'       =>  $request->activite_id,
            'montant_projet'    =>  $request->montant_projet,
            'author'       =>  $request->author,
        ]);

        return $this->msgJson('Information ajoutée avec succès');
    }


    function update_data(Request $request, $id)
    {
        $data = tperso_paie_projet::where('id', $id)->update([
            'activite_id'       =>  $request->activite_id,
            'montant_projet'    =>  $request->montant_projet,
            'author'       =>  $request->author,
        ]);       
        return $this->msgJson('Information ajoutée avec succès');
    }


    function delete_data($id)
    {
        $data = tperso_paie_projet::where('id',$id)->delete();
        return $this->msgJson('Information ajoutée avec succès');
        
    }
}
