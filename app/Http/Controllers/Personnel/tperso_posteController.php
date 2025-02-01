<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Personnel\{tperso_poste};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tperso_posteController extends Controller
{
    // tperso_poste  id,nom_poste,description_poste
    // tperso_lieuaffectation  id,nom_lieu,description_lieu
    // tperso_mutuelle  id,nom_mutuelle,description_mutuelle
    // tperso_poste  id,nom_poste,code_contrat
    use GlobalMethod;
    use Slug;
    public function index(Request $query)
    {
        $data = DB::table('tperso_poste')
        ->select("tperso_poste.id",'nom_poste','description_poste','transport',
        "tperso_poste.created_at");

        if (!is_null($query->get('query'))) {
            # code...
            $query = $this->Gquery($query);

            $data->where('tperso_poste.nom_poste', 'like', '%'.$query.'%')
            ->orderBy("tperso_poste.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
        
    }


    function fetch_dropdown_2()
    {
        $data = DB::table('tperso_poste')
        ->select("tperso_poste.id","tperso_poste.nom_poste",'description_poste','transport',
        "tperso_poste.created_at")
        ->orderBy("nom_poste", "asc")->get();
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
            //transport
            $data = tperso_poste::where("id", $query->id)->update([
                'nom_poste' =>  $query->nom_poste,
                'description_poste' =>  $query->description_poste,
                'transport' =>  $query->transport
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!"
            ]);
        }
        else
        {
     
            $data = tperso_poste::create([

                'nom_poste' =>$query->nom_poste,
                'description_poste' =>  $query->description_poste,
                'transport' =>  $query->transport
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
        $data = tperso_poste::where('id', $id)->get();
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
        $data = tperso_poste::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
