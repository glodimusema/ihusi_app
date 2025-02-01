<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_detail_cuisine;
use App\Models\Ventes\tvente_entete_cuisine;
use App\Models\Hotel\thotel_reservation_chambre;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tvente_detail_cuisineController extends Controller
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

        $data = DB::table('tvente_detail_cuisine')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_cuisine.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')

        ->join('tvente_entete_cuisine','tvente_entete_cuisine.id','=','tvente_detail_cuisine.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tvente_entete_cuisine.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_cuisine.refService')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_cuisine.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')

        ->select('tvente_detail_cuisine.id','refEnteteVente','refProduit','tvente_detail_cuisine.compte_vente',
        'tvente_detail_cuisine.compte_variationstock','tvente_detail_cuisine.compte_perte','tvente_detail_cuisine.compte_produit',
        'tvente_detail_cuisine.compte_destockage','puVente','qteVente','uniteVente','puBase','qteBase',
        'tvente_detail_cuisine.uniteBase','cmupVente','tvente_detail_cuisine.devise',
        'tvente_detail_cuisine.taux','montantreduction',
        'tvente_detail_cuisine.active','tvente_detail_cuisine.author','tvente_detail_cuisine.refUser',
        'tvente_detail_cuisine.created_at','idStockService',

        'tvente_produit.designation','tvente_produit.refCategorie','tvente_produit.refUniteBase',
        'tvente_produit.pu','tvente_produit.qte','tvente_produit.cmup','tvente_produit.taux',
        'tvente_produit.Oldcode','tvente_produit.Newcode','tvente_produit.tvaapplique',
        'tvente_produit.estvendable',
        
        'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        "tvente_categorie_client.designation as CategorieClient","compte_client",

        'nom_service', "tvente_module.nom_module",'tvente_entete_cuisine.code','refClient','refService','refReservation',
        'module_id','dateVente','libelle','priseencharge','montant','reduction','totaltva')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tvente_detail_cuisine.taux) as PTVenteFC')
       ->selectRaw('(qteBase*puBase) as PTBase');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_cuisine.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_detail_cuisine.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }

    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tvente_detail_cuisine')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_cuisine.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')

        ->join('tvente_entete_cuisine','tvente_entete_cuisine.id','=','tvente_detail_cuisine.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tvente_entete_cuisine.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_cuisine.refService')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_cuisine.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')

        ->select('tvente_detail_cuisine.id','refEnteteVente','refProduit','tvente_detail_cuisine.compte_vente',
        'tvente_detail_cuisine.compte_variationstock','tvente_detail_cuisine.compte_perte','tvente_detail_cuisine.compte_produit',
        'tvente_detail_cuisine.compte_destockage','puVente','qteVente','uniteVente','puBase','qteBase',
        'tvente_detail_cuisine.uniteBase','cmupVente','tvente_detail_cuisine.devise',
        'tvente_detail_cuisine.taux','montantreduction',
        'tvente_detail_cuisine.active','tvente_detail_cuisine.author','tvente_detail_cuisine.refUser',
        'tvente_detail_cuisine.created_at','idStockService',

        'tvente_produit.designation','tvente_produit.refCategorie','tvente_produit.refUniteBase',
        'tvente_produit.pu','tvente_produit.qte','tvente_produit.cmup','tvente_produit.taux',
        'tvente_produit.Oldcode','tvente_produit.Newcode','tvente_produit.tvaapplique',
        'tvente_produit.estvendable',
        
        'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        "tvente_categorie_client.designation as CategorieClient","compte_client",

        'nom_service', "tvente_module.nom_module",'tvente_entete_cuisine.code','refClient','refService','refReservation',
        'module_id','dateVente','libelle','priseencharge','montant','reduction','totaltva')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tvente_detail_cuisine.taux) as PTVenteFC')
       ->selectRaw('(qteBase*puBase) as PTBase')
        ->Where('refEnteteVente',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_cuisine.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_detail_cuisine.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }  

    function fetch_single_data($id)
    {
        $data= DB::table('tvente_detail_cuisine')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_cuisine.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')

        ->join('tvente_entete_cuisine','tvente_entete_cuisine.id','=','tvente_detail_cuisine.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tvente_entete_cuisine.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_cuisine.refService')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_cuisine.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')

        ->select('tvente_detail_cuisine.id','refEnteteVente','refProduit','tvente_detail_cuisine.compte_vente',
        'tvente_detail_cuisine.compte_variationstock','tvente_detail_cuisine.compte_perte','tvente_detail_cuisine.compte_produit',
        'tvente_detail_cuisine.compte_destockage','puVente','qteVente','uniteVente','puBase','qteBase',
        'tvente_detail_cuisine.uniteBase','cmupVente','tvente_detail_cuisine.devise',
        'tvente_detail_cuisine.taux','montantreduction',
        'tvente_detail_cuisine.active','tvente_detail_cuisine.author','tvente_detail_cuisine.refUser',
        'tvente_detail_cuisine.created_at','idStockService',

        'tvente_produit.designation','tvente_produit.refCategorie','tvente_produit.refUniteBase',
        'tvente_produit.pu','tvente_produit.qte','tvente_produit.cmup','tvente_produit.taux',
        'tvente_produit.Oldcode','tvente_produit.Newcode','tvente_produit.tvaapplique',
        'tvente_produit.estvendable',
        
        'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        "tvente_categorie_client.designation as CategorieClient","compte_client",

        'nom_service', "tvente_module.nom_module",'tvente_entete_cuisine.code','refClient','refService','refReservation',
        'module_id','dateVente','libelle','priseencharge','montant','reduction','totaltva')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tvente_detail_cuisine.taux) as PTVenteFC')
       ->selectRaw('(qteBase*puBase) as PTBase')
        ->where('tvente_detail_cuisine.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_detail_facture($id)
    {

        $data = DB::table('tvente_detail_cuisine')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_cuisine.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')

        ->join('tvente_entete_cuisine','tvente_entete_cuisine.id','=','tvente_detail_cuisine.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tvente_entete_cuisine.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_cuisine.refService')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_cuisine.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')

        ->select('tvente_detail_cuisine.id','refEnteteVente','refProduit','tvente_detail_cuisine.compte_vente',
        'tvente_detail_cuisine.compte_variationstock','tvente_detail_cuisine.compte_perte','tvente_detail_cuisine.compte_produit',
        'tvente_detail_cuisine.compte_destockage','puVente','qteVente','uniteVente','puBase','qteBase',
        'tvente_detail_cuisine.uniteBase','cmupVente','tvente_detail_cuisine.devise',
        'tvente_detail_cuisine.taux','montantreduction',
        'tvente_detail_cuisine.active','tvente_detail_cuisine.author','tvente_detail_cuisine.refUser',
        'tvente_detail_cuisine.created_at','idStockService',

        'tvente_produit.designation','tvente_produit.refCategorie','tvente_produit.refUniteBase',
        'tvente_produit.pu','tvente_produit.qte','tvente_produit.cmup','tvente_produit.taux',
        'tvente_produit.Oldcode','tvente_produit.Newcode','tvente_produit.tvaapplique',
        'tvente_produit.estvendable',
        
        'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        "tvente_categorie_client.designation as CategorieClient","compte_client",

        'nom_service', "tvente_module.nom_module",'tvente_entete_cuisine.code','refClient','refService','refReservation',
        'module_id','dateVente','libelle','priseencharge','montant','reduction','totaltva')
        ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) - IFNULL(reduction,0)),0),2) as totalFacture')
        ->selectRaw('ROUND((totaltva),2) as TotalTVA')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0),2) as PTTTC')
        ->selectRaw('((qteVente*puVente)/tvente_detail_cuisine.taux) as PTVenteFC')
        ->selectRaw('(qteBase*puBase) as PTBase')      
       ->Where('tvente_detail_cuisine.refEnteteVente',$id)               
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
        

        $data33=DB::table('tvente_entete_cuisine') 
         ->select('id','code','refClient','refService','refReservation','module_id','dateVente',
         'libelle','author','refUser')
         ->where([
            ['tvente_entete_cuisine.id','=', $request->refEnteteVente]
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
        $cmupVente=0;

        $uniteVente = $request->nom_unite;
        $uniteBase = $request->nom_unite;           
        $qteBase =  1;
        $puBase = $montants;      
        $estunite = 'OUI';
        $cmupVente = $montants;


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
          ['tvente_tva.id','=', $request->id_tva],
          ['tvente_tva.active','=', 'OUI']
       ])      
      ->get();
      foreach ($data5 as $row) 
      {
          $pourtageTVA = $row->montant_tva;
      }
      //$idStockService
      $montanttva = (((floatval($request->qteVente) * floatval($montants))*floatval($pourtageTVA))/100);

        $data = tvente_detail_cuisine::create([
            'refEnteteVente'       =>  $request->refEnteteVente,
            'refProduit'    =>  $refProduit,
            'qteVente'    =>  $request->qteVente,            
            'montantreduction'    =>  $request->montantreduction, 
            'idStockService'    =>  $request->idStockService,                       
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser,

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

        $data3 = DB::update(
            'update tvente_entete_cuisine set montant = montant + (:pu * :qte), reduction = reduction + :reduction, totaltva = totaltva + :totaltva where id = :refEnteteVente',
            ['pu' => $montants,'qte' => $request->qteVente,'reduction' => $request->montantreduction,'totaltva' => $montanttva,'refEnteteVente' => $request->refEnteteVente]
        );

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

        $deleteds = DB::table('tvente_detail_cuisine')
        ->selectRaw('(qteVente*puVente) as prixTotal')
        ->Where('id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $idFacture = $deleted->refEnteteVente;
            $montant_last = $deleted->prixTotal;
        }

        $data3 = DB::update(
            'update tvente_entete_cuisine set montant = montant - (:montant_last) + (:prixunitaire * :qteVente) where id = :refEnteteVente',
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

        $data = tvente_detail_cuisine::where('id', $id)->update([
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


        $qte=0;
        $idProduit=0;
        $idFacture=0;
        $pu=0;
        $montantreduction=0;
        $montanttva=0;

        $deleteds = DB::table('tvente_detail_cuisine')->Where('id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $qte = $deleted->qte;            
            $pu = $deleted->pu;
            $idProduit = $deleted->refProduit;
            $idFacture = $deleted->refEnteteVente;
            $montantreduction = $deleted->montantreduction;
            $montanttva = $deleted->montanttva;
        }

        $data3 = DB::update(
            'update tvente_entete_cuisine set montant = montant + (:pu * :qte),reduction = reduction - :reduction, totaltva = totaltva - :totaltva where id = :refEnteteVente',
            ['pu' => $pu,'qte' => $qte,'reduction' => $montantreduction,'totaltva' => $montanttva,'refEnteteVente' => $idFacture]
        );


        $data = tvente_detail_cuisine::where('id',$id)->delete();
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }

    function insert_dataGlobal(Request $request)
    {
        $id_module = 9;
        $active = "OUI";
        $estServie = "NON";
        $libelle = "Commande Cuisisne";

        $code = $this->GetCodeData('tvente_param_systeme','module_id',$id_module);
        $data111 = tvente_entete_cuisine::create([
            'code'       =>  $code,
            'refClient'       =>  $request->refClient,
            'refService'       =>  $request->refService,  
            'refReservation'       =>  0,          
            'module_id'       =>  $id_module,
            'dateVente'    =>  $request->dateVente,
            'libelle'    =>  $libelle,
            'serveur_id'    =>  $request->serveur_id,
            'table_id'    =>  $request->table_id,
            'estServie'    =>  $estServie,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);

        $idmax=0;
        $maxid = DB::table('tvente_entete_cuisine')       
        ->selectRaw('MAX(tvente_entete_cuisine.id) as code_entete')
        ->where([
            ['tvente_entete_cuisine.refUser', $request->refUser],
            ['tvente_entete_cuisine.refClient','=', $request->refClient]
         ])
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
            $devises='';
            if($request->devise != 'USD')
            {
                $montants = ($data['puVente'])/$taux;
                $devises='USD';
            }
            else
            {
                $montants = $data['puVente'];
                $devises = $request->devise;
            }  


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
         $cmupVente=0;
 
         $uniteVente = $data['nom_unite'];
         $uniteBase = $data['nom_unite'];           
         $qteBase =  1;
         $puBase = $montants;      
         $estunite = 'OUI';
         $cmupVente = $montants; 
 
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
         ['tvente_tva.id','=', $data['id_tva']],
          ['tvente_tva.active','=', 'OUI']
       ])      
      ->get();
      foreach ($data5 as $row) 
      {
          $pourtageTVA = $row->montant_tva;
      }




         
         $montanttva = (((floatval($data['qteVente']) * floatval($montants))*floatval($pourtageTVA))/100);
    
            $data222 = tvente_detail_cuisine::create([
                'refEnteteVente'       =>  $idmax,
                'refProduit'    =>  $refProduit,
                'qteVente'    =>  $data['qteVente'],            
                'montantreduction'    =>  $data['montantreduction'],  
                'idStockService'    =>  $data['idStockService'],                     
                'author'       =>  $request->author,
                'refUser'    =>  $request->refUser,
    
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

            $data3 = DB::update(
                'update tvente_entete_cuisine set montant = montant + (:pu * :qte),reduction = reduction + :reduction,totaltva = totaltva + :totaltva where id = :refEnteteVente',
                ['pu' => $montants,'qte' => $data['qteVente'],'reduction' => $data['montantreduction'],'totaltva' => $montanttva,'refEnteteVente' => $idmax]
            );

        }

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }

    function affecter_reservation(Request $request, $id)
    {
        $data = tvente_entete_cuisine::where('id', $id)->update([                        
            'refReservation' =>  $request->refReservation,
            'etat_facture'    =>  'Chambre',            
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]); 
    }

}
