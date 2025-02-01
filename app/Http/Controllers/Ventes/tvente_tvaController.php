<?php

namespace App\Http\Controllers\Ventes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Ventes\{tvente_tva};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

// tvente_tva
// libelle_tva
// code_unite
// active

class tvente_tvaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //id,,'montant_tva','libelle_tva','active'
        $data = DB::table("tvente_tva")
        ->select("tvente_tva.id", "tvente_tva.montant_tva","libelle_tva","active", "tvente_tva.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tvente_tva.libelle_tva', 'like', '%'.$query.'%')
            ->orderBy("tvente_tva.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tvente_tva_2()
    {
         $data = DB::table("tvente_tva")
         ->select("tvente_tva.id", "tvente_tva.montant_tva","libelle_tva","active", "tvente_tva.created_at")
        ->get();
        return response()->json(['data' => $data]);
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
        if ($request->id !='') 
        {
            # code...
            // update  //id,,'montant_tva','libelle_tva','active'
            $data = tvente_tva::where("id", $request->id)->update([
                'montant_tva' =>  $request->montant_tva,
                'libelle_tva' =>  $request->libelle_tva,
                'active' =>  $request->active
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tvente_tva::create([
                'montant_tva' =>  $request->montant_tva,
                'libelle_tva' =>  $request->libelle_tva,
                'active' =>  $request->active
            ]);

            return $this->msgJson('Insertion avec succès!!!');
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
        $data = tvente_tva::where('id', $id)->get();
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
        $data = tvente_tva::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
