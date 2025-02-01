<?php

namespace App\Http\Controllers\Parametres;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Parametres\{tconf_crud_access};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tconf_crud_accessController extends Controller
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
       
      
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tconf_crud_access')
            ->join('roles','roles.id','=','tconf_crud_access.refRole')        
            ->select("tconf_crud_access.id" ,"roles.nom",'insert','update','delete','load','tconf_crud_access.author')
            ->where('nom', 'like', '%'.$query.'%')
            ->orderBy("tconf_crud_access.id", "asc")
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tconf_crud_access')
            ->join('roles','roles.id','=','tconf_crud_access.refRole')        
            ->select("tconf_crud_access.id" ,"roles.nom",'insert','update',
            'delete','load','tconf_crud_access.author')
            ->orderBy("tconf_crud_access.id", "asc")
            ->paginate(10);
            return response($data, 200);
        }

    }


    public function fetch_affaction_role(Request $request,$refRole)
    {     
      
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tconf_crud_access')
            ->join('roles','roles.id','=','tconf_crud_access.refRole')        
            ->select("tconf_crud_access.id" ,"roles.nom",'insert','update',
            'delete','load','tconf_crud_access.author')
            ->where([
                ['name_menu', 'like', '%'.$query.'%'],
                ['refRole', $refRole]
            ])
            ->orderBy("tconf_crud_access.id", "asc")
            ->paginate(10);

            return response($data, 200);          

        }
        else{
            $data = DB::table('tconf_crud_access')
            ->join('roles','roles.id','=','tconf_crud_access.refRole')        
            ->select("tconf_crud_access.id" ,"roles.nom",'insert','update',
            'delete','load','tconf_crud_access.author')
            ->Where('refRole',$refRole)
            ->orderBy("tconf_crud_access.id", "asc")
            ->paginate(10);
            return response($data, 200);
        }
    }

    function fetch_single_detail($id)
    {
        $data = DB::table('tconf_crud_access')
        ->join('roles','roles.id','=','tconf_crud_access.refRole')        
        ->select("tconf_crud_access.id" ,"roles.nom",'insert','update',
        'delete','load','tconf_crud_access.author')
        ->where('tconf_crud_access.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_menu_roles($refRole)
    {
        $data = DB::table('tconf_crud_access')
        ->join('roles','roles.id','=','tconf_crud_access.refRole')        
        ->select("tconf_crud_access.id" ,"roles.nom",'insert','update','delete','load','tconf_crud_access.author')
        ->where('tconf_crud_access.refRole', $refRole)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
    //id,refRole,'insert','update','delete','load','tconf_crud_access.author'
    function insert_detail(Request $request)
    {
        $data = tconf_crud_access::create([
            'refRole'       =>  $request->refRole,
            'insert'    =>  $request->insert,
            'update'    =>  $request->update,
            'delete'    =>  $request->delete,
            'load'    =>  $request->load,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_detail(Request $request, $id)
    {
        $data = tconf_crud_access::where('id', $id)->update([
            'refRole'       =>  $request->refRole,
            'insert'    =>  $request->insert,
            'update'    =>  $request->update,
            'delete'    =>  $request->delete,
            'load'    =>  $request->load,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_detail($id)
    {
        $data = tconf_crud_access::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }

}
