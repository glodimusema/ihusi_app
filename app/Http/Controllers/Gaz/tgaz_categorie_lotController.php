<?php

namespace App\Http\Controllers\Gaz;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Gaz\{tgaz_categorie_lot};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;




class tgaz_categorie_lotController extends Controller
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
        $data = DB::table("tgaz_categorie_lot")
        ->select("tgaz_categorie_lot.id",'nom_categorie_lot',"tgaz_categorie_lot.created_at");
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tgaz_categorie_lot.nom_categorie_lot', 'like', '%'.$query.'%')
            ->orderBy("tgaz_categorie_lot.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tgaz_categorie_lot_2()
    {
         $data = DB::table("tgaz_categorie_lot")
        ->select("tgaz_categorie_lot.id",'nom_categorie_lot',"tgaz_categorie_lot.created_at")
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
            // update  //'id','nom_categorie_lot','code_lot','unite_lot','stock_alerte','author','refUser'
            $data = tgaz_categorie_lot::where("id", $request->id)->update([                
                'nom_categorie_lot' =>  $request->nom_categorie_lot
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tgaz_categorie_lot::create([
                'nom_categorie_lot' =>  $request->nom_categorie_lot
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
        $data = tgaz_categorie_lot::where('id', $id)->get();
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
        $data = tgaz_categorie_lot::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
