<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\{tperso_mois};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tperso_moisController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_mois')
            ->select("tperso_mois.id","tperso_mois.name_mois","tperso_mois.created_at")->where('name_mois', 'like', '%'.$query.'%')
            ->orWhere('name_mois', 'like', '%'.$query.'%')
            ->orderBy("tperso_mois.id", "desc")
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tperso_mois')
            ->select("tperso_mois.id","tperso_mois.name_mois","tperso_mois.created_at")
            ->orderBy("tperso_mois.id", "desc")
            ->paginate(10);
            return response($data, 200);
        }
    }


    function fetch_dropdown_2()
    {
        $data = DB::table('tperso_mois')
        ->select("tperso_mois.id","tperso_mois.name_mois","tperso_mois.created_at")
        ->orderBy("id", "asc")->get();
        return response()->json([
            'data'  => $data
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
 
            $data = tperso_mois::where("id", $request->id)->update([
                'name_mois' =>  $request->name_mois
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!"
            ]);
        }
        else
        {
     
            $data = tperso_mois::create([

                'name_mois' =>$request->name_mois
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
        $data = tperso_mois::where('id', $id)->get();
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
        $data = tperso_mois::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
