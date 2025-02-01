<?php

namespace App\Http\Controllers\Logistique;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Logistique\tlog_entete_entree;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tlog_entete_entreeController extends Controller
{

    use GlobalMethod, Slug;

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

        $data = DB::table('tlog_entete_entree')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tlog_entete_entree.refFournisseur')
        ->select('tlog_entete_entree.id','noms','contact','mail','adresse','dateEntree',
        'libelle','tlog_entete_entree.author','tlog_entete_entree.created_at');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tlog_entete_entree.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tlog_entete_entree.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tlog_entete_entree')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tlog_entete_entree.refFournisseur')
        ->select('tlog_entete_entree.id','noms','contact','mail','adresse','dateEntree',
        'libelle','tlog_entete_entree.author','tlog_entete_entree.created_at')
        ->Where('refFournisseur',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("noms", "asc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tlog_entete_entree.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    

    function fetch_list_fournisseur()
    {
        $data = DB::table('tvente_fournisseur')->select("tvente_fournisseur.id","tvente_fournisseur.noms")->get();
        return response()->json([
            'data'  => $data,
        ]);
    }
    

    function fetch_single_data($id)
    {

        $data = DB::table('tlog_entete_entree')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tlog_entete_entree.refFournisseur')
        ->select('tlog_entete_entree.id','noms','contact','mail','adresse','dateEntree',
        'libelle','tlog_entete_entree.author','tlog_entete_entree.created_at')
        ->where('tlog_entete_entree.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   //id,refFournisseur,dateEntree,libelle,author
    function insert_data(Request $request)
    {       
        $data = tlog_entete_entree::create([
            'refFournisseur'       =>  $request->refFournisseur,
            'dateEntree'    =>  $request->dateEntree,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {
        $data = tlog_entete_entree::where('id', $id)->update([
            'refFournisseur'       =>  $request->refFournisseur,
            'dateEntree'    =>  $request->dateEntree,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = tlog_entete_entree::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
