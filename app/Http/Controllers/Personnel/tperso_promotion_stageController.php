<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Personnel\{tperso_promotion_stage};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tperso_promotion_stageController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_promotion_stage')
            ->select("tperso_promotion_stage.id","tperso_promotion_stage.name_promotion",
            "tperso_promotion_stage.author","tperso_promotion_stage.created_at")
            ->where('name_promotion', 'like', '%'.$query.'%')
            ->orderBy("tperso_promotion_stage.id", "desc")
            ->paginate(10);

           return response($data, 200);
           

        }
        else{
            $data = DB::table('tperso_promotion_stage')
            ->select("tperso_promotion_stage.id","tperso_promotion_stage.name_promotion",
            "tperso_promotion_stage.author","tperso_promotion_stage.created_at")
            ->orderBy("tperso_promotion_stage.id", "desc")
            ->paginate(10);
            
           return response($data, 200);
        }
    }


    function fetch_dropdown_2()
    {
        $data = DB::table('tperso_promotion_stage')
        ->select("tperso_promotion_stage.id","tperso_promotion_stage.name_promotion",
        "tperso_promotion_stage.author","tperso_promotion_stage.created_at")
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
 
            $data = tperso_promotion_stage::where("id", $request->id)->update([
                'name_promotion' =>  $request->name_promotion,
                'author' =>  $request->author
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!"
            ]);
        }
        else
        {
     
            $data = tperso_promotion_stage::create([

                'name_promotion' =>$request->name_promotion,
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
        $data = tperso_promotion_stage::where('id', $id)->get();
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
        $data = tperso_promotion_stage::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
