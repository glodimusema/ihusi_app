<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Personnel\{tperso_categorie_circonstance};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tperso_categorie_circonstanceController extends Controller
{
    use GlobalMethod;
    use Slug;

    function Gquery($query)
    {
      return str_replace(" ", "%", $query->get('query'));
      // return $query->get('query');
    }

    public function index(Request $query)
    {
        //
        
        if (!is_null($query->get('query'))) {
            # code...
            $query = $this->Gquery($query);
            $data = DB::table('tperso_categorie_circonstance')
            ->select("tperso_categorie_circonstance.id","tperso_categorie_circonstance.nom_categorie","tperso_categorie_circonstance.created_at")->where('nom_categorie', 'like', '%'.$query.'%')
            ->orWhere('nom_categorie', 'like', '%'.$query.'%')
            ->orderBy("tperso_categorie_circonstance.id", "desc")
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tperso_categorie_circonstance')
            ->select("tperso_categorie_circonstance.id","tperso_categorie_circonstance.nom_categorie","tperso_categorie_circonstance.created_at")
            ->orderBy("tperso_categorie_circonstance.id", "desc")
            ->paginate(10);

            return response($data, 200);
        }
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $query
     * @return \Illuminate\Http\Response
     */
    public function store(Request $query)
    {
        
        if ($query->id !='') 
        {
 
            $data = tperso_categorie_circonstance::where("id", $query->id)->update([
                'nom_categorie' =>  $query->nom_categorie
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!"
            ]);
        }
        else
        {
     
            $data = tperso_categorie_circonstance::create([

                'nom_categorie' =>$query->nom_categorie
            ]);

            return response()->json([
                'data'  =>  "Insertion avec succès!!!",
            ]);
        }
    }

    function fetch_dropdown_2()
    {
        $data = DB::table('tperso_categorie_circonstance')
        ->select("tperso_categorie_circonstance.id","tperso_categorie_circonstance.nom_categorie",
        "tperso_categorie_circonstance.created_at")
        ->orderBy("id", "desc")
        ->get();
        return response()->json([
            'data'  => $data
        ]);

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
        $data = tperso_categorie_circonstance::where('id', $id)->get();
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
        $data = tperso_categorie_circonstance::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
