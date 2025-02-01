<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_projets;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;

class tperso_projetsController extends Controller
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
            $data = DB::table('tperso_projets')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
            ->select("tperso_projets.id","partenaire_id", "typecontrat_id","nom_contrat","code_contrat",
             "description_projet", "chef_projet","date_debut_projet",'duree_projet', "date_fin_projet",
             "tperso_projets.author","nom_org", "adresse_org", "contact_org", "rccm_org", "idnat_org")  
             ->selectRaw('TIMESTAMPDIFF(DAY, CURDATE(), date_fin_projet) as dureerestante') 
            ->where([
                ['description_projet', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_projets.id", "desc")          
            ->paginate(10);
            return response($data, 200);
        }
        else{
            $data = DB::table('tperso_projets')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
            ->select("tperso_projets.id","partenaire_id", "typecontrat_id","nom_contrat","code_contrat",
             "description_projet", "chef_projet","date_debut_projet",'duree_projet', "date_fin_projet",
             "tperso_projets.author","nom_org", "adresse_org", "contact_org", "rccm_org", "idnat_org") 
             ->selectRaw('TIMESTAMPDIFF(DAY, CURDATE(), date_fin_projet) as dureerestante')  
            ->orderBy("tperso_projets.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }


    public function fetch_detail_entete(Request $request,$partenaire_id)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_projets')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
            ->select("tperso_projets.id","partenaire_id", "typecontrat_id","nom_contrat","code_contrat",
             "description_projet", "chef_projet","date_debut_projet",'duree_projet', "date_fin_projet",
             "tperso_projets.author","nom_org", "adresse_org", "contact_org", "rccm_org", "idnat_org") 
             ->selectRaw('TIMESTAMPDIFF(DAY, CURDATE(), date_fin_projet) as dureerestante')
            ->where([
                ['description_projet', 'like', '%'.$query.'%'],
                ['partenaire_id',$partenaire_id]
            ])                    
            ->orderBy("tperso_projets.id", "desc")
            ->paginate(10);

            return response($data, 200);        

        }
        else{
      
            $data = DB::table('tperso_projets')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
            ->select("tperso_projets.id","partenaire_id", "typecontrat_id","nom_contrat","code_contrat",
             "description_projet", "chef_projet","date_debut_projet",'duree_projet', "date_fin_projet",
             "tperso_projets.author","nom_org", "adresse_org", "contact_org", "rccm_org", "idnat_org") 
             ->selectRaw('TIMESTAMPDIFF(DAY, CURDATE(), date_fin_projet) as dureerestante')              
            ->Where('partenaire_id',$partenaire_id)    
            ->orderBy("tperso_projets.id", "desc")
            ->paginate(10);

            return response($data, 200);         
 
        }

    } 
    
    function fetch_dropdown()
    {
        $data = DB::table('tperso_projets')
        ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
        ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
        ->select("tperso_projets.id","partenaire_id", "typecontrat_id","nom_contrat","code_contrat",
         "description_projet", "chef_projet","date_debut_projet",'duree_projet', "date_fin_projet",
         "tperso_projets.author","nom_org", "adresse_org", "contact_org", "rccm_org", "idnat_org") 
         ->selectRaw('TIMESTAMPDIFF(DAY, CURDATE(), date_fin_projet) as dureerestante')
         ->get();
         return response()->json([
            'data'  => $data,
        ]);
    }


    function fetch_single($id)
    {
        $data = DB::table('tperso_projets')
        ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
        ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
        ->select("tperso_projets.id","partenaire_id", "typecontrat_id","nom_contrat","code_contrat",
         "description_projet", "chef_projet","date_debut_projet",'duree_projet', "date_fin_projet",
         "tperso_projets.author","nom_org", "adresse_org", "contact_org", "rccm_org", "idnat_org")  
         ->selectRaw('TIMESTAMPDIFF(DAY, CURDATE(), date_fin_projet) as dureerestante')
        ->where('tperso_projets.id', $id)
        ->get();

        return response($data, 200);
    }


//id,partenaire_id, typecontrat_id, description_projet, chef_projet, date_debut_projet,'duree_projet', date_fin_projet, author

    function insert_data(Request $request)
    {
        $currentDate = Carbon::parse($request->date_debut_projet);
        $duree = (int)$request->duree_projet;
        $newDate = $currentDate->addDays($duree);

        $data = tperso_projets::create([
            'partenaire_id'       =>  $request->partenaire_id,
            'typecontrat_id'    =>  $request->typecontrat_id,
            'description_projet'    =>  $request->description_projet,
            'chef_projet'    =>  $request->chef_projet,
            'date_debut_projet'    =>  $request->date_debut_projet,
            'duree_projet'    =>  $duree,
            'date_fin_projet'    =>  $newDate,
            'author'       =>  $request->author,
        ]);

        return $this->msgJson('Information ajoutée avec succès');
    }


    function update_data(Request $request, $id)
    {
        $currentDate = Carbon::parse($request->date_debut_projet);
        $duree = (int)$request->duree_projet;
        $newDate = $currentDate->addDays($duree);

        $data = tperso_projets::where('id', $id)->update([
            'partenaire_id'       =>  $request->partenaire_id,
            'typecontrat_id'    =>  $request->typecontrat_id,
            'description_projet'    =>  $request->description_projet,
            'chef_projet'    =>  $request->chef_projet,
            'date_debut_projet'    =>  $request->date_debut_projet,
            'duree_projet'    =>  $duree,
            'date_fin_projet'    =>  $newDate,
            'author'       =>  $request->author,
        ]);       
        return $this->msgJson('Information ajoutée avec succès');
    }


    function delete_data($id)
    {
        $data = tperso_projets::where('id',$id)->delete();
        return $this->msgJson('Information ajoutée avec succès');
        
    }
}
