<?php

namespace App\Http\Controllers\Gaz;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gaz\tgaz_detail_inventaire;
use App\Models\Gaz\tgaz_entete_inventaire;
use App\Models\Gaz\tgaz_mouvement_stock_service_lot;
use App\Models\Gaz\tgaz_entete_production;
use App\Models\Gaz\tgaz_detail_production;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tgaz_detail_inventaireController extends Controller
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

        $data = DB::table('tgaz_detail_inventaire')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_inventaire.idStockService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')

        ->join('tgaz_entete_inventaire','tgaz_entete_inventaire.id','=','tgaz_detail_inventaire.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_inventaire.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_inventaire.refService')
        
        ->select('tgaz_detail_inventaire.id','qteObs','refEnteteVente','puVente','qteVente',
        'uniteVente','cmupVente','tgaz_detail_inventaire.devise','tgaz_detail_inventaire.taux',
        'montantreduction','tgaz_detail_inventaire.active','tgaz_detail_inventaire.author',
        'tgaz_detail_inventaire.refUser','tgaz_detail_inventaire.created_at','idStockService',

        'tgaz_stock_service_lot.refLot','tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot',
        'tgaz_stock_service_lot.active','nom_lot','code_lot','unite_lot','stock_alerte',

        'nom_service', "tvente_module.nom_module",'tgaz_entete_inventaire.code','tgaz_entete_inventaire.refService',
        'module_id','dateVente','libelle','priseencharge'
       )
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tgaz_detail_inventaire.taux) as PTVenteFC');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('nom_lot', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_detail_inventaire.created_at", "asc");

            return $this->apiData($data->paginate(10));          

        }
        $data->orderBy("tgaz_detail_inventaire.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }

    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tgaz_detail_inventaire')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_inventaire.idStockService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')

        ->join('tgaz_entete_inventaire','tgaz_entete_inventaire.id','=','tgaz_detail_inventaire.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_inventaire.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_inventaire.refService')
        
        ->select('tgaz_detail_inventaire.id','qteObs','refEnteteVente','puVente','qteVente',
        'uniteVente','cmupVente','tgaz_detail_inventaire.devise','tgaz_detail_inventaire.taux',
        'montantreduction','tgaz_detail_inventaire.active','tgaz_detail_inventaire.author',
        'tgaz_detail_inventaire.refUser','tgaz_detail_inventaire.created_at','idStockService',

        'tgaz_stock_service_lot.refLot','tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot',
        'tgaz_stock_service_lot.active','nom_lot','code_lot','unite_lot','stock_alerte',

        'nom_service', "tvente_module.nom_module",'tgaz_entete_inventaire.code','tgaz_entete_inventaire.refService',
        'module_id','dateVente','libelle','priseencharge'
       )
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tgaz_detail_inventaire.taux) as PTVenteFC')
        ->Where('refEnteteVente',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('nom_lot', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_detail_inventaire.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tgaz_detail_inventaire.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }  

    function fetch_single_data($id)
    {
        $data= DB::table('tgaz_detail_inventaire')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_inventaire.idStockService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')

        ->join('tgaz_entete_inventaire','tgaz_entete_inventaire.id','=','tgaz_detail_inventaire.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_inventaire.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_inventaire.refService')
        
        ->select('tgaz_detail_inventaire.id','qteObs','refEnteteVente','puVente','qteVente',
        'uniteVente','cmupVente','tgaz_detail_inventaire.devise','tgaz_detail_inventaire.taux',
        'montantreduction','tgaz_detail_inventaire.active','tgaz_detail_inventaire.author',
        'tgaz_detail_inventaire.refUser','tgaz_detail_inventaire.created_at','idStockService',

        'tgaz_stock_service_lot.refLot','tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot',
        'tgaz_stock_service_lot.active','nom_lot','code_lot','unite_lot','stock_alerte',

        'nom_service', "tvente_module.nom_module",'tgaz_entete_inventaire.code','tgaz_entete_inventaire.refService',
        'module_id','dateVente','libelle','priseencharge'
       )
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tgaz_detail_inventaire.taux) as PTVenteFC')
        ->where('tgaz_detail_inventaire.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_detail_facture($id)
    {

        $data = DB::table('tgaz_detail_inventaire')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_inventaire.idStockService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')

        ->join('tgaz_entete_inventaire','tgaz_entete_inventaire.id','=','tgaz_detail_inventaire.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_inventaire.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_inventaire.refService')
        
        ->select('tgaz_detail_inventaire.id','qteObs','refEnteteVente','puVente','qteVente',
        'uniteVente','cmupVente','tgaz_detail_inventaire.devise','tgaz_detail_inventaire.taux',
        'montantreduction','tgaz_detail_inventaire.active','tgaz_detail_inventaire.author',
        'tgaz_detail_inventaire.refUser','tgaz_detail_inventaire.created_at','idStockService',

        'tgaz_stock_service_lot.refLot','tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot',
        'tgaz_stock_service_lot.active','nom_lot','code_lot','unite_lot','stock_alerte',

        'nom_service', "tvente_module.nom_module",'tgaz_entete_inventaire.code','tgaz_entete_inventaire.refService',
        'module_id','dateVente','libelle','priseencharge'
       )
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tgaz_detail_inventaire.taux) as PTVenteFC')       
       ->Where('tgaz_detail_inventaire.refEnteteVente',$id)               
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

        $montants=0;
        $devises='USD';
        $unite = '';
        $cmupVente = 0;
        $refLot=0;
        $uniteVente = '';

        $data99 = DB::table('tgaz_stock_service_lot')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
        ->select('tgaz_stock_service_lot.id','tgaz_stock_service_lot.refService','tgaz_stock_service_lot.refLot',
        'tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot','tgaz_stock_service_lot.devise',
        'tgaz_stock_service_lot.taux','tgaz_stock_service_lot.active','tgaz_stock_service_lot.refUser',
        'tgaz_stock_service_lot.author',"stock_alerte","tgaz_stock_service_lot.created_at",
        'nom_lot','code_lot','unite_lot','stock_alerte')
        ->where([
           ['tgaz_stock_service_lot.id','=', $request->idStockService]
        ])      
        ->get();
        foreach ($data99 as $row) 
        {
            $refLot =  $row->refLot; 
            $montants = $row->cmup_lot; 
            $cmupVente = $row->cmup_lot; 
            $uniteVente = $row->unite_lot;       
        }

        $qte=$request->qteVente;
        $idDetail=$refLot;
        $idFacture=$request->refEnteteVente;

        $refService=0;        

        $data33=DB::table('tgaz_entete_inventaire') 
         ->select('id','code','tgaz_entete_inventaire.refService','module_id','dateVente','libelle','author','refUser')
         ->where([
            ['tgaz_entete_inventaire.id','=', $request->refEnteteVente]
        ])      
        ->first();
        if ($data33) 
        {
            $refService =  $data33->refService;           
        }

       $qteVente = floatval($request->qteVente);

       
       $montanttva=0;
       $pourtageTVA=0;
 
       $data5=DB::table('tvente_tva')     
       ->select('montant_tva')
       ->where([
          ['tvente_tva.active','=', 'OUI']
       ])      
      ->get();
      foreach ($data5 as $row) 
      {
          $pourtageTVA = $row->montant_tva;
      }

      $montanttva = (((floatval($request->qteVente) * floatval($montants))*floatval($pourtageTVA))/100);
      $montantreduction = 0;

        $data = tgaz_detail_inventaire::create([
            'refEnteteVente'       =>  $request->refEnteteVente,
            'qteVente'    =>  $request->qteVente,
            'qteObs'    =>  $request->qteObs,
            'idStockService'    =>  $request->idStockService,                       
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser,

            'montantreduction'    =>  $montantreduction,
            'active'    =>  $active,
            'uniteVente'    =>  $uniteVente,
            'puVente'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'cmupVente'    =>  $cmupVente,
            'montanttva'    =>  $montanttva
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

        $montants=0;
        $devises='USD';
        $unite = '';
        $cmupVente = 0;
        $refLot=0;
        $uniteVente = '';

        $data99 = DB::table('tgaz_stock_service_lot')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
        ->select('tgaz_stock_service_lot.id','tgaz_stock_service_lot.refService','tgaz_stock_service_lot.refLot',
        'tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot','tgaz_stock_service_lot.devise',
        'tgaz_stock_service_lot.taux','tgaz_stock_service_lot.active','tgaz_stock_service_lot.refUser',
        'tgaz_stock_service_lot.author',"stock_alerte","tgaz_stock_service_lot.created_at",
        'nom_lot','code_lot','unite_lot','stock_alerte')
        ->where([
           ['tgaz_stock_service_lot.id','=', $request->idStockService]
        ])      
        ->get();
        foreach ($data99 as $row) 
        {
            $refLot =  $row->refLot; 
            $montants = $row->cmup_lot; 
            $cmupVente = $row->cmup_lot; 
            $uniteVente = $row->unite_lot;       
        }

        $qte=$request->qteVente;
        $idDetail=$refLot;
        $idFacture=$request->refEnteteVente;

        $refService=0;        

        $data33=DB::table('tgaz_entete_inventaire') 
         ->select('id','code','tgaz_entete_inventaire.refService','module_id','dateVente','libelle','author','refUser')
         ->where([
            ['tgaz_entete_inventaire.id','=', $request->refEnteteVente]
        ])      
        ->first();
        if ($data33) 
        {
            $refService =  $data33->refService;           
        }

       $qteVente = floatval($request->qteVente);

       
       $montanttva=0;
       $pourtageTVA=0;
 
       $data5=DB::table('tvente_tva')     
       ->select('montant_tva')
       ->where([
          ['tvente_tva.active','=', 'OUI']
       ])      
      ->get();
      foreach ($data5 as $row) 
      {
          $pourtageTVA = $row->montant_tva;
      }

      $montanttva = (((floatval($request->qteVente) * floatval($montants))*floatval($pourtageTVA))/100);
      $montantreduction = 0;

        $data = tgaz_detail_inventaire::where('id', $id)->update([
            'refEnteteVente'       =>  $request->refEnteteVente,
            'qteVente'    =>  $request->qteVente,
            'qteObs'    =>  $request->qteObs,
            'idStockService'    =>  $request->idStockService,                       
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser,

            'montantreduction'    =>  $montantreduction,
            'active'    =>  $active,
            'uniteVente'    =>  $uniteVente,
            'puVente'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'cmupVente'    =>  $cmupVente,
            'montanttva'    =>  $montanttva,        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = tgaz_detail_inventaire::where('id',$id)->delete();

        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }

    function insert_dataGlobal(Request $request)
    {
        $id_module = 16;
        $active = "OUI";

        $code = $this->GetCodeData('tvente_param_systeme','module_id',$id_module);
        $data = tgaz_entete_inventaire::create([
            'code'       =>  $code,            
            'refService'       =>  $request->refService, 
            'module_id'       =>  $id_module,
            'dateVente'    =>  $request->dateVente,
            'libelle'    =>  $request->libelle,            
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);

        $idmax=0;
        $maxid = DB::table('tgaz_entete_inventaire')       
        ->selectRaw('MAX(tgaz_entete_inventaire.id) as code_entete')
        ->where('tgaz_entete_inventaire.refService', $request->refService)
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_entete;
        }

        $detailData = $request->detailData;

        foreach ($detailData as $data) {

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
    
            $montants=0;
            $devises='USD';
            $unite = '';
            $cmupVente=0;
            $uniteVente = '';

            $refLot=0;
            $data99 = DB::table('tgaz_stock_service_lot')
            ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
            ->select('tgaz_stock_service_lot.id','tgaz_stock_service_lot.refService','tgaz_stock_service_lot.refLot',
            'tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot','tgaz_stock_service_lot.devise',
            'tgaz_stock_service_lot.taux','tgaz_stock_service_lot.active','tgaz_stock_service_lot.refUser',
            'tgaz_stock_service_lot.author',"stock_alerte","tgaz_stock_service_lot.created_at",
            'nom_lot','code_lot','unite_lot','stock_alerte')
             ->where([
                ['tgaz_stock_service_lot.id','=', $data['idStockService']]
             ])      
             ->get();
            foreach ($data99 as $row) 
            {
                $refLot =  $row->refLot; 
                $montants = $row->cmup_lot; 
                $cmupVente= $row->cmup_lot;
                $uniteVente = $row->unite_lot;         
            }

            $qte=$data['qteVente'];
            $idDetail=$refLot;
            $idFacture=$idmax;
 
            $qteVente = floatval($data['qteVente']);
        
            $montanttva=0;
            $pourtageTVA=0;
 
            $data5=DB::table('tvente_tva')     
            ->select('montant_tva')
            ->where([
               ['tvente_tva.active','=', 'OUI']
            ])      
            ->get();
            foreach ($data5 as $row) 
            {
                $pourtageTVA = $row->montant_tva;
            }

            $montantreduction = 0;
         
            $montanttva = (((floatval($data['qteVente']) * floatval($montants))*floatval($pourtageTVA))/100);
     
            $data = tgaz_detail_inventaire::create([
                'refEnteteVente'       =>  $idmax,
                'refProduit'    =>  $refLot,
                'qteVente'    =>  $data['qteVente'],
                'qteObs'    =>  $data['qteDisponible'],
                'idStockService'    =>  $data['idStockService'],                     
                'author'       =>  $request->author,
                'refUser'    =>  $request->refUser,

                'montantreduction'    =>   $montantreduction,
                'active'    =>  $active,
                'uniteVente'    =>  $uniteVente,
                'puVente'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'cmupVente'    =>  $cmupVente,
                'montanttva'    =>  $montanttva,
            ]);

            $data2 = DB::update(
                'update tgaz_stock_service_lot set qte_lot = :qteEntree where id = :idStockService',
                ['qteEntree' => $qteVente,'idStockService' => $data['idStockService']]
            );

            
        }        

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }

    function insert_dataGlobalInnitialise(Request $request)
    {
        $id_module = 16;
        $active = "OUI";

        $code = $this->GetCodeData('tvente_param_systeme','module_id',$id_module);
        $data200 = tgaz_entete_inventaire::create([
            'code'       =>  $code,            
            'refService'       =>  $request->refService, 
            'module_id'       =>  $id_module,
            'dateVente'    =>  $request->dateVente,
            'libelle'    =>  $request->libelle,            
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);

        $idmax=0;
        $maxid = DB::table('tgaz_entete_inventaire')       
        ->selectRaw('MAX(tgaz_entete_inventaire.id) as code_entete')
        ->where('tgaz_entete_inventaire.refService', $request->refService)
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_entete;
        }



        //=============================== APPROVISIONNEMENT ==========================================

        $id_moduless = 12;
        $actives = "OUI";

        $codes = $this->GetCodeData('tvente_param_systeme','module_id',$id_moduless);
        $data202 = tgaz_entete_production::create([
            'code'       =>  $codes,
            'refService'       =>  $request->refService,
            'module_id'       =>  $id_moduless,            
            'dateProduction'    =>  $request->dateVente,
            'libelle_production'    =>  $request->libelle,
            'montant'    =>  0,           
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser
        ]); 

        $idmaxs=DB::table('tgaz_entete_production')
        ->where([
            ['refUser','=', $request->refUser],
            ['refService','=', $request->refService]
        ])
        ->max('id');



        //=============================================================================================

        $detailData = $request->detailData;

        foreach ($detailData as $data) {

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
    
            $montants=0;
            $devises='USD';
            $unite = '';
            $cmupVente=0;
            $uniteVente = '';

            $refLot=0;
            $data99 = DB::table('tgaz_stock_service_lot')
            ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
            ->select('tgaz_stock_service_lot.id','tgaz_stock_service_lot.refService','tgaz_stock_service_lot.refLot',
            'tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot','tgaz_stock_service_lot.devise',
            'tgaz_stock_service_lot.taux','tgaz_stock_service_lot.active','tgaz_stock_service_lot.refUser',
            'tgaz_stock_service_lot.author',"stock_alerte","tgaz_stock_service_lot.created_at",
            'nom_lot','code_lot','unite_lot','stock_alerte')
             ->where([
                ['tgaz_stock_service_lot.id','=', $data['idStockService']]
             ])      
             ->get();
            foreach ($data99 as $row) 
            {
                $refLot =  $row->refLot; 
                $montants = $row->cmup_lot; 
                $cmupVente= $row->cmup_lot;
                $uniteVente = $row->unite_lot;         
            }

            $qte=$data['qteVente'];
            $idDetail=$refLot;
            $idFacture=$idmax;
 
            $qteVente = floatval($data['qteVente']);
        
            $montanttva=0;
            $pourtageTVA=0;
 
            $data5=DB::table('tvente_tva')     
            ->select('montant_tva')
            ->where([
               ['tvente_tva.active','=', 'OUI']
            ])      
            ->get();
            foreach ($data5 as $row) 
            {
                $pourtageTVA = $row->montant_tva;
            }

            $montantreduction = 0;
         
            $montanttva = (((floatval($data['qteVente']) * floatval($montants))*floatval($pourtageTVA))/100);
     
            $data = tgaz_detail_inventaire::create([
                'refEnteteVente'       =>  $idmax,
                'refProduit'    =>  $refLot,
                'qteVente'    =>  $data['qteVente'],
                'qteObs'    =>  $data['qteDisponible'],
                'idStockService'    =>  $data['idStockService'],                     
                'author'       =>  $request->author,
                'refUser'    =>  $request->refUser,

                'montantreduction'    =>   $montantreduction,
                'active'    =>  $active,
                'uniteVente'    =>  $uniteVente,
                'puVente'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'cmupVente'    =>  $cmupVente,
                'montanttva'    =>  $montanttva,
            ]);

            $data2 = DB::update(
                'update tgaz_stock_service_lot set qte_lot = :qteEntree where id = :idStockService',
                ['qteEntree' => $qteVente,'idStockService' => $data['idStockService']]
            );

            $compte_vente = 0;
            $compte_variationstock = 0;
            $compte_perte = 0;
            $compte_produit = 0;
            $compte_destockage = 0;
            $compte_achat = 0;
            $compte_stockage = 0;

            
            $data203 = tgaz_detail_production::create([                
                'refEnteteProduction'       =>  $idmaxs,
                'compte_achat' =>  $compte_achat,
                'compte_variationstock' =>  $compte_variationstock,
                'compte_produit' =>  $compte_produit,
                'compte_stockage' =>  $compte_stockage,
                'idStockService'    =>  $data['idStockService'],
                'puProduction'    =>  $montants,
                'qteProduction'    =>  $data['qteVente'],
                'uniteProduction'    =>  $uniteVente,
                'cmupProduction'    =>  $cmupVente,
                'devise'    =>  $devises,
                'taux'    =>  $taux,    
                'montanttva'    =>  $montanttva,
                'montantreduction'       =>  $montantreduction, 
                'active'    =>  $active,
                'author'       =>  $request->author, 
                'refUser'    =>  $request->refUser
            ]);
        
                $id_detail_max=0;
                $detail_list = DB::table('tgaz_detail_production')       
                ->selectRaw('MAX(id) as code_entete')
                ->where([
                    ['refUser','=', $request->refUser],
                    ['idStockService','=', $data['idStockService']]
                ]) 
                ->get();
                foreach ($detail_list as $list) {
                    $id_detail_max= $list->code_entete;
                }

            $data99 = tgaz_mouvement_stock_service_lot::create([             
                'idStockService'    =>  $data['idStockService'],             
                'dateMvt'    =>   $request->dateVente,   
                'type_mouvement'    =>  'Entree',
                'libelle_mouvement'    =>  'Innitialisation Stock Kit',
                'nom_table'    =>  'tgaz_detail_production',
                'id_data'    =>  $id_detail_max, 
                'qteMvt'    =>  $data['qteVente'],
                'puMvt'    =>  $montants,                   
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'type_sortie'    =>  'Entree',
    
                'active'    =>  $active,
                'uniteMvt'    =>  $uniteVente,
                'compte_vente'    =>  $compte_destockage,
                'compte_variationstock'    =>  $compte_variationstock,
                'compte_perte'    =>  0,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  0,
                'compte_achat'    =>  $compte_destockage,
                'compte_stockage'    => 0,
                'puProduction'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'cmupMvt'    =>  $cmupVente
            ]);



            
        }



        

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }



}
