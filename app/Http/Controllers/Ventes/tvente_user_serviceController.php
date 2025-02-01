<?php

namespace App\Http\Controllers\Ventes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ventes\{tvente_user_service};
use App\Models\Produit;
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;


class tvente_user_serviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        $data = DB::table('tvente_user_service')
        ->join('users','users.id','=','tvente_user_service.refUser')
        ->join('roles','users.id_role','=','roles.id')
        ->join('tvente_services','tvente_services.id','=','tvente_user_service.refService')
        ->select("tvente_user_service.id",'tvente_user_service.refUser','tvente_user_service.refService',
        'tvente_user_service.active','tvente_user_service.author',"tvente_user_service.created_at",
        "nom_service",'users.avatar','users.name','users.email','users.id_role','roles.nom as role_name',
        'users.sexe','users.telephone','users.adresse');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('users.name', 'like', '%'.$query.'%')
            ->orderBy("tvente_user_service.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tvente_user_service_2()
    {
         $data = DB::table('tvente_user_service')
         ->join('users','users.id','=','tvente_user_service.refUser')
         ->join('roles','users.id_role','=','roles.id')
         ->join('tvente_services','tvente_services.id','=','tvente_user_service.refService')
         ->select("tvente_user_service.id",'tvente_user_service.refUser','tvente_user_service.refService',
         'tvente_user_service.active','tvente_user_service.author',"tvente_user_service.created_at",
         "nom_service",'users.avatar','users.name','users.email','users.id_role','roles.nom as role_name',
         'users.sexe','users.telephone','users.adresse')        
        ->get();
        
        return response()->json(['data' => $data]);

    }


    function fetch_service_user_by_user($refUser)
    {
        $data = DB::table('tvente_user_service')
        ->join('users','users.id','=','tvente_user_service.refUser')
        ->join('roles','users.id_role','=','roles.id')
        ->join('tvente_services','tvente_services.id','=','tvente_user_service.refService')
        ->select("tvente_user_service.id",'tvente_user_service.refUser','tvente_user_service.refService',
        'tvente_user_service.active','tvente_user_service.author',"tvente_user_service.created_at",
        "nom_service",'users.avatar','users.name','users.email','users.id_role','roles.nom as role_name',
        'users.sexe','users.telephone','users.adresse','status')
        ->where([
            ['tvente_user_service.refUser', $refUser],
            ['tvente_user_service.active','=', 'OUI'],
            ['tvente_services.status','!=', 'Depot Central']
         ])
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_service_pointvente_user_by_user($refUser)
    {
        $data = DB::table('tvente_user_service')
        ->join('users','users.id','=','tvente_user_service.refUser')
        ->join('roles','users.id_role','=','roles.id')
        ->join('tvente_services','tvente_services.id','=','tvente_user_service.refService')
        ->select("tvente_user_service.id",'tvente_user_service.refUser','tvente_user_service.refService',
        'tvente_user_service.active','tvente_user_service.author',"tvente_user_service.created_at",
        "nom_service",'users.avatar','users.name','users.email','users.id_role','roles.nom as role_name',
        'users.sexe','users.telephone','users.adresse')
        ->where([
            ['tvente_user_service.refUser', $refUser],
            ['tvente_user_service.active','=', 'OUI'],
            ['status','=', 'Point de vente']
         ])
         ->orWhere([
            ['tvente_user_service.refUser', $refUser],
            ['tvente_user_service.active','=', 'OUI'],
            ['status','=', 'Point de Consommation']
         ])
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_service_magasin_user_by_user($refUser)
    {
        $data = DB::table('tvente_user_service')
        ->join('users','users.id','=','tvente_user_service.refUser')
        ->join('roles','users.id_role','=','roles.id')
        ->join('tvente_services','tvente_services.id','=','tvente_user_service.refService')
        ->select("tvente_user_service.id",'tvente_user_service.refUser','tvente_user_service.refService',
        'tvente_user_service.active','tvente_user_service.author',"tvente_user_service.created_at",
        "nom_service",'users.avatar','users.name','users.email','users.id_role','roles.nom as role_name',
        'users.sexe','users.telephone','users.adresse')
        ->where([
            ['tvente_user_service.refUser', $refUser],
            ['tvente_user_service.active','=', 'OUI'],
            ['status','=', 'Magasin(Depot)']
         ])
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_service_stockmasison_user_by_user($refUser)
    {
        $data = DB::table('tvente_user_service')
        ->join('users','users.id','=','tvente_user_service.refUser')
        ->join('roles','users.id_role','=','roles.id')
        ->join('tvente_services','tvente_services.id','=','tvente_user_service.refService')
        ->select("tvente_user_service.id",'tvente_user_service.refUser','tvente_user_service.refService',
        'tvente_user_service.active','tvente_user_service.author',"tvente_user_service.created_at",
        "nom_service",'users.avatar','users.name','users.email','users.id_role','roles.nom as role_name',
        'users.sexe','users.telephone','users.adresse')
        ->where([
            ['tvente_user_service.refUser', $refUser],
            ['tvente_user_service.active','=', 'OUI'],
            ['status','=', 'Stock Maison']
         ])
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //
        if ($request->id !='') 
        {
            # code...
            // update  'id','refUser','refService','active','author'
            $data = tvente_user_service::where("id", $request->id)->update([
                'refUser'       =>  $request->refUser,
                'refService'    =>  $request->refService,
                'active'    =>  $request->active,
                'author'    =>  $request->author
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tvente_user_service::create([
                'refUser'       =>  $request->refUser,
                'refService'    =>  $request->refService,
                'active'    =>  $request->active,
                'author'    =>  $request->author
            ]);

            return $this->msgJson('Insertion avec succès!!!');
        }
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = tvente_user_service::where('id', $id)->get();
        return response()->json(['data' => $data]);
    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = tvente_user_service::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
