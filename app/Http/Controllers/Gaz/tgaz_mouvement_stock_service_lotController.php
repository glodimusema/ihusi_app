<?php

namespace App\Http\Controllers\Gaz;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gaz\tgaz_mouvement_stock_service_lot;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tgaz_mouvement_stock_service_lotController extends Controller
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
        $data = DB::table('tgaz_mouvement_stock_service_lot')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_mouvement_stock_service_lot.idStockService')
        ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot') 

        ->select('tgaz_mouvement_stock_service_lot.id','idStockService',
        'dateMvt','type_mouvement','libelle_mouvement','nom_table','id_data','puMvt','qteMvt',
        'uniteMvt','cmupMvt','tgaz_mouvement_stock_service_lot.devise',
        'tgaz_mouvement_stock_service_lot.taux','tgaz_mouvement_stock_service_lot.author',
        'tgaz_mouvement_stock_service_lot.refUser','tgaz_mouvement_stock_service_lot.created_at',

        'tgaz_stock_service_lot.refService','tgaz_stock_service_lot.refLot',
        'tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot','tgaz_stock_service_lot.active',
        "tvente_services.nom_service","stock_alerte",'nom_lot','code_lot','unite_lot','stock_alerte')
       ->selectRaw('ROUND(((qteMvt*puMvt)),2) as PTMvt')
       ->selectRaw('ROUND(((qteMvt*puMvt)),2) as PTMvtTTC');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('nom_lot', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_mouvement_stock_service_lot.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tgaz_mouvement_stock_service_lot.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }

    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tgaz_mouvement_stock_service_lot')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_mouvement_stock_service_lot.idStockService')
        ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot') 

        ->select('tgaz_mouvement_stock_service_lot.id','idStockService',
        'dateMvt','type_mouvement','libelle_mouvement','nom_table','id_data','puMvt','qteMvt',
        'uniteMvt','cmupMvt','tgaz_mouvement_stock_service_lot.devise',
        'tgaz_mouvement_stock_service_lot.taux','tgaz_mouvement_stock_service_lot.author',
        'tgaz_mouvement_stock_service_lot.refUser','tgaz_mouvement_stock_service_lot.created_at',

        'tgaz_stock_service_lot.refService','tgaz_stock_service_lot.refLot',
        'tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot','tgaz_stock_service_lot.active',
        "tvente_services.nom_service","stock_alerte",'nom_lot','code_lot','unite_lot','stock_alerte')
       ->selectRaw('ROUND(((qteMvt*puMvt)),2) as PTMvt')
       ->selectRaw('ROUND(((qteMvt*puMvt)),2) as PTMvtTTC')
       ->Where('tgaz_mouvement_stock_service_lot.idStockService',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('nom_lot', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_mouvement_stock_service_lot.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tgaz_mouvement_stock_service_lot.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }  

    function fetch_single_data($id)
    {
        $data = DB::table('tgaz_mouvement_stock_service_lot')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_mouvement_stock_service_lot.idStockService')
        ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot') 

        ->select('tgaz_mouvement_stock_service_lot.id','idStockService',
        'dateMvt','type_mouvement','libelle_mouvement','nom_table','id_data','puMvt','qteMvt',
        'uniteMvt','cmupMvt','tgaz_mouvement_stock_service_lot.devise',
        'tgaz_mouvement_stock_service_lot.taux','tgaz_mouvement_stock_service_lot.author',
        'tgaz_mouvement_stock_service_lot.refUser','tgaz_mouvement_stock_service_lot.created_at',

        'tgaz_stock_service_lot.refService','tgaz_stock_service_lot.refLot',
        'tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot','tgaz_stock_service_lot.active',
        "tvente_services.nom_service","stock_alerte",'nom_lot','code_lot','unite_lot','stock_alerte')
       ->selectRaw('ROUND(((qteMvt*puMvt)),2) as PTMvt')
       ->selectRaw('ROUND(((qteMvt*puMvt)),2) as PTMvtTTC')
        ->where('tgaz_mouvement_stock_service_lot.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function insert_data(Request $request)
    {
        $active = "OUI";

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

        
        $devises='';
        $montants=0;
        $refProduit=0;
        $data99=DB::table('tgaz_stock_service_lot') 
        ->select('id','refService','refLot','pu_lot','qte_lot','cmup_lot',
        'devise','taux','active','refUser','author')
        ->where([
           ['tgaz_stock_service_lot.id','=', $request->idStockService]
        ])      
        ->get();
        foreach ($data99 as $row) 
        {
            $montants =  $row->cmup_lot;   
            $devises =  $row->devise;        
        }
       
       $montanttva=0;
       $pourtageTVA=0;
       $montantreduction = 0;

       $montanttva = (((floatval($request->qteMvt) * floatval($montants))*floatval($pourtageTVA))/100);
       
       $data = tgaz_mouvement_stock_service_lot::create([             
            'idStockService'    =>  $request->idStockService,             
            'dateMvt'    =>  $request->dateMvt,   
            'type_mouvement'    =>  $request->type_mouvement,
            'libelle_mouvement'    =>  $request->libelle_mouvement,
            'nom_table'    =>  $request->nom_table,
            'id_data'    =>  $request->id_data, 
            'puMvt'    =>  $request->puMvt,
            'qteMvt'    =>  $request->qteMvt,
            'uniteMvt'    =>  $request->uniteMvt,
            'cmupMvt'    =>  $montants, 
            'devise'    =>  $devises, 
            'taux'    =>  $taux,                  
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {

        $active = "OUI";

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

        
        $devises='';
        $montants=0;
        $refProduit=0;
        $data99=DB::table('tgaz_stock_service_lot') 
        ->select('id','refService','refLot','pu_lot','qte_lot','cmup_lot',
        'devise','taux','active','refUser','author')
        ->where([
           ['tgaz_stock_service_lot.id','=', $request->idStockService]
        ])      
        ->get();
        foreach ($data99 as $row) 
        {
            $montants =  $row->cmup_lot;   
            $devises =  $row->devise;        
        }
       
       $montanttva=0;
       $pourtageTVA=0;
       $montantreduction = 0;

       $montanttva = (((floatval($request->qteMvt) * floatval($montants))*floatval($pourtageTVA))/100);

        $data = tgaz_mouvement_stock_service_lot::where('id', $id)->update([
            'idStockService'    =>  $request->idStockService,             
            'dateMvt'    =>  $request->dateMvt,   
            'type_mouvement'    =>  $request->type_mouvement,
            'libelle_mouvement'    =>  $request->libelle_mouvement,
            'nom_table'    =>  $request->nom_table,
            'id_data'    =>  $request->id_data, 
            'puMvt'    =>  $request->puMvt,
            'qteMvt'    =>  $request->qteMvt,
            'uniteMvt'    =>  $request->uniteMvt,
            'cmupMvt'    =>  $montants, 
            'devise'    =>  $devises, 
            'taux'    =>  $taux,                  
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser,
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = tgaz_mouvement_stock_service_lot::where('id',$id)->delete();
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }






}
