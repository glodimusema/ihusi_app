<?php

namespace App\Http\Controllers\Vehicule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Vehicule\{tcar_produit};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;


class tcar_produitController extends Controller
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
        //id,designation,author

        $data = DB::table('tcar_produit')        
        ->select("tcar_produit.id","tcar_produit.designation as designation",'pu','devise','taux','unite','author');

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tcar_produit.designation', 'like', '%'.$query.'%')
            ->orderBy("tcar_produit.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tcar_produit_2()
    {
         $data = DB::table('tcar_produit')        
         ->select("tcar_produit.id","tcar_produit.designation as designation",'pu','devise','taux','unite','author')
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
        $taux=0;
        $data5 =  DB::table("tvente_taux")
        ->select("tvente_taux.id", "tvente_taux.taux", 
        "tvente_taux.created_at", "tvente_taux.author")
         ->get(); 
         $output='';
         foreach ($data5 as $row) 
         {                                
            $taux=$row->taux;                           
         }

        $montants=0;
        $devises='';
        if($request->devise != 'FC')
        {
            $montants = ($request->pu)*$taux;
            $devises='FC';
        }
        else
        {
            $montants = $request->pu;
            $devises = $request->devise;
        }


        //
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = tcar_produit::where("id", $request->id)->update([
                'designation'       =>  $request->designation,
                'pu'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'unite'    =>  $request->unite,
                'author'    =>  $request->author
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tcar_produit::create([
                'designation'       =>  $request->designation,
                'pu'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'unite'    =>  $request->unite,
                'author'    =>  $request->author
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
        $data = tcar_produit::where('id', $id)->get();
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
        $data = tcar_produit::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
