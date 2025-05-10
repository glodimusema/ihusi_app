<?php

namespace App\Http\Controllers\Gaz;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gaz\tgaz_parametre_lot;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tgaz_parametre_lotController extends Controller
{

    use GlobalMethod, Slug;

// 'id','refProduit','refLot','pu_param','qte_param','autre_detail','author','refUser'
// tgaz_parametre_lot
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

        $data = DB::table('tgaz_parametre_lot')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_parametre_lot.refLot')
        ->join('tvente_produit','tvente_produit.id','=','tgaz_parametre_lot.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')  
        ->select('tgaz_parametre_lot.id','refProduit','refLot','pu_param','qte_param','autre_detail',
        'tgaz_parametre_lot.author','tgaz_parametre_lot.refUser','nom_lot','code_lot','unite_lot'
        ,"tvente_produit.designation as designation",'refCategorie','uniteBase','pu','qte',
        'cmup','devise','taux','Oldcode','Newcode','tvaapplique','estvendable',
        "tvente_categorie_produit.designation as Categorie");
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('nom_lot', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_parametre_lot.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tgaz_parametre_lot.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 
        $data = DB::table('tgaz_parametre_lot')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_parametre_lot.refLot')
        ->join('tvente_produit','tvente_produit.id','=','tgaz_parametre_lot.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')  
        ->select('tgaz_parametre_lot.id','refProduit','refLot','pu_param','qte_param','autre_detail',
        'tgaz_parametre_lot.author','tgaz_parametre_lot.refUser','nom_lot','code_lot','unite_lot'
        ,"tvente_produit.designation as designation",'refCategorie','uniteBase','pu','qte',
        'cmup','devise','taux','Oldcode','Newcode','tvaapplique','estvendable',
        "tvente_categorie_produit.designation as Categorie")
        ->Where('tgaz_parametre_lot.refLot',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('nom_lot', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_parametre_lot.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tgaz_parametre_lot.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    

     

    function fetch_single_data($id)
    {
        $data = DB::table('tgaz_parametre_lot')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_parametre_lot.refLot')
        ->join('tvente_produit','tvente_produit.id','=','tgaz_parametre_lot.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')  
        ->select('tgaz_parametre_lot.id','refProduit','refLot','pu_param','qte_param','autre_detail',
        'tgaz_parametre_lot.author','tgaz_parametre_lot.refUser','nom_lot','code_lot','unite_lot'
        ,"tvente_produit.designation as designation",'refCategorie','uniteBase','pu','qte',
        'cmup','devise','taux','Oldcode','Newcode','tvaapplique','estvendable',
        "tvente_categorie_produit.designation as Categorie")
        ->where('tgaz_parametre_lot.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }


    function fetch_parametre_lot($refLot)
    {

        $data = DB::table('tgaz_parametre_lot')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_parametre_lot.refLot')
        ->join('tvente_produit','tvente_produit.id','=','tgaz_parametre_lot.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')  
        ->select('tgaz_parametre_lot.id','refProduit','refLot','pu_param','qte_param','autre_detail',
        'tgaz_parametre_lot.author','tgaz_parametre_lot.refUser','nom_lot','code_lot','unite_lot'
        ,"tvente_produit.designation as designation",'refCategorie','uniteBase','pu','qte',
        'cmup','devise','taux','Oldcode','Newcode','tvaapplique','estvendable',
        "tvente_categorie_produit.designation as Categorie")                     
        ->Where('refLot',$refLot)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }


    function fetch_parametre_lot_stock_service($idStockService)
    { 

        $id_flot = 0;
        $stockservice = DB::table('tgaz_stock_service_lot')       
        ->select('id','refService','refLot','pu_lot','qte_lot','cmup_lot',
        'devise','taux','active','refUser','author')
        ->where([
           ['tgaz_stock_service_lot.id','=',  $idStockService]
        ])
        ->first();
        if ($stockservice) {
            $id_flot = $stockservice->refLot;
        }

        $data = DB::table('tgaz_parametre_lot')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_parametre_lot.refLot')
        ->join('tvente_produit','tvente_produit.id','=','tgaz_parametre_lot.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')  
        ->select('tgaz_parametre_lot.id','refProduit','refLot','pu_param','qte_param','autre_detail',
        'tgaz_parametre_lot.author','tgaz_parametre_lot.refUser','nom_lot','code_lot','unite_lot'
        ,"tvente_produit.designation as designation",'refCategorie','pu','qte',
        'cmup','devise','taux','Oldcode','Newcode','tvaapplique','estvendable','uniteBase',
        "tvente_categorie_produit.designation as Categorie")                     
        ->Where('refLot',$id_flot)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }


   //'id','refProduit','refLot','pu_param','qte_param','autre_detail','author','refUser'
    function insert_data(Request $request)
    {       
        $data = tgaz_parametre_lot::create([
            'refProduit'       =>  $request->refProduit,
            'refLot'    =>  $request->refLot,
            'pu_param'    =>  $request->pu_param,
            'qte_param'    =>  $request->qte_param,
            'autre_detail'    =>  $request->autre_detail,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {
        $data = tgaz_parametre_lot::where('id', $id)->update([
            'refProduit'       =>  $request->refProduit,
            'refLot'    =>  $request->refLot,
            'pu_param'    =>  $request->pu_param,
            'qte_param'    =>  $request->qte_param,
            'autre_detail'    =>  $request->autre_detail,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = tgaz_parametre_lot::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
