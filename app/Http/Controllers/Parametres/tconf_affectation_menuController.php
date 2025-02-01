<?php

namespace App\Http\Controllers\Parametres;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Parametres\{tconf_affectation_menu};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tconf_affectation_menuController extends Controller
{
    use GlobalMethod;
    use Slug;
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
        
        $data = DB::table('tconf_affectation_menu')
        ->join('roles','roles.id','=','tconf_affectation_menu.refRole')
        ->join('tconf_list_menu','tconf_list_menu.id','=','tconf_affectation_menu.refMenu')        
        ->select("tconf_affectation_menu.id" ,"roles.nom","tconf_list_menu.name_menu","numero_menu",
        'refRole','refMenu','tconf_affectation_menu.author');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('name_menu', 'like', '%'.$query.'%')          
            ->orderBy("tconf_list_menu.numero_menu", "asc");

            return $this->apiData($data->paginate(10));          

        }
        $data->orderBy("tconf_list_menu.numero_menu", "asc");
        return $this->apiData($data->paginate(10));

    }


    public function fetch_affaction_role(Request $request,$refRole)
    {  
        $data = DB::table('tconf_affectation_menu')
        ->join('roles','roles.id','=','tconf_affectation_menu.refRole')
        ->join('tconf_list_menu','tconf_list_menu.id','=','tconf_affectation_menu.refMenu')        
        ->select("tconf_affectation_menu.id" ,"roles.nom","tconf_list_menu.name_menu","numero_menu",
        'refRole','refMenu','tconf_affectation_menu.author')
        ->Where('refRole',$refRole);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('name_menu', 'like', '%'.$query.'%')          
            ->orderBy("tconf_list_menu.numero_menu", "asc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tconf_list_menu.numero_menu", "asc");
        return $this->apiData($data->paginate(10)); 
    }

    function fetch_single_detail($id)
    {
        $data = DB::table('tconf_affectation_menu')
        ->join('roles','roles.id','=','tconf_affectation_menu.refRole')
        ->join('tconf_list_menu','tconf_list_menu.id','=','tconf_affectation_menu.refMenu')        
        ->select("tconf_affectation_menu.id" ,"roles.nom","tconf_list_menu.name_menu","numero_menu",
        'refRole','refMenu','tconf_affectation_menu.author')
        ->where('tconf_affectation_menu.id', $id)
        ->orderBy("tconf_list_menu.numero_menu", "asc")
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_menu_roles($refRole)
    {
        $data = DB::table('tconf_affectation_menu')
        ->join('roles','roles.id','=','tconf_affectation_menu.refRole')
        ->join('tconf_list_menu','tconf_list_menu.id','=','tconf_affectation_menu.refMenu')        
        ->select("tconf_affectation_menu.id","numero_menu")
        ->where('tconf_affectation_menu.refRole', $refRole)
        ->orderBy("tconf_affectation_menu.id", "asc")
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
    //id,refRole,refMenu,author
    function insert_detail(Request $request)
    {
        $data = tconf_affectation_menu::create([
            'refRole'       =>  $request->refRole,
            'refMenu'    =>  $request->refMenu,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_detail(Request $request, $id)
    {
        $data = tconf_affectation_menu::where('id', $id)->update([
            'refRole'       =>  $request->refRole,
            'refMenu'    =>  $request->refMenu,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_detail($id)
    {
        $data = tconf_affectation_menu::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }

}
