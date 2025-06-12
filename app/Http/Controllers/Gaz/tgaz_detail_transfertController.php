<?php

namespace App\Http\Controllers\Gaz;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gaz\tgaz_detail_transfert;
use App\Models\Gaz\tgaz_entete_transfert;
use App\Models\Gaz\tgaz_mouvement_stock_service_lot;

use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tgaz_detail_transfertController extends Controller
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

        $data = DB::table('tgaz_detail_transfert')  
        ->join('tgaz_entete_transfert','tgaz_entete_transfert.id','=','tgaz_detail_transfert.refEnteteTransfert')     
        ->join('tvente_services as servicesOrigine','servicesOrigine.id','=','tgaz_entete_transfert.refService')
        ->join('tvente_services as servicesDestination','servicesDestination.id','=','tgaz_detail_transfert.refDestination')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_detail_transfert.refLot')
        
        ->select('tgaz_detail_transfert.id','refEnteteTransfert','refDestination','idStockService',
        'refLot','puTransfert','qteTransfert','uniteTransfert','tgaz_detail_transfert.author',
        'tgaz_detail_transfert.refUser','tgaz_detail_transfert.created_at','refService',
        'date_transfert',"servicesOrigine.nom_service as ServiceOrigine",
        "servicesDestination.nom_service as ServiceDestination"

        ,'nom_lot','code_lot','unite_lot','stock_alerte')
        ->selectRaw('(qteTransfert*puTransfert) as PTTransfert');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tgaz_lot.nom_lot', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_detail_transfert.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tgaz_detail_transfert.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }

    public function fetch_data_entete(Request $request,$refEntete)
    {
        $data = DB::table('tgaz_detail_transfert')  
        ->join('tgaz_entete_transfert','tgaz_entete_transfert.id','=','tgaz_detail_transfert.refEnteteTransfert')     
        ->join('tvente_services as servicesOrigine','servicesOrigine.id','=','tgaz_entete_transfert.refService')
        ->join('tvente_services as servicesDestination','servicesDestination.id','=','tgaz_detail_transfert.refDestination')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_detail_transfert.refLot')
        
        ->select('tgaz_detail_transfert.id','refEnteteTransfert','refDestination','idStockService',
        'refLot','puTransfert','qteTransfert','uniteTransfert','tgaz_detail_transfert.author',
        'tgaz_detail_transfert.refUser','tgaz_detail_transfert.created_at','refService',
        'date_transfert',"servicesOrigine.nom_service as ServiceOrigine",
        "servicesDestination.nom_service as ServiceDestination"

        ,'nom_lot','code_lot','unite_lot','stock_alerte')
        ->selectRaw('(qteTransfert*puTransfert) as PTTransfert')
        ->Where('refEnteteTransfert',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('tgaz_lot.nom_lot', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_detail_transfert.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tgaz_detail_transfert.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    

    function fetch_single_data($id)
    {
        $data = DB::table('tgaz_detail_transfert')  
        ->join('tgaz_entete_transfert','tgaz_entete_transfert.id','=','tgaz_detail_transfert.refEnteteTransfert')     
        ->join('tvente_services as servicesOrigine','servicesOrigine.id','=','tgaz_entete_transfert.refService')
        ->join('tvente_services as servicesDestination','servicesDestination.id','=','tgaz_detail_transfert.refDestination')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_detail_transfert.refLot')
        
        ->select('tgaz_detail_transfert.id','refEnteteTransfert','refDestination','idStockService',
        'refLot','puTransfert','qteTransfert','uniteTransfert','tgaz_detail_transfert.author',
        'tgaz_detail_transfert.refUser','tgaz_detail_transfert.created_at','refService',
        'date_transfert',"servicesOrigine.nom_service as ServiceOrigine",
        "servicesDestination.nom_service as ServiceDestination"

        ,'nom_lot','code_lot','unite_lot','stock_alerte')
        ->selectRaw('(qteTransfert*puTransfert) as PTTransfert')
        ->where('tgaz_detail_transfert.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function insert_data(Request $request)
    {    

        $id_service = $request->refDestination;
        $id_lot = 0;


        $temp_idservice = 0;
        $temp_idflot = 0;
        $temp_id=0;
        $idStockService=0;

        $stockservice = DB::table('tgaz_stock_service_lot')       
        ->select('id','refService','refLot','pu_lot','qte_lot','cmup_lot',
        'devise','taux','active','refUser','author')
        ->where([
           ['tgaz_stock_service_lot.id','=',  $request->idStockService]
        ])
        ->get();
        foreach ($stockservice as $list) {
            $id_lot = $list->refLot;
        }

        $cmupVente=0;
        $cmupTemp=0;
        $SI=0;
        $puTransfert=0;
        $qteTransfert=0;
        $uniteTransfert='';

        $stockservicedest = DB::table('tgaz_stock_service_lot')       
        ->select('id','refService','refLot','pu_lot','qte_lot','cmup_lot',
        'devise','taux','active','refUser','author')
        ->where([
           ['tgaz_stock_service_lot.refService','=',  $id_service],
           ['tgaz_stock_service_lot.refLot','=',  $id_lot]
       ])
        ->first();
        if ($stockservicedest) {
            $temp_idservice = $stockservicedest->refService;
            $temp_idflot = $stockservicedest->refLot;
            $temp_id = $stockservicedest->id;

            $cmupVente = $stockservicedest->cmup_lot;
            $cmupTemp = $stockservicedest->cmup_lot;
            $SI = $stockservicedest->qte_lot;

            $puTransfert=$stockservicedest->cmup_lot;
            $qteTransfert=$stockservicedest->qte_lot;            
        }


        $products = DB::table("tgaz_lot")
        ->select("tgaz_lot.id",'nom_lot','code_lot','unite_lot','stock_alerte',
        'author','refUser',"tgaz_lot.created_at")
        ->where([
           ['tgaz_lot.id','=',  $id_lot]
        ])
        ->first();
        if ($products) {
            $uniteTransfert = $products->unite_lot;            
        }



       $taux=0;
       $data5 =  DB::table("tvente_taux")
       ->select("tvente_taux.id", "tvente_taux.taux", 
       "tvente_taux.created_at", "tvente_taux.author")
       ->first();
       if ($data5) 
       {                                
          $taux=$data5->taux;                           
       }

       $devise=0;
       $data55 =  DB::table("tvente_devise")
       ->select("tvente_devise.id", "tvente_devise.designation","tvente_devise.created_at")
       ->where([
           ['tvente_devise.active','=', 'OUI']
       ])
        ->first();
        if ($data55) 
        {                                
           $devise=$data55->designation;                           
        }

       $qteEntree = floatval($request->qteTransfert);

       $refServiceSource = $request->refService;  

       if(($id_service == $temp_idservice) && ($id_lot == $temp_idflot))
       {
            $data23 = DB::update(
            'update tgaz_stock_service_lot set qte_lot = qte_lot + :qteTransfert where (refLot = :refLot) and (refService = :refService)',
            ['qteTransfert' => $qteEntree,'refLot' => $id_lot,'refService' => $id_service]
            );

            $data22 = DB::update(
               'update tgaz_stock_service_lot set qte_lot = qte_lot - :qteTransfert where (tgaz_stock_service_lot.id = :id)',
               ['qteTransfert' => $qteEntree,'id' => $request->idStockService]
           );
       }
       else
       {
           $data22 = DB::update(
               'insert into tgaz_stock_service_lot (refService,refLot,pu_lot,qte_lot,cmup_lot,devise,
               taux,active,refUser,author) 
               values (:refService,:refLot,:pu_lot,:qte_lot,:cmup_lot,:devise,:taux,:active,:refUser,:author)',
               ['refService' => $id_service,'refLot' => $id_lot,'pu_lot' => $cmupTemp,'qte_lot' => $qteEntree,
               'cmup_lot' => $cmupTemp,'devise' => $devise,'taux' => $taux,'active' => $active,
               'refUser' => $request->refUser,'author' => $request->author]
           );

           $data22 = DB::update(
            'update tgaz_stock_service_lot set qte = qte - :qteTransfert where (tgaz_stock_service_lot.id = :id)',
            ['qteTransfert' => $qteEntree,'id' => $request->idStockService]
            );
       }        


        $data = tgaz_detail_transfert::create([
            'refEnteteTransfert'       => $request->refEnteteTransfert,
            'refLot'       =>  $id_lot,  
            'refDestination'       =>  $request->refDestination,  
            'idStockService'       =>  $temp_id,         
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser,

            'puTransfert'       =>  $puTransfert, 
            'qteTransfert'       =>  $request->qteTransfert, 
            'uniteTransfert'       =>  $uniteTransfert
        ]);

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {
        $data = tgaz_detail_transfert::where('id', $id)->update([
            'refEnteteTransfert'       =>  $request->refEnteteTransfert,
            'refLot'       =>  $request->refLot,  
            'refDestination'       =>  $request->refDestination, 
            'puTransfert'       =>  $request->puTransfert, 
            'qteTransfert'       =>  $request->qteTransfert, 
            'uniteTransfert'       =>  $request->uniteTransfert, 
            'puBase'       =>  $request->puBase, 
            'qteBase'       =>  $request->qteBase, 
            'uniteBase'       =>  $request->uniteBase,        
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {

        $qte=0;
        $id_lot=0;
        $id_service=0;
        $id_source;
        $status_source = '';
        $status_dest = '';
        $puBase =0;

        $deleteds = DB::table('tgaz_detail_transfert')
        ->join('tgaz_entete_transfert','tgaz_entete_transfert.id','=','tgaz_detail_transfert.refEnteteTransfert')
        ->join('tvente_services as servicesOrigine','servicesOrigine.id','=','tgaz_entete_transfert.refService')
        ->join('tvente_services as servicesDestination','servicesDestination.id','=','tgaz_detail_transfert.refDestination')
        ->select('tgaz_detail_transfert.id','refEnteteTransfert','refLot','refDestination',
        'puTransfert','qteTransfert','uniteTransfert','tgaz_detail_transfert.author',
        'tgaz_detail_transfert.refUser','refService','date_transfert',
        'servicesOrigine.status as status_source',
        'servicesDestination.status as status_dest')
        ->selectRaw('(qteTransfert) as qteTotal')
        ->Where('tgaz_detail_transfert.id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $qte = $deleted->qteTotal;
            $id_lot = $deleted->refLot;
            $id_service = $deleted->refDestination;
            $id_source = $deleted->refService;
            $status_source = $deleted->status_source;
            $status_dest = $deleted->status_dest;
            $puBase = $deleted->puBase;
        }

        $stockservicedest=0;
        $listeStockDest = DB::table('tgaz_stock_service_lot')       
        ->select('id','refService','refLot','pu_lot','qte_lot','cmup_lot',
        'devise','taux','active','refUser','author')
        ->where([
           ['tgaz_stock_service_lot.refService','=',  $id_service],
           ['tgaz_stock_service_lot.refLot','=',  $id_lot]
       ])
        ->get();
        foreach ($listeStockDest as $list) {
            $stockservicedest = $list->id;
        }

        $stockservicesource=0;
        $listeStockSource = DB::table('tgaz_stock_service_lot')       
        ->select('id','refService','refLot','pu_lot','qte_lot','cmup_lot',
        'devise','taux','active','refUser','author')
        ->where([
           ['tgaz_stock_service_lot.refService','=',  $id_service],
           ['tgaz_stock_service_lot.refLot','=',  $id_lot]
       ])
        ->get();
        foreach ($listeStockSource as $list) {
            $stockservicesource = $list->id;
        }



        $data2 = DB::update(
            'update tgaz_stock_service_lot set qte_lot = qte_lot - :qteStock where (refLot = :refLot) and (refService = :refService)',
            ['qteStock' => $qte,'refLot' => $id_lot,'refService' => $id_service]
        );

        $data3 = DB::update(
            'update tgaz_stock_service_lot set qte_lot = qte_lot + :qteStock where (refLot = :refLot) and (refService = :refService)',
            ['qteStock' => $qte,'refLot' => $id_lot,'refService' => $id_source]
        );

        
        $nom_table = 'tgaz_detail_transfert';

        $data4 = DB::update(
            'delete from tgaz_mouvement_stock_service_lot where tgaz_mouvement_stock_service_lot.id_data = :id and nom_table=:nom_table',
            ['id' => $id, 'nom_table' => $nom_table]
        );

 

        $data = tgaz_detail_transfert::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }

    function insert_dataGlobal(Request $request)
    {
        $id_module = 12;
        $active = "OUI";

        $code = $this->GetCodeData('tvente_param_systeme','module_id',$id_module);
        $data = tgaz_entete_transfert::create([
            'refService'       =>  $request->refService,
            'module_id'       =>  $id_module,
            'date_transfert'       =>  $request->date_transfert,         
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser
        ]);

        $idmax=0;
        $maxid = DB::table('tgaz_entete_transfert')       
        ->selectRaw('MAX(tgaz_entete_transfert.id) as code_entete')
        ->where([
            ['tgaz_entete_transfert.refService','=', $request->refService],
            ['tgaz_entete_transfert.refUser','=', $request->refUser]
         ])
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_entete;
        }
        $detailData = $request->detailData;

        foreach ($detailData as $data) {
            
            $refIdStockSource = $data['idStockService'];
            $id_lot = 0;

            $cmup_data = floatval($this->calculerCoutGazMoyen($refIdStockSource, $request->date_transfert, $request->date_transfert));

            $puTransfert=0;
            $data_stockss = DB::table('tgaz_stock_service_lot')       
            ->select('id','refService','refLot','pu_lot','qte_lot','cmup_lot',
            'devise','taux','active','refUser','author')
            ->where([
               ['tgaz_stock_service_lot.id','=',  $refIdStockSource]
           ])
            ->first();
            if ($data_stockss) {
                $id_lot = $data_stockss->refLot;                
            }
    
            $temp_idservice = 0;
            $temp_idflot = 0;
            $temp_id=0;

            
            $qteTransfert=0;
            $uniteTransfert='';
            $cmupVente= $cmup_data;
            $cmupTemp= $cmup_data;
            $puTransfert = $cmup_data;
            $SI=0;  
   
           $stockservicedest = DB::table('tgaz_stock_service_lot')       
            ->select('id','refService','refLot','pu_lot','qte_lot','cmup_lot',
            'devise','taux','active','refUser','author')
            ->where([
               ['tgaz_stock_service_lot.refService','=',  $request->refDestination],
               ['tgaz_stock_service_lot.refLot','=',  $id_lot]
           ])
            ->first();
            if ($stockservicedest) {
                $temp_idservice = $stockservicedest->refService;
                $temp_idflot = $stockservicedest->refLot;
                $temp_id = $stockservicedest->id;

                
                $qteTransfert = floatval($stockservicedest->qte_lot);
                $SI = floatval($stockservicedest->qte_lot);
            }

            $products = DB::table("tgaz_lot")
            ->select("tgaz_lot.id",'nom_lot','code_lot','unite_lot','stock_alerte',
            'author','refUser',"tgaz_lot.created_at")
            ->where([
               ['tgaz_lot.id','=',  $id_lot]
            ])
            ->first();
            if ($products) {
                $uniteTransfert = $products->unite_lot;            
            } 

           $taux=0;
           $data5 =  DB::table("tvente_taux")
           ->select("tvente_taux.id", "tvente_taux.taux", 
           "tvente_taux.created_at", "tvente_taux.author")
            ->first();
            if ($data5) 
            {                                
               $taux=$data5->taux;                           
            }

           $devise=0;
           $data55 =  DB::table("tvente_devise")
           ->select("tvente_devise.id", "tvente_devise.designation","tvente_devise.created_at")
           ->where([
               ['tvente_devise.active','=', 'OUI']
           ])
            ->first();
            if ($data55) 
            {                                
               $devise=$data55->designation;                           
            }
    
           $qteEntree = floatval($data['qteTransfert']);

           $data90 = tgaz_detail_transfert::create([
                'refEnteteTransfert'       => $idmax,
                'refLot'       =>  $id_lot,  
                'refDestination'       =>  $request->refDestination,  
                'idStockService'       =>  $refIdStockSource, 
                'puTransfert'       =>  $puTransfert, 
                'qteTransfert'      =>  $data['qteTransfert'], 
                'uniteTransfert'    =>  $uniteTransfert,       
                'author'       =>  $request->author,
                'refUser'    =>  $request->refUser
            ]);

           if(($request->refDestination == $temp_idservice) && ($id_lot == $temp_idflot))
           {


            $data22 = DB::update(
                'update tgaz_stock_service_lot set qte_lot = qte_lot - :qteTransfert where id = :id',
                ['qteTransfert' => $qteEntree,'id' => $refIdStockSource]
            );

            $id_detail_max1 =0;
            $detail_list1 = DB::table('tgaz_detail_transfert')       
            ->selectRaw('MAX(id) as code_entete')
            ->where('refUser', $request->refUser)
            ->get();
            foreach ($detail_list1 as $list) {
                $id_detail_max1 = $list->code_entete;
            }
          
            $data999 = tgaz_mouvement_stock_service_lot::create([             
                'idStockService'    =>  $refIdStockSource,             
                'dateMvt'    =>   $request->date_transfert,   
                'type_mouvement'    =>  'Sortie',
                'libelle_mouvement'    =>  'Transfert Stock Gaz',
                'nom_table'    =>  'tgaz_detail_transfert',
                'id_data'    =>  $id_detail_max1, 
                'qteMvt'    =>  $data['qteTransfert'],
                'puMvt'    =>  $puTransfert,                   
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'type_sortie'    =>  'Sortie',
    
                'active'    =>  $active,
                'uniteMvt'    =>  $uniteTransfert,
                'compte_vente'    =>  0,
                'compte_variationstock'    =>  0,
                'compte_perte'    =>  0,
                'compte_produit'    =>  0,
                'compte_destockage'    =>  0,
                'compte_achat'    =>  0,
                'compte_stockage'    => 0,
                'devise'    =>  $devise,
                'taux'    =>  $taux,
                'cmupMvt'    =>  $puTransfert
            ]); 

            $data23 = DB::update(
            'update tgaz_stock_service_lot set qte_lot = qte_lot + :qteTransfert where id = :id',
            ['qteTransfert' => $qteEntree,'id' => $temp_id]
            );

            $id_detail_max=0;
            $detail_list = DB::table('tgaz_detail_transfert')       
            ->selectRaw('MAX(id) as code_entete')
            ->where('refUser', $request->refUser)
            ->get();
            foreach ($detail_list as $list) {
                $id_detail_max= $list->code_entete;
            }
              
            $data98 = tgaz_mouvement_stock_service_lot::create([             
                    'idStockService'    =>  $temp_id,             
                    'dateMvt'    =>   $request->date_transfert,   
                    'type_mouvement'    =>  'Entree',
                    'libelle_mouvement'    =>  'Entrée Stock par Transfert des Gaz',
                    'nom_table'    =>  'tgaz_detail_transfert',
                    'id_data'    =>  $id_detail_max, 
                    'qteMvt'    =>  $data['qteTransfert'],
                    'puMvt'    =>  $puTransfert,                   
                    'author'       =>  $request->author,
                    'refUser'       =>  $request->refUser,
                    'type_sortie'    =>  'Entree',
        
                    'active'    =>  $active,
                    'uniteMvt'    =>  $uniteTransfert,
                    'compte_vente'    =>  0,
                    'compte_variationstock'    =>  0,
                    'compte_perte'    =>  0,
                    'compte_produit'    =>  0,
                    'compte_destockage'    =>  0,
                    'compte_achat'    =>  0,
                    'compte_stockage'    =>  0,
                    'devise'    =>  'USD',
                    'taux'    =>  $taux,
                    'cmupMvt'    =>  $puTransfert
            ]); 

           }
           else
           {
               $data22 = DB::update(
                   'insert into tgaz_stock_service_lot (refService,refLot,pu_lot,qte_lot,cmup_lot,devise,taux,active,refUser,author) 
                   values (:refService,:refLot,:pu_lot,:qte_lot,:cmup_lot,:devise,:taux,:active,:refUser,:author)',
                   ['refService' => $request->refDestination,'refLot' => $id_lot,'pu_lot' => $cmupTemp,'qte_lot' => $qteEntree,
                   'cmup_lot' => $cmupTemp,'devise' => $devise,'taux' => $taux,'active' => $active,
                   'refUser' => $request->refUser,'author' => $request->author]
               );

               
               $data220 = DB::update(
                'update tgaz_stock_service_lot set qte_lot = qte_lot - :qteTransfert where id = :id',
                ['qteTransfert' => $qteEntree,'id' => $data['idStockService']] 
                );

                $id_detail_max1 =0;
                $detail_list1 = DB::table('tgaz_detail_transfert')       
                ->selectRaw('MAX(id) as code_entete')
                ->where('refUser', $request->refUser)
                ->get();
                foreach ($detail_list1 as $list) {
                    $id_detail_max1 = $list->code_entete;
                }
              
                $data97 = tgaz_mouvement_stock_service_lot::create([             
                    'idStockService'    =>  $data['idStockService'],             
                    'dateMvt'    =>   $request->date_transfert,   
                    'type_mouvement'    =>  'Sortie',
                    'libelle_mouvement'    =>  'Transfert Stock des Gaz',
                    'nom_table'    =>  'tgaz_detail_transfert',
                    'id_data'    =>  $id_detail_max1, 
                    'qteMvt'    =>  $data['qteTransfert'],
                    'puMvt'    =>  $puTransfert,                   
                    'author'       =>  $request->author,
                    'refUser'       =>  $request->refUser,
                    'type_sortie'    =>  'Sortie',
        
                    'active'    =>  $active,
                    'uniteMvt'    =>  $uniteTransfert,
                    'compte_vente'    =>  0,
                    'compte_variationstock'    =>  0,
                    'compte_perte'    =>  0,
                    'compte_produit'    =>  0,
                    'compte_destockage'    =>  0,
                    'compte_achat'    =>  0,
                    'compte_stockage'    =>  0,
                    'devise'    =>  'USD',
                    'taux'    =>  $taux,
                    'cmupMvt'    =>  $puTransfert
                ]); 





                $id_detail_max=0;
                $detail_list = DB::table('tgaz_detail_transfert')       
                ->selectRaw('MAX(id) as code_entete')
                ->where('refUser', $request->refUser)
                ->first();
                if ($detail_list) {
                    $id_detail_max= $detail_list->code_entete;
                }

                $id_stock_servi_dest=0;

                $data_dest = DB::table('tgaz_stock_service_lot')       
                ->selectRaw('MAX(id) as code_entete')
                ->where([
                   ['tgaz_stock_service_lot.refService','=',  $request->refDestination],
                   ['tgaz_stock_service_lot.refLot','=',  $id_lot]
               ])
                ->first();
                if ($data_dest) {
                    $id_stock_servi_dest = $data_dest->code_entete;
                }

                            
                $data98 = tgaz_mouvement_stock_service_lot::create([             
                    'idStockService'    =>  $id_stock_servi_dest,             
                    'dateMvt'    =>   $request->date_transfert,   
                    'type_mouvement'    =>  'Entree',
                    'libelle_mouvement'    =>  'Entrée Stock par transfert des Gaz',
                    'nom_table'    =>  'tgaz_detail_transfert',
                    'id_data'    =>  $id_detail_max, 
                    'qteMvt'    =>  $data['qteTransfert'],
                    'puMvt'    =>  $puTransfert,                   
                    'author'       =>  $request->author,
                    'refUser'       =>  $request->refUser,
                    'type_sortie'    =>  'Entree',
        
                    'active'    =>  $active,
                    'uniteMvt'    =>  $uniteTransfert,
                    'devise'    =>  'USD',
                    'taux'    =>  $taux,
                    'cmupMvt'    =>  $puTransfert
                ]);  
           }
           
            
        }

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }
        

}
