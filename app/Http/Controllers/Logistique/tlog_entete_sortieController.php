<?php

namespace App\Http\Controllers\Logistique;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Logistique\tlog_entete_sortie;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tlog_entete_sortieController extends Controller
{
    use GlobalMethod, Slug;
    //vEnteteEntree
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

        $data = DB::table('tlog_entete_sortie')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
        ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
        ->select('tlog_entete_sortie.id','refService','dateSortie',"name_serv_perso","name_categorie_service",
        "refCatService",'libelle','nom_agent','tlog_entete_sortie.author','tlog_entete_sortie.created_at');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('nom_agent', 'like', '%'.$query.'%')          
            ->orderBy("tlog_entete_sortie.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tlog_entete_sortie.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    {
        $data = DB::table('tlog_entete_sortie')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
        ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
        ->select('tlog_entete_sortie.id','refService','dateSortie',"name_serv_perso","name_categorie_service",
        "refCatService",'libelle','nom_agent','tlog_entete_sortie.author','tlog_entete_sortie.created_at')
        ->Where('refService',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('nom_agent', 'like', '%'.$query.'%')          
            ->orderBy("tlog_entete_sortie.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tlog_entete_sortie.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }   


    function fetch_single_data($id)
    {

        $data = DB::table('tlog_entete_sortie')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
        ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
        ->select('tlog_entete_sortie.id','refService','dateSortie',"name_serv_perso","name_categorie_service",
        "refCatService",'libelle','nom_agent','tlog_entete_sortie.author','tlog_entete_sortie.created_at')
        ->where('tlog_entete_sortie.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   //id,refService,nom_agent,dateSortie,libelle,author
    function insert_data(Request $request)
    {
       
        $data = tlog_entete_sortie::create([
            'refService'       =>  $request->refService,
            'nom_agent'       =>  $request->nom_agent,
            'dateSortie'    =>  $request->dateSortie,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {
        $data = tlog_entete_sortie::where('id', $id)->update([
            'refService'       =>  $request->refService,
            'nom_agent'       =>  $request->nom_agent,
            'dateSortie'    =>  $request->dateSortie,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = tlog_entete_sortie::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
