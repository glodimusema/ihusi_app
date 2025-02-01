<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Personnel\{tperso_lieuaffectation};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tperso_lieuaffectationController extends Controller
{
    // tperso_poste  id,nom_poste,description_poste
    // tperso_lieuaffectation  id,nom_lieu,description_lieu
    // tperso_mutuelle  id,nom_mutuelle,description_mutuelle
    // tperso_lieuaffectation  id,nom_lieu,code_contrat
    use GlobalMethod;
    use Slug;
    public function index(Request $query)
    {
        $data = DB::table('tperso_lieuaffectation')
        ->select("tperso_lieuaffectation.id",'nom_lieu','description_lieu',
        "tperso_lieuaffectation.created_at");

        if (!is_null($query->get('query'))) {
            # code...
            $query = $this->Gquery($query);

            $data->where('tperso_lieuaffectation.nom_lieu', 'like', '%'.$query.'%')
            ->orderBy("tperso_lieuaffectation.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
        
    }


    function fetch_dropdown_2()
    {
        $data = DB::table('tperso_lieuaffectation')
        ->select("tperso_lieuaffectation.id","tperso_lieuaffectation.nom_lieu",'description_lieu',
        "tperso_lieuaffectation.created_at")
        ->orderBy("nom_lieu", "asc")->get();
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
 
            $data = tperso_lieuaffectation::where("id", $query->id)->update([
                'nom_lieu' =>  $query->nom_lieu,
                'description_lieu' =>  $query->description_lieu
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!"
            ]);
        }
        else
        {
     
            $data = tperso_lieuaffectation::create([

                'nom_lieu' =>$query->nom_lieu,
                'description_lieu' =>  $query->description_lieu
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
        $data = tperso_lieuaffectation::where('id', $id)->get();
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
        $data = tperso_lieuaffectation::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
