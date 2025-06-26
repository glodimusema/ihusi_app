<?php

namespace App\Http\Controllers\Gaz;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gaz\tgaz_stock_service_lot;
use App\Models\Facture;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;

class tgaz_stock_service_lotController extends Controller
{
    use GlobalMethod, Slug;

// 'id','refService','refLot','pu_lot','qte_lot','cmup_lot','devise','taux','active','refUser','author'
// tgaz_stock_service_lot

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

        $data = DB::table('tgaz_stock_service_lot')
        ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
        ->select('tgaz_stock_service_lot.id','tgaz_stock_service_lot.refService','tgaz_stock_service_lot.refLot',
        'tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot','tgaz_stock_service_lot.devise',
        'tgaz_stock_service_lot.taux','tgaz_stock_service_lot.active','tgaz_stock_service_lot.refUser',
        'tgaz_stock_service_lot.author' ,"tvente_services.nom_service","stock_alerte",
        "tgaz_stock_service_lot.created_at",'nom_lot','code_lot','unite_lot','stock_alerte')
         ->selectRaw('ROUND((qte_lot * cmup_lot),2) as PTcmup_lot');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tgaz_lot.nom_lot', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_stock_service_lot.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tgaz_stock_service_lot.created_at", "desc");
        return $this->apiData($data->paginate(10));        
    }


    public function fetch_data_entete_service(Request $request,$refEntete)
    {
        $data = DB::table('tgaz_stock_service_lot')
        ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
        ->select('tgaz_stock_service_lot.id','tgaz_stock_service_lot.refService','tgaz_stock_service_lot.refLot',
        'tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot','tgaz_stock_service_lot.devise',
        'tgaz_stock_service_lot.taux','tgaz_stock_service_lot.active','tgaz_stock_service_lot.refUser',
        'tgaz_stock_service_lot.author' ,"tvente_services.nom_service","stock_alerte",
        "tgaz_stock_service_lot.created_at",'nom_lot','code_lot','unite_lot')
        ->selectRaw('ROUND((qte_lot * cmup_lot),2) as PTcmup_lot')
        ->Where('refService',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('tgaz_lot.nom_lot', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_stock_service_lot.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tgaz_stock_service_lot.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }  
    
    function fetch_data_stock_service_filter(Request $request)
    {
        if (($request->get('refLot')) && ($request->get('refService'))) 
        {
          
            $data = DB::table('tgaz_stock_service_lot')
            ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
            ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
            ->select('tgaz_stock_service_lot.id','tgaz_stock_service_lot.refService','tgaz_stock_service_lot.refLot',
            'tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot','tgaz_stock_service_lot.devise',
            'tgaz_stock_service_lot.taux','tgaz_stock_service_lot.active','tgaz_stock_service_lot.refUser',
            'tgaz_stock_service_lot.author' ,"tvente_services.nom_service","stock_alerte",
            "tgaz_stock_service_lot.created_at",'nom_lot','code_lot','unite_lot','stock_alerte')
            ->selectRaw('ROUND((qte_lot * cmup_lot),2) as PTcmup_lot')
            ->where([               
                ['tgaz_stock_service_lot.refLot','=', $request->refLot],
                ['tgaz_stock_service_lot.refService','=', $request->refService]
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
        $data = DB::table('tgaz_stock_service_lot')
        ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
        ->select('tgaz_stock_service_lot.id','tgaz_stock_service_lot.refService','tgaz_stock_service_lot.refLot',
        'tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot','tgaz_stock_service_lot.devise',
        'tgaz_stock_service_lot.taux','tgaz_stock_service_lot.active','tgaz_stock_service_lot.refUser',
        'tgaz_stock_service_lot.author' ,"tvente_services.nom_service","stock_alerte",
        "tgaz_stock_service_lot.created_at"  
        
         ,'nom_lot','code_lot','unite_lot','stock_alerte')
         ->selectRaw('ROUND((qte_lot * cmup_lot),2) as PTcmup_lot')
        ->Where('refLot',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('tvente_services.nom_service', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_stock_service_lot.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tgaz_stock_service_lot.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }  

    function fetch_single_data($id)
    {

        $data = DB::table('tgaz_stock_service_lot')
        ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
        ->select('tgaz_stock_service_lot.id','tgaz_stock_service_lot.refService','tgaz_stock_service_lot.refLot',
        'tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot','tgaz_stock_service_lot.devise',
        'tgaz_stock_service_lot.taux','tgaz_stock_service_lot.active','tgaz_stock_service_lot.refUser',
        'tgaz_stock_service_lot.author' ,"tvente_services.nom_service","stock_alerte"  
        
         ,'nom_lot','code_lot','unite_lot','stock_alerte')
         ->selectRaw('ROUND((qte_lot * cmup_lot),2) as PTcmup_lot')
        ->where('tgaz_stock_service_lot.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_stock_data_byservice($refService)
    {
 
        $data = DB::table('tgaz_stock_service_lot')
        ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
        ->select('tgaz_stock_service_lot.id','tgaz_stock_service_lot.refService','tgaz_stock_service_lot.refLot',
        'tgaz_stock_service_lot.pu_lot','qte_lot','cmup_lot','tgaz_stock_service_lot.devise',
        'tgaz_stock_service_lot.taux','tgaz_stock_service_lot.active','tgaz_stock_service_lot.refUser',
        'tgaz_stock_service_lot.author' ,"tvente_services.nom_service","stock_alerte"
         ,'nom_lot','code_lot','unite_lot','stock_alerte')
         ->selectRaw('ROUND((qte_lot * cmup_lot),2) as PTcmup_lot')
        ->where('tgaz_stock_service_lot.refService', $refService)
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
        $data11 = DB::table('tgaz_stock_service_lot')
        ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')

        ->leftJoin('tgaz_mouvement_stock_service_lot as dtEntree', function ($join) use ($date1, $idService) {
            $join->on('dtEntree.idStockService', '=', 'tgaz_stock_service_lot.id')        
                ->where('dtEntree.type_mouvement', '=', 'Entree')
                ->where('dtEntree.dateMvt', '<', $date1);
        })

        // Utilisez distinct() avant select()
        ->distinct()
        ->select(
            "tgaz_stock_service_lot.id",
            'tgaz_stock_service_lot.refService',
            'tgaz_stock_service_lot.refLot',
            "tgaz_lot.nom_lot as nom_lot",
            "tgaz_stock_service_lot.pu_lot",
            "tgaz_stock_service_lot.qte_lot",
            "tgaz_lot.unite_lot",
            "tgaz_stock_service_lot.cmup_lot",
            "tgaz_stock_service_lot.devise",
            "tgaz_stock_service_lot.taux",            
            DB::raw('IFNULL(ROUND(SUM(dtEntree.qteMvt), 0), 0) as totalEntree'),

        )
        ->where([
            ['tgaz_stock_service_lot.refService', '=', $idService]
        ])
        ->groupBy("tgaz_stock_service_lot.id",
            'tgaz_stock_service_lot.refService',
            'tgaz_stock_service_lot.refLot',
            "tgaz_lot.nom_lot",
            "tgaz_stock_service_lot.pu_lot",
            "tgaz_stock_service_lot.qte_lot",
            "tgaz_lot.unite_lot",
            "tgaz_stock_service_lot.cmup_lot",
            "tgaz_stock_service_lot.devise",
            "tgaz_stock_service_lot.taux")
        ->orderBy("tgaz_lot.nom_lot", "asc")
        ->get();

    //======================================================================

        $data22 = DB::table('tgaz_stock_service_lot')
        ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')

        ->leftJoin('tgaz_mouvement_stock_service_lot as dtSortie', function ($join) use ($date1, $idService) {
            $join->on('dtSortie.idStockService', '=', 'tgaz_stock_service_lot.id')        
                ->where('dtSortie.type_mouvement', '=', 'Sortie')
                ->where('dtSortie.dateMvt', '<', $date1);
        })
        // Utilisez distinct() avant select()
        ->distinct()
        ->select(
            "tgaz_stock_service_lot.id",
            'tgaz_stock_service_lot.refService',
            'tgaz_stock_service_lot.refLot',
            "tgaz_lot.nom_lot as nom_lot",
            "tgaz_stock_service_lot.pu_lot",
            "tgaz_stock_service_lot.qte_lot",
            "tgaz_lot.unite_lot",
            "tgaz_stock_service_lot.cmup_lot",
            "tgaz_stock_service_lot.devise",
            "tgaz_stock_service_lot.taux", 
            DB::raw('IFNULL(ROUND(SUM(dtSortie.qteMvt), 0), 0) as totalSortie')
        )
        ->where([
            ['tgaz_stock_service_lot.refService', '=', $idService]
        ])
        ->groupBy("tgaz_stock_service_lot.id",
            'tgaz_stock_service_lot.refService',
            'tgaz_stock_service_lot.refLot',
            "tgaz_lot.nom_lot",
            "tgaz_stock_service_lot.pu_lot",
            "tgaz_stock_service_lot.qte_lot",
            "tgaz_lot.unite_lot",
            "tgaz_stock_service_lot.cmup_lot",
            "tgaz_stock_service_lot.devise",
            "tgaz_stock_service_lot.taux")
        ->orderBy("tgaz_lot.nom_lot", "asc")
        ->get();

    // ============ LEs Mouvements =========================================================================

        // Récupérer les données de stock, mouvements et ventes en une seule requête 
        $data1 = DB::table('tgaz_stock_service_lot')
        ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
    
        ->leftJoin('tgaz_mouvement_stock_service_lot as mvtEntree', function ($join) use ($date1, $idService) {
            $join->on('mvtEntree.idStockService', '=', 'tgaz_stock_service_lot.id')        
                 ->where('mvtEntree.type_mouvement', '=', 'Entree')
                 ->whereBetween('mvtEntree.dateMvt', [$date1, $date1]);
        })
    
            // Utilisez distinct() avant select()
            ->distinct()
            ->select(
                "tgaz_stock_service_lot.id",
                'tgaz_stock_service_lot.refService',
                'tgaz_stock_service_lot.refLot',
                "tgaz_lot.nom_lot as nom_lot",
                "tgaz_stock_service_lot.pu_lot",
                "tgaz_stock_service_lot.qte_lot",
                "tgaz_lot.unite_lot",
                "tgaz_stock_service_lot.cmup_lot",
                "tgaz_stock_service_lot.devise",
                "tgaz_stock_service_lot.taux",            
                DB::raw('IFNULL(ROUND(SUM(mvtEntree.qteMvt), 0), 0) as stockEntree'),
    
            )
            ->where([
                ['tgaz_stock_service_lot.refService', '=', $idService]
            ])
            ->groupBy("tgaz_stock_service_lot.id",
                'tgaz_stock_service_lot.refService',
                'tgaz_stock_service_lot.refLot',
                "tgaz_lot.nom_lot",
                "tgaz_stock_service_lot.pu_lot",
                "tgaz_stock_service_lot.qte_lot",
                "tgaz_lot.unite_lot",
                "tgaz_stock_service_lot.cmup_lot",
                "tgaz_stock_service_lot.devise",
                "tgaz_stock_service_lot.taux")
            ->orderBy("tgaz_lot.nom_lot", "asc")
            ->get();
    
    //======================================================================
    
        // Récupérer les données de stock, mouvements et ventes en une seule requête 
        $data2 = DB::table('tgaz_stock_service_lot')
        ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
    
        ->leftJoin('tgaz_mouvement_stock_service_lot as mvtSortie', function ($join) use ($date1, $idService) {
            $join->on('mvtSortie.idStockService', '=', 'tgaz_stock_service_lot.id')        
                 ->where('mvtSortie.type_mouvement', '=', 'Sortie')
                 ->whereBetween('mvtSortie.dateMvt', [$date1, $date1]);;
        })
    
            // Utilisez distinct() avant select()
            ->distinct()
            ->select(
                "tgaz_stock_service_lot.id",
                'tgaz_stock_service_lot.refService',
                'tgaz_stock_service_lot.refLot',
                "tgaz_lot.nom_lot as nom_lot",
                "tgaz_stock_service_lot.pu_lot",
                "tgaz_stock_service_lot.qte_lot",
                "tgaz_lot.unite_lot",
                "tgaz_stock_service_lot.cmup_lot",
                "tgaz_stock_service_lot.devise",
                "tgaz_stock_service_lot.taux",            
                DB::raw('IFNULL(ROUND(SUM(mvtSortie.qteMvt), 0), 0) as stockSortie'),
    
            )
            ->where([
                ['tgaz_stock_service_lot.refService', '=', $idService]
            ])
            ->groupBy("tgaz_stock_service_lot.id",
                'tgaz_stock_service_lot.refService',
                'tgaz_stock_service_lot.refLot',
                "tgaz_lot.nom_lot",
                "tgaz_stock_service_lot.pu_lot",
                "tgaz_stock_service_lot.qte_lot",
                "tgaz_lot.unite_lot",
                "tgaz_stock_service_lot.cmup_lot",
                "tgaz_stock_service_lot.devise",
                "tgaz_stock_service_lot.taux",)
            ->orderBy("tgaz_lot.nom_lot", "asc")
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
                    $totalPT = floatval($totalSF) * floatval($row2->cmup_lot);

                    $data_return[] = [
                        'id' => $row1->id,                    
                        'nom_lot' => $row1->nom_lot,
                        'SI' => $totalSI,
                        'Entree' =>$totalGEntree,
                        'Total' => $totalG,
                        'Sortie' => $TGSortie,
                        'SF' => $totalSF,
                        'PU' => round($row2->cmup_lot, 2),
                        'PT' => round($totalPT, 2),
                        'Unite' => $row1->unite_lot
                    ];  

            }
            } 
            else {
                // Gérer le cas où les tableaux n'ont pas la même longueur
                echo 'Les tableaux ont pas la même longueur.';
            }

        return response()->json($data_return);
    }


    function fetch_stock_data_gaz_byserviceAndCategorie(Request $request)   
    {

        if ($request->get('refService') && $request->get('refCategorie'))
        {
            $refService = $request->get('refService');
            $refCategorie = $request->get('refCategorie');

            $data = DB::table('tgaz_stock_service_lot')
            ->join('tvente_services','tvente_services.id','=','tgaz_stock_service_lot.refService')
            ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')
            ->join('tgaz_categorie_lot','tgaz_categorie_lot.id','=','tgaz_lot.refCategorieLot')
            ->select('tgaz_stock_service_lot.id','tgaz_stock_service_lot.refService',
            'tgaz_stock_service_lot.refLot','tgaz_stock_service_lot.devise',
            'tgaz_stock_service_lot.taux','tgaz_stock_service_lot.active',
            'tgaz_stock_service_lot.refUser','tgaz_stock_service_lot.author' ,
            "tvente_services.nom_service","stock_alerte","tgaz_stock_service_lot.created_at",
            'nom_lot','code_lot','unite_lot','refCategorieLot','nom_categorie_lot')
            ->selectRaw('IFNULL(tgaz_stock_service_lot.qte_lot,0) as qte')
            ->selectRaw('ROUND(tgaz_stock_service_lot.pu_lot,2) as pu')
            ->selectRaw('ROUND(tgaz_stock_service_lot.cmup_lot,2) as cmup')
            ->selectRaw('ROUND(IFNULL((tgaz_stock_service_lot.cmup_lot * tgaz_stock_service_lot.qte_lot),0),2) as PTCmup')          
            ->where([
                ['tgaz_lot.refCategorieLot','=', $refCategorie],
                ['tgaz_stock_service_lot.refService','=', $refService]
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


    function insert_data(Request $request)
    {

        $taux=0;
        $data5 =  DB::table("tvente_taux")
        ->select("tvente_taux.id", "tvente_taux.taux", 
        "tvente_taux.created_at", "tvente_taux.author")
         ->first(); 
         if ($data5) 
         {                                
            $taux=$data5->taux;                           
         }

        //  'id','refService','refLot','pu_lot','qte_lot','cmup_lot','devise','taux','active','refUser','author'

        $data = tgaz_stock_service_lot::create([            
            'refService'       =>  $request->refService,    
            'refLot'       =>  $request->refLot,        
            'pu_lot'       =>  $request->pu_lot,
            'qte_lot'    =>  $request->qte_lot,
            'cmup_lot'    =>  $request->cmup_lot,
            'devise'    =>  $request->devise,
            'taux'    =>  $taux,
            'active'    =>  $request->active,
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
         ->first(); 
         if ($data5) 
         {                                
            $taux=$data5->taux;                           
         }

        $data = tgaz_stock_service_lot::where('id', $id)->update([
            'refService'       =>  $request->refService,    
            'refLot'       =>  $request->refLot,        
            'pu_lot'       =>  $request->pu_lot,
            'qte_lot'    =>  $request->qte_lot,
            'cmup_lot'    =>  $request->cmup_lot,
            'devise'    =>  $request->devise,
            'taux'    =>  $taux,
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
        $data = tgaz_stock_service_lot::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
