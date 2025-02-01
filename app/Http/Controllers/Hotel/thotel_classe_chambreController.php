<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Hotel\{thotel_classe_chambre};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;


class thotel_classe_chambreController extends Controller
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

        $data = DB::table("thotel_classe_chambre")
        ->select("thotel_classe_chambre.id", "thotel_classe_chambre.designation",
        "prix_chambre","devise","taux","thotel_classe_chambre.created_at", 
        "thotel_classe_chambre.author","thotel_classe_chambre.refUser");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('thotel_classe_chambre.designation', 'like', '%'.$query.'%')
            ->orderBy("thotel_classe_chambre.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_thotel_classe_chambre_2()
    {
         $data = DB::table("thotel_classe_chambre")
         ->select("thotel_classe_chambre.id", "thotel_classe_chambre.designation","prix_chambre",
         "devise","taux", "thotel_classe_chambre.created_at", "thotel_classe_chambre.author",
         "thotel_classe_chambre.refUser")
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
        if($request->devise != 'USD')
        {
            $montants = ($request->prix_chambre)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->prix_chambre;
            $devises = $request->devise;
        }

        //
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = thotel_classe_chambre::where("id", $request->id)->update([
                'designation' =>  $request->designation,
                'prix_chambre' =>  $montants,
                'devise' =>  $devises,
                'taux' =>  $taux,
                'author' =>  $request->author,
                'refUser'       =>  $request->refUser
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = thotel_classe_chambre::create([
                'designation' =>  $request->designation,
                'prix_chambre' =>  $montants,
                'devise' =>  $devises,
                'taux' =>  $taux,
                'author' =>  $request->author,
                'refUser'       =>  $request->refUser
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
        $data = thotel_classe_chambre::where('id', $id)->get();
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
        $data = thotel_classe_chambre::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
