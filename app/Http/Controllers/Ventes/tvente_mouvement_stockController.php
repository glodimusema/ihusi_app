<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_mouvement_stock;
use App\Models\Ventes\tvente_entete_utilisation;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tvente_mouvement_stockController extends Controller
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
        $data = DB::table('tvente_mouvement_stock')
        ->join('tvente_stock_service','tvente_stock_service.id','=','tvente_mouvement_stock.idStockService')
        ->join('tvente_produit','tvente_produit.id','=','tvente_stock_service.refProduit')
        ->join('tvente_services','tvente_services.id','=','tvente_stock_service.refService')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 

        ->select('tvente_mouvement_stock.id','idStockService','tvente_categorie_produit.compte_vente',
        'tvente_categorie_produit.compte_variationstock','tvente_categorie_produit.compte_perte',
        'tvente_categorie_produit.compte_produit','tvente_categorie_produit.compte_destockage',
        'tvente_categorie_produit.compte_achat','tvente_categorie_produit.compte_stockage','dateMvt','type_mouvement',
        'libelle_mouvement','nom_table','id_data','puMvt','qteMvt','uniteMvt','puBase','qteBase','tvente_mouvement_stock.uniteBase',
        'cmupMvt','tvente_mouvement_stock.devise','tvente_mouvement_stock.taux','tvente_mouvement_stock.author',
        'tvente_mouvement_stock.refUser','tvente_mouvement_stock.created_at',

        'tvente_produit.designation','tvente_produit.refCategorie','tvente_produit.refUniteBase',
        'tvente_produit.Oldcode','tvente_produit.Newcode','tvente_produit.tvaapplique',
        'tvente_produit.estvendable',  

        'nom_service','tvente_stock_service.refService','tvente_stock_service.refProduit',
        'tvente_stock_service.pu','tvente_stock_service.qte',
        'tvente_stock_service.cmup','tvente_stock_service.active')
       ->selectRaw('ROUND(((qteMvt*puMvt)),2) as PTMvt')
       ->selectRaw('ROUND(((qteMvt*puMvt)),2) as PTMvtTTC')
       ->selectRaw('(qteBase*puBase) as PTBase');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tvente_produit.designation', 'like', '%'.$query.'%')          
            ->orderBy("tvente_mouvement_stock.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_mouvement_stock.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }

    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tvente_mouvement_stock')
        ->join('tvente_stock_service','tvente_stock_service.id','=','tvente_mouvement_stock.idStockService')
        ->join('tvente_produit','tvente_produit.id','=','tvente_stock_service.refProduit')
        ->join('tvente_services','tvente_services.id','=','tvente_stock_service.refService')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 

        ->select('tvente_mouvement_stock.id','idStockService','tvente_categorie_produit.compte_vente',
        'tvente_categorie_produit.compte_variationstock','tvente_categorie_produit.compte_perte',
        'tvente_categorie_produit.compte_produit','tvente_categorie_produit.compte_destockage',
        'tvente_categorie_produit.compte_achat','tvente_categorie_produit.compte_stockage','dateMvt','type_mouvement',
        'libelle_mouvement','nom_table','id_data','puMvt','qteMvt','uniteMvt','puBase','qteBase','tvente_mouvement_stock.uniteBase',
        'cmupMvt','tvente_mouvement_stock.devise','tvente_mouvement_stock.taux','tvente_mouvement_stock.author',
        'tvente_mouvement_stock.refUser','tvente_mouvement_stock.created_at',

        'tvente_produit.designation','tvente_produit.refCategorie','tvente_produit.refUniteBase',
        'tvente_produit.Oldcode','tvente_produit.Newcode','tvente_produit.tvaapplique',
        'tvente_produit.estvendable',  

        'nom_service','tvente_stock_service.refService','tvente_stock_service.refProduit',
        'tvente_stock_service.pu','tvente_stock_service.qte',
        'tvente_stock_service.cmup','tvente_stock_service.active')
        ->selectRaw('ROUND(((qteMvt*puMvt)),2) as PTMvt')
       ->selectRaw('ROUND(((qteMvt*puMvt)),2) as PTMvtTTC')
       ->selectRaw('(qteBase*puBase) as PTBase')
       ->Where('tvente_mouvement_stock.idStockService',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('tvente_produit.designation', 'like', '%'.$query.'%')          
            ->orderBy("tvente_mouvement_stock.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_mouvement_stock.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }  

    function fetch_single_data($id)
    {
        $data = DB::table('tvente_mouvement_stock')
        ->join('tvente_stock_service','tvente_stock_service.id','=','tvente_mouvement_stock.idStockService')
        ->join('tvente_produit','tvente_produit.id','=','tvente_stock_service.refProduit')
        ->join('tvente_services','tvente_services.id','=','tvente_stock_service.refService')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 

        ->select('tvente_mouvement_stock.id','idStockService','tvente_categorie_produit.compte_vente',
        'tvente_categorie_produit.compte_variationstock','tvente_categorie_produit.compte_perte',
        'tvente_categorie_produit.compte_produit','tvente_categorie_produit.compte_destockage',
        'tvente_categorie_produit.compte_achat','tvente_categorie_produit.compte_stockage','dateMvt','type_mouvement',
        'libelle_mouvement','nom_table','id_data','puMvt','qteMvt','uniteMvt','puBase','qteBase','tvente_mouvement_stock.uniteBase',
        'cmupMvt','tvente_mouvement_stock.devise','tvente_mouvement_stock.taux','tvente_mouvement_stock.author',
        'tvente_mouvement_stock.refUser','tvente_mouvement_stock.created_at',

        'tvente_produit.designation','tvente_produit.refCategorie','tvente_produit.refUniteBase',
        'tvente_produit.Oldcode','tvente_produit.Newcode','tvente_produit.tvaapplique',
        'tvente_produit.estvendable',  

        'nom_service','tvente_stock_service.refService','tvente_stock_service.refProduit',
        'tvente_stock_service.pu','tvente_stock_service.qte',
        'tvente_stock_service.cmup','tvente_stock_service.active')
        ->selectRaw('ROUND(((qteMvt*puMvt)),2) as PTMvt')
        ->selectRaw('ROUND(((qteMvt*puMvt)),2) as PTMvtTTC')
        ->selectRaw('(qteBase*puBase) as PTBase')
        ->where('tvente_mouvement_stock.id', $id)
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

        
        $devises='USD';
        $montants=0;
        $refProduit=0;
        $data99=DB::table('tvente_stock_service') 
        ->select('id','refService','refProduit','pu','qte','uniteBase','cmup',
        'devise','taux','active','refUser','author')
        ->where([
           ['tvente_stock_service.id','=', $request->idStockService]
        ])      
        ->get();
        foreach ($data99 as $row) 
        {
            $refProduit =  $row->refProduit;
            $montants =  $row->cmup;           
        }


        $qte=$request->qteMvt;

        $compte_achat = 0;
        $compte_vente =0;
        $compte_variationstock=0;
        $compte_perte=0;
        $compte_produit=0;
        $compte_destockage=0;
        $compte_stockage=0;
        $cmupMvt=0;

        $data3=DB::table('tvente_produit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
         ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
         'compte_perte','compte_produit','compte_destockage','compte_stockage','cmup')
         ->where([
            ['tvente_produit.id','=', $refProduit]
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $compte_achat =  $row->compte_achat;
            $compte_vente = $row->compte_vente;
            $compte_variationstock= $row->compte_variationstock;
            $compte_perte= $row->compte_perte;
            $compte_produit= $row->compte_produit;
            $compte_destockage= $row->compte_destockage;
            $compte_stockage= $row->compte_stockage; 
            $cmupMvt=$row->cmup;         
        }


        $uniteMvt = '';
        $uniteBase = '';
        $puBase=0;
        $qteBase=0;
        $estunite='';

        $data4=DB::table('tvente_detail_unite')
        ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_unite.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
        ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
        'compte_perte','compte_produit','compte_destockage','compte_stockage','uniteBase','qteBase',
        'puBase','nom_unite','qteUnite','puUnite','estunite')
         ->where([
            ['tvente_detail_unite.id','=',  $request->refDetailUnite]
        ])      
        ->get();      
        
        foreach ($data4 as $row) 
        {
            $uniteMvt = $row->nom_unite;
            $puBase=$row->puBase;
            $qteBase=$row->qteBase;
            $uniteBase=$row->uniteBase;     
            $estunite = $row->estunite;
            $cmupMvt = $montants;             
        }


       $qteMvt = $qteBase * floatval($request->qteMvt);

       if($estunite = "OUI")
       {
          $puBase=  floatval($montants);
       }
       else
       {
          $puBase=  floatval($montants) / floatval($qteBase);
       }
       
       $montanttva=0;
       $pourtageTVA=0;
       $montantreduction = 0;

      $montanttva = (((floatval($request->qteMvt) * floatval($montants))*floatval($pourtageTVA))/100);

        $data = tvente_mouvement_stock::create([             
            'idStockService'    =>  $request->idStockService,             
            'dateMvt'    =>  $request->dateMvt,   
            'type_mouvement'    =>  $request->type_mouvement,
            'libelle_mouvement'    =>  $request->libelle_mouvement,
            'nom_table'    =>  $request->nom_table,
            'id_data'    =>  $request->id_data, 
            'qteMvt'    =>  $request->qteMvt,
            'puMvt'    =>  $request->puMvt,                   
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser,
            'type_sortie'    =>  $request->type_sortie,

            'active'    =>  $active,
            'uniteMvt'    =>  $uniteMvt,
            'compte_vente'    =>  $compte_vente,
            'compte_variationstock'    =>  $compte_variationstock,
            'compte_perte'    =>  $compte_perte,
            'compte_produit'    =>  $compte_produit,
            'compte_destockage'    =>  $compte_destockage,
            'compte_achat'    =>  $compte_achat,
            'compte_stockage'    =>  $compte_stockage,
            'puVente'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'puBase'    =>  $puBase,
            'qteBase'    =>  $qteBase,
            'uniteBase'    =>  $uniteBase,
            'cmupMvt'    =>  $cmupMvt
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

        
        $devises='USD';
        $montants=0;
        $refProduit=0;
        $data99=DB::table('tvente_stock_service') 
        ->select('id','refService','refProduit','pu','qte','uniteBase','cmup',
        'devise','taux','active','refUser','author')
        ->where([
           ['tvente_stock_service.id','=', $request->idStockService]
        ])      
        ->get();
        foreach ($data99 as $row) 
        {
            $refProduit =  $row->refProduit;
            $montants =  $row->cmup;           
        }


        $qte=$request->qteMvt;

        $compte_achat = 0;
        $compte_vente =0;
        $compte_variationstock=0;
        $compte_perte=0;
        $compte_produit=0;
        $compte_destockage=0;
        $compte_stockage=0;
        $cmupMvt=0;

        $data3=DB::table('tvente_produit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
         ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
         'compte_perte','compte_produit','compte_destockage','compte_stockage','cmup')
         ->where([
            ['tvente_produit.id','=', $refProduit]
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $compte_achat =  $row->compte_achat;
            $compte_vente = $row->compte_vente;
            $compte_variationstock= $row->compte_variationstock;
            $compte_perte= $row->compte_perte;
            $compte_produit= $row->compte_produit;
            $compte_destockage= $row->compte_destockage;
            $compte_stockage= $row->compte_stockage; 
            $cmupMvt=$row->cmup;         
        }


        $uniteMvt = '';
        $uniteBase = '';
        $puBase=0;
        $qteBase=0;
        $estunite='';

        $data4=DB::table('tvente_detail_unite')
        ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_unite.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
        ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
        'compte_perte','compte_produit','compte_destockage','compte_stockage','uniteBase','qteBase',
        'puBase','nom_unite','qteUnite','puUnite')
         ->where([
            ['tvente_detail_unite.id','=',  $request->refDetailUnite]
        ])      
        ->get();      
        
        foreach ($data4 as $row) 
        {
            $uniteMvt = $row->nom_unite;
            $puBase=$row->puBase;
            $qteBase=$row->qteBase;
            $uniteBase=$row->uniteBase;     
            $estunite = $row->estunite;
            $cmupMvt = $montants;             
        }


       $qteMvt = $qteBase * floatval($request->qteMvt);

       if($estunite = "OUI")
       {
          $puBase=  floatval($montants);
       }
       else
       {
          $puBase=  floatval($montants) / floatval($qteBase);
       }
       
       $montanttva=0;
       $pourtageTVA=0;
       $montantreduction = 0;
       
      $montanttva = (((floatval($request->qteMvt) * floatval($montants))*floatval($pourtageTVA))/100);

        $data = tvente_mouvement_stock::where('id', $id)->update([
            'idStockService'    =>  $request->idStockService,             
            'dateMvt'    =>  $request->dateMvt,   
            'type_mouvement'    =>  $request->type_mouvement,
            'libelle_mouvement'    =>  $request->libelle_mouvement,
            'nom_table'    =>  $request->nom_table,
            'id_data'    =>  $request->id_data, 
            'qteMvt'    =>  $request->qteMvt,
            'puMvt'    =>  $request->puMvt,                   
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser,
            'type_sortie'    =>  $request->type_sortie,

            'active'    =>  $active,
            'uniteMvt'    =>  $uniteMvt,
            'compte_vente'    =>  $compte_vente,
            'compte_variationstock'    =>  $compte_variationstock,
            'compte_perte'    =>  $compte_perte,
            'compte_produit'    =>  $compte_produit,
            'compte_destockage'    =>  $compte_destockage,
            'compte_achat'    =>  $compte_achat,
            'compte_stockage'    =>  $compte_stockage,
            'puVente'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'puBase'    =>  $puBase,
            'qteBase'    =>  $qteBase,
            'uniteBase'    =>  $uniteBase,
            'cmupMvt'    =>  $cmupMvt
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = tvente_mouvement_stock::where('id',$id)->delete();
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }






}
