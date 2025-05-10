<?php

namespace App\Http\Controllers\Gaz;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gaz\tgaz_entete_transfert;
use App\Models\Gaz\tgaz_detail_transfert;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tgaz_entete_transfertController extends Controller
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

    // 'id','refService','date_transfert','author','refUser'   tgaz_entete_transfert

    //'id','refService','module_id','date_transfert','author','refUser'


    public function all(Request $request)
    { 

        $data = DB::table('tgaz_entete_transfert')       
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_transfert.refService')
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_transfert.module_id')
        ->select('tgaz_entete_transfert.id','tgaz_entete_transfert.refService','date_transfert',
        'tgaz_entete_transfert.author','tgaz_entete_transfert.refUser','tgaz_entete_transfert.module_id',
        'tgaz_entete_transfert.created_at',"tvente_services.nom_service","nom_module");
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tvente_services.nom_service', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_entete_transfert.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tgaz_entete_transfert.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    {
        $data = DB::table('tgaz_entete_transfert')       
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_transfert.refService')
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_transfert.module_id')
        ->select('tgaz_entete_transfert.id','tgaz_entete_transfert.refService','date_transfert',
        'tgaz_entete_transfert.author','tgaz_entete_transfert.refUser','tgaz_entete_transfert.module_id',
        'tgaz_entete_transfert.created_at',"tvente_services.nom_service","nom_module")
        ->Where('refFournisseur',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('tvente_services.nom_service', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_entete_transfert.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tgaz_entete_transfert.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    


  

    function fetch_single_data($id)
    {
        $data = DB::table('tgaz_entete_transfert')       
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_transfert.refService')
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_transfert.module_id')
        ->select('tgaz_entete_transfert.id','tgaz_entete_transfert.refService','date_transfert',
        'tgaz_entete_transfert.author','tgaz_entete_transfert.refUser','tgaz_entete_transfert.module_id',
        'tgaz_entete_transfert.created_at',"tvente_services.nom_service","nom_module")
        ->where('tgaz_entete_transfert.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    // 'id','refService','date_transfert','author','refUser' 

    function insert_data(Request $request)
    {
        $id_module = 12;
        $code = $this->GetCodeData('tvente_param_systeme','module_id',$request->module_id);     
        $data = tgaz_entete_transfert::create([
            'refService'       =>  $request->refService,
            'module_id'       =>  $id_module,
            'date_transfert'       =>  $request->date_transfert,         
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {
        $data = tgaz_entete_transfert::where('id', $id)->update([
            'refService'       =>  $request->refService,
            'date_transfert'       =>  $request->date_transfert,         
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {

        $idDetail=0;

        $deleteds = DB::table('tgaz_detail_transfert')->Where('refEnteteTransfert',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $idDetail = $deleted->id;

            $qte=0;
            $id_flot=0;
            $id_service=0;
            $id_source;
            $status_source = '';
            $status_dest = '';

  
            $data_delete_detail = DB::table('tgaz_detail_transfert')
            ->join('tgaz_entete_transfert','tgaz_entete_transfert.id','=','tgaz_detail_transfert.refEnteteTransfert')
            ->join('tvente_services as servicesOrigine','servicesOrigine.id','=','tgaz_entete_transfert.refService')
            ->join('tvente_services as servicesDestination','servicesDestination.id','=','tgaz_detail_transfert.refDestination')
            ->select('tgaz_detail_transfert.id','refEnteteTransfert','refDestination','idStockService',
            'refLot','puTransfert','qteTransfert','uniteTransfert','tgaz_detail_transfert.author',
            'tgaz_detail_transfert.refUser','refService','date_transfert',
            'servicesOrigine.status as status_source',
            'servicesDestination.status as status_dest')
            ->selectRaw('(qteTransfert) as qteTotal')
            ->Where('tgaz_detail_transfert.id',$idDetail)->get(); 
            foreach ($data_delete_detail as $delete_det) {
                $qte = $delete_det->qteTotal;
                $id_flot = $delete_det->refLot;
                $id_service = $delete_det->refDestination;
                $id_source = $delete_det->refService;
                $status_source = $delete_det->status_source;
                $status_dest = $delete_det->status_dest;
            }
    
            $data2 = DB::update(
                'update tgaz_stock_service_lot set qte_lot = qte_lot - :qteStock where (refLot = :refLot) and (refService = :refService)',
                ['qteStock' => $qte,'refLot' => $id_flot,'refService' => $id_service]
            ); 
    
            $data3 = DB::update(
                'update tgaz_stock_service_lot set qte = qte + :qteStock where (refLot = :refLot) and (refService = :refService)',
                ['qteStock' => $qte,'refLot' => $id_flot,'refService' => $id_source]
            );
    
            
            $nom_table = 'tgaz_detail_transfert';
    
            $data4 = DB::update(
                'delete from tgaz_mouvement_stock_service_lot where tgaz_mouvement_stock_service_lot.id_data = :id and nom_table=:nom_table',
                ['id' => $idDetail, 'nom_table' => $nom_table]
            ); 
    
            $data1 = tgaz_detail_transfert::where('id',$idDetail)->delete();

        }

        $data33 = tgaz_detail_transfert::where('refEnteteTransfert',$id)->delete();
        $data = tgaz_entete_transfert::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
