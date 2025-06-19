<?php

namespace App\Http\Controllers\Gaz;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gaz\tgaz_detail_production;
use App\Models\Gaz\tgaz_entete_production;
use App\Models\Gaz\tgaz_mouvement_stock_service_lot;
use App\Models\Ventes\tvente_mouvement_stock;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tgaz_detail_productionController extends Controller
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

        $data = DB::table('tgaz_detail_production')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_production.idStockService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')

        ->join('tgaz_entete_production','tgaz_entete_production.id','=','tgaz_detail_production.refEnteteProduction')        
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_production.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_production.refService')

        ->select('tgaz_detail_production.id','tgaz_detail_production.refEnteteProduction',
        'tgaz_detail_production.compte_achat','tgaz_detail_production.compte_variationstock',
        'tgaz_detail_production.compte_produit','tgaz_detail_production.compte_stockage',
        'tgaz_detail_production.idStockService','tgaz_detail_production.puProduction',
        'tgaz_detail_production.qteProduction','tgaz_detail_production.uniteProduction',
        'tgaz_detail_production.cmupProduction','tgaz_detail_production.devise',
        'tgaz_detail_production.taux','tgaz_detail_production.montanttva',
        'tgaz_detail_production.montantreduction','tgaz_detail_production.active',
        'tgaz_detail_production.author','tgaz_detail_production.refUser',

        'tgaz_stock_service_lot.refLot',
        'tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot',
        'tgaz_stock_service_lot.active','nom_lot','code_lot','unite_lot','stock_alerte',

        'tgaz_entete_production.code','tgaz_entete_production.refService','module_id','dateProduction',
        'libelle_production','tgaz_entete_production.montant','nom_service', 
        "tvente_module.nom_module")

       ->selectRaw('ROUND(((qteProduction*puProduction) - montantreduction),2) as PTProduction')
       ->selectRaw('ROUND(((qteProduction*puProduction) - montantreduction + montanttva),2) as PTProductionTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteProduction*puProduction)/tgaz_detail_production.taux) as PTProductionFC');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('nom_lot', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_detail_production.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tgaz_detail_production.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }

    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tgaz_detail_production')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_production.idStockService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')

        ->join('tgaz_entete_production','tgaz_entete_production.id','=','tgaz_detail_production.refEnteteProduction')        
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_production.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_production.refService')

        ->select('tgaz_detail_production.id','tgaz_detail_production.refEnteteProduction',
        'tgaz_detail_production.compte_achat','tgaz_detail_production.compte_variationstock',
        'tgaz_detail_production.compte_produit','tgaz_detail_production.compte_stockage',
        'tgaz_detail_production.idStockService','tgaz_detail_production.puProduction',
        'tgaz_detail_production.qteProduction',
        'tgaz_detail_production.uniteProduction','tgaz_detail_production.cmupProduction',
        'tgaz_detail_production.devise','tgaz_detail_production.taux',
        'tgaz_detail_production.montanttva','tgaz_detail_production.montantreduction',
        'tgaz_detail_production.active','tgaz_detail_production.author',
        'tgaz_detail_production.refUser',

        'tgaz_stock_service_lot.refLot',
        'tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot',
        'tgaz_stock_service_lot.active','nom_lot','code_lot','unite_lot','stock_alerte',

        'tgaz_entete_production.code','tgaz_entete_production.refService','module_id','dateProduction',
        'libelle_production','tgaz_entete_production.montant','nom_service', 
        "tvente_module.nom_module")

       ->selectRaw('ROUND(((qteProduction*puProduction) - montantreduction),2) as PTProduction')
       ->selectRaw('ROUND(((qteProduction*puProduction) - montantreduction + montanttva),2) as PTProductionTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteProduction*puProduction)/tgaz_detail_production.taux) as PTProductionFC')
        ->Where('refEnteteProduction',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('nom_lot', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_detail_production.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tgaz_detail_production.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }  

    function fetch_single_data($id)
    {
        $data = DB::table('tgaz_detail_production')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_production.idStockService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')

        ->join('tgaz_entete_production','tgaz_entete_production.id','=','tgaz_detail_production.refEnteteProduction')        
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_production.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_production.refService')

        ->select('tgaz_detail_production.id','tgaz_detail_production.refEnteteProduction',
        'tgaz_detail_production.compte_achat','tgaz_detail_production.compte_variationstock',
        'tgaz_detail_production.compte_produit','tgaz_detail_production.compte_stockage',
        'tgaz_detail_production.idStockService','tgaz_detail_production.puProduction',
        'tgaz_detail_production.qteProduction',
        'tgaz_detail_production.uniteProduction','tgaz_detail_production.cmupProduction',
        'tgaz_detail_production.devise','tgaz_detail_production.taux',
        'tgaz_detail_production.montanttva','tgaz_detail_production.montantreduction',
        'tgaz_detail_production.active','tgaz_detail_production.author',
        'tgaz_detail_production.refUser',

        'tgaz_stock_service_lot.refLot',
        'tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot',
        'tgaz_stock_service_lot.active','nom_lot','code_lot','unite_lot','stock_alerte',

        'tgaz_entete_production.code','tgaz_entete_production.refService','module_id','dateProduction',
        'libelle_production','tgaz_entete_production.montant','nom_service', 
        "tvente_module.nom_module")

       ->selectRaw('ROUND(((qteProduction*puProduction) - montantreduction),2) as PTProduction')
       ->selectRaw('ROUND(((qteProduction*puProduction) - montantreduction + montanttva),2) as PTProductionTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteProduction*puProduction)/tgaz_detail_production.taux) as PTProductionFC')
        ->where('tgaz_detail_production.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_detail_facture($id)
    {

        $data = DB::table('tgaz_detail_production')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_production.idStockService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')

        ->join('tgaz_entete_production','tgaz_entete_production.id','=','tgaz_detail_production.refEnteteProduction')        
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_production.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_production.refService')

        ->select('tgaz_detail_production.id','tgaz_detail_production.refEnteteProduction',
        'tgaz_detail_production.compte_achat','tgaz_detail_production.compte_variationstock',
        'tgaz_detail_production.compte_produit','tgaz_detail_production.compte_stockage',
        'tgaz_detail_production.idStockService','tgaz_detail_production.puProduction',
        'tgaz_detail_production.qteProduction',
        'tgaz_detail_production.uniteProduction','tgaz_detail_production.cmupProduction',
        'tgaz_detail_production.devise','tgaz_detail_production.taux',
        'tgaz_detail_production.montanttva','tgaz_detail_production.montantreduction',
        'tgaz_detail_production.active','tgaz_detail_production.author',
        'tgaz_detail_production.refUser',

        'tgaz_stock_service_lot.refLot',
        'tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot',
        'tgaz_stock_service_lot.active','nom_lot','code_lot','unite_lot','stock_alerte',

        'tgaz_entete_production.code','tgaz_entete_production.refService','module_id','dateProduction',
        'libelle_production','tgaz_entete_production.montant','nom_service', 
        "tvente_module.nom_module")

       ->selectRaw('ROUND(((qteProduction*puProduction) - montantreduction),2) as PTProduction')
       ->selectRaw('ROUND(((qteProduction*puProduction) - montantreduction + montanttva),2) as PTProductionTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteProduction*puProduction)/tgaz_detail_production.taux) as PTProductionFC')       
       ->Where('tgaz_detail_production.refEnteteProduction',$id)               
       ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function insert_data(Request $request)
    {
        $current = Carbon::now();
        $active = "OUI";

        $taux=DB::table("tvente_taux")->pluck('taux')->first();

        $montants = 0;
        $devises ='';

        if($request->devise != 'USD')
        {
            $montants = ($request->puProduction)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puProduction;
            $devises = $request->devise;
        }

        $refLot = 0;
        $refService = 0;
        $cmupProduction = 0;
        $data99=DB::table('tgaz_stock_service_lot') 
        ->select('id','refService','refLot','cmup_lot')
        ->where([
            ['tgaz_stock_service_lot.id','=', $request->idStockService]
        ])      
        ->first();
        if ($data99) 
        {
            $refLot =  $data99->refLot;
            $cmupProduction =  $data99->cmup_lot;        
        }

        $data909=DB::table('tgaz_entete_production') 
        ->select('refService')
        ->where([
            ['tgaz_entete_production.id','=', $request->refEnteteProduction]
        ])->first();
        if ($data909) 
        {
            $refService =  $data909->refService;     
        }

        $compte_achat = 0;
        $compte_vente =0;
        $compte_variationstock=0;
        $compte_perte=0;
        $compte_produit=0;
        $compte_destockage=0;
        $compte_stockage=0;
        $cmupVente=0;
       
        $montanttva=0;
        $pourtageTVA=0;

        $data5=DB::table('tvente_tva')     
        ->select('montant_tva')
        ->where([
            ['tvente_tva.id','=', $request->id_tva],
            ['tvente_tva.active','=', 'OUI']
        ])      
        ->first();
        if ($data5) 
        {
            $pourtageTVA = $data5->montant_tva;
        }
        $montanttva = (((floatval($request->qteProduction) * floatval($montants))*floatval($pourtageTVA))/100);
        
        $data = tgaz_detail_production::create([
            'refEnteteProduction'       =>  $request->refEnteteProduction,
            'compte_achat' =>  $compte_achat,
            'compte_variationstock' =>  $compte_variationstock,
            'compte_produit' =>  $compte_produit,
            'compte_stockage' =>  $compte_stockage,
            'idStockService'    =>  $request->idStockService,
            'puProduction'    =>  $montants,
            'qteProduction'    =>  $request->qteProduction,
            'uniteProduction'    =>  $request->uniteProduction,
            'cmupProduction'    =>  $cmupProduction,
            'devise'    =>  $devises,
            'taux'    =>  $taux,    
            'montanttva'    =>  $montanttva,
            'montantreduction'       =>  $request->montantreduction, 
            'active'    =>  $active,
            'author'       =>  $request->author, 
            'refUser'    =>  $request->refUser
        ]);


        $id_detail_max=0;
        $detail_list = DB::table('tgaz_detail_production')       
        ->selectRaw('MAX(id) as code_entete')
        ->where([
            ['refUser','=', $request->refUser],
            ['idStockService','=', $request->idStockService]
         ])
        ->get();
        foreach ($detail_list as $list) {
            $id_detail_max= $list->code_entete;
        }
      
        $data99 = tgaz_mouvement_stock_service_lot::create([             
            'idStockService'    =>  $request->idStockService,             
            'dateMvt'    =>   $current,   
            'type_mouvement'    =>  'Entree',
            'libelle_mouvement'    =>  'Productions des Gaz',
            'nom_table'    =>  'tgaz_detail_production',
            'id_data'    =>  $id_detail_max, 
            'qteMvt'    =>  $request->qteProduction,
            'puMvt'    =>  $montants,                   
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser,
            'type_sortie'    =>  'Entree',

            'active'    =>  $active,
            'uniteMvt'    =>  $request->uniteProduction,
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
            'cmupMvt'    =>  $cmupProduction
        ]); 

        $data2 = DB::update(
            'update tgaz_stock_service_lot set qte_lot = qte_lot + :qteProduction where id = :idStockService',
            ['qteProduction' => $request->qteProduction,'idStockService' => $request->idStockService]
        );

        $idProduit=0; 
        $qte_param = 0;
        $refLot = DB::table("tgaz_stock_service_lot")->pluck('refLot')->Where('id',$request->idStockService)->first();
        $save_prods = DB::table('tgaz_parametre_lot')->Where('refLot',$refLot)->get(); 
        $refServices=DB::table("tgaz_entete_production")
        ->pluck('tgaz_entete_production.refService')
        ->Where('tgaz_entete_production.id',$request->refEnteteProduction)->first();

        foreach ($save_prods as $save_data) {
            $idProduit = $save_data->refProduit;
            $qte_param = $save_data->qte_param;

            $qte_total = floatval($qte_param) * floatval($request->qteProduction);
            $price_total = floatval($qte_param) * floatval($montants);

            $data_stock = DB::update(
                'update tvente_stock_service set qte = qte - :qteProd where refProduit = :refProduit and refService = :refService',
                ['qteProd' => $qte_total,'refProduit' => $idProduit,'refService' => $refServices]
            );

            $id_stock_services=0;
            $data_stock_pros = DB::table('tvente_stock_service')       
            ->select('tvente_stock_service.id as code_entete')
            ->where([
                ['tvente_stock_service.refProduit','=', $idProduit],
                ['tvente_stock_service.refService','=', $refServices]
             ])
            ->get();
            foreach ($data_stock_pros as $list) {
                $id_stock_services= $list->code_entete;
            }
    
            $nom_table = 'tgaz_detail_production';
    
            $data_mvt = tvente_mouvement_stock::create([             
                'idStockService'    =>  $id_stock_services,             
                'dateMvt'    =>   $request->dataProduction,   
                'type_mouvement'    =>  'Sortie',
                'libelle_mouvement'    =>  'Production des kits des Gaz',
                'nom_table'    =>  'tgaz_detail_production',
                'id_data'    =>  $id_detail_max, 
                'qteMvt'    =>  $qte_total,
                'puMvt'    =>  $price_total,                   
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'type_sortie'    =>  'Sortie',
    
                'active'    =>  $active,
                'uniteMvt'    =>  $request->uniteProduction,
                'compte_vente'    =>  0,
                'compte_variationstock'    =>  $compte_variationstock,
                'compte_perte'    =>  $compte_perte,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                'compte_achat'    =>  0,
                'compte_stockage'    =>  0,
                'puVente'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'puBase'    =>  $price_total,
                'qteBase'    =>  $qte_total,
                'uniteBase'    =>  $request->uniteProduction,
                'cmupMvt'    =>  $cmupProduction
            ]); 

        
        }



    
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {
        $current = Carbon::now();
        $active = "OUI";

        $taux=DB::table("tvente_taux")->pluck('taux')->first();

        $montants = 0;
        $devises ='';

        if($request->devise != 'USD')
        {
            $montants = ($request->puProduction)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puProduction;
            $devises = $request->devise;
        }

        $refLot = 0;
        $refService = 0;
        $cmupProduction = 0;
        $data99=DB::table('tgaz_stock_service_lot') 
        ->select('id','refService','refLot','cmup_lot')
        ->where([
            ['tgaz_stock_service_lot.id','=', $request->idStockService]
        ])      
        ->first();
        if ($data99) 
        {
            $refLot =  $data99->refLot;
            $cmupProduction =  $data99->cmup_lot;        
        }

        $data909=DB::table('tgaz_entete_production') 
        ->select('refService')
        ->where([
            ['tgaz_entete_production.id','=', $request->refEnteteProduction]
        ])->first();
        if ($data909) 
        {
            $refService =  $data909->refService;     
        }

        $compte_achat = 0;
        $compte_vente =0;
        $compte_variationstock=0;
        $compte_perte=0;
        $compte_produit=0;
        $compte_destockage=0;
        $compte_stockage=0;
        $cmupVente=0;


       
        $montanttva=0;
        $pourtageTVA=0;

        $data5=DB::table('tvente_tva')     
        ->select('montant_tva')
        ->where([
            ['tvente_tva.id','=', $request->id_tva],
            ['tvente_tva.active','=', 'OUI']
        ])      
        ->first();
        if ($data5) 
        {
            $pourtageTVA = $data5->montant_tva;
        }
        $montanttva = (((floatval($request->qteProduction) * floatval($montants))*floatval($pourtageTVA))/100);

        $data = tgaz_detail_production::where('id', $id)->update([
            'refEnteteProduction'       =>  $request->refEnteteProduction,
            'compte_achat' =>  $compte_achat,
            'compte_variationstock' =>  $compte_variationstock,
            'compte_produit' =>  $compte_produit,
            'compte_stockage' =>  $compte_stockage,
            'idStockService'    =>  $request->idStockService,
            'puProduction'    =>  $montants,
            'qteProduction'    =>  $request->qteProduction,
            'uniteProduction'    =>  $request->uniteProduction,
            'cmupProduction'    =>  $cmupProduction,
            'devise'    =>  $devises,
            'taux'    =>  $taux,    
            'montanttva'    =>  $montanttva,
            'montantreduction'       =>  $request->montantreduction, 
            'active'    =>  $active,
            'author'       =>  $request->author, 
            'refUser'    =>  $request->refUser
        ]);


        $id_detail_max=0;
        $detail_list = DB::table('tgaz_detail_production')       
        ->selectRaw('MAX(id) as code_entete')
        ->where([
            ['refUser','=', $request->refUser],
            ['idStockService','=', $request->idStockService]
         ])
        ->get();
        foreach ($detail_list as $list) {
            $id_detail_max= $list->code_entete;
        }
      
        $data99 = tgaz_mouvement_stock_service_lot::create([             
            'idStockService'    =>  $request->idStockService,             
            'dateMvt'    =>   $current,   
            'type_mouvement'    =>  'Entree',
            'libelle_mouvement'    =>  'Productions des Gaz',
            'nom_table'    =>  'tgaz_detail_production',
            'id_data'    =>  $id_detail_max, 
            'qteMvt'    =>  $request->qteProduction,
            'puMvt'    =>  $montants,                   
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser,
            'type_sortie'    =>  'Entree',

            'active'    =>  $active,
            'uniteMvt'    =>  $request->uniteProduction,
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
            'cmupMvt'    =>  $cmupProduction
        ]); 

        $data2 = DB::update(
            'update tgaz_stock_service_lot set qte_lot = qte_lot + :qteProduction where id = :idStockService',
            ['qteProduction' => $qteProduction,'idStockService' => $request->idStockService]
        );

        $idProduit=0; 
        $qte_param = 0;
        $refLot = DB::table("tgaz_stock_service_lot")->pluck('refLot')->Where('id',$request->idStockService)->first();
        $save_prods = DB::table('tgaz_parametre_lot')->Where('refLot',$refLot)->get(); 
        $refServices=DB::table("tgaz_entete_production")->pluck('tgaz_entete_production.refService')->Where('tgaz_entete_production.id',$request->refEnteteProduction)->first();

        foreach ($save_prods as $save_data) {
            $idProduit = $save_data->refProduit;
            $qte_param = $save_data->qte_param;

            $qte_total = floatval($qte_param) * floatval($request->qteProduction);
            $price_total = floatval($qte_param) * floatval($montants);

            $data_stock = DB::update(
                'update tgaz_stock_service_lot set qte = qte - :qteProd where refProduit = :refProduit and refService = :refService',
                ['qteProd' => $qte_total,'refProduit' => $idProduit,'refService' => $refServices]
            );

            $id_stock_services=0;
            $data_stock_pros = DB::table('tgaz_stock_service_lot')       
            ->select('tgaz_stock_service_lot.id as code_entete')
            ->where([
                ['tgaz_stock_service_lot.refProduit','=', $request->$idProduit],
                ['tgaz_stock_service_lot.refService','=', $request->$refServices]
             ])
            ->get();
            foreach ($data_stock_pros as $list) {
                $id_stock_services= $list->code_entete;
            }
    
            $nom_table = 'tgaz_detail_production';
    
            $data_mvt = tvente_mouvement_stock::create([             
                'idStockService'    =>  $id_stock_services,             
                'dateMvt'    =>   $request->dataProduction,   
                'type_mouvement'    =>  'Sortie',
                'libelle_mouvement'    =>  'Production des kits des Gaz',
                'nom_table'    =>  'tgaz_detail_production',
                'id_data'    =>  $id_detail_max, 
                'qteMvt'    =>  $qte_total,
                'puMvt'    =>  $price_total,                   
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'type_sortie'    =>  'Sortie',
    
                'active'    =>  $active,
                'uniteMvt'    =>  $request->uniteProduction,
                'compte_vente'    =>  0,
                'compte_variationstock'    =>  $compte_variationstock,
                'compte_perte'    =>  $compte_perte,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                'compte_achat'    =>  0,
                'compte_stockage'    =>  0,
                'puVente'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'puBase'    =>  $price_total,
                'qteBase'    =>  $qte_total,
                'uniteBase'    =>  $request->uniteProduction,
                'cmupMvt'    =>  $cmupProduction
            ]); 

        
        }
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $qte=0;
        $idProduit=0;
        $idFacture=0;
        $pu=0;
        $montantreduction=0;
        $montanttva=0;

        $deleteds = DB::table('tgaz_detail_production')->Where('id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $qte = $deleted->qteProduction;            
            $pu = $deleted->puProduction;
            $idProduit = $deleted->refProduit;
            $idFacture = $deleted->refEnteteProduction;
            $montantreduction = $deleted->montantreduction;
            $montanttva = $deleted->montanttva;
        }

        $refService=0;
        

        $data33=DB::table('tgaz_entete_production') 
         ->select('id','code','refService','module_id','dateUse','libelle','author','refUser')
         ->where([
            ['tgaz_entete_production.id','=', $idFacture]
        ])      
        ->get();      
        $output='';
        foreach ($data33 as $row) 
        {
            $refService =  $row->refService;           
        }


        $data2 = DB::update(
            'update tgaz_stock_service_lot set qte = qte + :qteProduction where refProduit = :refProduit and refService = :refService',
            ['qteProduction' => $qte,'refProduit' => $idProduit,'refService' => $refService]
        );

        $nom_table = 'tgaz_detail_production';

        $data4 = DB::update(
            'delete from tgaz_mouvement_stock_service_lot where tgaz_mouvement_stock_service_lot.id_data = :id and nom_table=:nom_table',
            ['id' => $id, 'nom_table' => $nom_table]
        );

        $data = tgaz_detail_production::where('id',$id)->delete();
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }

    function insert_dataGlobal(Request $request)
    {
        $module_id = 12;
        $code = $this->GetCodeData('tvente_param_systeme','module_id',$module_id);
        $active = "OUI";

        $data111 = tgaz_entete_production::create([
            'code'       =>  $code,
            'refService'       =>  $request->refService, 
            'module_id'       =>  $module_id,
            'dateProduction'    =>  $request->dateProduction,
            'libelle_production'    =>  $request->libelle_production,
            'montant'    =>  0,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);

        $idmax=0;
        $maxid = DB::table('tgaz_entete_production')       
        ->selectRaw('MAX(tgaz_entete_production.id) as code_entete')
        ->where([
            ['tgaz_entete_production.refUser','=', $request->refUser],
            ['tgaz_entete_production.refService','=', $request->refService]
         ])
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_entete;
        }

        $detailData = $request->detailData;

        foreach ($detailData as $data) {

            $current = Carbon::now();
            $active = "OUI";
    
            $taux=DB::table("tvente_taux")->pluck('taux')->first();
    
            $montants = 0;
            $devises ='';
    
            if($request->devise != 'USD')
            {
                $montants = ($data['puProduction'])/$taux;
                $devises='USD';
            }
            else
            {
                $montants = $data['puProduction'];
                $devises = $request->devise;
            }
    
            $refLot = 0;
            $refService = 0;
            $cmupProduction = 0; 
            $data99=DB::table('tgaz_stock_service_lot') 
            ->select('id','refService','refLot','cmup_lot')
            ->where([
                ['tgaz_stock_service_lot.id','=', $data['idStockService']]
            ])      
            ->first();
            if ($data99) 
            {
                $refLot =  $data99->refLot;
                $cmupProduction =  $data99->cmup_lot;        
            }
    
            $data909=DB::table('tgaz_entete_production') 
            ->select('refService')
            ->where([
                ['tgaz_entete_production.id','=', $idmax]
            ])->first();
            if ($data909) 
            {
                $refService =  $data909->refService;     
            }
    
            $compte_achat = 0;
            $compte_vente =0;
            $compte_variationstock=0;
            $compte_perte=0;
            $compte_produit=0;
            $compte_destockage=0;
            $compte_stockage=0;
            $cmupVente=0;
           
            $montanttva=0;
            $pourtageTVA=0;
    
            $data5=DB::table('tvente_tva')     
            ->select('montant_tva')
            ->where([
                ['tvente_tva.id','=', $data['id_tva']],
                ['tvente_tva.active','=', 'OUI']
            ])      
            ->first();
            if ($data5) 
            {
                $pourtageTVA = $data5->montant_tva;
            }
            $montanttva = (((floatval($data['qteProduction']) * floatval($montants))*floatval($pourtageTVA))/100);
            
            $data = tgaz_detail_production::create([
                'refEnteteProduction'       =>  $idmax,
                'compte_achat' =>  $compte_achat,
                'compte_variationstock' =>  $compte_variationstock,
                'compte_produit' =>  $compte_produit,
                'compte_stockage' =>  $compte_stockage,
                'idStockService'    =>  $data['idStockService'],
                'puProduction'    =>  $montants,
                'qteProduction'    =>  $data['qteProduction'],
                'uniteProduction'    =>  $data['nom_unite'],
                'cmupProduction'    =>  $cmupProduction,
                'devise'    =>  $devises,
                'taux'    =>  $taux,    
                'montanttva'    =>  $montanttva,
                'montantreduction'       =>  $data['montantreduction'], 
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
                'dateMvt'    =>   $current,   
                'type_mouvement'    =>  'Entree',
                'libelle_mouvement'    =>  'Productions des Gaz',
                'nom_table'    =>  'tgaz_detail_production',
                'id_data'    =>  $id_detail_max, 
                'qteMvt'    =>  $data['qteProduction'],
                'puMvt'    =>  $montants,                   
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'type_sortie'    =>  'Entree',
    
                'active'    =>  $active,
                'uniteMvt'    =>  $data['uniteProduction'],
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
                'cmupMvt'    =>  $cmupProduction
            ]); 
    
            $data2 = DB::update(
                'update tgaz_stock_service_lot set qte_lot = qte_lot + :qteProduction where id = :idStockService',
                ['qteProduction' => $data['qteProduction'],'idStockService' => $data['idStockService']]
            );

            $data303 = DB::update(
            'update tgaz_entete_production set montant = montant + (:pu * :qte) where id = :refEnteteVente',
            ['pu' => $montants,'qte' => $data['qteProduction'],'refEnteteVente' => $idmax]
            );  


            $idProduit=0; 
            $qte_param = 0;
            $refLot = 0;
            $refServices = 0;

            $data_lot= DB::table("tgaz_stock_service_lot")
            ->select('refLot')->Where('id',$data['idStockService'])
            ->first();
            if($data_lot)
            {
                $refLot = $data_lot->refLot;
            }             

            // $date_serv=DB::table("tgaz_entete_production")
            // ->select('tgaz_entete_production.refService')
            // ->Where('tgaz_entete_production.id',$idmax)
            // ->first();
            // if($date_serv)
            // {
            //     $refServices = $date_serv->refService;
            // }

            $refServices = $request->refService;

            $save_prods = DB::table('tgaz_parametre_lot')
            ->select('id','refProduit','refLot','pu_param','qte_param','autre_detail',
            'author','refUser')
            ->Where('refLot',$refLot)
            ->get();
    
            foreach ($save_prods as $save_data) {

                $idProduit = $save_data->refProduit;
                $qte_param = $save_data->qte_param;
    
                $qte_total = floatval($qte_param) * floatval($data['qteProduction']);
                $price_total = floatval($qte_param) * floatval($montants);
    
                $data_stock = DB::update(
                    'update tvente_stock_service set qte = qte - :qteProd where refProduit = :refProduit and refService = :refService',
                    ['qteProd' => $qte_total,'refProduit' => $idProduit,'refService' => $refServices]
                );
    
                $id_stock_services=0;
                $data_stock_pros = DB::table('tvente_stock_service')       
                ->select('tvente_stock_service.id as code_entete')
                ->where([
                    ['tvente_stock_service.refProduit','=', $idProduit],
                    ['tvente_stock_service.refService','=', $refServices]
                 ])
                ->get();
                foreach ($data_stock_pros as $list) {
                    $id_stock_services= $list->code_entete;
                }
        
                $nom_table = 'tgaz_detail_production';
                $qte_base = 1;
        
                $data_mvt = tvente_mouvement_stock::create([             
                    'idStockService'    =>  $id_stock_services,             
                    'dateMvt'    =>   $current,   
                    'type_mouvement'    =>  'Sortie',
                    'libelle_mouvement'    =>  'Production des kits des Gaz',
                    'nom_table'    =>  'tgaz_detail_production',
                    'id_data'    =>  $id_detail_max, 
                    'qteMvt'    =>  $qte_total,
                    'puMvt'    =>  $price_total,                   
                    'author'       =>  $request->author,
                    'refUser'       =>  $request->refUser,
                    'type_sortie'    =>  'Sortie',
        
                    'active'    =>  $active,
                    'uniteMvt'    =>  $data['uniteProduction'],
                    'compte_vente'    =>  0,
                    'compte_variationstock'    =>  $compte_variationstock,
                    'compte_perte'    =>  $compte_perte,
                    'compte_produit'    =>  $compte_produit,
                    'compte_destockage'    =>  $compte_destockage,
                    'compte_achat'    =>  0,
                    'compte_stockage'    =>  0,
                    'puVente'    =>  $montants,
                    'devise'    =>  $devises,
                    'taux'    =>  $taux,
                    'puBase'    =>  $price_total,
                    'qteBase'    =>  $qte_base,
                    'uniteBase'    =>  $data['uniteProduction'],
                    'cmupMvt'    =>  $cmupProduction
                ]); 
    
            
            }
        
        }

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }




}
