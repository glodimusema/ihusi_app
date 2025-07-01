<?php

namespace App\Http\Controllers\Gaz;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gaz\tgaz_affectation_kit;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tgaz_affectation_kitController extends Controller
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

        $data = DB::table('tgaz_affectation_kit')
        ->join('tgaz_lot as kit','kit.id','=','tgaz_affectation_kit.id_kit_lot')
        ->join('tgaz_lot as gaz','gaz.id','=','tgaz_affectation_kit.id_gaz')
        ->select('tgaz_affectation_kit.id','id_kit_lot','id_gaz','qte_gaz',
        'tgaz_affectation_kit.author','tgaz_affectation_kit.refUser'

        ,'kit.nom_lot as nom_lot_kit','kit.code_lot as code_lot_kit',
        'kit.unite_lot as unite_lot_kit','kit.stock_alerte as stock_alerte_kit'
        
        ,'gaz.nom_lot as nom_lot_gaz','gaz.code_lot as code_lot_gaz',
        'gaz.unite_lot as unite_lot_gaz','gaz.stock_alerte as stock_alerte_gaz');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('gaz.nom_lot', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_affectation_kit.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tgaz_affectation_kit.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 
        $data = DB::table('tgaz_affectation_kit')
        ->join('tgaz_lot as kit','kit.id','=','tgaz_affectation_kit.id_kit_lot')
        ->join('tgaz_lot as gaz','gaz.id','=','tgaz_affectation_kit.id_gaz')
        ->select('tgaz_affectation_kit.id','id_kit_lot','id_gaz','qte_gaz',
        'tgaz_affectation_kit.author','tgaz_affectation_kit.refUser'

        ,'kit.nom_lot as nom_lot_kit','kit.code_lot as code_lot_kit',
        'kit.unite_lot as unite_lot_kit','kit.stock_alerte as stock_alerte_kit'
        
        ,'gaz.nom_lot as nom_lot_gaz','gaz.code_lot as code_lot_gaz',
        'gaz.unite_lot as unite_lot_gaz','gaz.stock_alerte as stock_alerte_gaz')
        ->Where('tgaz_affectation_kit.id_kit_lot',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('gaz.nom_lot', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_affectation_kit.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tgaz_affectation_kit.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    

     

    function fetch_single_data($id)
    {
        $data = DB::table('tgaz_affectation_kit')
        ->join('tgaz_lot as kit','kit.id','=','tgaz_affectation_kit.id_kit_lot')
        ->join('tgaz_lot as gaz','gaz.id','=','tgaz_affectation_kit.id_gaz')
        ->select('tgaz_affectation_kit.id','id_kit_lot','id_gaz','qte_gaz',
        'tgaz_affectation_kit.author','tgaz_affectation_kit.refUser'

        ,'kit.nom_lot as nom_lot_kit','kit.code_lot as code_lot_kit',
        'kit.unite_lot as unite_lot_kit','kit.stock_alerte as stock_alerte_kit'
        
        ,'gaz.nom_lot as nom_lot_gaz','gaz.code_lot as code_lot_gaz',
        'gaz.unite_lot as unite_lot_gaz','gaz.stock_alerte as stock_alerte_gaz')
        ->where('tgaz_affectation_kit.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }


    function fetch_affectation_kit($refLot)
    {

        $data = DB::table('tgaz_affectation_kit')
        ->join('tgaz_lot as kit','kit.id','=','tgaz_affectation_kit.id_kit_lot')
        ->join('tgaz_lot as gaz','gaz.id','=','tgaz_affectation_kit.id_gaz')
        ->select('tgaz_affectation_kit.id','id_kit_lot','id_gaz','qte_gaz',
        'tgaz_affectation_kit.author','tgaz_affectation_kit.refUser'

        ,'kit.nom_lot as nom_lot_kit','kit.code_lot as code_lot_kit',
        'kit.unite_lot as unite_lot_kit','kit.stock_alerte as stock_alerte_kit'
        
        ,'gaz.nom_lot as nom_lot_gaz','gaz.code_lot as code_lot_gaz',
        'gaz.unite_lot as unite_lot_gaz','gaz.stock_alerte as stock_alerte_gaz')                     
        ->Where('tgaz_affectation_kit.id_kit_lot',$refLot)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }

    function fetch_affectation_kit_gaz_stock_service($idStockService)
    { 
        $id_lot = 0;
        $id_service = 0;
        $stockservice = DB::table('tgaz_stock_service_lot')       
        ->select('id','refService','refLot','pu_lot','qte_lot','cmup_lot',
        'devise','taux','active','refUser','author')
        ->where([
           ['tgaz_stock_service_lot.id','=',  $idStockService]
        ])
        ->first();
        if ($stockservice) {
            $id_lot = $stockservice->refLot;
            $id_service = $stockservice->refService;
        }

        $id_gaz = 0;
        $id_stock_serv_gaz = 0;
        $affect_kit = DB::table('tgaz_affectation_kit')       
        ->select('id','id_kit_lot','id_gaz','qte_gaz','author','refUser')
        ->where([
           ['tgaz_affectation_kit.id_kit_lot','=',  $id_lot]
        ])
        ->first();
        if ($affect_kit) {
            $id_gaz = $affect_kit->id_gaz;
        }


        $data_gaz_st = DB::table('tgaz_stock_service_lot')       
        ->select('id','refService','refLot','pu_lot','qte_lot','cmup_lot',
        'devise','taux','active','refUser','author')
        ->where([
           ['tgaz_stock_service_lot.refService','=',  $id_service],
           ['tgaz_stock_service_lot.refLot','=',  $id_gaz]
        ])
        ->first();
        if ($data_gaz_st) {
            $id_stock_serv_gaz = $data_gaz_st->id;
        }

        $data = DB::table('tgaz_parametre_lot')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_parametre_lot.refLot')
        ->join('tvente_produit','tvente_produit.id','=','tgaz_parametre_lot.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')  
        ->select('tgaz_parametre_lot.id','refProduit','refLot','pu_param','qte_param','autre_detail',
        'tgaz_parametre_lot.author','tgaz_parametre_lot.refUser','nom_lot','code_lot','unite_lot'
        ,"tvente_produit.designation as designation",'refCategorie','pu','qte',
        'cmup','devise','taux','Oldcode','Newcode','tvaapplique','estvendable','uniteBase',
        "tvente_categorie_produit.designation as Categorie",DB::raw($id_stock_serv_gaz . ' as id_gaz'))                     
        ->Where('refLot',$id_gaz)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }


    function insert_data(Request $request)
    {       
        $data = tgaz_affectation_kit::create([
            'id_kit_lot'       =>  $request->id_kit_lot,
            'id_gaz'    =>  $request->id_gaz,
            'qte_gaz'    =>  $request->qte_gaz,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {
        $data = tgaz_affectation_kit::where('id', $id)->update([
           'id_kit_lot'       =>  $request->id_kit_lot,
            'id_gaz'    =>  $request->id_gaz,
            'qte_gaz'    =>  $request->qte_gaz,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = tgaz_affectation_kit::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
