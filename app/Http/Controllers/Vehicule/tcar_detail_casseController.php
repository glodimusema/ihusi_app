<?php

namespace App\Http\Controllers\Vehicule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vehicule\tcar_detail_casse;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tcar_detail_casseController extends Controller
{
    use GlobalMethod, Slug;

    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    public function all(Request $request)
    { 
        //'id','refEnteteMvt','refProduit','puCasse','qteCasse','devise','taux','author'

        $data = DB::table('tcar_detail_casse')
        ->join('tcar_produit','tcar_produit.id','=','tcar_detail_casse.refProduit')
        ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_detail_casse.refEnteteMvt')
        ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
        ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
        ->select('tcar_entete_mouvement.id','refVehicule','refProvenance','dateMvt','numBS',
        'numCD','numSR','nom_vehicule','marque','couleur','numPlaque','nom_producteur',
        'adresse_prod','contact_prod','mail_prod','autres_details',
        'Chauffeur','tcar_entete_mouvement.author','tcar_entete_mouvement.created_at',
        'refEnteteMvt','refProduit','puCasse','qteCasse','tcar_detail_casse.devise','tcar_detail_casse.taux',
        "tcar_produit.designation as designation",'pu','tcar_detail_casse.devise','tcar_detail_casse.taux','unite')
        ->selectRaw('CONCAT("F",YEAR(dateMvt),"",MONTH(dateMvt),"00",tcar_entete_mouvement.id) as codeFacture')
        ->selectRaw('(qteCasse*puCasse) as PTCasse');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tcar_produit.designation', 'like', '%'.$query.'%')          
            ->orderBy("tcar_detail_casse.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tcar_detail_casse.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    {
        $data = DB::table('tcar_detail_casse')
        ->join('tcar_produit','tcar_produit.id','=','tcar_detail_casse.refProduit')
        ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_detail_casse.refEnteteMvt')
        ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
        ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
        ->select('tcar_entete_mouvement.id','refVehicule','refProvenance','dateMvt','numBS',
        'numCD','numSR','nom_vehicule','marque','couleur','numPlaque','nom_producteur',
        'adresse_prod','contact_prod','mail_prod','autres_details',
        'Chauffeur','tcar_entete_mouvement.author','tcar_entete_mouvement.created_at',
        'refEnteteMvt','refProduit','puCasse','qteCasse','tcar_detail_casse.devise','tcar_detail_casse.taux',
        "tcar_produit.designation as designation",'pu','tcar_detail_casse.devise','tcar_detail_casse.taux','unite')
        ->selectRaw('CONCAT("F",YEAR(dateMvt),"",MONTH(dateMvt),"00",tcar_entete_mouvement.id) as codeFacture')
        ->selectRaw('(qteCasse*puCasse) as PTCasse')
        ->Where('refEnteteMvt',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('tcar_produit.designation', 'like', '%'.$query.'%')          
            ->orderBy("tcar_detail_casse.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tcar_detail_casse.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }   


    function fetch_single_data($id)
    {

        $data = DB::table('tcar_detail_casse')
        ->join('tcar_produit','tcar_produit.id','=','tcar_detail_casse.refProduit')
        ->join('tcar_entete_mouvement','tcar_entete_mouvement.id','=','tcar_detail_casse.refEnteteMvt')
        ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
        ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
        ->select('tcar_entete_mouvement.id','refVehicule','refProvenance','dateMvt','numBS',
        'numCD','numSR','nom_vehicule','marque','couleur','numPlaque','nom_producteur',
        'adresse_prod','contact_prod','mail_prod','autres_details',
        'Chauffeur','tcar_entete_mouvement.author','tcar_entete_mouvement.created_at',
        'refEnteteMvt','refProduit','puCasse','qteCasse','tcar_detail_casse.devise','tcar_detail_casse.taux',
        "tcar_produit.designation as designation",'pu','tcar_detail_casse.devise','tcar_detail_casse.taux','unite')
        ->selectRaw('CONCAT("F",YEAR(dateMvt),"",MONTH(dateMvt),"00",tcar_entete_mouvement.id) as codeFacture')
        ->selectRaw('(qteCasse*puCasse) as PTCasse')
        ->where('tcar_detail_casse.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

 
    function insert_data(Request $request)
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
            $montants = ($request->puCasse)*$taux;
            $devises='FC';
        }
        else
        {
            $montants = $request->puCasse;
            $devises = $request->devise;
        }
        $data = tcar_detail_casse::create([
            'refEnteteMvt'       =>  $request->refEnteteMvt,
            'refProduit'    =>  $request->refProduit,
            'puCasse'    =>  $montants,
            'qteCasse'    =>  $request->qteCasse,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
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
            $montants = ($request->puCasse)*$taux;
            $devises='FC';
        }
        else
        {
            $montants = $request->puCasse;
            $devises = $request->devise;
        }
        $data = tcar_detail_casse::create([
            'refEnteteMvt'       =>  $request->refEnteteMvt,
            'refProduit'    =>  $request->refProduit,
            'puCasse'    =>  $montants,
            'qteCasse'    =>  $request->qteCasse,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = tcar_detail_casse::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
