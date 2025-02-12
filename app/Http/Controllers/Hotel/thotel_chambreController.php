<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Hotel\{thotel_chambre};
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use IlluminateHttpRequest;

use App\User;
use App\Message;


class thotel_chambreController extends Controller
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
        //id,nom_chambre,author

        $data = DB::table("thotel_chambre")
        ->join('thotel_classe_chambre','thotel_classe_chambre.id','=','thotel_chambre.refClasse') 
        ->select("thotel_chambre.id", "thotel_chambre.nom_chambre","numero_chambre","refClasse", 
        "thotel_classe_chambre.designation as ClasseChambre","thotel_classe_chambre.prix_chambre",
        "thotel_classe_chambre.devise","thotel_classe_chambre.taux", 
        "thotel_chambre.created_at", "thotel_chambre.author","thotel_chambre.refUser");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('thotel_chambre.nom_chambre', 'like', '%'.$query.'%')
            ->orderBy("thotel_chambre.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_thotel_chambre_2()
    {
         $data = DB::table("thotel_chambre")
         ->join('thotel_classe_chambre','thotel_classe_chambre.id','=','thotel_chambre.refClasse') 
         ->select("thotel_chambre.id", "thotel_chambre.nom_chambre","numero_chambre","refClasse", 
         "thotel_classe_chambre.designation as ClasseChambre","thotel_classe_chambre.prix_chambre",
         "thotel_classe_chambre.devise","thotel_classe_chambre.taux", 
         "thotel_chambre.created_at", "thotel_chambre.author","thotel_chambre.refUser")
        ->get();
        
        return response()->json(['data' => $data]);

    }


    function fetch_thotel_chambre_libre(Request $request)
    {
        // Vérifiez que les paramètres sont présents
        if ($request->has(['date_entree', 'date_sortie', 'refClasse'])) {
            // Récupérer les dates et la référence de classe
            $dateentree = $request->get('date_entree');
            $datesortie = $request->get('date_sortie');
            $refClasses = $request->get('refClasse');

            // Convertir les dates en format Y-m-d
            $dateentree_new = Carbon::parse($dateentree)->format('Y-m-d');
            $datesortie_new = Carbon::parse($datesortie)->format('Y-m-d');

            // Requête pour obtenir les chambres libres
            $data = DB::select(
                "SELECT thotel_chambre.id, thotel_chambre.nom_chambre, thotel_chambre.numero_chambre, thotel_chambre.refClasse, 
                thotel_classe_chambre.designation AS ClasseChambre, thotel_classe_chambre.prix_chambre,
                thotel_classe_chambre.devise, thotel_classe_chambre.taux 
                FROM thotel_chambre
                INNER JOIN thotel_classe_chambre ON thotel_classe_chambre.id = thotel_chambre.refClasse
                WHERE thotel_chambre.id NOT IN (
                    SELECT refChmabre 
                    FROM thotel_reservation_chambre 
                    WHERE (date_entree < ? AND date_sortie > ?)
                ) 
                AND refClasse = ?",
                [$datesortie_new, $dateentree_new, $refClasses]
            );

            return response()->json(['data' => $data]);
        } else {
            return response()->json(['error' => 'Invalid parameters'], 400);
        }
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
            // update 
            $data = thotel_chambre::where("id", $request->id)->update([
                'nom_chambre' =>  $request->nom_chambre,
                'numero_chambre' =>  $request->numero_chambre,
                'refClasse' =>  $request->refClasse,
                'author' =>  $request->author,
                'refUser'       =>  $request->refUser
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = thotel_chambre::create([
                'nom_chambre' =>  $request->nom_chambre,
                'numero_chambre' =>  $request->numero_chambre,
                'refClasse' =>  $request->refClasse,
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
        $data = DB::table("thotel_chambre")
        ->join('thotel_classe_chambre','thotel_classe_chambre.id','=','thotel_chambre.refClasse') 
        ->select("thotel_chambre.id", "thotel_chambre.nom_chambre","numero_chambre","refClasse", 
        "thotel_classe_chambre.designation as ClasseChambre","thotel_classe_chambre.prix_chambre",
        "thotel_classe_chambre.devise","thotel_classe_chambre.taux", 
        "thotel_chambre.created_at", "thotel_chambre.author","thotel_chambre.refUser")
        ->where('thotel_chambre.id', $id)
        ->get();
        return response()->json(['data' => $data]);
    }

    public function chambre_by_categorie($refClasse)
    {
        //
        $data = DB::table("thotel_chambre")
        ->join('thotel_classe_chambre','thotel_classe_chambre.id','=','thotel_chambre.refClasse') 
        ->select("thotel_chambre.id", "thotel_chambre.nom_chambre","numero_chambre","refClasse", 
        "thotel_classe_chambre.designation as ClasseChambre","thotel_classe_chambre.prix_chambre",
        "thotel_classe_chambre.devise","thotel_classe_chambre.taux", 
        "thotel_chambre.created_at", "thotel_chambre.author","thotel_chambre.refUser")
        ->where('thotel_chambre.refClasse', $refClasse)
        ->get();
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
        $data = thotel_chambre::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
