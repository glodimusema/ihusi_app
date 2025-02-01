<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_detail_inventaire;
use App\Models\Ventes\tvente_entete_inventaire;
use App\Models\Ventes\tvente_paiement;
use App\Models\Ventes\tvente_entete_paievente;
use App\Models\Hotel\thotel_reservation_chambre;
use App\Models\Ventes\tvente_entete_entree;
use App\Models\Ventes\tvente_detail_entree;
use App\Models\Ventes\tvente_mouvement_stock;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tvente_detail_inventaireController extends Controller
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

        $data = DB::table('tvente_detail_inventaire')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_inventaire.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')

        ->join('tvente_entete_inventaire','tvente_entete_inventaire.id','=','tvente_detail_inventaire.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tvente_entete_inventaire.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_inventaire.refService')
        
        ->select('tvente_detail_inventaire.id','qteObs','refEnteteVente','refProduit','tvente_detail_inventaire.compte_vente',
        'tvente_detail_inventaire.compte_variationstock','tvente_detail_inventaire.compte_perte',
        'tvente_detail_inventaire.compte_produit','tvente_detail_inventaire.compte_destockage','puVente',
        'qteVente','uniteVente','puBase','qteBase','tvente_detail_inventaire.uniteBase','cmupVente',
        'tvente_detail_inventaire.devise','tvente_detail_inventaire.taux','montantreduction',
        'tvente_detail_inventaire.active','tvente_detail_inventaire.author','tvente_detail_inventaire.refUser',
        'tvente_detail_inventaire.created_at','idStockService',

        'tvente_produit.designation','tvente_produit.refCategorie','tvente_produit.refUniteBase',
        'tvente_produit.pu','tvente_produit.qte','tvente_produit.cmup','tvente_produit.taux',
        'tvente_produit.Oldcode','tvente_produit.Newcode','tvente_produit.tvaapplique',
        'tvente_produit.estvendable',

        'nom_service', "tvente_module.nom_module",'tvente_entete_inventaire.code','refService',
        'module_id','dateVente','libelle','priseencharge'
       )
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tvente_detail_inventaire.taux) as PTVenteFC')
       ->selectRaw('(qteBase*puBase) as PTBase');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('nom_service', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_inventaire.created_at", "asc");

            return $this->apiData($data->paginate(10));          

        }
        $data->orderBy("tvente_detail_inventaire.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }

    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tvente_detail_inventaire')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_inventaire.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')

        ->join('tvente_entete_inventaire','tvente_entete_inventaire.id','=','tvente_detail_inventaire.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tvente_entete_inventaire.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_inventaire.refService')
        
        ->select('tvente_detail_inventaire.id','qteObs','refEnteteVente','refProduit','tvente_detail_inventaire.compte_vente',
        'tvente_detail_inventaire.compte_variationstock','tvente_detail_inventaire.compte_perte',
        'tvente_detail_inventaire.compte_produit','tvente_detail_inventaire.compte_destockage','puVente',
        'qteVente','uniteVente','puBase','qteBase','tvente_detail_inventaire.uniteBase','cmupVente',
        'tvente_detail_inventaire.devise','tvente_detail_inventaire.taux','montantreduction',
        'tvente_detail_inventaire.active','tvente_detail_inventaire.author','tvente_detail_inventaire.refUser',
        'tvente_detail_inventaire.created_at','idStockService',

        'tvente_produit.designation','tvente_produit.refCategorie','tvente_produit.refUniteBase',
        'tvente_produit.pu','tvente_produit.qte','tvente_produit.cmup','tvente_produit.taux',
        'tvente_produit.Oldcode','tvente_produit.Newcode','tvente_produit.tvaapplique',
        'tvente_produit.estvendable',

        'nom_service', "tvente_module.nom_module",'tvente_entete_inventaire.code','refService',
        'module_id','dateVente','libelle','priseencharge'
       )
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tvente_detail_inventaire.taux) as PTVenteFC')
       ->selectRaw('(qteBase*puBase) as PTBase')
        ->Where('refEnteteVente',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('nom_service', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_inventaire.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_detail_inventaire.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }  

    function fetch_single_data($id)
    {
        $data= DB::table('tvente_detail_inventaire')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_inventaire.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')

        ->join('tvente_entete_inventaire','tvente_entete_inventaire.id','=','tvente_detail_inventaire.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tvente_entete_inventaire.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_inventaire.refService')
        
        ->select('tvente_detail_inventaire.id','refEnteteVente','refProduit','tvente_detail_inventaire.compte_vente',
        'tvente_detail_inventaire.compte_variationstock','tvente_detail_inventaire.compte_perte',
        'tvente_detail_inventaire.compte_produit','tvente_detail_inventaire.compte_destockage','puVente',
        'qteVente','qteObs','uniteVente','puBase','qteBase','tvente_detail_inventaire.uniteBase','cmupVente',
        'tvente_detail_inventaire.devise','tvente_detail_inventaire.taux','montantreduction',
        'tvente_detail_inventaire.active','tvente_detail_inventaire.author','tvente_detail_inventaire.refUser',
        'tvente_detail_inventaire.created_at','idStockService',

        'tvente_produit.designation','tvente_produit.refCategorie','tvente_produit.refUniteBase',
        'tvente_produit.pu','tvente_produit.qte','tvente_produit.cmup','tvente_produit.taux',
        'tvente_produit.Oldcode','tvente_produit.Newcode','tvente_produit.tvaapplique',
        'tvente_produit.estvendable',

        'nom_service', "tvente_module.nom_module",'tvente_entete_inventaire.code','refService',
        'module_id','dateVente','libelle','priseencharge'
       )
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tvente_detail_inventaire.taux) as PTVenteFC')
       ->selectRaw('(qteBase*puBase) as PTBase')
        ->where('tvente_detail_inventaire.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_detail_facture($id)
    {

        $data = DB::table('tvente_detail_inventaire')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_inventaire.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')

        ->join('tvente_entete_inventaire','tvente_entete_inventaire.id','=','tvente_detail_inventaire.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tvente_entete_inventaire.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_inventaire.refService')
        
        ->select('tvente_detail_inventaire.id','refEnteteVente','refProduit','tvente_detail_inventaire.compte_vente',
        'tvente_detail_inventaire.compte_variationstock','tvente_detail_inventaire.compte_perte',
        'tvente_detail_inventaire.compte_produit','tvente_detail_inventaire.compte_destockage','puVente',
        'qteVente','qteObs','uniteVente','puBase','qteBase','tvente_detail_inventaire.uniteBase','cmupVente',
        'tvente_detail_inventaire.devise','tvente_detail_inventaire.taux','montantreduction',
        'tvente_detail_inventaire.active','tvente_detail_inventaire.author','tvente_detail_inventaire.refUser',
        'tvente_detail_inventaire.created_at','idStockService',

        'tvente_produit.designation','tvente_produit.refCategorie','tvente_produit.refUniteBase',
        'tvente_produit.pu','tvente_produit.qte','tvente_produit.cmup','tvente_produit.taux',
        'tvente_produit.Oldcode','tvente_produit.Newcode','tvente_produit.tvaapplique',
        'tvente_produit.estvendable',

        'nom_service', "tvente_module.nom_module",'tvente_entete_inventaire.code','refService',
        'module_id','dateVente','libelle','priseencharge'
       )
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tvente_detail_inventaire.taux) as PTVenteFC')
       ->selectRaw('(qteBase*puBase) as PTBase')       
       ->Where('tvente_detail_inventaire.refEnteteVente',$id)               
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
            $montants = $row->cmup;          
        }

        $qte=$request->qteVente;
        $idDetail=$refProduit;
        $idFacture=$request->refEnteteVente;

        $compte_achat = 0;
        $compte_vente =0;
        $compte_variationstock=0;
        $compte_perte=0;
        $compte_produit=0;
        $compte_destockage=0;
        $compte_stockage=0;
        $cmupVente=0;

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
            $cmupVente=$row->cmup;         
        }

        $refService=0;        

        $data33=DB::table('tvente_entete_inventaire') 
         ->select('id','code','refService','module_id','dateVente','libelle','author','refUser')
         ->where([
            ['tvente_entete_inventaire.id','=', $request->refEnteteVente]
        ])      
        ->get();      
        $output='';
        foreach ($data33 as $row) 
        {
            $refService =  $row->refService;           
        }

        $uniteVente = '';
        $uniteBase = '';
        $puBase=0;
        $qteBase=0;
        $estunite='';
        $cmupVente = $montants;

        $data95=DB::table('tvente_detail_unite')
        ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_unite.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
        ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
        'compte_perte','compte_produit','compte_destockage','compte_stockage','qteUnite',
        'puUnite','uniteBase','nom_unite','estunite','qteBase','puBase','refUnite')
        ->where([
           ['tvente_detail_unite.id','=', $request->refDetailUnite]
        ])      
        ->get();
        foreach ($data95 as $row) 
        {
            $uniteVente = $row->nom_unite;
            $uniteBase = $row->uniteBase;           
            $qteBase =  $row->qteBase;
            $puBase = $row->puBase;      
            $estunite = $row->estunite;   
            $refUnite = $row->refUnite;   
        }


       $qteVente = $qteBase * floatval($request->qteVente);
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
      //$idStockService  qteObs
      $montanttva = (((floatval($request->qteVente) * floatval($montants))*floatval($pourtageTVA))/100);
      $montantreduction = 0;

        $data = tvente_detail_inventaire::create([
            'refEnteteVente'       =>  $request->refEnteteVente,
            'refProduit'    =>  $refProduit,
            'qteVente'    =>  $request->qteVente,
            'qteObs'    =>  $request->qteObs,
            'idStockService'    =>  $request->idStockService,                       
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser,

            'montantreduction'    =>  $montantreduction,
            'active'    =>  $active,
            'uniteVente'    =>  $uniteVente,
            'compte_vente'    =>  $compte_vente,
            'compte_variationstock'    =>  $compte_variationstock,
            'compte_perte'    =>  $compte_perte,
            'compte_produit'    =>  $compte_produit,
            'compte_destockage'    =>  $compte_destockage,
            'puVente'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'puBase'    =>  $puBase,
            'qteBase'    =>  $qteBase,
            'uniteBase'    =>  $uniteBase,
            'cmupVente'    =>  $cmupVente,
            'montanttva'    =>  $montanttva,
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

        $montants=0;
        $devises='';
        if($request->devise != 'USD')
        {
            $montants = ($request->puVente)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puVente;
            $devises = $request->devise;
        }



        $idFacture=0;
        $montant_last=0;
        $prixunitaire=$montants;
        $qteVente=$request->qteVente;

        $deleteds = DB::table('tvente_detail_inventaire')
        ->selectRaw('(qteVente*puVente) as prixTotal')
        ->Where('id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $idFacture = $deleted->refEnteteVente;
            $montant_last = $deleted->prixTotal;
        }

        $data3 = DB::update(
            'update tvente_entete_inventaire set montant = montant - (:montant_last) + (:prixunitaire * :qteVente) where id = :refEnteteVente',
            ['montant_last' => $montant_last,'prixunitaire' => $prixunitaire,'qteVente' => $qteVente,'refEnteteVente' => $idFacture]
        );

        $compte_achat = 0;
        $compte_vente =0;
        $compte_variationstock=0;
        $compte_perte=0;
        $compte_produit=0;
        $compte_destockage=0;
        $compte_stockage=0;

        $data3=DB::table('tvente_produit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
         ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
         'compte_perte','compte_produit','compte_destockage','compte_stockage')
         ->where([
            ['tvente_produit.id','=', $request->refProduit]
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
        }

        $data = tvente_detail_inventaire::where('id', $id)->update([
            'refEnteteVente'       =>  $request->refEnteteVente,
            'refProduit'    =>  $request->refProduit,
            'compte_vente'    =>  $compte_vente,
            'compte_variationstock'    =>  $compte_variationstock,
            'compte_perte'    =>  $compte_perte,
            'compte_produit'    =>  $compte_produit,
            'compte_destockage'    =>  $compte_destockage,
            'puVente'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'qteVente'    =>  $request->qteVente,
            'qteObs'    =>  $request->qteDisponible,
            'uniteVente'    =>  $request->uniteVente,
            'puBase'    =>  $request->puBase,
            'qteBase'    =>  $request->qteBase,
            'uniteBase'    =>  $request->uniteBase,
            'cmupVente'    =>  $request->cmupVente,
            'montanttva'    =>  $request->montanttva,
            'montantreduction'    =>  $request->montantreduction,
            'active'    =>  $request->active,
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser,
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = tvente_detail_inventaire::where('id',$id)->delete();

        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }



    function insert_dataGlobal(Request $request)
    {
        $id_module = 8;
        $active = "OUI";

        $code = $this->GetCodeData('tvente_param_systeme','module_id',$id_module);
        $data = tvente_entete_inventaire::create([
            'code'       =>  $code,            
            'refService'       =>  $request->refService, 
            'module_id'       =>  $id_module,
            'dateVente'    =>  $request->dateVente,
            'libelle'    =>  $request->libelle,            
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);

        $idmax=0;
        $maxid = DB::table('tvente_entete_inventaire')       
        ->selectRaw('MAX(tvente_entete_inventaire.id) as code_entete')
        ->where('tvente_entete_inventaire.refService', $request->refService)
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

         $refProduit=0;
         $data99=DB::table('tvente_stock_service') 
         ->select('id','refService','refProduit','pu','qte','uniteBase','cmup',
         'devise','taux','active','refUser','author')
         ->where([
            ['tvente_stock_service.id','=', $data['idStockService']]
         ])      
         ->get();
         foreach ($data99 as $row) 
         {
             $refProduit =  $row->refProduit; 
             $montants = $row->cmup;          
         }

         $qte=$data['qteVente'];
         $idDetail=$refProduit;
         $idFacture=$idmax;
 
         $compte_achat = 0;
         $compte_vente =0;
         $compte_variationstock=0;
         $compte_perte=0;
         $compte_produit=0;
         $compte_destockage=0;
         $compte_stockage=0;
         $cmupVente=0;
 
         $data3=DB::table('tvente_produit')
          ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
          ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
          'compte_perte','compte_produit','compte_destockage','compte_stockage','cmup')
          ->where([
             ['tvente_produit.id','=', $refProduit]
         ])      
         ->get();
         foreach ($data3 as $row) 
         {
             $compte_achat =  $row->compte_achat;
             $compte_vente = $row->compte_vente;
             $compte_variationstock= $row->compte_variationstock;
             $compte_perte= $row->compte_perte;
             $compte_produit= $row->compte_produit;
             $compte_destockage= $row->compte_destockage;
             $compte_stockage= $row->compte_stockage; 
             $cmupVente=$row->cmup;         
         }

         $uniteVente = '';
         $uniteBase = '';
         $puBase=0;
         $qteBase=0;
         $estunite='';
         $cmupVente = $montants;
         $refUnite = 0;

         $data95=DB::table('tvente_detail_unite')
         ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
         ->join('tvente_produit','tvente_produit.id','=','tvente_detail_unite.refProduit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
         ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
         'compte_perte','compte_produit','compte_destockage','compte_stockage','qteUnite',
         'puUnite','uniteBase','nom_unite','estunite','qteBase','puBase','refUnite')
         ->where([
            ['tvente_detail_unite.refProduit','=', $refProduit],
            ['tvente_detail_unite.estunite','=', 'OUI']
         ])      
         ->get();
         foreach ($data95 as $row) 
         {
             $uniteVente = $row->nom_unite;
             $uniteBase = $row->uniteBase;           
             $qteBase =  $row->qteBase;
             $puBase = $row->puBase;      
             $estunite = $row->estunite;   
             $refUnite = $row->refUnite;   
         } 
 
        $qteVente = $qteBase * floatval($data['qteVente']);
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



      //qteObs

         $montantreduction = 0;
         
         $montanttva = (((floatval($data['qteVente']) * floatval($montants))*floatval($pourtageTVA))/100);
    
            $data = tvente_detail_inventaire::create([
                'refEnteteVente'       =>  $idmax,
                'refProduit'    =>  $refProduit,
                'qteVente'    =>  $data['qteVente'],
                'qteObs'    =>  $data['qteDisponible'],
                'idStockService'    =>  $data['idStockService'],                     
                'author'       =>  $request->author,
                'refUser'    =>  $request->refUser,

                'montantreduction'    =>   $montantreduction,
                'active'    =>  $active,
                'uniteVente'    =>  $uniteVente,
                'compte_vente'    =>  $compte_vente,
                'compte_variationstock'    =>  $compte_variationstock,
                'compte_perte'    =>  $compte_perte,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                'puVente'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'puBase'    =>  $puBase,
                'qteBase'    =>  $qteBase,
                'uniteBase'    =>  $uniteBase,
                'cmupVente'    =>  $cmupVente,
                'montanttva'    =>  $montanttva,
            ]);

            $data2 = DB::update(
                'update tvente_stock_service set qte = :qteEntree where id = :idStockService',
                ['qteEntree' => $qteVente,'idStockService' => $data['idStockService']]
            );

            
        }        

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }

    function insert_dataGlobalInnitialise(Request $request)
    {
        $id_module = 8;
        $active = "OUI";

        $code = $this->GetCodeData('tvente_param_systeme','module_id',$id_module);
        $data200 = tvente_entete_inventaire::create([
            'code'       =>  $code,            
            'refService'       =>  $request->refService, 
            'module_id'       =>  $id_module,
            'dateVente'    =>  $request->dateVente,
            'libelle'    =>  $request->libelle,            
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);

        $idmax=0;
        $maxid = DB::table('tvente_entete_inventaire')       
        ->selectRaw('MAX(tvente_entete_inventaire.id) as code_entete')
        ->where('tvente_entete_inventaire.refService', $request->refService)
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_entete;
        }



        //=============================== APPROVISIONNEMENT ==========================================



        $id_fss=0;
        $data_fss=DB::table('tvente_fournisseur')     
        ->select('id')
        ->where([
        ['tvente_fournisseur.noms','=', 'SI']
        ])      
        ->first();
        if ($data_fss) 
        {
            $id_fss = $data_fss->id;
        }

        $id_moduless = 2;
        $actives = "OUI";

        $codes = $this->GetCodeData('tvente_param_systeme','module_id',$id_moduless);
        $data202 = tvente_entete_entree::create([
            'code'       =>  $codes,
            'refRecquisition'       =>  0,
            'refFournisseur'       =>  $id_fss,
            'transporteur'       =>  'SI',
            'module_id'       =>  $id_moduless,
            'refService'       =>  $request->refService,
            'dateEntree'    =>  $request->dateVente,
            'libelle'    =>  $request->libelle,
            'niveau1'    =>  0,
            'niveaumax'    =>  3,
            'active'    => $actives,            
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser
        ]); 

        $idmaxs=DB::table('tvente_entete_entree')
        ->where([
            ['refUser','=', $request->refUser],
            ['refFournisseur','=', $id_fss]
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

            $refProduit=0;
            $data99=DB::table('tvente_stock_service') 
            ->select('id','refService','refProduit','pu','qte','uniteBase','cmup',
            'devise','taux','active','refUser','author')
            ->where([
                ['tvente_stock_service.id','=', $data['idStockService']]
            ])      
            ->get();
            foreach ($data99 as $row) 
            {
                $refProduit =  $row->refProduit; 
                $montants = $row->cmup;          
            }

            $qte=$data['qteVente'];
            $idDetail=$refProduit;
            $idFacture=$idmax;
    
            $compte_achat = 0;
            $compte_vente =0;
            $compte_variationstock=0;
            $compte_perte=0;
            $compte_produit=0;
            $compte_destockage=0;
            $compte_stockage=0;
            $cmupVente=0;
    
            $data3=DB::table('tvente_produit')
            ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
            ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
            'compte_perte','compte_produit','compte_destockage','compte_stockage','cmup')
            ->where([
                ['tvente_produit.id','=', $refProduit]
            ])      
            ->get();
            foreach ($data3 as $row) 
            {
                $compte_achat =  $row->compte_achat;
                $compte_vente = $row->compte_vente;
                $compte_variationstock= $row->compte_variationstock;
                $compte_perte= $row->compte_perte;
                $compte_produit= $row->compte_produit;
                $compte_destockage= $row->compte_destockage;
                $compte_stockage= $row->compte_stockage; 
                $cmupVente=$row->cmup;         
            }

            $uniteVente = '';
            $uniteBase = '';
            $puBase=0;
            $qteBase=0;
            $estunite='';
            $cmupVente = $montants;
            $refUnite = 0;

            $data95=DB::table('tvente_detail_unite')
            ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
            ->join('tvente_produit','tvente_produit.id','=','tvente_detail_unite.refProduit')
            ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
            ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
            'compte_perte','compte_produit','compte_destockage','compte_stockage','qteUnite',
            'puUnite','uniteBase','nom_unite','estunite','qteBase','puBase','refUnite')
            ->where([
                ['tvente_detail_unite.refProduit','=', $refProduit],
                ['tvente_detail_unite.estunite','=', 'OUI']
            ])      
            ->get();
            foreach ($data95 as $row) 
            {
                $uniteVente = $row->nom_unite;
                $uniteBase = $row->uniteBase;           
                $qteBase =  $row->qteBase;
                $puBase = $row->puBase;      
                $estunite = $row->estunite;   
                $refUnite = $row->refUnite;   
            } 
    
            $qteVente = $qteBase * floatval($data['qteVente']);
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
        
            $data5=DB::table('tvente_tva')     
            ->select('montant_tva')
            ->where([
                ['tvente_tva.active','=', 'OUI']
            ])      
            ->first();
            if ($data5) 
            {
                $pourtageTVA = $data5->montant_tva;
            }

            $montantreduction = 0;
            
            $montanttva = (((floatval($data['qteVente']) * floatval($montants))*floatval($pourtageTVA))/100);
        
                $data201 = tvente_detail_inventaire::create([
                    'refEnteteVente'       =>  $idmax,
                    'refProduit'    =>  $refProduit,
                    'qteVente'    =>  $data['qteVente'],
                    'qteObs'    =>  $data['qteDisponible'],
                    'idStockService'    =>  $data['idStockService'],                     
                    'author'       =>  $request->author,
                    'refUser'    =>  $request->refUser,

                    'montantreduction'    =>   $montantreduction,
                    'active'    =>  $active,
                    'uniteVente'    =>  $uniteVente,
                    'compte_vente'    =>  $compte_vente,
                    'compte_variationstock'    =>  $compte_variationstock,
                    'compte_perte'    =>  $compte_perte,
                    'compte_produit'    =>  $compte_produit,
                    'compte_destockage'    =>  $compte_destockage,
                    'puVente'    =>  $montants,
                    'devise'    =>  $devises,
                    'taux'    =>  $taux,
                    'puBase'    =>  $puBase,
                    'qteBase'    =>  $qteBase,
                    'uniteBase'    =>  $uniteBase,
                    'cmupVente'    =>  $cmupVente,
                    'montanttva'    =>  $montanttva,
                ]);

                $data2 = DB::update(
                    'update tvente_stock_service set qte = :qteEntree where id = :idStockService',
                    ['qteEntree' => $qteVente,'idStockService' => $data['idStockService']]
                );



                $data203 = tvente_detail_entree::create([
                    'refEnteteEntree'       =>  $idmaxs,
                    'refProduit'    =>  $refProduit,
                    'idStockService'    =>  $data['idStockService'], 
                    'qteEntree'    =>  $data['qteVente'],
                    'montantreduction'    =>  0,
                    'active'    =>  "OUI",            
                    'author'       =>  $request->author,
                    'refUser'    =>  $request->refUser,
        
                    'compte_achat'    =>  $compte_achat,
                    'compte_variationstock'    =>  $compte_variationstock,
                    'compte_produit'    =>  $compte_produit,
                    'compte_stockage'    =>  $compte_stockage,
                    'puEntree'    =>  $montants,
                    'devise'    =>  $devises,
                    'taux'    =>  $taux,
                    'uniteEntree'    =>  $uniteVente,
                    'puBase'    =>  $puBase,
                    'qteBase'    =>  $qteBase,
                    'uniteBase'    =>  $uniteBase,
                    'montanttva'    =>  $montanttva            
                ]);



        
                $id_detail_max=0;
                $detail_list = DB::table('tvente_detail_entree')       
                ->selectRaw('MAX(id) as code_entete')
                ->where([
                    ['refUser','=', $request->refUser],
                    ['idStockService','=', $data['idStockService']]
                ]) 
                ->get();
                foreach ($detail_list as $list) {
                    $id_detail_max= $list->code_entete;
                }

                $data99 = tvente_mouvement_stock::create([             
                    'idStockService'    =>  $data['idStockService'],             
                    'dateMvt'    =>   $request->dateVente,   
                    'type_mouvement'    =>  'Entree',
                    'libelle_mouvement'    =>  'Stock Inntial',
                    'nom_table'    =>  'tvente_detail_entree',
                    'id_data'    =>  $id_detail_max, 
                    'qteMvt'    =>  $data['qteVente'],
                    'puMvt'    =>  $montants,                   
                    'author'       =>  $request->author,
                    'refUser'       =>  $request->refUser,
                    'type_sortie'    =>  'Entree',

                    'active'    =>  $active,
                    'uniteMvt'    =>  $uniteVente,
                    'compte_vente'    =>  0,
                    'compte_variationstock'    =>  $compte_variationstock,
                    'compte_perte'    =>  0,
                    'compte_produit'    =>  $compte_produit,
                    'compte_destockage'    =>  0,
                    'compte_achat'    =>  $compte_achat,
                    'compte_stockage'    =>  $compte_stockage,
                    'puVente'    =>  $montants,
                    'devise'    =>  $devises,
                    'taux'    =>  $taux,
                    'puBase'    =>  $puBase,
                    'qteBase'    =>  $qteBase,
                    'uniteBase'    =>  $uniteBase,
                    'cmupMvt'    =>  $cmupVente
                ]);



            
        }



        

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }

    function insert_dataGlobal_Pivot(Request $request)
    {
        $id_module = 8;
        $active = "OUI";

        $code = $this->GetCodeData('tvente_param_systeme','module_id',$id_module);
        $data = tvente_entete_inventaire::create([
            'code'       =>  $code,            
            'refService'       =>  $request->refService, 
            'module_id'       =>  $id_module,
            'dateVente'    =>  $request->dateVente,
            'libelle'    =>  $request->libelle,            
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);

        $idmax=0;
        $maxid = DB::table('tvente_entete_inventaire')       
        ->selectRaw('MAX(tvente_entete_inventaire.id) as code_entete')
        ->where('tvente_entete_inventaire.refService', $request->refService)
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

         $refProduit=0;
         $data99=DB::table('tvente_stock_service') 
         ->select('id','refService','refProduit','pu','qte','uniteBase','cmup',
         'devise','taux','active','refUser','author')
         ->where([
            ['tvente_stock_service.id','=', $data['idStockService']]
         ])      
         ->get();
         foreach ($data99 as $row) 
         {
             $refProduit =  $row->refProduit; 
             $montants = $row->cmup;          
         }

         $qte=$data['qteVente'];
         $idDetail=$refProduit;
         $idFacture=$idmax;
 
         $compte_achat = 0;
         $compte_vente =0;
         $compte_variationstock=0;
         $compte_perte=0;
         $compte_produit=0;
         $compte_destockage=0;
         $compte_stockage=0;
         $cmupVente=0;
 
         $data3=DB::table('tvente_produit')
          ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
          ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
          'compte_perte','compte_produit','compte_destockage','compte_stockage','cmup')
          ->where([
             ['tvente_produit.id','=', $refProduit]
         ])      
         ->get();
         foreach ($data3 as $row) 
         {
             $compte_achat =  $row->compte_achat;
             $compte_vente = $row->compte_vente;
             $compte_variationstock= $row->compte_variationstock;
             $compte_perte= $row->compte_perte;
             $compte_produit= $row->compte_produit;
             $compte_destockage= $row->compte_destockage;
             $compte_stockage= $row->compte_stockage; 
             $cmupVente=$row->cmup;         
         }

         $uniteVente = '';
         $uniteBase = '';
         $puBase=0;
         $qteBase=0;
         $estunite='';
         $cmupVente = $montants;
         $refUnite = 0;

         $data95=DB::table('tvente_detail_unite')
         ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
         ->join('tvente_produit','tvente_produit.id','=','tvente_detail_unite.refProduit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
         ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
         'compte_perte','compte_produit','compte_destockage','compte_stockage','qteUnite',
         'puUnite','uniteBase','nom_unite','estunite','qteBase','puBase','refUnite','estpivot')
         ->where([
            ['tvente_detail_unite.refProduit','=', $refProduit],
            ['tvente_detail_unite.estpivot','=', 'OUI']
         ])      
         ->get();
         foreach ($data95 as $row) 
         {
             $uniteVente = $row->nom_unite;
             $uniteBase = $row->uniteBase;           
             $qteBase =  $row->qteBase;
             $puBase = $row->puBase;      
             $estunite = $row->estunite;   
             $refUnite = $row->refUnite;   
         } 
 
        $qteVente = $qteBase * floatval($data['qteVente']);
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
    
            $data = tvente_detail_inventaire::create([
                'refEnteteVente'       =>  $idmax,
                'refProduit'    =>  $refProduit,
                'qteVente'    =>  $data['qteVente'],
                'qteObs'    =>  $data['qteDisponible'],
                'idStockService'    =>  $data['idStockService'],                     
                'author'       =>  $request->author,
                'refUser'    =>  $request->refUser,

                'montantreduction'    =>   $montantreduction,
                'active'    =>  $active,
                'uniteVente'    =>  $uniteVente,
                'compte_vente'    =>  $compte_vente,
                'compte_variationstock'    =>  $compte_variationstock,
                'compte_perte'    =>  $compte_perte,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                'puVente'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'puBase'    =>  $puBase,
                'qteBase'    =>  $qteBase,
                'uniteBase'    =>  $uniteBase,
                'cmupVente'    =>  $cmupVente,
                'montanttva'    =>  $montanttva,
            ]);
        }

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }





}
