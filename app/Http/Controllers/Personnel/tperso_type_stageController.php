<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Personnel\{tperso_type_stage};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tperso_type_stageController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_type_stage')
            ->select("tperso_type_stage.id","tperso_type_stage.name_typestage",
            "tperso_type_stage.author","tperso_type_stage.created_at")
            ->where('name_typestage', 'like', '%'.$query.'%')
            ->orderBy("tperso_type_stage.id", "desc")
            ->paginate(10);

           return response($data, 200);
           

        }
        else{
            $data = DB::table('tperso_type_stage')
            ->select("tperso_type_stage.id","tperso_type_stage.name_typestage",
            "tperso_type_stage.author","tperso_type_stage.created_at")
            ->orderBy("tperso_type_stage.id", "desc")
            ->paginate(10);
            
           return response($data, 200);
        }
    }


    function fetch_dropdown_2()
    {
        $data = DB::table('tperso_type_stage')
        ->select("tperso_type_stage.id","tperso_type_stage.name_typestage",
        "tperso_type_stage.author","tperso_type_stage.created_at")
        ->orderBy("id", "desc")->get();
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
        
        if ($request->id !='') 
        { 
            $data = tperso_type_stage::where("id", $request->id)->update([
                'name_typestage' =>  $request->name_typestage,
                'author' =>  $request->author
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!"
            ]);
        }
        else
        {
     
            $data = tperso_type_stage::create([
                'name_typestage' =>$request->name_typestage,
                'author' =>  $request->author
            ]);

            return response()->json([
                'data'  =>  "Insertion avec succès!!!",
            ]);
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
        $data = tperso_type_stage::where('id', $id)->get();
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
        $data = tperso_type_stage::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
