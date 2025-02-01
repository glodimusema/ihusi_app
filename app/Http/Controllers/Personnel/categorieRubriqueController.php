<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Personnel\{tperso_categorie_rubrique};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tperso_categorie_rubriqueController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $query)
    {
        $data = DB::table('tperso_categorie_rubrique')
        ->select("tperso_categorie_rubrique.id","tperso_categorie_rubrique.name_categorie_rubrique",
        "tperso_categorie_rubrique.created_at");

        if (!is_null($query->get('query'))) {
            # code...
            $query = $this->Gquery($query);

            $data->where('tperso_categorie_rubrique.name_categorie_rubrique', 'like', '%'.$query.'%')
            ->orderBy("tperso_categorie_rubrique.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
        
    }


    function fetch_dopdown_2()
    {
        $data = DB::table('tperso_categorie_rubrique')
        ->select("tperso_categorie_rubrique.id","tperso_categorie_rubrique.name_categorie_rubrique",
        "tperso_categorie_rubrique.created_at")
        ->orderBy("name_categorie_rubrique", "asc")->get();
        return response()->json([
            'data'  => $data
        ]);

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
 
            $data = tperso_categorie_rubrique::where("id", $query->id)->update([
                'name_categorie_rubrique' =>  $query->name_categorie_rubrique
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!"
            ]);
        }
        else
        {
     
            $data = tperso_categorie_rubrique::create([

                'name_categorie_rubrique' =>$query->name_categorie_rubrique
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
        $data = tperso_categorie_rubrique::where('id', $id)->get();
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
        $data = tperso_categorie_rubrique::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
