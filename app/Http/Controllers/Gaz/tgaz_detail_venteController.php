<?php

namespace App\Http\Controllers\Gaz;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gaz\tgaz_detail_vente;
use App\Models\Gaz\tgaz_mouvement_stock_service_lot;
use App\Models\Gaz\tgaz_entete_vente;
use App\Models\Gaz\tgaz_detail_paiement_vente;
use App\Models\Gaz\tgaz_entete_paiement_vente;


use App\Models\Hotel\thotel_reservation_chambre;

use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tgaz_detail_venteController extends Controller
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
        $data = DB::table('tgaz_detail_vente')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_vente.idStockService')

        ->join('tgaz_parametre_lot','tgaz_parametre_lot.id','=','tgaz_detail_vente.idParamLot')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_parametre_lot.refLot')
        ->join('tvente_produit','tvente_produit.id','=','tgaz_parametre_lot.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        
        ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_vente.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tgaz_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        
        ->select('tgaz_detail_vente.id','tgaz_detail_vente.refEnteteVente','tgaz_detail_vente.compte_vente',
        'tgaz_detail_vente.compte_variationstock','tgaz_detail_vente.compte_perte',
        'tgaz_detail_vente.compte_produit','tgaz_detail_vente.compte_destockage',
        'tgaz_detail_vente.idStockService','tgaz_detail_vente.idParamLot',
        'tgaz_detail_vente.puVente','tgaz_detail_vente.qteVente','tgaz_detail_vente.uniteVente',
        'tgaz_detail_vente.cmupVente','tgaz_detail_vente.devise','tgaz_detail_vente.taux',
        'tgaz_detail_vente.montanttva','tgaz_detail_vente.montantreduction','tgaz_detail_vente.priseencharge',
        'tgaz_detail_vente.active','tgaz_detail_vente.author','tgaz_detail_vente.refUser','qte_kit',
        //Stock service
        'tgaz_stock_service_lot.refService as refService_StockServ',
        'tgaz_stock_service_lot.refLot','pu_lot','qte_lot','cmup_lot',
        //Parametre flot
        'refProduit','pu_param','qte_param','autre_detail',
        'tgaz_parametre_lot.author','tgaz_parametre_lot.refUser','nom_lot','code_lot','unite_lot',
        "tvente_produit.designation as designation",'refCategorie','uniteBase','pu','qte',
        'cmup','Oldcode','Newcode','tvente_produit.tvaapplique','tvente_produit.estvendable',
        "tvente_categorie_produit.designation as Categorie",
        //Entete Vente
        'tgaz_entete_vente.code','refClient','tgaz_entete_vente.refService','module_id','serveur_id','etat_facture',
        'dateVente','libelle','tgaz_entete_vente.montant','reduction','totaltva','tgaz_entete_vente.paie',
        'etat_facture',
        
        'nom_service', "tvente_module.nom_module",'date_paie_current','nombre_print'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug'
       )
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tgaz_detail_vente.taux) as PTVenteFC')
       ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0),2) as totalFacture')
       ->selectRaw('IFNULL(paie,0) as totalPaie')
       ->selectRaw('ROUND((IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0) - IFNULL(paie,0)),2) as RestePaie');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_detail_vente.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tgaz_detail_vente.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }

    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tgaz_detail_vente')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_vente.idStockService')

        ->join('tgaz_parametre_lot','tgaz_parametre_lot.id','=','tgaz_detail_vente.idParamLot')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_parametre_lot.refLot')
        ->join('tvente_produit','tvente_produit.id','=','tgaz_parametre_lot.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        
        ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_vente.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tgaz_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        
        ->select('tgaz_detail_vente.id','tgaz_detail_vente.refEnteteVente','tgaz_detail_vente.compte_vente',
        'tgaz_detail_vente.compte_variationstock','tgaz_detail_vente.compte_perte',
        'tgaz_detail_vente.compte_produit','tgaz_detail_vente.compte_destockage',
        'tgaz_detail_vente.idStockService','tgaz_detail_vente.idParamLot',
        'tgaz_detail_vente.puVente','tgaz_detail_vente.qteVente','tgaz_detail_vente.uniteVente',
        'tgaz_detail_vente.cmupVente','tgaz_detail_vente.devise','tgaz_detail_vente.taux',
        'tgaz_detail_vente.montanttva','tgaz_detail_vente.montantreduction','tgaz_detail_vente.priseencharge',
        'tgaz_detail_vente.active','tgaz_detail_vente.author','tgaz_detail_vente.refUser','qte_kit',
        //Stock service
        'tgaz_stock_service_lot.refService as refService_StockServ',
        'tgaz_stock_service_lot.refLot','pu_lot','qte_lot','cmup_lot',
        //Parametre flot
        'refProduit','pu_param','qte_param','autre_detail',
        'tgaz_parametre_lot.author','tgaz_parametre_lot.refUser','nom_lot','code_lot','unite_lot',
        "tvente_produit.designation as designation",'refCategorie','uniteBase','pu','qte',
        'cmup','Oldcode','Newcode','tvente_produit.tvaapplique','tvente_produit.estvendable',
        "tvente_categorie_produit.designation as Categorie",
        //Entete Vente
        'tgaz_entete_vente.code','refClient','tgaz_entete_vente.refService','module_id','serveur_id','etat_facture',
        'dateVente','libelle','tgaz_entete_vente.montant','reduction','totaltva','tgaz_entete_vente.paie',
        'etat_facture',
        
        'nom_service', "tvente_module.nom_module",'date_paie_current','nombre_print'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug'
       )
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tgaz_detail_vente.taux) as PTVenteFC')
       ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0),2) as totalFacture')
       ->selectRaw('IFNULL(paie,0) as totalPaie')
       ->selectRaw('ROUND((IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0) - IFNULL(paie,0)),2) as RestePaie')
        ->Where('refEnteteVente',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_detail_vente.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tgaz_detail_vente.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }  

    function fetch_single_data($id)
    {
        $data= DB::table('tgaz_detail_vente')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_vente.idStockService')

        ->join('tgaz_parametre_lot','tgaz_parametre_lot.id','=','tgaz_detail_vente.idParamLot')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_parametre_lot.refLot')
        ->join('tvente_produit','tvente_produit.id','=','tgaz_parametre_lot.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        
        ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_vente.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tgaz_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        
        ->select('tgaz_detail_vente.id','tgaz_detail_vente.refEnteteVente','tgaz_detail_vente.compte_vente',
        'tgaz_detail_vente.compte_variationstock','tgaz_detail_vente.compte_perte',
        'tgaz_detail_vente.compte_produit','tgaz_detail_vente.compte_destockage',
        'tgaz_detail_vente.idStockService','tgaz_detail_vente.idParamLot',
        'tgaz_detail_vente.puVente','tgaz_detail_vente.qteVente','tgaz_detail_vente.uniteVente',
        'tgaz_detail_vente.cmupVente','tgaz_detail_vente.devise','tgaz_detail_vente.taux',
        'tgaz_detail_vente.montanttva','tgaz_detail_vente.montantreduction','tgaz_detail_vente.priseencharge',
        'tgaz_detail_vente.active','tgaz_detail_vente.author','tgaz_detail_vente.refUser','qte_kit',
        //Stock service
        'tgaz_stock_service_lot.refService as refService_StockServ',
        'tgaz_stock_service_lot.refLot','pu_lot','qte_lot','cmup_lot',
        //Parametre flot
        'refProduit','pu_param','qte_param','autre_detail',
        'tgaz_parametre_lot.author','tgaz_parametre_lot.refUser','nom_lot','code_lot','unite_lot',
        "tvente_produit.designation as designation",'refCategorie','uniteBase','pu','qte',
        'cmup','Oldcode','Newcode','tvente_produit.tvaapplique','tvente_produit.estvendable',
        "tvente_categorie_produit.designation as Categorie",
        //Entete Vente
        'tgaz_entete_vente.code','refClient','tgaz_entete_vente.refService','module_id','serveur_id','etat_facture',
        'dateVente','libelle','tgaz_entete_vente.montant','reduction','totaltva','tgaz_entete_vente.paie',
        'etat_facture',
        
        'nom_service', "tvente_module.nom_module",'date_paie_current','nombre_print'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug'
       )
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tgaz_detail_vente.taux) as PTVenteFC')
       ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0),2) as totalFacture')
       ->selectRaw('IFNULL(paie,0) as totalPaie')
       ->selectRaw('ROUND((IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0) - IFNULL(paie,0)),2) as RestePaie')
        ->where('tgaz_detail_vente.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_detail_facture($id)
    {      

        $data = DB::table('tgaz_detail_vente')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_vente.idStockService')

        ->join('tgaz_parametre_lot','tgaz_parametre_lot.id','=','tgaz_detail_vente.idParamLot')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_parametre_lot.refLot')
        ->join('tvente_produit','tvente_produit.id','=','tgaz_parametre_lot.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        
        ->join('tgaz_entete_vente','tgaz_entete_vente.id','=','tgaz_detail_vente.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tgaz_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        
        ->select('tgaz_detail_vente.id','tgaz_detail_vente.refEnteteVente','tgaz_detail_vente.compte_vente',
        'tgaz_detail_vente.compte_variationstock','tgaz_detail_vente.compte_perte',
        'tgaz_detail_vente.compte_produit','tgaz_detail_vente.compte_destockage',
        'tgaz_detail_vente.idStockService','tgaz_detail_vente.idParamLot',
        'tgaz_detail_vente.puVente','tgaz_detail_vente.qteVente','tgaz_detail_vente.uniteVente',
        'tgaz_detail_vente.cmupVente','tgaz_detail_vente.devise','tgaz_detail_vente.taux',
        'tgaz_detail_vente.montanttva','tgaz_detail_vente.montantreduction','tgaz_detail_vente.priseencharge',
        'tgaz_detail_vente.active','tgaz_detail_vente.author','tgaz_detail_vente.refUser','qte_kit',
        //Stock service
        'tgaz_stock_service_lot.refService as refService_StockServ',
        'tgaz_stock_service_lot.refLot','pu_lot','qte_lot','cmup_lot',
        //Parametre flot
        'refProduit','pu_param','qte_param','autre_detail',
        'tgaz_parametre_lot.author','tgaz_parametre_lot.refUser','nom_lot','code_lot','unite_lot',
        "tvente_produit.designation as designation",'refCategorie','uniteBase','pu','qte',
        'cmup','Oldcode','Newcode','tvente_produit.tvaapplique','tvente_produit.estvendable',
        "tvente_categorie_produit.designation as Categorie",
        //Entete Vente
        'tgaz_entete_vente.code','refClient','tgaz_entete_vente.refService','module_id','serveur_id','etat_facture',
        'dateVente','libelle','tgaz_entete_vente.montant','reduction','totaltva','tgaz_entete_vente.paie',
        'etat_facture',
        
        'nom_service', "tvente_module.nom_module",'date_paie_current','nombre_print'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) - IFNULL(reduction,0)),0),2) as totalFacture')
       ->selectRaw('ROUND((totaltva),2) as TotalTVA')
       ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0),2) as PTTTC')
       ->selectRaw('((qteVente*puVente)/tgaz_detail_vente.taux) as PTVenteFC')
       ->selectRaw('ROUND((IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0) - IFNULL(paie,0)),2) as RestePaie')
       ->selectRaw("DATE_FORMAT(date_paie_current,'%d/%M/%Y') as date_paie_current")
       ->selectRaw('IFNULL(paie,0) as totalPaie')       
       ->Where('tgaz_detail_vente.refEnteteVente',$id)               
       ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }


    function insert_data(Request $request)
    {
        $current = Carbon::now();
        $active = "OUI";

        $dateVente=0;
        $data_entete =  DB::table("tgaz_entete_vente")
        ->select("tgaz_entete_vente.id", "tgaz_entete_vente.dateVente")
        ->where([
            ['tgaz_entete_vente.id','=', $request->refEnteteVente]
        ])
        ->first(); 
         if ($data_entete) 
         {                                
            $dateVente=$data_entete->dateVente;                           
         }

        $cmup_data = floatval($this->calculerCoutGazMoyen($request->idStockService, $dateVente, $dateVente));

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


            $cmup_data = $cmup_data;
            $cmupVente = $cmup_data;
            $refLot=0;
            
            $data99=DB::table('tgaz_stock_service_lot') 
            ->select('id','refService','refLot','pu_lot','qte_lot','cmup_lot',
            'devise','taux','active','refUser','author')
            ->where([
                ['tgaz_stock_service_lot.id','=', $request->idStockService]
            ])      
            ->first();
            if ($data99) 
            {
                $refLot =  $data99->refLot;       
            }



            $qte=$request->qteVente;
            $idDetail=$refLot;
            $idFacture=$request->refEnteteVente;

          

        $uniteVente = '';
        $cmupVente = $cmup_data;
        $uniteVente = $request->nom_unite;   

            
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
        

        $montanttva = (((floatval($request->qteVente) * floatval($montants))*floatval($pourtageTVA))/100);
            $data = tgaz_detail_vente::create([
                'refEnteteVente'       =>  $request->refEnteteVente,
                'compte_vente'    =>  $compte_vente,
                'compte_variationstock'    =>  $compte_variationstock,
                'compte_perte'    =>  $compte_perte,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                'idStockService'    =>  $request->idStockService,
                'idParamLot'    =>  $request->idParamLot,
                'puVente'    =>  $montants,
                'qteVente'    =>  $request->qteVente,
                'uniteVente'    =>  $uniteVente,
                'cmupVente'    =>  $cmupVente,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'montanttva'    =>  $montanttva,
                'montantreduction'    =>  $request->montantreduction,
                'active'    =>  $active,
                'author'       =>  $request->author,
                'refUser'    =>  $request->refUser                
            ]);

            $id_detail_max=0;
            $detail_list = DB::table('tgaz_detail_vente')       
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
                'type_mouvement'    =>  'Sortie',
                'libelle_mouvement'    =>  'Vente des Gaz et Accesseoires',
                'nom_table'    =>  'tgaz_detail_vente',
                'id_data'    =>  $id_detail_max, 
                'qteMvt'    =>  $request->qteVente,
                'puMvt'    =>  $montants,                   
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'type_sortie'    =>  'Sortie',

                'active'    =>  $active,
                'uniteMvt'    =>  $uniteVente,
                'compte_vente'    =>  $compte_vente,
                'compte_variationstock'    =>  $compte_variationstock,
                'compte_perte'    =>  $compte_perte,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                'compte_achat'    =>  $compte_achat,
                'compte_stockage'    =>  $compte_stockage,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'cmupMvt'    =>  $cmupVente
            ]); 

            $data2 = DB::update(
                'update tgaz_stock_service_lot set qte_lot = qte_lot - :qteVente where id = :idStockService',
                ['qteVente' => $qteVente,'idStockService' => $request->idStockService]
            );

            $data3 = DB::update(
                'update tgaz_entete_vente set montant = montant + (:pu * :qte),reduction = reduction + :reduction,totaltva = totaltva + :totaltva where id = :refEnteteVente',
                ['pu' => $montants,'qte' => $request->qteVente,'reduction' => $request->montantreduction,'totaltva' => $montanttva,'refEnteteVente' => $request->refEnteteVente]
            );

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {

        $puVente=0;
        $qteVente=0;
        $qteBase=0;
        $montanttvaDeleted = 0;
        $montantreductionDeleted = 0;

        $dateVente=0;
        $data_entete =  DB::table("tgaz_entete_vente")
        ->select("tgaz_entete_vente.id", "tgaz_entete_vente.dateVente")
        ->where([
            ['tgaz_entete_vente.id','=', $request->refEnteteVente]
        ])
        ->first(); 
         if ($data_entete) 
         {                                
            $dateVente=$data_entete->dateVente;                           
         }

        $cmup_data = floatval($this->calculerCoutGazMoyen($request->idStockService, $dateVente, $dateVente));


        $deleted =  DB::table("tgaz_detail_vente")
        ->select('id','refEnteteVente','compte_vente','compte_variationstock',
        'compte_perte','compte_produit','compte_destockage','idStockService','idParamLot',
        'puVente','qteVente','uniteVente','cmupVente','devise','taux','montanttva',
        'montantreduction','priseencharge','active','author','refUser')
        ->where([
            ['tgaz_detail_vente.id','=', $id]
         ])
         ->first();
         if ($deleted) 
         {
            $puVente = $deleted->puVente;
            $qteVente = $deleted->qteVente;
            $montanttvaDeleted = $deleted->montanttva;
            $montantreductionDeleted = $deleted->montantreduction;                     
         }
         $qteDeleted = floatval($qteVente);
         $montantDeleted = floatval($qteVente) * floatval($puVente);

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

        $refLot=0;
        $data99=DB::table('tgaz_stock_service_lot') 
        ->select('id','refService','refLot','pu_lot','qte_lot','cmup_lot',
        'devise','taux','active','refUser','author')
        ->where([
            ['tgaz_stock_service_lot.id','=', $request->idStockService]
        ])      
        ->first();
        if ($data99) 
        {
            $refLot =  $data99->refLot;          
        }



        $qte=$request->qteVente;
        $idDetail=$refLot;
        $idFacture=$request->refEnteteVente;

        $compte_achat = 0;
        $compte_vente =0;
        $compte_variationstock=0;
        $compte_perte=0;
        $compte_produit=0;
        $compte_destockage=0;
        $compte_stockage=0;


        $uniteVente = '';
        $cmupVente= $cmup_data;

        $uniteVente = $request->nom_unite;
        $cmupVente = $cmup_data; 

        $qteVente = floatval($request->qteVente);
            
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

        
        $montanttva = (((floatval($request->qteVente) * floatval($montants))*floatval($pourtageTVA))/100);

            $data = tgaz_detail_vente::where('id', $id)->update([
                'refEnteteVente'       =>  $request->refEnteteVente,
                'compte_vente'    =>  $compte_vente,
                'compte_variationstock'    =>  $compte_variationstock,
                'compte_perte'    =>  $compte_perte,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                'idStockService'    =>  $request->idStockService,
                'idParamLot'    =>  $request->idParamLot,
                'puVente'    =>  $montants,
                'qteVente'    =>  $request->qteVente,
                'uniteVente'    =>  $uniteVente,
                'cmupVente'    =>  $cmupVente,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'montanttva'    =>  $montanttva,
                'montantreduction'    =>  $request->montantreduction,
                'active'    =>  $active,
                'author'       =>  $request->author,
                'refUser'    =>  $request->refUser 
            ]);

      
            $data99 = tgaz_mouvement_stock_service_lot::where([['id_data','=', $id],['nom_table','=','tgaz_detail_vente']])->update([             
                'idStockService'    =>  $request->idStockService,             
                'dateMvt'    =>   $request->dateVente,   
                'type_mouvement'    =>  'Sortie',
                'libelle_mouvement'    =>  'Vente des Gaz et Accesseoires',
                'qteMvt'    =>  $request->qteVente,
                'puMvt'    =>  $montants,                   
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'type_sortie'    =>  'Sortie',

                'active'    =>  $active,
                'uniteMvt'    =>  $uniteVente,
                'compte_vente'    =>  $compte_vente,
                'compte_variationstock'    =>  $compte_variationstock,
                'compte_perte'    =>  $compte_perte,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'cmupMvt'    =>  $cmupVente
            ]); 

            $data2 = DB::update(
                'update tgaz_stock_service_lot set qte_lot = qte_lot + :qteDeleted - :qteVente where id = :idStockService',
                ['qteDeleted' => $qteDeleted,'qteVente' => $qteVente,'idStockService' => $request->idStockService]
            );

            $data3 = DB::update(
                'update tgaz_entete_vente set montant = montant - :montantDeleted + (:pu * :qte),reduction = reduction - :montantreductionDeleted + :reduction,totaltva = totaltva - :montanttvaDeleted + :totaltva where id = :refEnteteVente',
                ['montantDeleted' => $montantDeleted,'pu' => $montants,'qte' => $request->qteVente,'montantreductionDeleted' => $montantreductionDeleted,'reduction' => $request->montantreduction,'montanttvaDeleted' => $montanttvaDeleted,'totaltva' => $montanttva,'refEnteteVente' => $request->refEnteteVente]
            );

        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $qte=0;
        $refLot=0;
        $idFacture=0;
        $pu=0;
        $montantreduction=0;
        $montanttva=0;
        $idmax = 0;

        $deleteds = DB::table('tgaz_detail_vente')->Where('id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $qte = $deleted->qteVente;            
            $pu = $deleted->puVente;
            $refLot = $deleted->refLot;
            $idFacture = $deleted->refEnteteVente;
            $montantreduction = $deleted->montantreduction;
            $montanttva = $deleted->montanttva;
        }


        $qteParLot = 0;
        $priceParLot = 0;
        $idStockLot = 0;

        $total_red = 0;
        $total_tva = 0;
        $total_pu = 0;

        $data_qte_lot = DB::table('tgaz_detail_vente')       
        ->selectRaw('SUM(tgaz_detail_vente.qteVente) as qte_kit,
        SUM(tgaz_detail_vente.qteVente * tgaz_detail_vente.puVente) as prix_total_kit,
        SUM(tgaz_detail_vente.puVente) as total_pu,
        SUM(tgaz_detail_vente.montanttva) as total_tva,
        SUM(tgaz_detail_vente.montantreduction) as total_reduction,
         idStockService')
        ->where([
            ['tgaz_detail_vente.refEnteteVente','=', $idFacture]
         ])
        ->groupby('idStockService')
        ->get();
        foreach ($data_qte_lot as $list) {
            $qteParLot= $list->qte_kit;
            $priceParLot= $list->prix_total_kit;
            $idStockLot= $list->idStockService;
            $total_red = $list->total_reduction;
            $total_tva = $list->total_tva;
            $total_pu = $list->total_pu;

            $data2 = DB::update(
            'update tgaz_stock_service_lot set qte_lot = qte_lot + :qteLot where id = :idStockService',
            ['qteLot' => $qteParLot,'idStockService' => $idStockLot]
            );
        
            $data3 = DB::update(
                'update tgaz_entete_vente set montant = montant - (:montant),reduction = reduction - :reduction,totaltva = totaltva - :totaltva where id = :refEnteteVente',
                ['montant' => $priceParLot,'reduction' => $total_red,'totaltva' => $total_tva,'refEnteteVente' => $idFacture]
            );

            $nom_table = 'tgaz_detail_vente';

            $data4 = DB::update(
                'delete from tgaz_mouvement_stock_service_lot where tgaz_mouvement_stock_service_lot.id_data = :id and nom_table=:nom_table',
                ['id' => $id, 'nom_table' => $nom_table]
            );
  
        } 
        $data = tgaz_detail_vente::where('id',$id)->delete();


              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }

    function insert_dataGlobal(Request $request)
    {
        $id_module = 13;
        $active = "OUI";

        $code = $this->GetCodeData('tvente_param_systeme','module_id',$id_module);
        $data11 = tgaz_entete_vente::create([
            'code'       =>  $code,
            'refClient'       =>  $request->refClient,
            'refService'       =>  $request->refService,
            'module_id'       =>  $id_module,
            'dateVente'    =>  $request->dateVente,
            'libelle'    =>  $request->libelle,
            'serveur_id'    =>  $request->serveur_id,
            'etat_facture'    =>  $request->etat_facture,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);

        $idmax=0;
        $maxid = DB::table('tgaz_entete_vente')       
        ->selectRaw('MAX(tgaz_entete_vente.id) as code_entete')
        ->where([
            ['tgaz_entete_vente.refUser','=', $request->refUser],
            ['tgaz_entete_vente.refClient','=', $request->refClient]
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

         $cmup_data = floatval($this->calculerCoutGazMoyen($data['idStockService'], $request->dateVente, $request->dateVente));
         $refLot=0;
         $cmupVente= $cmup_data;
         $data99=DB::table('tgaz_stock_service_lot') 
         ->select('id','refService','refLot','pu_lot','qte_lot','cmup_lot',
         'devise','taux','active','refUser','author')
         ->where([
            ['tgaz_stock_service_lot.id','=', $data['idStockService']]
         ])      
         ->get();
         foreach ($data99 as $row) 
         {
             $refLot =  $row->refLot;     
         }

         $qte=$data['qteVente'];
         $idDetail=$refLot;
         $idFacture=$idmax;
 
         $compte_achat = 0;
         $compte_vente =0;
         $compte_variationstock=0;
         $compte_perte=0;
         $compte_produit=0;
         $compte_destockage=0;
         $compte_stockage=0;
         
 
 
       $uniteVente = ''; 
       $uniteVente = $data['nom_unite'];
       $cmupVente = $cmup_data; 
 
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
    
            $data12 = tgaz_detail_vente::create([
                'refEnteteVente'       =>  $idmax,
                'refProduit'    =>  $refLot,
                'qteVente'    =>  $data['qteVente'],            
                'montantreduction'    =>  $data['montantreduction'],  
                'idStockService'    =>  $data['idStockService'],
                'idParamLot'    =>  $data['idParamLot'], 
                'qte_kit'    =>  $data['qte_kit'],                     
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
                'cmupVente'    =>  $cmupVente,
                'montanttva'    =>  $montanttva,
            ]);



        }

        $qteParLot = 0;
        $priceParLot = 0;
        $idStockLot = 0;

        $total_red = 0;
        $total_tva = 0;
        $total_pu = 0;

        $data_qte_lot = DB::table('tgaz_detail_vente')       
        ->selectRaw('MAX(tgaz_detail_vente.qte_kit) as qte_kit,
        SUM(tgaz_detail_vente.qteVente * tgaz_detail_vente.puVente) as prix_total_kit,
        SUM(tgaz_detail_vente.puVente) as total_pu,
        SUM(tgaz_detail_vente.montanttva) as total_tva,
        SUM(tgaz_detail_vente.montantreduction) as total_reduction,
         idStockService')
        ->where([
            ['tgaz_detail_vente.refEnteteVente','=', $idmax]
         ])
        ->groupby('idStockService')
        ->get();
        foreach ($data_qte_lot as $list) {
            $qteParLot= $list->qte_kit;
            $priceParLot= $list->prix_total_kit;
            $idStockLot= $list->idStockService;
            $total_red = $list->total_reduction;
            $total_tva = $list->total_tva;
            $total_pu = $list->total_pu;

            $data2 = DB::update(
            'update tgaz_stock_service_lot set qte_lot = qte_lot - :qteLot where id = :idStockService',
            ['qteLot' => $qteParLot,'idStockService' => $idStockLot]
            );
        
            $data3 = DB::update(
                'update tgaz_entete_vente set montant = montant + (:montant),reduction = reduction + :reduction,totaltva = totaltva + :totaltva where id = :refEnteteVente',
                ['montant' => $priceParLot,'reduction' => $total_red,'totaltva' => $total_tva,'refEnteteVente' => $idmax]
            );

            $id_detail_max=0;
            $detail_list = DB::table('tgaz_detail_vente')       
            ->selectRaw('MAX(id) as code_entete')
            ->where([
                ['refUser','=', $request->refUser],
                ['idStockService','=', $idStockLot]
             ]) 
            ->get();
            foreach ($detail_list as $list) {
                $id_detail_max= $list->code_entete;
            }
          
            $data99 = tgaz_mouvement_stock_service_lot::create([             
                'idStockService'    =>  $idStockLot,             
                'dateMvt'    =>   $request->dateVente,   
                'type_mouvement'    =>  'Sortie',
                'libelle_mouvement'    =>  'Vente des Gaz et Accesseoires',
                'nom_table'    =>  'tgaz_detail_vente',
                'id_data'    =>  $id_detail_max, 
                'qteMvt'    =>  $qteParLot,
                'puMvt'    =>  $total_pu,                   
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'type_sortie'    =>  'Sortie',
    
                'active'    =>  $active,
                'uniteMvt'    =>  $uniteVente,
                'compte_vente'    =>  $compte_vente,
                'compte_variationstock'    =>  $compte_variationstock,
                // 'compte_perte'    =>  $compte_perte,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                // 'compte_achat'    =>  $compte_achat,
                // 'compte_stockage'    =>  $compte_stockage,
                'puVente'    =>  $total_pu,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'cmupMvt'    =>  $total_pu
            ]); 

        }      

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }

    function insert_dataGlobalCash(Request $request)
    {
        $id_module = 13;
        $active = "OUI";

        $code = $this->GetCodeData('tvente_param_systeme','module_id',$id_module);
        $data11 = tgaz_entete_vente::create([
            'code'       =>  $code,
            'refClient'       =>  $request->refClient,
            'refService'       =>  $request->refService,
            'module_id'       =>  $id_module,
            'dateVente'    =>  $request->dateVente,
            'libelle'    =>  $request->libelle,
            'serveur_id'    =>  $request->serveur_id,
            'etat_facture'    =>  $request->etat_facture,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);

        $idmax=0;
        $maxid = DB::table('tgaz_entete_vente')       
        ->selectRaw('MAX(tgaz_entete_vente.id) as code_entete')
        ->where([
            ['tgaz_entete_vente.refUser','=', $request->refUser],
            ['tgaz_entete_vente.refClient','=', $request->refClient]
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
    
            $cmup_data = floatval($this->calculerCoutGazMoyen($data['idStockService'], $request->dateVente, $request->dateVente));
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

         $refLot=0;
         $cmupVente= $cmup_data;
         $data99=DB::table('tgaz_stock_service_lot') 
         ->select('id','refService','refLot','pu_lot','qte_lot','cmup_lot',
         'devise','taux','active','refUser','author')
         ->where([
            ['tgaz_stock_service_lot.id','=', $data['idStockService']]
         ])      
         ->get();
         foreach ($data99 as $row) 
         {
             $refLot =  $row->refLot;       
         }

         $qte=$data['qteVente'];
         $idDetail=$refLot;
         $idFacture=$idmax;
 
         $compte_achat = 0;
         $compte_vente =0;
         $compte_variationstock=0;
         $compte_perte=0;
         $compte_produit=0;
         $compte_destockage=0;
         $compte_stockage=0;
         
 
 
       $uniteVente = ''; 
       $uniteVente = $data['nom_unite'];
       $cmupVente = $cmup_data; 
 
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
    
            $data12 = tgaz_detail_vente::create([
                'refEnteteVente'       =>  $idmax,
                'refProduit'    =>  $refLot,
                'qteVente'    =>  $data['qteVente'],            
                'montantreduction'    =>  $data['montantreduction'],  
                'idStockService'    =>  $data['idStockService'],
                'idParamLot'    =>  $data['idParamLot'],                     
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
                'cmupVente'    =>  $cmupVente,
                'montanttva'    =>  $montanttva,
            ]);


        }

        $qteParLot = 0;
        $priceParLot = 0;
        $idStockLot = 0;

        $total_red = 0;
        $total_tva = 0;
        $total_pu = 0;

        $data_qte_lot = DB::table('tgaz_detail_vente')       
        ->selectRaw('SUM(tgaz_detail_vente.qteVente) as qte_kit,
        SUM(tgaz_detail_vente.qteVente * tgaz_detail_vente.puVente) as prix_total_kit,
        SUM(tgaz_detail_vente.puVente) as total_pu,
        SUM(tgaz_detail_vente.montanttva) as total_tva,
        SUM(tgaz_detail_vente.montantreduction) as total_reduction,
         idStockService')
        ->where([
            ['tgaz_detail_vente.refEnteteVente','=', $idmax]
         ])
        ->groupby('idStockService')
        ->get();
        foreach ($data_qte_lot as $list) {
            $qteParLot= $list->qte_kit;
            $priceParLot= $list->prix_total_kit;
            $idStockLot= $list->idStockService;
            $total_red = $list->total_reduction;
            $total_tva = $list->total_tva;
            $total_pu = $list->total_pu;

            $data2 = DB::update(
            'update tgaz_stock_service_lot set qte_lot = qte_lot - :qteLot where id = :idStockService',
            ['qteLot' => $qteParLot,'idStockService' => $idStockLot]
            );
        
            $data3 = DB::update(
                'update tgaz_entete_vente set montant = montant + (:montant),reduction = reduction + :reduction,totaltva = totaltva + :totaltva where id = :refEnteteVente',
                ['montant' => $priceParLot,'reduction' => $total_red,'totaltva' => $total_tva,'refEnteteVente' => $idmax]
            );


            $id_detail_max=0;
            $detail_list = DB::table('tgaz_detail_vente')       
            ->selectRaw('MAX(id) as code_entete')
            ->where([
                ['refUser','=', $request->refUser],
                ['idStockService','=', $idStockLot]
             ]) 
            ->get();
            foreach ($detail_list as $list) {
                $id_detail_max= $list->code_entete;
            }
          
            $data99 = tgaz_mouvement_stock_service_lot::create([             
                'idStockService'    =>  $idStockLot,             
                'dateMvt'    =>   $request->dateVente,   
                'type_mouvement'    =>  'Sortie',
                'libelle_mouvement'    =>  'Vente des Gaz et Accesseoires',
                'nom_table'    =>  'tgaz_detail_vente',
                'id_data'    =>  $id_detail_max, 
                'qteMvt'    =>  $qteParLot,
                'puMvt'    =>  $total_pu,                   
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'type_sortie'    =>  'Sortie',
    
                'active'    =>  $active,
                'uniteMvt'    =>  $uniteVente,
                'compte_vente'    =>  $compte_vente,
                'compte_variationstock'    =>  $compte_variationstock,
                // 'compte_perte'    =>  $compte_perte,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                // 'compte_achat'    =>  $compte_achat,
                // 'compte_stockage'    =>  $compte_stockage,
                'puVente'    =>  $total_pu,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'cmupMvt'    =>  $total_pu
            ]); 

        }      


        //PAIEMENT DE LA FACTURE ===================================================================


        
        $montants=0;
        $Gaz = DB::table('tgaz_entete_vente')
        ->selectRaw('(tgaz_entete_vente.montant - tgaz_entete_vente.reduction + tgaz_entete_vente.totaltva) as montant')
        ->Where('id',$idmax)->get(); 
        foreach ($Gaz as $vente) {
            $montants = $vente->montant;
        }


        $current = Carbon::now(); 
        $refEntetepaie=0; 
        $refService = $request->refService;
        $module_id_paie = 14;      

        $codepaie = $this->GetCodeData('tvente_param_systeme','module_id',$module_id_paie); 

        $data13 = tgaz_entete_paiement_vente::create([
            'code'       =>  $codepaie,
            'date_entete_paie'    =>  $current,
            'refService'    =>  $refService,
            'module_id'    =>  $module_id_paie,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        
        $idmax_paie=0;
        $maxid = DB::table('tgaz_entete_paiement_vente')       
        ->selectRaw('MAX(tgaz_entete_paiement_vente.id) as code_entete')
        ->where([
            ['tgaz_entete_paiement_vente.refUser','=', $request->refUser],
            ['tgaz_entete_paiement_vente.refService','=', $refService]
         ])
        ->get();
        foreach ($maxid as $list) {
            $idmax_paie= $list->code_entete;
        }

        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', $request->dateVente)
       ->take(1)
       ->orderBy('id', 'desc')         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == $request->dateVente)
       {
            return response()->json([
                'data'  =>  "La Caisse est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
            ]);            
       }
       else
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

            $modepaie = 'CASH';
            $libellepaie = 'Paiement vente Cash';
            $refBanque = 0;
            $numeroBordereau = '0000000000';

            $data44 = DB::table('tconf_banque')
            ->select('id','nom_banque','numerocompte','nom_mode','refSscompte')
            ->where('nom_mode','=', $modepaie)
            ->get();    
            foreach ($data44 as $row) 
            {                           
                $refBanque=$row->id;          
            }

            $data14 = tgaz_detail_paiement_vente::create([
                'refEntetepaie'       =>  $idmax_paie,
                'refEnteteVente'       => $idmax,
                'montant_paie'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'date_paie'    =>  $request->dateVente,
                'modepaie'       =>  $modepaie,
                'libellepaie'       =>  $libellepaie, 
                'refBanque'       =>  $refBanque,
                'numeroBordereau'       =>  $numeroBordereau,
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'active'       =>  $active
            ]);

            $data3 = DB::update(
                'update tgaz_entete_vente set paie = paie + (:paiement) where id = :refEnteteVente',
                ['paiement' => $montants,'refEnteteVente' => $idmax]
            );       

       }

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }



    function insert_paiement_cash(Request $request, $id)
    {

        $current = Carbon::now(); 
        $refEntetepaie=0; 
        $module_id_paie = 5;
        $active = "OUI";

        $codepaie = $this->GetCodeData('tvente_param_systeme','module_id',$module_id_paie); 
        $idmax = $id; 
        $refService = 0;  

        //PAIEMENT DE LA FACTURE ===================================================================
        
        $montants=0;
        $Gaz = DB::table('tgaz_entete_vente')
        ->select('id','code','refClient','refService','module_id',
        'dateVente','libelle','serveur_id','etat_facture','montant','paie','reduction',
        'totaltva','author','refUser')
        ->selectRaw('(tgaz_entete_vente.montant - tgaz_entete_vente.reduction + tgaz_entete_vente.totaltva) as montant')
        ->Where('id',$idmax)->get(); 
        foreach ($Gaz as $vente) {
            $montants = $vente->montant;
            $refService = $vente->refService;
        } 

        $data11 = tgaz_entete_paiement_vente::create([
            'code'       =>  $codepaie,
            'date_entete_paie'    =>  $current,
            'refService'    =>  $refService,
            'module_id'    =>  $module_id_paie,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        
        $idmax_paie=0;
        $maxid = DB::table('tgaz_entete_paiement_vente')       
        ->selectRaw('MAX(tgaz_entete_paiement_vente.id) as code_entete')
        ->where([
            ['tgaz_entete_paiement_vente.refUser','=', $request->refUser],
            ['tgaz_entete_paiement_vente.refService','=', $refService]
         ])
        ->get();
        foreach ($maxid as $list) {
            $idmax_paie= $list->code_entete;
        }

        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', $request->dateVente)
       ->take(1)
       ->orderBy('id', 'desc')         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == $request->dateVente)
       {
            return response()->json([
                'data'  =>  "La Caisse est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
            ]);            
       }
       else
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

            $devises = 'USD';
            $modepaie = 'CASH';
            $libellepaie = 'Paiement vente Cash';
            $refBanque = 0;
            $numeroBordereau = '0000000000';

            $data44 = DB::table('tconf_banque')
            ->select('id','nom_banque','numerocompte','nom_mode','refSscompte')
            ->where('nom_mode','=', $modepaie)
            ->get();    
            foreach ($data44 as $row) 
            {                           
                $refBanque=$row->id;          
            }

            $data12 = tgaz_detail_paiement_vente::create([
                'refEntetepaie'       =>  $idmax_paie,
                'refEnteteVente'       => $idmax,
                'montant_paie'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'date_paie'    =>  $current,
                'modepaie'       =>  $modepaie,
                'libellepaie'       =>  $libellepaie, 
                'refBanque'       =>  $refBanque,
                'numeroBordereau'       =>  $numeroBordereau,
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'active'       =>  $active
            ]);

            $data3 = DB::update(
                'update tgaz_entete_vente set paie = paie + (:paiement) where id = :refEnteteVente',
                ['paiement' => $montants,'refEnteteVente' => $idmax]
            );       

       }

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }


}
