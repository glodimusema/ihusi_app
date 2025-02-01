<?php

namespace App\Http\Controllers\Logistique;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Logistique\tlog_entete_requisition;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tlog_entete_requisitionController extends Controller
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

        $data = DB::table('tlog_entete_requisition')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tlog_entete_requisition.refFournisseur')
        ->select('tlog_entete_requisition.id','noms','contact','mail','adresse','dateCmd',
        'libelle','tlog_entete_requisition.author','tlog_entete_requisition.created_at');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tlog_entete_requisition.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tlog_entete_requisition.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    {
        $data = DB::table('tlog_entete_requisition')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tlog_entete_requisition.refFournisseur')
        ->select('tlog_entete_requisition.id','noms','contact','mail','adresse','dateCmd',
        'libelle','tlog_entete_requisition.author','tlog_entete_requisition.created_at')
        ->Where('refFournisseur',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tlog_entete_requisition.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tlog_entete_requisition.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    


  

    function fetch_single_data($id)
    {
        $data = DB::table('tlog_entete_requisition')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tlog_entete_requisition.refFournisseur')
        ->select('tlog_entete_requisition.id','noms','contact','mail','adresse','dateCmd',
        'libelle','tlog_entete_requisition.author','tlog_entete_requisition.created_at')
        ->where('tlog_entete_requisition.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function insert_data(Request $request)
    {       
        $data = tlog_entete_requisition::create([
            'refFournisseur'       =>  $request->refFournisseur,
            'dateCmd'    =>  $request->dateCmd,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {
        $data = tlog_entete_requisition::where('id', $id)->update([
            'refFournisseur'       =>  $request->refFournisseur,
            'dateCmd'    =>  $request->dateCmd,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = tlog_entete_requisition::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
