<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Personnel\{tperso_typecirconstanceconge};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tperso_typecirconstancecongeController extends Controller
{
    //tperso_typecirconstanceconge  nom_circontstance,description_circons

    // tperso_poste  id,nom_poste,description_poste
    // tperso_typecirconstanceconge  id,nom_circontstance,description_circons
    // tperso_mutuelle  id,nom_mutuelle,description_mutuelle
    // tperso_typecirconstanceconge  id,nom_circontstance,code_contrat

    use GlobalMethod;
    use Slug;
    public function index(Request $query)
    {
        $data = DB::table('tperso_typecirconstanceconge')
        ->join('tperso_categorie_circonstance','tperso_categorie_circonstance.id','=','tperso_typecirconstanceconge.categorie_id')
        ->select("tperso_typecirconstanceconge.id",'nom_circontstance','description_circons',
        "tperso_typecirconstanceconge.created_at",'categorie_id','nbrjour_cirscons','nom_categorie');

        if (!is_null($query->get('query'))) {
            # code...
            $query = $this->Gquery($query);

            $data->where('tperso_typecirconstanceconge.nom_circontstance', 'like', '%'.$query.'%')
            ->orderBy("tperso_typecirconstanceconge.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
        
    }


    function fetch_dropdown_2()
    {
        $data = DB::table('tperso_typecirconstanceconge')
        ->join('tperso_categorie_circonstance','tperso_categorie_circonstance.id','=','tperso_typecirconstanceconge.categorie_id')
        ->select("tperso_typecirconstanceconge.id",'nom_circontstance','description_circons',
        "tperso_typecirconstanceconge.created_at",'categorie_id','nbrjour_cirscons','nom_categorie')
        ->orderBy("nom_circontstance", "asc")->get();
        return response()->json([
            'data'  => $data
        ]);

    }

    function fetch_dropdown_categorie($categorie_id)
    {
        $data = DB::table('tperso_typecirconstanceconge')
        ->join('tperso_categorie_circonstance','tperso_categorie_circonstance.id','=','tperso_typecirconstanceconge.categorie_id')
        ->select("tperso_typecirconstanceconge.id",'nom_circontstance','description_circons',
        "tperso_typecirconstanceconge.created_at",'categorie_id','nbrjour_cirscons','nom_categorie')
        ->where('tperso_typecirconstanceconge.categorie_id', $categorie_id)
        ->get();
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
        //categorie_id nbrjour_cirscons
        
        if ($query->id !='') 
        {
 
            $data = tperso_typecirconstanceconge::where("id", $query->id)->update([
                'nom_circontstance' =>  $query->nom_circontstance,
                'description_circons' =>  $query->description_circons,
                'categorie_id' =>  $query->categorie_id,
                'nbrjour_cirscons' =>  $query->nbrjour_cirscons
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!"
            ]);
        }
        else
        {
     
            $data = tperso_typecirconstanceconge::create([
                'nom_circontstance' =>  $query->nom_circontstance,
                'description_circons' =>  $query->description_circons,
                'categorie_id' =>  $query->categorie_id,
                'nbrjour_cirscons' =>  $query->nbrjour_cirscons
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
        $data = tperso_typecirconstanceconge::where('id', $id)->get();
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
        $data = tperso_typecirconstanceconge::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
