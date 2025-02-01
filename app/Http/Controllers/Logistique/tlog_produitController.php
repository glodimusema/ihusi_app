<?php

namespace App\Http\Controllers\Logistique;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Logistique\{tlog_produit};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;


class tlog_produitController extends Controller
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

        $data = DB::table('tlog_produit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
        ->join('tlog_emplacements','tlog_emplacements.id','=','tlog_produit.refEmplacement')        
        ->select("tlog_produit.id","tlog_produit.designation as designation","refCategorie","refEmplacement",
        "pu","unite","devise","qte","tvente_categorie_produit.designation as Categorie","nom_emplacement");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tlog_produit.designation', 'like', '%'.$query.'%')
            ->orderBy("tlog_produit.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tlog_produit_2()
    {
         $data = DB::table('tlog_produit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
         ->join('tlog_emplacements','tlog_emplacements.id','=','tlog_produit.refEmplacement')        
         ->select("tlog_produit.id","tlog_produit.designation as designation","refCategorie","refEmplacement",
         "pu","unite","devise","qte","tvente_categorie_produit.designation as Categorie","nom_emplacement")
        ->get();
        
        return response()->json(['data' => $data]);

    }

    function fetch_list_produit_depo($refEmplacement)
    {
        $data = DB::table('tlog_produit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
        ->join('tlog_emplacements','tlog_emplacements.id','=','tlog_produit.refEmplacement')        
        ->select("tlog_produit.id","tlog_produit.designation as designation","refCategorie","refEmplacement",
        "pu","unite","devise","qte","tvente_categorie_produit.designation as Categorie","nom_emplacement")
        ->Where('refEmplacement',$refEmplacement) 
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
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
            $montants = ($request->pu)/$taux;
            $devises='USD';
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
            $data = tlog_produit::where("id", $request->id)->update([
                'designation'       =>  $request->designation,
                'pu'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'unite'    =>  $request->unite,
                'refCategorie'    =>  $request->refCategorie,
                'refEmplacement'    =>  $request->refEmplacement,
                'author'    =>  $request->author
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tlog_produit::create([
                'designation'       =>  $request->designation,
                'pu'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'unite'    =>  $request->unite,
                'refCategorie'    =>  $request->refCategorie,
                'refEmplacement'    =>  $request->refEmplacement,
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
        $data = tlog_produit::where('id', $id)->get();
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
        $data = tlog_produit::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
