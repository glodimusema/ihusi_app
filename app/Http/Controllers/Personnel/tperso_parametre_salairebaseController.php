<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_parametre_salairebase;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;

class tperso_parametre_salairebaseController extends Controller
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
            /////,'nom_poste','description_poste','transport'
            $query = $this->Gquery($request);
            $data = DB::table('tperso_parametre_salairebase')
            ->join('tperso_poste','tperso_poste.id','=','tperso_parametre_salairebase.categorie_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
            ->select("tperso_parametre_salairebase.id","categorie_id","projet_id","salaire_base",
            "partenaire_id", "typecontrat_id","nom_contrat","code_contrat","description_projet", 
            "chef_projet","date_debut_projet","date_fin_projet","nom_org","adresse_org", 
            "contact_org","rccm_org", "idnat_org",'nom_poste','description_poste','transport',
            "tperso_parametre_salairebase.author","salaire_prevu")   
            ->where([
                ['description_projet', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_parametre_salairebase.id", "desc")          
            ->paginate(10);
            return response($data, 200);
        }
        else{
            $data = DB::table('tperso_parametre_salairebase')
            ->join('tperso_poste','tperso_poste.id','=','tperso_parametre_salairebase.categorie_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
            ->select("tperso_parametre_salairebase.id","categorie_id","projet_id","salaire_base",
            "partenaire_id", "typecontrat_id","nom_contrat","code_contrat","description_projet", 
            "chef_projet","date_debut_projet","date_fin_projet","nom_org","adresse_org", 
            "contact_org","rccm_org", "idnat_org",'nom_poste','description_poste','transport',
            "tperso_parametre_salairebase.author","salaire_prevu")    
            ->orderBy("tperso_parametre_salairebase.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }


    public function fetch_detail_entete(Request $request,$projet_id)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_parametre_salairebase')
            ->join('tperso_poste','tperso_poste.id','=','tperso_parametre_salairebase.categorie_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
            ->select("tperso_parametre_salairebase.id","categorie_id","projet_id","salaire_base",
            "partenaire_id", "typecontrat_id","nom_contrat","code_contrat","description_projet", 
            "chef_projet","date_debut_projet","date_fin_projet","nom_org","adresse_org", 
            "contact_org","rccm_org", "idnat_org",'nom_poste','description_poste','transport',
            "tperso_parametre_salairebase.author","salaire_prevu") 
            ->where([
                ['description_projet', 'like', '%'.$query.'%'],
                ['projet_id',$projet_id]
            ])                    
            ->orderBy("tperso_parametre_salairebase.id", "desc")
            ->paginate(10);

            return response($data, 200);        

        }
        else{
      
            $data = DB::table('tperso_parametre_salairebase')
            ->join('tperso_poste','tperso_poste.id','=','tperso_parametre_salairebase.categorie_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
            ->select("tperso_parametre_salairebase.id","categorie_id","projet_id","salaire_base",
            "partenaire_id", "typecontrat_id","nom_contrat","code_contrat","description_projet", 
            "chef_projet","date_debut_projet","date_fin_projet","nom_org","adresse_org", 
            "contact_org","rccm_org", "idnat_org",'nom_poste','description_poste','transport',
            "tperso_parametre_salairebase.author","salaire_prevu")               
            ->Where('projet_id',$projet_id)    
            ->orderBy("tperso_parametre_salairebase.id", "desc")
            ->paginate(10);

            return response($data, 200);         
 
        }

    }   
    
    function fetch_dropdown_2()
    {
        $data = DB::table('tperso_parametre_salairebase')
        ->join('tperso_poste','tperso_poste.id','=','tperso_parametre_salairebase.categorie_id')
        ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
        ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
        ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
        ->select("tperso_parametre_salairebase.id","categorie_id","projet_id","salaire_base",
        "partenaire_id", "typecontrat_id","nom_contrat","code_contrat","description_projet", 
        "chef_projet","date_debut_projet","date_fin_projet","nom_org","adresse_org", 
        "contact_org","rccm_org", "idnat_org",'nom_poste','description_poste','transport',
        "tperso_parametre_salairebase.author","salaire_prevu")
        ->orderBy("id", "desc")->get();
        return response()->json([
            'data'  => $data,
        ]);

    }


    function fetch_data_projet($projet_id)
    {
        $data = DB::table('tperso_parametre_salairebase')
        ->join('tperso_poste','tperso_poste.id','=','tperso_parametre_salairebase.categorie_id')
        ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
        ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
        ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
        ->select("tperso_parametre_salairebase.id","categorie_id","projet_id","salaire_base",
        "partenaire_id", "typecontrat_id","nom_contrat","code_contrat","description_projet", 
        "chef_projet","date_debut_projet","date_fin_projet","nom_org","adresse_org", 
        "contact_org","rccm_org", "idnat_org",'nom_poste','description_poste','transport',
        "tperso_parametre_salairebase.author","salaire_prevu")
        ->where('tperso_parametre_salairebase.projet_id', $projet_id)
        ->get();
        return response()->json([
            'data'  => $data,
        ]);

    }



    function fetch_single($id)
    {
        $data = DB::table('tperso_parametre_salairebase')
        ->join('tperso_poste','tperso_poste.id','=','tperso_parametre_salairebase.categorie_id')
        ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
        ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
        ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
        ->select("tperso_parametre_salairebase.id","categorie_id","projet_id","salaire_base",
        "partenaire_id", "typecontrat_id","nom_contrat","code_contrat","description_projet", 
        "chef_projet","date_debut_projet","date_fin_projet","nom_org","adresse_org", 
        "contact_org","rccm_org", "idnat_org",'nom_poste','description_poste','transport',
        "tperso_parametre_salairebase.author","salaire_prevu") 
        ->where('tperso_parametre_salairebase.id', $id)
        ->get();
        return response($data, 200);
    }


//'id','categorie_id','projet_id','salaire_base','salaire_prevu','author'
    function insert_data(Request $request)
    {
        $data = tperso_parametre_salairebase::create([
            'categorie_id'       =>  $request->categorie_id,
            'projet_id'    =>  $request->projet_id,
            'salaire_base'    =>  $request->salaire_base,
            'salaire_prevu'    =>  $request->salaire_prevu,
            'author'       =>  $request->author,
        ]);

        return $this->msgJson('Information ajoutée avec succès');
    }


    function update_data(Request $request, $id)
    {
        $data = tperso_parametre_salairebase::where('id', $id)->update([
            'categorie_id'       =>  $request->categorie_id,
            'projet_id'    =>  $request->projet_id,
            'salaire_base'    =>  $request->salaire_base,
            'salaire_prevu'    =>  $request->salaire_prevu,
            'author'       =>  $request->author,
        ]);       
        return $this->msgJson('Information ajoutée avec succès');
    }


    function delete_data($id)
    {
        $data = tperso_parametre_salairebase::where('id',$id)->delete();
        return $this->msgJson('Information ajoutée avec succès');
        
    }
}
