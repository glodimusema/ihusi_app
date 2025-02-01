<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_option_stage;
use DB;


class tperso_option_stageController extends Controller
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

            $data = DB::table('tperso_option_stage')
            ->join('tperso_domaine_stage','tperso_domaine_stage.id','=','tperso_option_stage.domaine_id')
            ->select("tperso_option_stage.id","name_option","name_domaine","tperso_option_stage.created_at",
            "tperso_option_stage.author","domaine_id")
            ->where('name_domaine', 'like', '%'.$query.'%')
            ->orWhere('name_option', 'like', '%'.$query.'%')
            ->orderBy("tperso_option_stage.id", "desc")
            ->paginate(10);
            return response($data, 200);           

        }
        else{

            $data = DB::table('tperso_option_stage')
            ->join('tperso_domaine_stage','tperso_domaine_stage.id','=','tperso_option_stage.domaine_id')
            ->select("tperso_option_stage.id","name_option","name_domaine","domaine_id","tperso_option_stage.created_at",
            "tperso_option_stage.author")
            ->orderBy("tperso_option_stage.id", "desc")
            ->paginate(10);

            return response($data, 200);
        }

    }

    function fetch_single($id)
    {
        $data = DB::table('tperso_option_stage')
        ->join('tperso_domaine_stage','tperso_domaine_stage.id','=','tperso_option_stage.domaine_id')
        ->select("tperso_option_stage.id","name_option","name_domaine","tperso_option_stage.created_at",
        "tperso_option_stage.author","domaine_id")
        ->where('tperso_option_stage.id', $id)
        ->get();

        return response()->json(['data' => $data]);

        // return response($data, 200);
    }


    function fetch_service_personnel_categorie($domaine_id)
    {
        $data = DB::table('tperso_option_stage')
        ->join('tperso_domaine_stage','tperso_domaine_stage.id','=','tperso_option_stage.domaine_id')
        ->select("tperso_option_stage.id","name_option","name_domaine","tperso_option_stage.created_at",
        "tperso_option_stage.author","domaine_id")
        ->where('tperso_option_stage.domaine_id', $domaine_id)
        ->get();

        return response()->json(['data' => $data]);
    }

    function fetch_service_personnel2()
    {
        $data = DB::table('tperso_option_stage')
        ->join('tperso_domaine_stage','tperso_domaine_stage.id','=','tperso_option_stage.domaine_id')
        ->select("tperso_option_stage.id","name_option","name_domaine","tperso_option_stage.created_at",
        "tperso_option_stage.author","domaine_id")
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }

 //
    function insert_data(Request $request)
    {       
        //id,name_option,domaine_id,author
        $data = tperso_option_stage::create([
            'domaine_id'       =>  $request->domaine_id,
            'name_option'    =>  $request->name_option,
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_data(Request $request, $id)
    {
        $data = tperso_option_stage::where('id', $id)->update([
            'domaine_id'       =>  $request->domaine_id,
            'name_option'    =>  $request->name_option,
            'author'    =>  $request->author
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
     $data = tperso_option_stage::where('id', $id)->delete();
     
     return response()->json([
        'data'  =>  "suppression avec succès",
    ]);
 }

}
