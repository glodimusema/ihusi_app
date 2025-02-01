<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_entete_transfert;
use App\Models\Ventes\tvente_detail_transfert;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tvente_entete_transfertController extends Controller
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

    // 'id','refService','date_transfert','author','refUser'   tvente_entete_transfert

    public function all(Request $request)
    { 

        $data = DB::table('tvente_entete_transfert')       
        ->join('tvente_services','tvente_services.id','=','tvente_entete_transfert.refService')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_transfert.module_id')
        ->select('tvente_entete_transfert.id','tvente_entete_transfert.refService','date_transfert',
        'tvente_entete_transfert.author','tvente_entete_transfert.refUser','tvente_entete_transfert.module_id',
        'tvente_entete_transfert.created_at',"tvente_services.nom_service","nom_module");
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tvente_services.nom_service', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_transfert.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_entete_transfert.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    {
        $data = DB::table('tvente_entete_transfert')       
        ->join('tvente_services','tvente_services.id','=','tvente_entete_transfert.refService')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_transfert.module_id')
        ->select('tvente_entete_transfert.id','tvente_entete_transfert.refService','date_transfert',
        'tvente_entete_transfert.author','tvente_entete_transfert.refUser','tvente_entete_transfert.module_id',
        'tvente_entete_transfert.created_at',"tvente_services.nom_service","nom_module")
        ->Where('refFournisseur',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('tvente_services.nom_service', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_transfert.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_entete_transfert.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    


  

    function fetch_single_data($id)
    {
        $data = DB::table('tvente_entete_transfert')       
        ->join('tvente_services','tvente_services.id','=','tvente_entete_transfert.refService')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_transfert.module_id')
        ->select('tvente_entete_transfert.id','tvente_entete_transfert.refService','date_transfert',
        'tvente_entete_transfert.author','tvente_entete_transfert.refUser','tvente_entete_transfert.module_id',
        'tvente_entete_transfert.created_at',"tvente_services.nom_service","nom_module")
        ->where('tvente_entete_transfert.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    // 'id','refService','date_transfert','author','refUser' 

    function insert_data(Request $request)
    {
        $id_module = 3;
        $code = $this->GetCodeData('tvente_param_systeme','module_id',$request->module_id);     
        $data = tvente_entete_transfert::create([
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
        $data = tvente_entete_transfert::where('id', $id)->update([
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

        $deleteds = DB::table('tvente_detail_transfert')->Where('refEnteteTransfert',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $idDetail = $deleted->id;

            $qte=0;
            $id_produit=0;
            $id_service=0;
            $id_source;
            $status_source = '';
            $status_dest = '';
            $puBase =0;
    
            $data_delete_detail = DB::table('tvente_detail_transfert')
            ->join('tvente_entete_transfert','tvente_entete_transfert.id','=','tvente_detail_transfert.refEnteteTransfert')
            ->join('tvente_services as servicesOrigine','servicesOrigine.id','=','tvente_entete_transfert.refService')
            ->join('tvente_services as servicesDestination','servicesDestination.id','=','tvente_detail_transfert.refDestination')
            ->select('tvente_detail_transfert.id','refEnteteTransfert','refProduit','refDestination',
            'puTransfert','qteTransfert','uniteTransfert','puBase','qteBase','uniteBase','tvente_detail_transfert.author',
            'tvente_detail_transfert.refUser','refService','date_transfert',
            'servicesOrigine.status as status_source',
            'servicesDestination.status as status_dest')
            ->selectRaw('(qteBase * qteTransfert) as qteTotal')
            ->Where('tvente_detail_transfert.id',$idDetail)->get(); 
            foreach ($data_delete_detail as $delete_det) {
                $qte = $delete_det->qteTotal;
                $id_produit = $delete_det->refProduit;
                $id_service = $delete_det->refDestination;
                $id_source = $delete_det->refService;
                $status_source = $delete_det->status_source;
                $status_dest = $delete_det->status_dest;
                $puBase = $delete_det->puBase;
            }
    
            $data2 = DB::update(
                'update tvente_stock_service set qte = qte - :qteVente where (refProduit = :refProduit) and (refService = :refService)',
                ['qteVente' => $qte,'refProduit' => $id_produit,'refService' => $id_service]
            );
    
            $data3 = DB::update(
                'update tvente_stock_service set qte = qte + :qteVente where (refProduit = :refProduit) and (refService = :refService)',
                ['qteVente' => $qte,'refProduit' => $id_produit,'refService' => $id_source]
            );
    
            
            $nom_table = 'tvente_detail_transfert';
    
            $data4 = DB::update(
                'delete from tvente_mouvement_stock where tvente_mouvement_stock.id_data = :id and nom_table=:nom_table',
                ['id' => $idDetail, 'nom_table' => $nom_table]
            ); 
    
            $data1 = tvente_detail_transfert::where('id',$idDetail)->delete();

        }

        $data33 = tvente_detail_transfert::where('refEnteteTransfert',$id)->delete();
        $data = tvente_entete_transfert::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
