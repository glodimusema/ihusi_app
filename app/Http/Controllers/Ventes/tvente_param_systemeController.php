<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_param_systeme;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tvente_param_systemeController extends Controller
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

        $data = DB::table('tvente_param_systeme')
        ->join('tvente_module','tvente_module.id','=','tvente_param_systeme.module_id')
        ->select('tvente_param_systeme.id','maxid','module_id','tvente_param_systeme.created_at', 
        "tvente_module.nom_module");
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tvente_module.nom_module', 'like', '%'.$query.'%')          
            ->orderBy("tvente_param_systeme.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_param_systeme.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 
        $data = DB::table('tvente_param_systeme')
        ->join('tvente_module','tvente_module.id','=','tvente_param_systeme.module_id')
        ->select('tvente_param_systeme.id','maxid','module_id','tvente_param_systeme.created_at', 
        "tvente_module.nom_module")
        ->Where('module_id',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('tvente_module.nom_module', 'like', '%'.$query.'%')          
            ->orderBy("tvente_param_systeme.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_param_systeme.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    

  

    function fetch_single_data($id)
    {
        $data = DB::table('tvente_param_systeme')
        ->join('tvente_module','tvente_module.id','=','tvente_param_systeme.module_id')
        ->select('tvente_param_systeme.id','maxid','module_id','tvente_param_systeme.created_at', 
        "tvente_module.nom_module")
        ->where('tvente_param_systeme.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   // 'id','module_id','maxid'
    function insert_data(Request $request)
    {       
        $data = tvente_param_systeme::create([
            'module_id'       =>  $request->module_id,
            'maxid'       =>  $request->maxid
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {
        $data = tvente_param_systeme::where('id', $id)->update([
            'module_id'       =>  $request->module_id,
            'maxid'       =>  $request->maxid
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = tvente_param_systeme::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
