<?php

namespace App\Http\Controllers\Gaz;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gaz\tgaz_entete_inventaire;
use App\Models\Gaz\tgaz_detail_inventaire;
use App\Models\Facture;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tgaz_entete_inventaireController extends Controller
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
        
        $data = DB::table('tgaz_entete_inventaire')
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_inventaire.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_inventaire.refService')       
        ->select('tgaz_entete_inventaire.id','tgaz_entete_inventaire.code','refService','module_id',
        'dateVente','libelle','tgaz_entete_inventaire.author',
        'tgaz_entete_inventaire.refUser','tgaz_entete_inventaire.created_at'        
        ,'nom_service', "tvente_module.nom_module");
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('nom_service', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_entete_inventaire.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tgaz_entete_inventaire.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }


    public function fetch_data_entete(Request $request,$refEntete)
    {
        $data = DB::table('tgaz_entete_inventaire')
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_inventaire.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_inventaire.refService')       
        ->select('tgaz_entete_inventaire.id','tgaz_entete_inventaire.code','refService','module_id',
        'dateVente','libelle','tgaz_entete_inventaire.author',
        'tgaz_entete_inventaire.refUser','tgaz_entete_inventaire.created_at'        
        ,'nom_service', "tvente_module.nom_module")
        ->Where('refService',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('nom_service', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_entete_inventaire.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tgaz_entete_inventaire.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }   


    function fetch_single_data($id)
    {

        $data = DB::table('tgaz_entete_inventaire')
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_inventaire.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_inventaire.refService')       
        ->select('tgaz_entete_inventaire.id','tgaz_entete_inventaire.code','refService','module_id',
        'dateVente','libelle','tgaz_entete_inventaire.author',
        'tgaz_entete_inventaire.refUser','tgaz_entete_inventaire.created_at'        
        ,'nom_service', "tvente_module.nom_module")
        ->where('tgaz_entete_inventaire.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   // //'id','code','refService','module_id','dateVente','libelle','author','refUser'
    function insert_data(Request $request)
    {
        $module_id = 16;
        $code = $this->GetCodeData('tvente_param_systeme','module_id',$module_id);
        $data = tgaz_entete_inventaire::create([
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
        $code = $this->GetCode2('tgaz_entete_inventaire');
        $data = tgaz_entete_inventaire::where('id', $id)->update([
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
        $data = tgaz_detail_inventaire::where('refEnteteVente',$id)->delete();
        $data = tgaz_entete_inventaire::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
