<?php

namespace App\Http\Controllers\Gaz;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Gaz\{tgaz_lot};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;




class tgaz_lotController extends Controller
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
        $data = DB::table("tgaz_lot")
        ->join('tgaz_categorie_lot','tgaz_categorie_lot.id','=','tgaz_lot.refCategorieLot')
        ->select("tgaz_lot.id",'refCategorieLot','nom_categorie_lot','nom_lot','code_lot',
        'unite_lot','stock_alerte','author','refUser',"tgaz_lot.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tgaz_lot.nom_lot', 'like', '%'.$query.'%')
            ->orderBy("tgaz_lot.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tgaz_lot_2()
    {
         $data = DB::table("tgaz_lot")
        ->select("tgaz_lot.id",'refCategorieLot','nom_lot','code_lot',
        'unite_lot','stock_alerte','author','refUser',"tgaz_lot.created_at")
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
            // update  ,'refCategorieLot'//'id','nom_lot','code_lot','unite_lot','stock_alerte','author','refUser'
            $data = tgaz_lot::where("id", $request->id)->update([                
                'refCategorieLot' =>  $request->refCategorieLot,
                'nom_lot' =>  $request->nom_lot,
                'code_lot' =>  $request->code_lot,
                'unite_lot' =>  $request->unite_lot,
                'stock_alerte' =>  $request->stock_alerte,
                'author' =>  $request->author,
                'refUser' =>  $request->refUser
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tgaz_lot::create([
                'refCategorieLot' =>  $request->refCategorieLot,
                'nom_lot' =>  $request->nom_lot,
                'code_lot' =>  $request->code_lot,
                'unite_lot' =>  $request->unite_lot,
                'stock_alerte' =>  $request->stock_alerte,
                'author' =>  $request->author,
                'refUser' =>  $request->refUser
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
        $data = tgaz_lot::where('id', $id)->get();
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
        $data = tgaz_lot::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
