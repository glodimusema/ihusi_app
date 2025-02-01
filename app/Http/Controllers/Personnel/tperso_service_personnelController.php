<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_service_personnel;
use DB;


class tperso_service_personnelController extends Controller
{
    function Gquery($request)
    {
     return str_replace(" ", "%", $request->get('query'));
    }

    public function all(Request $request)
    { 
                

        if (!is_null($request->get('query'))) 
        {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tperso_service_personnel')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->select("tperso_service_personnel.id","name_serv_perso","name_categorie_service",
            "tperso_service_personnel.created_at","refCatService")
            ->where('name_categorie_service', 'like', '%'.$query.'%')
            ->orWhere('name_serv_perso', 'like', '%'.$query.'%')
            ->orderBy("tperso_service_personnel.id", "desc")
            ->paginate(10);

            return response($data, 200);           

        }
        else{

            $data = DB::table('tperso_service_personnel')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=',
            'tperso_service_personnel.refCatService')
            ->select("tperso_service_personnel.id","name_serv_perso","name_categorie_service",
            "tperso_service_personnel.created_at","refCatService")
            ->orderBy("tperso_service_personnel.id", "desc")
            ->paginate(10);

            return response($data, 200);
        }

    }

    function fetch_single($id)
    {
        $data = DB::table('tperso_service_personnel')
        ->join('tperso_categorie_service','tperso_categorie_service.id','=',
        'tperso_service_personnel.refCatService')
        ->select("tperso_service_personnel.id","name_serv_perso","name_categorie_service",
        "tperso_service_personnel.created_at","refCatService")
        ->where('tperso_service_personnel.id', $id)
        ->get();

        return response()->json(['data' => $data]);

        // return response($data, 200);
    }


    function fetch_service_personnel_categorie($refCatService)
    {
        $data = DB::table('tperso_service_personnel')
        ->join('tperso_categorie_service','tperso_categorie_service.id','=',
        'tperso_service_personnel.refCatService')
        ->select("tperso_service_personnel.id","name_serv_perso","name_categorie_service",
        "tperso_service_personnel.created_at","refCatService")
        ->where('tperso_service_personnel.refCatService', $refCatService)
        ->get();

        return response()->json(['data' => $data]);
    }

    function fetch_service_personnel2()
    {
        $data = DB::table('tperso_service_personnel')
        ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
        ->select("tperso_service_personnel.id","name_serv_perso","name_categorie_service",
        "tperso_service_personnel.created_at","refCatService")
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }

 //
    function insert_data(Request $request)
    {
       

        $data = tperso_service_personnel::create([
            'refCatService'       =>  $request->refCatService,
            'name_serv_perso'    =>  $request->name_serv_perso                              
            
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_data(Request $request, $id)
    {
        $data = tperso_service_personnel::where('id', $id)->update([
            'refCatService'       =>  $request->refCatService,
            'name_serv_perso'    =>  $request->name_serv_perso
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }
 /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
 public function create()
 {
     //
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
 }

 /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function show($id)
 {
     //
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
 }

 /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function update(Request $request, $id)
 {
     //
 }

 /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function destroy($id)
 {
     $data = tperso_service_personnel::where('id', $id)->delete();
     
     return response()->json([
        'data'  =>  "suppression avec succès",
    ]);
 }

}
