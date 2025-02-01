<?php

namespace App\Http\Controllers\Vehicule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Vehicule\{tcar_producteur};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;


class tcar_producteurController extends Controller
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

        $data = DB::table('tcar_producteur')        
        ->select("tcar_producteur.id",'nom_producteur','adresse_prod','contact_prod','mail_prod','autres_details','author');

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tcar_producteur.designation', 'like', '%'.$query.'%')
            ->orderBy("tcar_producteur.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tcar_producteur_2()
    {
         $data = DB::table('tcar_producteur')        
         ->select("tcar_producteur.id",'nom_producteur','adresse_prod','contact_prod','mail_prod','autres_details','author')
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
            // update  id,'nom_producteur','adresse_prod','contact_prod','mail_prod','autres_details','author'
            $data = tcar_producteur::where("id", $request->id)->update([
                'nom_producteur'       =>  $request->nom_producteur,
                'adresse_prod'    =>  $request->adresse_prod,
                'contact_prod'    =>  $request->contact_prod,
                'mail_prod'    =>  $request->mail_prod,
                'autres_details'    =>  $request->autres_details,
                'author'    =>  $request->author
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tcar_producteur::create([
                'nom_producteur'       =>  $request->nom_producteur,
                'adresse_prod'    =>  $request->adresse_prod,
                'contact_prod'    =>  $request->contact_prod,
                'mail_prod'    =>  $request->mail_prod,
                'autres_details'    =>  $request->autres_details,
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
        $data = tcar_producteur::where('id', $id)->get();
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
        $data = tcar_producteur::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
