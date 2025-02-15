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

            // Récupérer les données de stock, mouvements et ventes en une seule requête 
        $data11 = DB::table('tvente_stock_service')
        ->join('tvente_services', 'tvente_services.id', '=', 'tvente_stock_service.refService')
        ->Join('tvente_produit', 'tvente_produit.id', '=', 'tvente_stock_service.refProduit')
        ->Join('tvente_categorie_produit', 'tvente_categorie_produit.id', '=', 'tvente_produit.refCategorie')

        ->leftJoin('tvente_mouvement_stock as dtEntree', function ($join) use ($date1, $idService) {
            $join->on('dtEntree.idStockService', '=', 'tvente_stock_service.id')        
                ->where('dtEntree.type_mouvement', '=', 'Entree')
                ->where('dtEntree.dateMvt', '<', $date1);
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
            DB::raw('IFNULL(ROUND(SUM(dtEntree.qteBase * dtEntree.qteMvt), 0), 0) as totalEntree'),

        )
        ->where([
            ['tvente_stock_service.refService', '=', $idService]
        ])
        ->groupBy("tvente_stock_service.id", "tvente_stock_service.refService", "tvente_stock_service.refProduit", 
        "designation", "refCategorie", "pu", "Categorie", "qte", "uniteBase","cmup",
        "tvente_stock_service.devise","tvente_stock_service.taux")
        ->orderBy("tvente_produit.designation", "asc")
        ->get();

    //======================================================================

        $data22 = DB::table('tvente_stock_service')
        ->join('tvente_services', 'tvente_services.id', '=', 'tvente_stock_service.refService')
        ->Join('tvente_produit', 'tvente_produit.id', '=', 'tvente_stock_service.refProduit')
        ->Join('tvente_categorie_produit', 'tvente_categorie_produit.id', '=', 'tvente_produit.refCategorie')

        ->leftJoin('tvente_mouvement_stock as dtSortie', function ($join) use ($date1, $idService) {
            $join->on('dtSortie.idStockService', '=', 'tvente_stock_service.id')        
                ->where('dtSortie.type_mouvement', '=', 'Sortie')
                ->where('dtSortie.dateMvt', '<', $date1);
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
            DB::raw('IFNULL(ROUND(SUM(dtSortie.qteBase * dtSortie.qteMvt), 0), 0) as totalSortie')
        )
        ->where([
            ['tvente_stock_service.refService', '=', $idService]
        ])
        ->groupBy("tvente_stock_service.id", "tvente_stock_service.refService", "tvente_stock_service.refProduit", "designation", "refCategorie", "pu", "Categorie", "qte", "uniteBase","cmup")
        ->orderBy("tvente_produit.designation", "asc")
        ->get();

    // ============ LEs Mouvements =========================================================================

        // Récupérer les données de stock, mouvements et ventes en une seule requête 
        $data1 = DB::table('tvente_stock_service')
        ->join('tvente_services', 'tvente_services.id', '=', 'tvente_stock_service.refService')
        ->Join('tvente_produit', 'tvente_produit.id', '=', 'tvente_stock_service.refProduit')
        ->Join('tvente_categorie_produit', 'tvente_categorie_produit.id', '=', 'tvente_produit.refCategorie')
    
        ->leftJoin('tvente_mouvement_stock as mvtEntree', function ($join) use ($date1, $idService) {
            $join->on('mvtEntree.idStockService', '=', 'tvente_stock_service.id')        
                 ->where('mvtEntree.type_mouvement', '=', 'Entree')
                 ->whereBetween('mvtEntree.dateMvt', [$date1, $date1]);
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
                DB::raw('IFNULL(ROUND(SUM(mvtEntree.qteBase * mvtEntree.qteMvt), 0), 0) as stockEntree'),
    
            )
            ->where([
                ['tvente_stock_service.refService', '=', $idService]
            ])
            ->groupBy("tvente_stock_service.id", "tvente_stock_service.refService", "tvente_stock_service.refProduit", 
            "designation", "refCategorie", "pu", "Categorie", "qte", "uniteBase","cmup",
            "tvente_stock_service.devise","tvente_stock_service.taux")
            ->orderBy("tvente_produit.designation", "asc")
            ->get();
    
    //======================================================================
    
        // Récupérer les données de stock, mouvements et ventes en une seule requête 
        $data2 = DB::table('tvente_stock_service')
        ->join('tvente_services', 'tvente_services.id', '=', 'tvente_stock_service.refService')
        ->Join('tvente_produit', 'tvente_produit.id', '=', 'tvente_stock_service.refProduit')
        ->Join('tvente_categorie_produit', 'tvente_categorie_produit.id', '=', 'tvente_produit.refCategorie')
    
        ->leftJoin('tvente_mouvement_stock as mvtSortie', function ($join) use ($date1, $idService) {
            $join->on('mvtSortie.idStockService', '=', 'tvente_stock_service.id')        
                 ->where('mvtSortie.type_mouvement', '=', 'Sortie')
                 ->whereBetween('mvtSortie.dateMvt', [$date1, $date1]);;
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
                DB::raw('IFNULL(ROUND(SUM(mvtSortie.qteBase * mvtSortie.qteMvt), 0), 0) as stockSortie'),
    
            )
            ->where([
                ['tvente_stock_service.refService', '=', $idService]
            ])
            ->groupBy("tvente_stock_service.id", "tvente_stock_service.refService", "tvente_stock_service.refProduit", 
            "designation", "refCategorie", "pu", "Categorie", "qte", "uniteBase","cmup",
            "tvente_stock_service.devise","tvente_stock_service.taux")
            ->orderBy("tvente_produit.designation", "asc")
            ->get();
 
            // Vérifiez que les deux tableaux ont la même longueur
            if ((count($data1) === count($data2)) && (count($data1) === count($data11)) 
            && (count($data1) === count($data22)))
            {
                for ($i = 0; $i < count($data1); $i++) {
                    $row11 = $data11[$i];
                    $row22 = $data22[$i];
                    $row1 = $data1[$i];
                    $row2 = $data2[$i];            

                    $totalSortie = floatval($row22->totalSortie);
                    $totalEntree = floatval($row11->totalEntree);

                    $stockSortie = floatval($row2->stockSortie);            
                    $stockEntree = floatval($row1->stockEntree);

                    $totalSI = ((floatval($totalEntree)) - (floatval($totalSortie)));
                    $totalGEntree = floatval($stockEntree);
                    $totalG = floatval($totalSI) + floatval($stockEntree);
                    $TGSortie = floatval($stockSortie);
                    $totalSF = floatval($totalG) - floatval($stockSortie);
                    $totalPT = floatval($totalSF) * floatval($row2->cmup);

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
                        'PU' => round($row2->cmup, 2),
                        'PT' => round($totalPT, 2),
                        'Unite' => $row1->uniteBase
                    ];  

            }
            } 
            else {
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
