<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_entete_inventaire;
use App\Models\Ventes\tvente_detail_inventaire;
use App\Models\Facture;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tvente_entete_inventaireController extends Controller
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
        
        $data = DB::table('tvente_entete_inventaire')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_inventaire.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_inventaire.refService')       
        ->select('tvente_entete_inventaire.id','tvente_entete_inventaire.code','refService','module_id',
        'dateVente','libelle','tvente_entete_inventaire.author',
        'tvente_entete_inventaire.refUser','tvente_entete_inventaire.created_at'        
        ,'nom_service', "tvente_module.nom_module");
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('nom_service', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_inventaire.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_entete_inventaire.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }


    public function fetch_data_entete(Request $request,$refEntete)
    {
        $data = DB::table('tvente_entete_inventaire')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_inventaire.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_inventaire.refService')       
        ->select('tvente_entete_inventaire.id','tvente_entete_inventaire.code','refService','module_id',
        'dateVente','libelle','tvente_entete_inventaire.author',
        'tvente_entete_inventaire.refUser','tvente_entete_inventaire.created_at'        
        ,'nom_service', "tvente_module.nom_module")
        ->Where('refService',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('nom_service', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_inventaire.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_entete_inventaire.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }   


    function fetch_single_data($id)
    {

        $data = DB::table('tvente_entete_inventaire')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_inventaire.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_inventaire.refService')       
        ->select('tvente_entete_inventaire.id','tvente_entete_inventaire.code','refService','module_id',
        'dateVente','libelle','tvente_entete_inventaire.author',
        'tvente_entete_inventaire.refUser','tvente_entete_inventaire.created_at'        
        ,'nom_service', "tvente_module.nom_module")
        ->where('tvente_entete_inventaire.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   // //'id','code','refService','module_id','dateVente','libelle','author','refUser'
    function insert_data(Request $request)
    {
        $module_id = 8;
        $code = $this->GetCodeData('tvente_param_systeme','module_id',$module_id);
        $data = tvente_entete_inventaire::create([
            'code'       => $code,
            'refService'       =>  $request->refService,            
            'module_id'       =>  $module_id,
            'dateVente'    =>  $request->dateVente,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    } 

    function update_data(Request $request, $id)
    {
        $code = $this->GetCode2('tvente_entete_inventaire');
        $data = tvente_entete_inventaire::where('id', $id)->update([
            'code'       => $code,
            'refService'       =>  $request->refService,            
            'dateVente'    =>  $request->dateVente,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = tvente_detail_inventaire::where('refEnteteVente',$id)->delete();
        $data = tvente_entete_inventaire::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
