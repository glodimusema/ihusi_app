<?php

namespace App\Http\Controllers\Vehicule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Vehicule\{tcar_vehicule};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;


class tcar_vehiculeController extends Controller
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
        //id,nom_vehicule,author

        $data = DB::table('tcar_vehicule')        
        ->select("tcar_vehicule.id",'nom_vehicule','marque','couleur','numPlaque','author');

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tcar_vehicule.nom_vehicule', 'like', '%'.$query.'%')
            ->orderBy("tcar_vehicule.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tcar_vehicule_2()
    {
         $data = DB::table('tcar_vehicule')        
         ->select("tcar_vehicule.id",'nom_vehicule','marque','couleur','numPlaque','author')
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
            // update  'nom_vehicule','marque','couleur','numPlaque','author'
            $data = tcar_vehicule::where("id", $request->id)->update([
                'nom_vehicule'       =>  $request->nom_vehicule,
                'marque'    =>  $request->marque,
                'couleur'    =>  $request->couleur,
                'numPlaque'    =>  $request->numPlaque,
                'author'    =>  $request->author
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tcar_vehicule::create([
                'nom_vehicule'       =>  $request->nom_vehicule,
                'marque'    =>  $request->marque,
                'couleur'    =>  $request->couleur,
                'numPlaque'    =>  $request->numPlaque,
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
        $data = tcar_vehicule::where('id', $id)->get();
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
        $data = tcar_vehicule::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
