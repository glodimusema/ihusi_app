<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_stock_service;
use App\Models\Facture;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;

class tvente_stock_serviceController extends Controller
{
    use GlobalMethod, Slug;

//     'id','refService','refProduit','pu','qte','cmup','devise','taux','active','refUser','author'
// 'tvente_stock_service'


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

        $data = DB::table('tvente_stock_service')
        ->join('tvente_services','tvente_services.id','=','tvente_stock_service.refService')
        ->join('tvente_produit','tvente_produit.id','=','tvente_stock_service.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')  

        ->select('tvente_stock_service.id','tvente_stock_service.refService','tvente_stock_service.refProduit',
        'tvente_stock_service.uniteBase','tvente_stock_service.devise','unitePivot','qtePivot',
        'tvente_stock_service.taux','tvente_stock_service.active','tvente_stock_service.refUser',
        'tvente_stock_service.author' ,"tvente_services.nom_service","stock_alerte"  
        
        ,"tvente_produit.designation as designation",'refCategorie','refUniteBase','Oldcode',
        'Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie"
        )
        ->selectRaw('IFNULL(tvente_stock_service.qte,0) as qte')
        ->selectRaw('ROUND(tvente_stock_service.pu,2) as pu')
        ->selectRaw('ROUND(tvente_stock_service.cmup,2) as cmup')
        ->selectRaw('ROUND(IFNULL((tvente_stock_service.cmup * tvente_stock_service.qte),0),2) as PTCmup');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tvente_produit.designation', 'like', '%'.$query.'%')          
            ->orderBy("tvente_stock_service.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_stock_service.created_at", "desc");
        return $this->apiData($data->paginate(10));        
    }


    public function fetch_data_entete_service(Request $request,$refEntete)
    {
        $data = DB::table('tvente_stock_service')
        ->join('tvente_services','tvente_services.id','=','tvente_stock_service.refService')
        ->join('tvente_produit','tvente_produit.id','=','tvente_stock_service.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')  

        ->select('tvente_stock_service.id','tvente_stock_service.refService','tvente_stock_service.refProduit',
        'tvente_stock_service.uniteBase','tvente_stock_service.devise','unitePivot','qtePivot',
        'tvente_stock_service.taux','tvente_stock_service.active','tvente_stock_service.refUser',
        'tvente_stock_service.author' ,"tvente_services.nom_service","stock_alerte"  
        
        ,"tvente_produit.designation as designation",'refCategorie','refUniteBase','Oldcode',
        'Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie"
        )
        ->selectRaw('IFNULL(tvente_stock_service.qte,0) as qte')
        ->selectRaw('ROUND(tvente_stock_service.pu,2) as pu')
        ->selectRaw('ROUND(tvente_stock_service.cmup,2) as cmup')
        ->selectRaw('ROUND(IFNULL((tvente_stock_service.cmup * tvente_stock_service.qte),0),2) as PTCmup')
        ->Where('refService',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('tvente_produit.designation', 'like', '%'.$query.'%')          
            ->orderBy("tvente_stock_service.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_stock_service.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }  
    
    function fetch_data_stock_service_filter(Request $request)
    {
        if (($request->get('refProduit')) && ($request->get('refService'))) 
        {
          
            $data = DB::table('tvente_stock_service')
            ->join('tvente_services','tvente_services.id','=','tvente_stock_service.refService')
            ->join('tvente_produit','tvente_produit.id','=','tvente_stock_service.refProduit')
            ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')  
    
            ->select('tvente_stock_service.id','tvente_stock_service.refService','tvente_stock_service.refProduit',
            'tvente_stock_service.uniteBase','tvente_stock_service.devise','unitePivot','qtePivot',
            'tvente_stock_service.taux','tvente_stock_service.active','tvente_stock_service.refUser',
            'tvente_stock_service.author' ,"tvente_services.nom_service","stock_alerte"  
            
            ,"tvente_produit.designation as designation",'refCategorie','refUniteBase','Oldcode',
            'Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie"
            )
            ->selectRaw('IFNULL(tvente_stock_service.qte,0) as qte')
            ->selectRaw('ROUND(tvente_stock_service.pu,4) as pu')
            ->selectRaw('ROUND(tvente_stock_service.cmup,4) as cmup')
            ->selectRaw('ROUND(IFNULL((tvente_stock_service.cmup * tvente_stock_service.qte),0),4) as PTCmup')
            ->where([               
                ['tvente_stock_service.refProduit','=', $request->refProduit],
                ['tvente_stock_service.refService','=', $request->refService]
            ])     
            ->get();               
        
            return response()->json([
                'data'  => $data,
            ]);
                       
        }
        else{

        }       
    }


    public function fetch_data_entete_produit(Request $request,$refEntete)
    {
        $data = DB::table('tvente_stock_service')
        ->join('tvente_services','tvente_services.id','=','tvente_stock_service.refService')
        ->join('tvente_produit','tvente_produit.id','=','tvente_stock_service.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')  

        ->select('tvente_stock_service.id','tvente_stock_service.refService','tvente_stock_service.refProduit',
        'tvente_stock_service.uniteBase','tvente_stock_service.devise','unitePivot','qtePivot',
        'tvente_stock_service.taux','tvente_stock_service.active','tvente_stock_service.refUser',
        'tvente_stock_service.author' ,"tvente_services.nom_service","stock_alerte"  
        
        ,"tvente_produit.designation as designation",'refCategorie','refUniteBase','Oldcode',
        'Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie"
        )
        ->selectRaw('IFNULL(tvente_stock_service.qte,0) as qte')
        ->selectRaw('ROUND(tvente_stock_service.pu,2) as pu')
        ->selectRaw('ROUND(tvente_stock_service.cmup,2) as cmup')
        ->selectRaw('ROUND(IFNULL((tvente_stock_service.cmup * tvente_stock_service.qte),0),2) as PTCmup')
        ->Where('refProduit',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('tvente_services.nom_service', 'like', '%'.$query.'%')          
            ->orderBy("tvente_stock_service.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_stock_service.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }   


    function fetch_single_data($id)
    {

        $data = DB::table('tvente_stock_service')
        ->join('tvente_services','tvente_services.id','=','tvente_stock_service.refService')
        ->join('tvente_produit','tvente_produit.id','=','tvente_stock_service.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
        ->select('tvente_stock_service.id','tvente_stock_service.refService','tvente_stock_service.refProduit',
        'tvente_stock_service.uniteBase','tvente_stock_service.devise','unitePivot','qtePivot',
        'tvente_stock_service.taux','tvente_stock_service.active','tvente_stock_service.refUser',
        'tvente_stock_service.author' ,"tvente_services.nom_service" ,"stock_alerte"        
        ,"tvente_produit.designation as designation",'refCategorie','refUniteBase','Oldcode',
        'Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie")
        ->selectRaw('IFNULL(tvente_stock_service.qte,0) as qte')
        ->selectRaw('ROUND(tvente_stock_service.pu,2) as pu')
        ->selectRaw('ROUND(tvente_stock_service.cmup,2) as cmup')
        ->selectRaw('ROUND(IFNULL((tvente_stock_service.cmup * tvente_stock_service.qte),0),2) as PTCmup')
        ->where('tvente_stock_service.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }



    function fetch_stock_data_byservice($refService)
    {
 
        $data = DB::table('tvente_stock_service')
        ->join('tvente_services','tvente_services.id','=','tvente_stock_service.refService')
        ->join('tvente_produit','tvente_produit.id','=','tvente_stock_service.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
        ->select('tvente_stock_service.id','tvente_stock_service.refService','tvente_stock_service.refProduit',
        'tvente_stock_service.uniteBase','tvente_stock_service.devise','unitePivot','qtePivot',
        'tvente_stock_service.taux','tvente_stock_service.active','tvente_stock_service.refUser',
        'tvente_stock_service.author' ,"tvente_services.nom_service","stock_alerte"         
        ,"tvente_produit.designation as designation",'refCategorie','refUniteBase','Oldcode',
        'Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie")
        ->selectRaw('IFNULL(tvente_stock_service.qte,0) as qte')
        ->selectRaw('ROUND(tvente_stock_service.pu,2) as pu')
        ->selectRaw('ROUND(tvente_stock_service.cmup,2) as cmup')
        ->selectRaw('ROUND(IFNULL((tvente_stock_service.cmup * tvente_stock_service.qte),0),2) as PTCmup')
        ->where('tvente_stock_service.refService', $refService)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function getStockFinal($idService)
    {
        $data_return = []; 
        $date1 = Carbon::now();
        $data11 = DB::table('tvente_stock_service')
        ->join('tvente_services', 'tvente_services.id', '=', 'tvente_stock_service.refService')
        ->Join('tvente_produit', 'tvente_produit.id', '=', 'tvente_stock_service.refProduit')
        ->Join('tvente_categorie_produit', 'tvente_categorie_produit.id', '=', 'tvente_produit.refCategorie')

        ->leftJoin('tvente_detail_transfert as dtSortie', function ($join) use ($date1, $idService) {
            $join->on('dtSortie.idStockService', '=', 'tvente_stock_service.id')
            ->join('tvente_entete_transfert as dtEnteteTransSortie', 'dtEnteteTransSortie.id', '=', 'dtSortie.refEnteteTransfert')
                //  ->where('dtEnteteTransSortie.refService', '=', $idService)
                ->where('dtEnteteTransSortie.date_transfert', '<', $date1);
        })
        // Utilisez distinct() avant select()
        ->distinct()
        ->select(
            "tvente_stock_service.id",
            'tvente_stock_service.refService',
            'tvente_stock_service.refProduit',
            "tvente_produit.designation as designation",
            "refCategorie",
            "tvente_stock_service.pu",
            "tvente_categorie_produit.designation as Categorie",
            "tvente_stock_service.qte",
            "tvente_stock_service.uniteBase",
            "tvente_stock_service.cmup",
            DB::raw('IFNULL(ROUND(SUM(dtSortie.qteBase * dtSortie.qteTransfert), 0), 0) as totalSortie')
        )
        ->where([
            ['tvente_stock_service.refService', '=', $idService]
        ])
        ->groupBy("tvente_stock_service.id", "tvente_stock_service.refService", "tvente_stock_service.refProduit", "designation", "refCategorie", "pu", "Categorie", "qte", "uniteBase","cmup")
        ->orderBy("tvente_produit.designation", "asc")
        ->get();


        // Récupérer les données de stock, mouvements et ventes en une seule requête 
        $data22 = DB::table('tvente_stock_service')
            ->join('tvente_services', 'tvente_services.id', '=', 'tvente_stock_service.refService')
            ->Join('tvente_produit', 'tvente_produit.id', '=', 'tvente_stock_service.refProduit')
            ->Join('tvente_categorie_produit', 'tvente_categorie_produit.id', '=', 'tvente_produit.refCategorie')

            ->leftJoin('tvente_detail_transfert as mvtSortie', function ($join) use ($date1, $idService) {
                $join->on('mvtSortie.idStockService', '=', 'tvente_stock_service.id')
                ->join('tvente_entete_transfert as mvtEnteteTransSortie', 'mvtEnteteTransSortie.id', '=', 'mvtSortie.refEnteteTransfert')
                    //  ->where('mvtEnteteTransSortie.refService', '=', $idService)
                    ->whereBetween('mvtEnteteTransSortie.date_transfert', [$date1, $date1]);
            })

            // Utilisez distinct() avant select()
            ->distinct()
            ->select(
                "tvente_stock_service.id",
                'tvente_stock_service.refService',
                'tvente_stock_service.refProduit',
                "tvente_produit.designation as designation",
                "refCategorie",
                "tvente_stock_service.pu",
                "tvente_categorie_produit.designation as Categorie",
                "tvente_stock_service.qte",
                "tvente_stock_service.uniteBase",
                "tvente_stock_service.cmup","tvente_stock_service.devise","tvente_stock_service.taux",            
                DB::raw('IFNULL(ROUND(SUM(mvtSortie.qteBase * mvtSortie.qteTransfert), 0), 0) as stockSortie'),

            )
            ->where([
                ['tvente_stock_service.refService', '=', $idService]
            ])
            ->groupBy("tvente_stock_service.id", "tvente_stock_service.refService", "tvente_stock_service.refProduit", 
            "designation", "refCategorie", "pu", "Categorie", "qte", "uniteBase","cmup",
            "tvente_stock_service.devise","tvente_stock_service.taux")
            ->orderBy("tvente_produit.designation", "asc")
            ->get();

        // Construction de l'output


        $data111 = DB::table('tvente_stock_service')
        ->join('tvente_services', 'tvente_services.id', '=', 'tvente_stock_service.refService')
        ->Join('tvente_produit', 'tvente_produit.id', '=', 'tvente_stock_service.refProduit')
        ->Join('tvente_categorie_produit', 'tvente_categorie_produit.id', '=', 'tvente_produit.refCategorie')

        ->leftJoin('tvente_detail_transfert as dtEntree', function ($join) use ($date1, $idService) {
            $join->on('dtEntree.refProduit', '=', 'tvente_produit.id')
            ->join('tvente_entete_transfert as dtEnteteTransEntree', 'dtEnteteTransEntree.id', '=', 'dtEntree.refEnteteTransfert')
                ->where('dtEntree.refDestination', '=', $idService)
                ->where('dtEnteteTransEntree.date_transfert', '<', $date1);
        })       
        // Utilisez distinct() avant select()
        ->distinct()
        ->select(
            "tvente_stock_service.id",
            'tvente_stock_service.refService',
            'tvente_stock_service.refProduit',
            "tvente_produit.designation as designation",
            "refCategorie",
            "tvente_stock_service.pu",
            "tvente_categorie_produit.designation as Categorie",
            "tvente_stock_service.qte",
            "tvente_stock_service.uniteBase",
            "tvente_stock_service.cmup",
            DB::raw('IFNULL(ROUND(SUM(dtEntree.qteBase * dtEntree.qteTransfert), 0), 0) as totalEntree')        
        )
        ->where([
            ['tvente_stock_service.refService', '=', $idService]
        ])
        ->groupBy("tvente_stock_service.id", "tvente_stock_service.refService", "tvente_stock_service.refProduit", "designation", "refCategorie", "pu", "Categorie", "qte", "uniteBase","cmup")
        ->orderBy("tvente_produit.designation", "asc")
        ->get();





            // Récupérer les données de stock, mouvements et ventes en une seule requête
            $data222 = DB::table('tvente_stock_service')
            ->join('tvente_services', 'tvente_services.id', '=', 'tvente_stock_service.refService')
            ->Join('tvente_produit', 'tvente_produit.id', '=', 'tvente_stock_service.refProduit')
            ->Join('tvente_categorie_produit', 'tvente_categorie_produit.id', '=', 'tvente_produit.refCategorie')

            ->leftJoin('tvente_detail_transfert as mvtEntree', function ($join) use ($date1, $idService) {
                $join->on('mvtEntree.refProduit', '=', 'tvente_produit.id')
                ->join('tvente_entete_transfert as mvtEnteteTransEntree', 'mvtEnteteTransEntree.id', '=', 'mvtEntree.refEnteteTransfert')
                    ->where('mvtEntree.refDestination', '=', $idService)
                    ->whereBetween('mvtEnteteTransEntree.date_transfert', [$date1, $date1]);
            })

            // Utilisez distinct() avant select()
            ->distinct()
            ->select(
                "tvente_stock_service.id",
                'tvente_stock_service.refService',
                'tvente_stock_service.refProduit',
                "tvente_produit.designation as designation",
                "refCategorie",
                "tvente_stock_service.pu",
                "tvente_categorie_produit.designation as Categorie",
                "tvente_stock_service.qte",
                "tvente_stock_service.uniteBase",
                "tvente_stock_service.cmup","tvente_stock_service.devise","tvente_stock_service.taux",

                DB::raw('IFNULL(ROUND(SUM(mvtEntree.qteBase * mvtEntree.qteTransfert), 0), 0) as stockEntree')
            )
            ->where([
                ['tvente_stock_service.refService', '=', $idService]
            ])
            ->groupBy("tvente_stock_service.id", "tvente_stock_service.refService", "tvente_stock_service.refProduit", 
            "designation", "refCategorie", "pu", "Categorie", "qte", "uniteBase","cmup",
            "tvente_stock_service.devise","tvente_stock_service.taux")
            ->orderBy("tvente_produit.designation", "asc")
            ->get();

        // Construction de l'output



            // Récupérer les données de stock, mouvements et ventes en une seule requête
            $data1 = DB::table('tvente_stock_service')
            ->join('tvente_services', 'tvente_services.id', '=', 'tvente_stock_service.refService')
            ->Join('tvente_produit', 'tvente_produit.id', '=', 'tvente_stock_service.refProduit')
            ->Join('tvente_categorie_produit', 'tvente_categorie_produit.id', '=', 'tvente_produit.refCategorie')

            ->leftJoin('tvente_detail_entree as dtAppro', function ($join) use ($date1, $idService) {
                $join->on('dtAppro.refProduit', '=', 'tvente_produit.id')
                ->join('tvente_entete_entree as dtEnteteAppro', 'dtEnteteAppro.id', '=', 'dtAppro.refEnteteEntree')
                ->join('tvente_services as dtEnteteApproServ', 'dtEnteteApproServ.id', '=', 'dtEnteteAppro.refService')
                    ->where('dtEnteteAppro.refService', '=', $idService)
                    ->where('dtEnteteAppro.dateEntree', '<', $date1);
            })
            ->leftJoin('tvente_detail_vente as dtVente', function ($join) use ($date1, $idService) {
                $join->on('dtVente.refProduit', '=', 'tvente_produit.id')
                ->join('tvente_entete_vente as dtEnteteVente', 'dtEnteteVente.id', '=', 'dtVente.refEnteteVente')
                ->join('tvente_services as dtEnteteVenteServ', 'dtEnteteVenteServ.id', '=', 'dtEnteteVente.refService')
                    ->where('dtEnteteVente.refService', '=', $idService)
                    ->where('dtEnteteVente.dateVente', '<', $date1);
            })
            ->leftJoin('tvente_detail_utilisation as dtUtilisation', function ($join) use ($date1, $idService) {
                $join->on('dtUtilisation.refProduit', '=', 'tvente_produit.id')
                ->join('tvente_entete_utilisation as dtEnteteUse', 'dtEnteteUse.id', '=', 'dtUtilisation.refEnteteVente')
                ->join('tvente_services as dtEnteteUseServ', 'dtEnteteUseServ.id', '=', 'dtEnteteUse.refService')
                    ->where('dtEnteteUse.refService', '=', $idService)
                    ->where('dtEnteteUse.dateUse', '<', $date1);
            })        
            // Utilisez distinct() avant select()
            ->distinct()
            ->select(
                "tvente_stock_service.id",
                'tvente_stock_service.refService',
                'tvente_stock_service.refProduit',
                "tvente_produit.designation as designation",
                "refCategorie",
                "tvente_stock_service.pu",
                "tvente_categorie_produit.designation as Categorie",
                "tvente_stock_service.qte",
                "tvente_stock_service.uniteBase",
                "tvente_stock_service.cmup",

                DB::raw('IFNULL(ROUND(SUM(DISTINCT dtAppro.qteBase * dtAppro.qteEntree), 0), 0) as totalAppro'),
                DB::raw('IFNULL(ROUND(SUM(DISTINCT dtVente.qteBase * dtVente.qteVente), 0), 0) as totalVente'),
                DB::raw('IFNULL(ROUND(SUM(DISTINCT dtUtilisation.qteBase * dtUtilisation.qteVente), 0), 0) as totalUse')
            )
            ->where([
                ['tvente_stock_service.refService', '=', $idService]
            ])
            ->groupBy("tvente_stock_service.id", "tvente_stock_service.refService", "tvente_stock_service.refProduit", "designation", "refCategorie", "pu", "Categorie", "qte", "uniteBase","cmup")
            ->orderBy("tvente_produit.designation", "asc")
            ->get();

        // Construction de l'output

        // Récupérer les données de stock, mouvements et ventes en une seule requête
        $data2 = DB::table('tvente_stock_service')
            ->join('tvente_services', 'tvente_services.id', '=', 'tvente_stock_service.refService')
            ->Join('tvente_produit', 'tvente_produit.id', '=', 'tvente_stock_service.refProduit')
            ->Join('tvente_categorie_produit', 'tvente_categorie_produit.id', '=', 'tvente_produit.refCategorie')

        ->leftJoin('tvente_detail_entree as mvtAppro', function ($join) use ($date1, $idService) {
                $join->on('mvtAppro.refProduit', '=', 'tvente_produit.id')
                ->join('tvente_entete_entree as mvtEnteteAppro', 'mvtEnteteAppro.id', '=', 'mvtAppro.refEnteteEntree')
                // ->join('tvente_services as mvtEnteteApproServ', 'mvtEnteteApproServ.id', '=', 'mvtEnteteAppro.refService')
                    ->where('mvtEnteteAppro.refService', '=', $idService)
                    ->whereBetween('mvtEnteteAppro.dateEntree', [$date1, $date1]);
            })

            ->leftJoin('tvente_detail_vente as mvtVente', function ($join) use ($date1, $idService) {
                $join->on('mvtVente.idStockService', '=', 'tvente_stock_service.id')
                ->join('tvente_entete_vente as mvtEnteteVente', 'mvtEnteteVente.id', '=', 'mvtVente.refEnteteVente')  
                    ->where('mvtEnteteVente.refService', '=', $idService)               
                    ->whereBetween('mvtEnteteVente.dateVente', [$date1, $date1]);
            })
            ->leftJoin('tvente_detail_utilisation as mvtUtilisation', function ($join) use ($date1, $idService) {
                $join->on('mvtUtilisation.idStockService', '=', 'tvente_stock_service.id')
                ->join('tvente_entete_utilisation as mvtEnteteUse', 'mvtEnteteUse.id', '=', 'mvtUtilisation.refEnteteVente')
                // ->join('tvente_services as mvtEnteteUseServ', 'mvtEnteteUseServ.id', '=', 'mvtEnteteUse.refService')
                    ->where('mvtEnteteUse.refService', '=', $idService)
                    ->whereBetween('mvtEnteteUse.dateUse', [$date1, $date1]);
            })
            // Utilisez distinct() avant select()
            ->distinct()
            ->select(
                "tvente_stock_service.id",
                'tvente_stock_service.refService',
                'tvente_stock_service.refProduit',
                "tvente_produit.designation as designation",
                "refCategorie",
                "tvente_stock_service.pu",
                "tvente_categorie_produit.designation as Categorie",
                "tvente_stock_service.qte",
                "tvente_stock_service.uniteBase",
                "tvente_stock_service.cmup","tvente_stock_service.devise","tvente_stock_service.taux",  
                
                DB::raw('IFNULL(ROUND(SUM(DISTINCT mvtAppro.qteBase * mvtAppro.qteEntree), 0), 0) as stockAppro'),
                DB::raw('IFNULL(ROUND(SUM(DISTINCT mvtVente.qteBase * mvtVente.qteVente), 0), 0) as stockVente'),
                DB::raw('IFNULL(ROUND(SUM(DISTINCT mvtUtilisation.qteBase * mvtUtilisation.qteVente), 0), 0) as stockUse'),

                DB::raw('IFNULL(tvente_stock_service.cmup, 0) as puVente'),

            )
            ->where([
                ['tvente_stock_service.refService', '=', $idService]
            ])
            ->groupBy("tvente_stock_service.id", "tvente_stock_service.refService", "tvente_stock_service.refProduit", 
            "designation", "refCategorie", "pu", "Categorie", "qte", "uniteBase","cmup",
            "tvente_stock_service.devise","tvente_stock_service.taux")
            ->orderBy("tvente_produit.designation", "asc")
            ->get();

        // Construction de l'output
        
        $output = '';

        // Vérifiez que les deux tableaux ont la même longueur
        if ((count($data1) === count($data2)) && (count($data1) === count($data11)) 
        && ( count($data1) === count($data111)) && (count($data1) === count($data22)) 
        && (count($data1) === count($data222))) {
            for ($i = 0; $i < count($data1); $i++) {
                $row1 = $data1[$i];
                $row2 = $data2[$i];
                $row11 = $data11[$i];
                $row22 = $data22[$i];
                $row111 = $data111[$i];
                $row222 = $data222[$i];

                $totalSortie = floatval($row11->totalSortie);
                $totalEntree = floatval($row111->totalEntree);
                $totalVente = floatval($row1->totalVente);
                $totalAppro = floatval($row1->totalAppro);
                $totalUse = floatval($row1->totalUse);

                $stockSortie = floatval($row22->stockSortie);            
                $stockEntree = floatval($row222->stockEntree);
                $stockVente = floatval($row2->stockVente);
                $stockAppro = floatval($row2->stockAppro);
                $stockUse = floatval($row2->stockUse);

                $totalSI = ((floatval($totalEntree) + floatval($totalAppro)) - (floatval($totalSortie) + floatval($totalVente) + floatval($totalUse)));
                $totalGEntree = floatval($stockEntree) + floatval($stockAppro);
                $totalG = floatval($totalSI) + floatval($stockEntree) + floatval($stockAppro);
                $TGSortie = floatval($stockSortie) + floatval($stockVente) + floatval($stockUse);
                $totalSF = floatval($totalG) - floatval($stockSortie) - floatval($stockVente) - floatval($stockUse);
                $totalPT = floatval($totalSF) * floatval($row2->puVente);


                $data_return[] = [
                    'id' => $row1->id,                    
                    'designation' => $row1->designation,
                    'refProduit' => $row2->refProduit,
                    'Categorie' => $row1->Categorie,
                    'SI' => $totalSI,
                    'Entree' =>$totalGEntree,
                    'Total' => $totalG,
                    'Sortie' => $TGSortie,
                    'SF' => $totalSF,
                    'PU' => round($row2->puVente, 2),
                    'PT' => round($totalPT, 2),
                    'Unite' => $row1->uniteBase
                ]; 

        }
        } else {
            // Gérer le cas où les tableaux n'ont pas la même longueur
            echo 'Les tableaux ont pas la même longueur.';
        } 
        return response()->json($data_return);
    }



    function fetch_stock_data_byserviceAndCategorie(Request $request)   
    {

        if ($request->get('refService') && $request->get('refCategorie'))
        {
            $refService = $request->get('refService');;
            $refCategorie = $request->get('refCategorie');;

            $data = DB::table('tvente_stock_service')
            ->join('tvente_services','tvente_services.id','=','tvente_stock_service.refService')
            ->join('tvente_produit','tvente_produit.id','=','tvente_stock_service.refProduit')
            ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
            ->select('tvente_stock_service.id','tvente_stock_service.refService','tvente_stock_service.refProduit',
            'tvente_stock_service.uniteBase','tvente_stock_service.devise','unitePivot','qtePivot',
            'tvente_stock_service.taux','tvente_stock_service.active','tvente_stock_service.refUser',
            'tvente_stock_service.author' ,"tvente_services.nom_service","stock_alerte"         
            ,"tvente_produit.designation as designation",'refCategorie','refUniteBase','Oldcode',
            'Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie")
            ->selectRaw('IFNULL(tvente_stock_service.qte,0) as qte')
            ->selectRaw('ROUND(tvente_stock_service.pu,2) as pu')
            ->selectRaw('ROUND(tvente_stock_service.cmup,2) as cmup')
            ->selectRaw('ROUND(IFNULL((tvente_stock_service.cmup * tvente_stock_service.qte),0),2) as PTCmup')          
            ->where([
                ['tvente_produit.refCategorie','=', $refCategorie],
                ['tvente_stock_service.refService','=', $refService]
            ])
            ->get();
    
            return response()->json([
                'data'  => $data,
            ]);
        }
        else
        {

        } 

    }


   // 'id','refService','refProduit','pu','qte','cmup','devise','taux','active','refUser','author'

    function insert_data(Request $request)
    {

        $taux=0;
        $data5 =  DB::table("tvente_taux")
        ->select("tvente_taux.id", "tvente_taux.taux", 
        "tvente_taux.created_at", "tvente_taux.author")
         ->first(); 
         $output='';
         if ($data5) 
         {                                
            $taux=$data5->taux;                           
         }

         $uniteBase = '';
         $data6 =  DB::table("tvente_detail_unite")
         ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
        ->select('nom_unite')
        ->where([
            ['tvente_detail_unite.refProduit','=', $request->refProduit],
            ['tvente_detail_unite.estunite','=', 'OUI']
        ])
         ->first(); 
         if ($data6) 
         {                                
            $uniteBase=$data6->nom_unite;                           
         }
         else
         {
            $uniteBase='Pcs'; 
         }

         $unitePivot = '';
         $qtePivot = 0;
         $data7 =  DB::table("tvente_detail_unite")
         ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
        ->select('tvente_detail_unite.id','refProduit','refUnite','puUnite','qteUnite','puBase',
        'qteBase','estunite','estpivot','tvente_detail_unite.active','tvente_detail_unite.author',
        'tvente_detail_unite.refUser','nom_unite')
        ->where([
            ['tvente_detail_unite.refProduit','=', $request->refProduit],
            ['tvente_detail_unite.estpivot','=', 'OUI']
        ])
         ->first(); 
         if ($data7) 
         {                                
            $unitePivot=$data7->nom_unite; 
            $qtePivot=$data7->qteBase;                           
         }
         else
         {
            $unitePivot='Pcs'; 
            $qtePivot=1;
         }

        $data = tvente_stock_service::create([            
            'refService'       =>  $request->refService,    
            'refProduit'       =>  $request->refProduit,        
            'pu'       =>  $request->pu,
            'qte'    =>  $request->qte,
            'uniteBase'    =>  $uniteBase,
            'cmup'    =>  $request->cmup,
            'devise'    =>  $request->devise,
            'taux'    =>  $taux,
            'active'    =>  $request->active,
            'unitePivot'    =>  $unitePivot,
            'qtePivot'    =>  $qtePivot,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
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


         $uniteBase = '';
         $data6 =  DB::table("tvente_detail_unite")
         ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
        ->select('nom_unite')
        ->where([
            ['tvente_detail_unite.refProduit','=', $request->refProduit],
            ['tvente_detail_unite.estunite','=', 'OUI']
        ])
         ->first(); 
         if ($data6) 
         {                                
            $uniteBase=$data6->nom_unite;                           
         }
         else
         {
            $uniteBase='Pcs'; 
         }

         $unitePivot = '';
         $qtePivot = 0;
         $data7 =  DB::table("tvente_detail_unite")
         ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
        ->select('tvente_detail_unite.id','refProduit','refUnite','puUnite','qteUnite','puBase',
        'qteBase','estunite','estpivot','tvente_detail_unite.active','tvente_detail_unite.author',
        'tvente_detail_unite.refUser','nom_unite')
        ->where([
            ['tvente_detail_unite.refProduit','=', $request->refProduit],
            ['tvente_detail_unite.estpivot','=', 'OUI']
        ])
         ->first(); 
         if ($data7) 
         {                                
            $unitePivot=$data7->nom_unite; 
            $qtePivot=$data7->qteBase;                           
         }
         else
         {
            $unitePivot='Pqt'; 
            $qtePivot=1;
         }


        $data = tvente_stock_service::where('id', $id)->update([
            'refService'       =>  $request->refService,    
            'refProduit'       =>  $request->refProduit,        
            'pu'       =>  $request->pu,
            'qte'    =>  $request->qte,
            'uniteBase'    =>  $uniteBase,
            'cmup'    =>  $request->cmup,
            'devise'    =>  $request->devise,
            'taux'    =>  $taux,
            'unitePivot'    =>  $unitePivot,
            'qtePivot'    =>  $qtePivot,
            'active'    =>  $request->active,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = tvente_stock_service::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
