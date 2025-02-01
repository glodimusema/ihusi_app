<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_validations;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tvente_validationsController extends Controller
{

    use GlobalMethod, Slug;

//     'id','user_id','module_id','niveau','codeOperation','author','refUser'
// tvente_validations
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

        $data = DB::table('tvente_validations')
        ->join('tvente_module','tvente_module.id','=','tvente_validations.module_id')
        ->join('users','users.id','=','tvente_validations.user_id')
        ->join('roles','users.id_role','=','roles.id')
        ->select('tvente_validations.id','user_id','module_id','niveau','codeOperation',
        'tvente_validations.refUser','tvente_validations.author','tvente_validations.created_at',
        "tvente_module.nom_module",'tvente_module.active','users.avatar','users.name','users.email','users.id_role',
        'roles.nom as role_name','users.sexe','users.telephone','users.adresse');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('nom_module', 'like', '%'.$query.'%')          
            ->orderBy("tvente_validations.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_validations.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 
        $data = DB::table('tvente_validations')
        ->join('tvente_module','tvente_module.id','=','tvente_validations.module_id')
        ->join('users','users.id','=','tvente_validations.user_id')
        ->join('roles','users.id_role','=','roles.id')
        ->select('tvente_validations.id','user_id','module_id','niveau','codeOperation',
        'tvente_validations.refUser','tvente_validations.author','tvente_validations.created_at',
        "tvente_module.nom_module",'tvente_module.active','users.avatar','users.name','users.email','users.id_role',
        'roles.nom as role_name','users.sexe','users.telephone','users.adresse')
        ->Where('user_id',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('nom_module', 'like', '%'.$query.'%')          
            ->orderBy("tvente_validations.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_validations.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    

    function fetch_list_users()
    {
        $data = DB::table('users')->select("users.id","users.name")->get();
        return response()->json([
            'data'  => $data,
        ]);
    }
    

    function fetch_single_data($id)
    {
        $data = DB::table('tvente_validations')
        ->join('tvente_module','tvente_module.id','=','tvente_validations.module_id')
        ->join('users','users.id','=','tvente_validations.user_id')
        ->join('roles','users.id_role','=','roles.id')
        ->select('tvente_validations.id','user_id','module_id','niveau','codeOperation',
        'tvente_validations.refUser','tvente_validations.author','tvente_validations.created_at',
        "tvente_module.nom_module",'tvente_module.active','users.avatar','users.name','users.email','users.id_role',
        'roles.nom as role_name','users.sexe','users.telephone','users.adresse')
        ->where('tvente_validations.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   //'id','user_id','module_id','niveau','codeOperation','author','refUser'
    function insert_data(Request $request)
    {       
        $data = tvente_validations::create([
            'user_id'       =>  $request->user_id,
            'module_id'    =>  $request->module_id,
            'niveau'    =>  $request->niveau,
            'codeOperation'    =>  $request->codeOperation,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {
        $data = tvente_validations::where('id', $id)->update([
            'user_id'       =>  $request->user_id,
            'module_id'    =>  $request->module_id,
            'niveau'    =>  $request->niveau,
            'codeOperation'    =>  $request->codeOperation,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = tvente_validations::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
