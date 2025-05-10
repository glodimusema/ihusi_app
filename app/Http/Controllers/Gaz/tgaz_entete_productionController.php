<?php

namespace App\Http\Controllers\Gaz;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gaz\tgaz_entete_production;
use App\Models\Gaz\tgaz_detail_production;
use App\Models\Facture;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tgaz_entete_productionController extends Controller
{
    use GlobalMethod, Slug;
    //vEnteteEntree
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

        $data = DB::table('tgaz_entete_production')
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_production.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_production.refService')
               
        ->select('tgaz_entete_production.id','tgaz_entete_production.code','refService','module_id',
        'dateProduction','libelle_production','tgaz_entete_production.montant',
        'tgaz_entete_production.author','tgaz_entete_production.refUser',
        'tgaz_entete_production.created_at'
        
        ,'nom_service', "tvente_module.nom_module")
        ->selectRaw('CONCAT("F",YEAR(dateProduction),"",MONTH(dateProduction),"00",tgaz_entete_production.id) as codeFacture');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('nom_service', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_entete_production.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tgaz_entete_production.created_at", "desc");
        return $this->apiData($data->paginate(10));
       
    }


    public function fetch_data_entete(Request $request,$refEntete)
    {
        $data = DB::table('tgaz_entete_production')
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_production.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_production.refService')
               
        ->select('tgaz_entete_production.id','tgaz_entete_production.code','refService','module_id',
        'dateProduction','libelle_production','tgaz_entete_production.montant',
        'tgaz_entete_production.author','tgaz_entete_production.refUser',
        'tgaz_entete_production.created_at'
        
        ,'nom_service', "tvente_module.nom_module")
        ->selectRaw('CONCAT("F",YEAR(dateProduction),"",MONTH(dateProduction),"00",tgaz_entete_production.id) as codeFacture')
        ->Where('tgaz_entete_production.refService',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('nom_service', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_entete_production.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tgaz_entete_production.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }     
    

    function fetch_single_data($id)
    {

        $data = DB::table('tgaz_entete_production')
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_production.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_production.refService')
               
        ->select('tgaz_entete_production.id','tgaz_entete_production.code','refService','module_id',
        'dateProduction','libelle_production','tgaz_entete_production.montant',
        'tgaz_entete_production.author','tgaz_entete_production.refUser',
        'tgaz_entete_production.created_at'
        
        ,'nom_service', "tvente_module.nom_module")
        ->selectRaw('CONCAT("F",YEAR(dateProduction),"",MONTH(dateProduction),"00",tgaz_entete_production.id) as codeFacture')
        ->where('tgaz_entete_production.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }


    function insert_data(Request $request)
    {
        //'id','code','module_id','refService','dateProduction',
        // //'libelle_production_production','montant','author','refUser'
        $module_id = 12;
        $code = $this->GetCodeData('tvente_param_systeme','module_id',$module_id);
        $data = tgaz_entete_production::create([
            'code'       =>  $code,
            'refService'       =>  $request->refService, 
            'module_id'       =>  $module_id,
            'dateProduction'    =>  $request->dateProduction,
            'libelle_production'    =>  $request->libelle_production,
            'montant'    =>  0,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {
        $data = tgaz_entete_production::where('id', $id)->update([            
            'code'       =>  $code,
            'refService'       =>  $request->refService, 
            'module_id'       =>  $module_id,
            'dateProduction'    =>  $request->dateProduction,
            'libelle_production'    =>  $request->libelle_production,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        
        $qte=0;               
        $pu=0;
        $montantreduction=0;
        $montanttva=0;
        $idStockService=0;
        $idDetail=0;
        $refEnteteProd=0;
        $refService = 0;

        $deleteds = DB::table('tgaz_detail_production')->Where('refEnteteProduction',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $idDetail = $deleted->id;
            $qte = $deleted->qteProduction;            
            $pu = $deleted->puProduction;
            $idStockService = $deleted->idStockService;
            $refEnteteProd = $deleted->refEnteteProduction;

            $data_entete=DB::table('tgaz_entete_production')     
            ->select('refService')
            ->where([['tgaz_entete_production.id','=', $refEnteteProd]])      
            ->first();
            if ($data_entete) 
            {
                $refService = $data_entete->refService;
            }

   
            $data2 = DB::update(
                'update tgaz_stock_service_lot set qte_lot = qte_lot + :qteProd where id = :id',
                ['qteProd' => $qte,'id' => $idStockService]
            ); 

            $nom_table = 'tgaz_detail_production';

            $data4 = DB::update(
                'delete from tgaz_mouvement_stock_service_lot where tgaz_mouvement_stock_service_lot.id_data = :id and nom_table=:nom_table',
                ['id' => $idDetail, 'nom_table' => $nom_table]
            );    
            

            $idProduit=0; 
            $qte_param = 0;
            $refLot = DB::table("tgaz_stock_service_lot")->Where('id',$idStockService)->pluck('refLot')->first();
            $deleted_prod = DB::table('tgaz_parametre_lot')->Where('refLot',$refLot)->get(); 
            foreach ($deleted_prod as $delete_data) {
                $idProduit = $delete_data->refProduit;
                $qte_param = $delete_data->qte_param;

                $qte_total = floatval($qte_param) * floatval($qte);

                $data_stock = DB::update(
                    'update tgaz_stock_service_lot set qte = qte + :qteVente where refProduit = :refProduit and refService = :refService',
                    ['qteVente' => $qte_total,'refProduit' => $idProduit,'refService' => $refService]
                );
        
                $nom_table = 'tgaz_detail_production';
        
                $data_mvt = DB::update(
                    'delete from tvente_mouvement_stock where tvente_mouvement_stock.id_data = :id and nom_table=:nom_table',
                    ['id' => $id, 'nom_table' => $nom_table]
                );

            
            }

            $data1 = tgaz_detail_production::where('id',$idDetail)->delete();

        }

        $data1 = tgaz_detail_production::where('refEnteteProduction',$id)->delete();
        $data = tgaz_entete_production::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
