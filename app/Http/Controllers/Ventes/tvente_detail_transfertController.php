<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_detail_transfert;
use App\Models\Ventes\tvente_entete_transfert;
use App\Models\Ventes\tvente_mouvement_stock;
use App\Models\Ventes\tvente_entete_entree;
use App\Models\Ventes\tvente_entete_utilisation;
use App\Models\Ventes\tvente_detail_utilisation;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tvente_detail_transfertController extends Controller
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

        $data = DB::table('tvente_detail_transfert')  
        ->join('tvente_entete_transfert','tvente_entete_transfert.id','=','tvente_detail_transfert.refEnteteTransfert')     
        ->join('tvente_services as servicesOrigine','servicesOrigine.id','=','tvente_entete_transfert.refService')
        ->join('tvente_services as servicesDestination','servicesDestination.id','=','tvente_detail_transfert.refDestination')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_transfert.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tfin_ssouscompte as compteachat','compteachat.id','=','tvente_categorie_produit.compte_achat')
        ->join('tfin_ssouscompte as comptevente','comptevente.id','=','tvente_categorie_produit.compte_vente')
        ->join('tfin_ssouscompte as comptevariation','comptevariation.id','=','tvente_categorie_produit.compte_variationstock')
        ->join('tfin_ssouscompte as compteperte','compteperte.id','=','tvente_categorie_produit.compte_perte')
        ->join('tfin_ssouscompte as compteproduit','compteproduit.id','=','tvente_categorie_produit.compte_produit')
        ->join('tfin_ssouscompte as comptedestockage','comptedestockage.id','=','tvente_categorie_produit.compte_destockage')
        ->join('tfin_ssouscompte as comptestockage','comptestockage.id','=','tvente_categorie_produit.compte_stockage') 
        ->select('tvente_detail_transfert.id','refEnteteTransfert','refProduit','refDestination','puTransfert',
        'qteTransfert','uniteTransfert','tvente_detail_transfert.puBase','tvente_detail_transfert.qteBase',
        'tvente_detail_transfert.uniteBase','tvente_detail_transfert.author','tvente_detail_transfert.refUser',
        'tvente_detail_transfert.created_at','refService','date_transfert',"servicesOrigine.nom_service as ServiceOrigine",
        "servicesDestination.nom_service as ServiceDestination"

        ,"tvente_produit.designation as designation",'refCategorie','refUniteBase','pu','qte',
        'cmup','devise','taux','Oldcode','Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie",
        'compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
        'compte_perte','compte_produit','compte_destockage','compte_stockage' 
        ,'compteachat.refSousCompte as refSousCompteAchat','compteachat.nom_ssouscompte as nom_ssouscompteAchat',
        'compteachat.numero_ssouscompte as numero_ssouscompteAchat'
        ,'comptevente.refSousCompte as refSousCompteVente','comptevente.nom_ssouscompte as nom_ssouscompteVente',
        'comptevente.numero_ssouscompte as numero_ssouscompteVente'
        ,'comptevariation.refSousCompte as refSousCompteVariation','comptevariation.nom_ssouscompte as nom_ssouscompteVariation',
        'comptevariation.numero_ssouscompte as numero_ssouscompteVariation'
        ,'compteperte.refSousCompte as refSousComptePerte','compteperte.nom_ssouscompte as nom_ssouscomptePerte',
        'compteperte.numero_ssouscompte as numero_ssouscomptePerte'
        ,'compteproduit.refSousCompte as refSousCompteProduit','compteproduit.nom_ssouscompte as nom_ssouscompteProduit',
        'compteproduit.numero_ssouscompte as numero_ssouscompteProduit'
        ,'comptedestockage.refSousCompte as refSousCompteDestockage','comptedestockage.nom_ssouscompte as nom_ssouscompteDestockage',
        'comptedestockage.numero_ssouscompte as numero_ssouscompteDestockage'
        ,'comptestockage.refSousCompte as refSousCompteStockage','comptestockage.nom_ssouscompte as nom_ssouscompteStockage',
        'comptestockage.numero_ssouscompte as numero_ssouscompteStockage'
        )
        ->selectRaw('(qteTransfert*puTransfert) as PTTransfert')
        ->selectRaw('(qteBase*puBase) as PTBase');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tvente_produit.designation', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_transfert.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_detail_transfert.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    {
        $data = DB::table('tvente_detail_transfert')  
        ->join('tvente_entete_transfert','tvente_entete_transfert.id','=','tvente_detail_transfert.refEnteteTransfert')     
        ->join('tvente_services as servicesOrigine','servicesOrigine.id','=','tvente_entete_transfert.refService')
        ->join('tvente_services as servicesDestination','servicesDestination.id','=','tvente_detail_transfert.refDestination')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_transfert.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tfin_ssouscompte as compteachat','compteachat.id','=','tvente_categorie_produit.compte_achat')
        ->join('tfin_ssouscompte as comptevente','comptevente.id','=','tvente_categorie_produit.compte_vente')
        ->join('tfin_ssouscompte as comptevariation','comptevariation.id','=','tvente_categorie_produit.compte_variationstock')
        ->join('tfin_ssouscompte as compteperte','compteperte.id','=','tvente_categorie_produit.compte_perte')
        ->join('tfin_ssouscompte as compteproduit','compteproduit.id','=','tvente_categorie_produit.compte_produit')
        ->join('tfin_ssouscompte as comptedestockage','comptedestockage.id','=','tvente_categorie_produit.compte_destockage')
        ->join('tfin_ssouscompte as comptestockage','comptestockage.id','=','tvente_categorie_produit.compte_stockage') 
        ->select('tvente_detail_transfert.id','refEnteteTransfert','refProduit','refDestination','puTransfert',
        'qteTransfert','uniteTransfert','tvente_detail_transfert.puBase','tvente_detail_transfert.qteBase',
        'tvente_detail_transfert.uniteBase','tvente_detail_transfert.author','tvente_detail_transfert.refUser',
        'tvente_detail_transfert.created_at','refService','date_transfert',"servicesOrigine.nom_service as ServiceOrigine",
        "servicesDestination.nom_service as ServiceDestination"

        ,"tvente_produit.designation as designation",'refCategorie','refUniteBase','pu','qte',
        'cmup','devise','taux','Oldcode','Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie",
        'compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
        'compte_perte','compte_produit','compte_destockage','compte_stockage' 
        ,'compteachat.refSousCompte as refSousCompteAchat','compteachat.nom_ssouscompte as nom_ssouscompteAchat',
        'compteachat.numero_ssouscompte as numero_ssouscompteAchat'
        ,'comptevente.refSousCompte as refSousCompteVente','comptevente.nom_ssouscompte as nom_ssouscompteVente',
        'comptevente.numero_ssouscompte as numero_ssouscompteVente'
        ,'comptevariation.refSousCompte as refSousCompteVariation','comptevariation.nom_ssouscompte as nom_ssouscompteVariation',
        'comptevariation.numero_ssouscompte as numero_ssouscompteVariation'
        ,'compteperte.refSousCompte as refSousComptePerte','compteperte.nom_ssouscompte as nom_ssouscomptePerte',
        'compteperte.numero_ssouscompte as numero_ssouscomptePerte'
        ,'compteproduit.refSousCompte as refSousCompteProduit','compteproduit.nom_ssouscompte as nom_ssouscompteProduit',
        'compteproduit.numero_ssouscompte as numero_ssouscompteProduit'
        ,'comptedestockage.refSousCompte as refSousCompteDestockage','comptedestockage.nom_ssouscompte as nom_ssouscompteDestockage',
        'comptedestockage.numero_ssouscompte as numero_ssouscompteDestockage'
        ,'comptestockage.refSousCompte as refSousCompteStockage','comptestockage.nom_ssouscompte as nom_ssouscompteStockage',
        'comptestockage.numero_ssouscompte as numero_ssouscompteStockage'
        )
        ->selectRaw('(qteTransfert*puTransfert) as PTTransfert')
        ->selectRaw('(qteBase*puBase) as PTBase')
        ->Where('refEnteteTransfert',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('tvente_produit.designation', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_transfert.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_detail_transfert.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    


    function fetch_single_data($id)
    {
        $data = DB::table('tvente_detail_transfert')  
        ->join('tvente_entete_transfert','tvente_entete_transfert.id','=','tvente_detail_transfert.refEnteteTransfert')     
        ->join('tvente_services as servicesOrigine','servicesOrigine.id','=','tvente_entete_transfert.refService')
        ->join('tvente_services as servicesDestination','servicesDestination.id','=','tvente_detail_transfert.refDestination')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_transfert.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tfin_ssouscompte as compteachat','compteachat.id','=','tvente_categorie_produit.compte_achat')
        ->join('tfin_ssouscompte as comptevente','comptevente.id','=','tvente_categorie_produit.compte_vente')
        ->join('tfin_ssouscompte as comptevariation','comptevariation.id','=','tvente_categorie_produit.compte_variationstock')
        ->join('tfin_ssouscompte as compteperte','compteperte.id','=','tvente_categorie_produit.compte_perte')
        ->join('tfin_ssouscompte as compteproduit','compteproduit.id','=','tvente_categorie_produit.compte_produit')
        ->join('tfin_ssouscompte as comptedestockage','comptedestockage.id','=','tvente_categorie_produit.compte_destockage')
        ->join('tfin_ssouscompte as comptestockage','comptestockage.id','=','tvente_categorie_produit.compte_stockage') 
        ->select('tvente_detail_transfert.id','refEnteteTransfert','refProduit','refDestination','puTransfert',
        'qteTransfert','uniteTransfert','tvente_detail_transfert.puBase','tvente_detail_transfert.qteBase',
        'tvente_detail_transfert.uniteBase','tvente_detail_transfert.author','tvente_detail_transfert.refUser',
        'tvente_detail_transfert.created_at','refService','date_transfert',"servicesOrigine.nom_service as ServiceOrigine",
        "servicesDestination.nom_service as ServiceDestination"

        ,"tvente_produit.designation as designation",'refCategorie','refUniteBase','pu','qte',
        'cmup','devise','taux','Oldcode','Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie",
        'compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
        'compte_perte','compte_produit','compte_destockage','compte_stockage' 
        ,'compteachat.refSousCompte as refSousCompteAchat','compteachat.nom_ssouscompte as nom_ssouscompteAchat',
        'compteachat.numero_ssouscompte as numero_ssouscompteAchat'
        ,'comptevente.refSousCompte as refSousCompteVente','comptevente.nom_ssouscompte as nom_ssouscompteVente',
        'comptevente.numero_ssouscompte as numero_ssouscompteVente'
        ,'comptevariation.refSousCompte as refSousCompteVariation','comptevariation.nom_ssouscompte as nom_ssouscompteVariation',
        'comptevariation.numero_ssouscompte as numero_ssouscompteVariation'
        ,'compteperte.refSousCompte as refSousComptePerte','compteperte.nom_ssouscompte as nom_ssouscomptePerte',
        'compteperte.numero_ssouscompte as numero_ssouscomptePerte'
        ,'compteproduit.refSousCompte as refSousCompteProduit','compteproduit.nom_ssouscompte as nom_ssouscompteProduit',
        'compteproduit.numero_ssouscompte as numero_ssouscompteProduit'
        ,'comptedestockage.refSousCompte as refSousCompteDestockage','comptedestockage.nom_ssouscompte as nom_ssouscompteDestockage',
        'comptedestockage.numero_ssouscompte as numero_ssouscompteDestockage'
        ,'comptestockage.refSousCompte as refSousCompteStockage','comptestockage.nom_ssouscompte as nom_ssouscompteStockage',
        'comptestockage.numero_ssouscompte as numero_ssouscompteStockage'
        )
        ->selectRaw('(qteTransfert*puTransfert) as PTTransfert')
        ->selectRaw('(qteBase*puBase) as PTBase')
        ->where('tvente_detail_transfert.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function insert_data(Request $request)
    {    

        $id_service = $request->refDestination;
        $id_produit = 0;


        $temp_idservice = 0;
        $temp_idproduit = 0;
        $temp_id=0;
        $idStockService=0;

        $stockservice = DB::table('tvente_stock_service')       
        ->select('id','refService','refProduit','pu','qte','uniteBase','cmup',
        'devise','taux','active','refUser','author')
        ->where([
           ['tvente_stock_service.id','=',  $request->idStockService]
        ])
        ->get();
        foreach ($stockservice as $list) {
            $id_produit = $list->refProduit;
        }

        $stockservicedest = DB::table('tvente_stock_service')       
        ->select('id','refService','refProduit','pu','qte','uniteBase','cmup',
        'devise','taux','active','refUser','author')
        ->where([
           ['tvente_stock_service.refService','=',  $id_service],
           ['tvente_stock_service.refProduit','=',  $id_produit]
       ])
        ->get();
        foreach ($stockservicedest as $list) {
            $temp_idservice = $list->refService;
            $temp_idproduit = $list->refProduit;
            $temp_id = $list->id;
        }

        $compte_achat = 0;
        $compte_vente =0;
        $compte_variationstock=0;
        $compte_perte=0;
        $compte_produit=0;
        $compte_destockage=0;
        $compte_stockage=0;
        $cmupVente=0;
        $cmupTemp=0;
        $SI=0;

        $data3=DB::table('tvente_produit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
         ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
         'compte_perte','compte_produit','compte_destockage','compte_stockage','cmup','qte')
         ->where([
            ['tvente_produit.id','=', $id_produit]
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
            $cmupTemp=$row->cmup;    
            $SI = $row->qte;     
        }


       $puTransfert=0;
       $qteTransfert=0;
       $uniteTransfert='';
       $puBase=0;
       $qteBase=0;
       $uniteBase='';

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
            $puTransfert=$row->puUnite;
            $qteTransfert=$row->qteUnite;
            $uniteTransfert=$row->nom_unite;
            $puBase=$row->puBase;
            $qteBase=$row->qteBase;
            $uniteBase=$row->uniteBase;
       }

       $taux=0;
       $data5 =  DB::table("tvente_taux")
       ->select("tvente_taux.id", "tvente_taux.taux", 
       "tvente_taux.created_at", "tvente_taux.author")
        ->get();
        foreach ($data5 as $row) 
        {                                
           $taux=$row->taux;                           
        }

       $devise=0;
       $data55 =  DB::table("tvente_devise")
       ->select("tvente_devise.id", "tvente_devise.designation","tvente_devise.created_at")
       ->where([
           ['tvente_devise.active','=', 'OUI']
       ])
        ->get();
        foreach ($data55 as $row) 
        {                                
           $devise=$row->designation;                           
        }

       $qteEntree = $qteBase * floatval($request->qteTransfert);

       $refServiceSource = $request->refService;  

       if(($id_service == $temp_idservice) && ($id_produit == $temp_idproduit))
       {
            $data23 = DB::update(
            'update tvente_stock_service set qte = qte + :qteTransfert where (refProduit = :refProduit) and (refService = :refService)',
            ['qteTransfert' => $qteEntree,'refProduit' => $id_produit,'refService' => $id_service]
            );

            $data22 = DB::update(
               'update tvente_stock_service set qte = qte - :qteTransfert where (tvente_stock_service.id = :id)',
               ['qteTransfert' => $qteEntree,'id' => $request->idStockService]
           );
       }
       else
       {
           $data22 = DB::update(
               'insert into tvente_stock_service (refService,refProduit,pu,qte,uniteBase,cmup,devise,taux,active,refUser,author) 
               values (:refService,:refProduit,:pu,:qte,:uniteBase,:cmup,:devise,:taux,:active,:refUser,:author)',
               ['refService' => $id_service,'refProduit' => $id_produit,'pu' => $cmupTemp,'qte' => $qteEntree,
               'uniteBase' => $uniteBase,'cmup' => $cmupTemp,'devise' => $devise,'taux' => $taux,'active' => $active,
               'refUser' => $request->refUser,'author' => $request->author]
           );

           $data22 = DB::update(
            'update tvente_stock_service set qte = qte - :qteTransfert where (tvente_stock_service.id = :id)',
            ['qteTransfert' => $qteEntree,'id' => $request->idStockService]
            );
       }        


        $data = tvente_detail_transfert::create([
            'refEnteteTransfert'       => $request->refEnteteTransfert,
            'refProduit'       =>  $id_produit,  
            'refDestination'       =>  $request->refDestination,  
            'idStockService'       =>  $temp_id,         
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser,

            'puTransfert'       =>  $puTransfert, 
            'qteTransfert'       =>  $request->qteTransfert, 
            'uniteTransfert'       =>  $uniteTransfert, 
            'puBase'       =>  $puBase, 
            'qteBase'       =>  $qteBase, 
            'uniteBase'       =>  $uniteBase,
        ]);
        // $data2 = DB::update(
        //     'update tvente_produit set qte = qte - :qteTransfert where id = :refProduit',
        //     ['qteTransfert' => $qteEntree,'refProduit' => $data['refProduit']]
        // );    


        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {
        $data = tvente_detail_transfert::where('id', $id)->update([
            'refEnteteTransfert'       =>  $request->refEnteteTransfert,
            'refProduit'       =>  $request->refProduit,  
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
        $id_produit=0;
        $id_service=0;
        $id_source;
        $status_source = '';
        $status_dest = '';
        $puBase =0;

        $deleteds = DB::table('tvente_detail_transfert')
        ->join('tvente_entete_transfert','tvente_entete_transfert.id','=','tvente_detail_transfert.refEnteteTransfert')
        ->join('tvente_services as servicesOrigine','servicesOrigine.id','=','tvente_entete_transfert.refService')
        ->join('tvente_services as servicesDestination','servicesDestination.id','=','tvente_detail_transfert.refDestination')
        ->select('tvente_detail_transfert.id','refEnteteTransfert','refProduit','refDestination',
        'puTransfert','qteTransfert','uniteTransfert','puBase','qteBase','uniteBase','tvente_detail_transfert.author',
        'tvente_detail_transfert.refUser','refService','date_transfert',
        'servicesOrigine.status as status_source',
        'servicesDestination.status as status_dest')
        ->selectRaw('(qteBase * qteTransfert) as qteTotal')
        ->Where('tvente_detail_transfert.id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $qte = $deleted->qteTotal;
            $id_produit = $deleted->refProduit;
            $id_service = $deleted->refDestination;
            $id_source = $deleted->refService;
            $status_source = $deleted->status_source;
            $status_dest = $deleted->status_dest;
            $puBase = $deleted->puBase;
        }

        $stockservicedest=0;
        $listeStockDest = DB::table('tvente_stock_service')       
        ->select('id','refService','refProduit','pu','qte','uniteBase','cmup',
        'devise','taux','active','refUser','author')
        ->where([
           ['tvente_stock_service.refService','=',  $id_service],
           ['tvente_stock_service.refProduit','=',  $id_produit]
       ])
        ->get();
        foreach ($listeStockDest as $list) {
            $stockservicedest = $list->id;
        }

        $stockservicesource=0;
        $listeStockSource = DB::table('tvente_stock_service')       
        ->select('id','refService','refProduit','pu','qte','uniteBase','cmup',
        'devise','taux','active','refUser','author')
        ->where([
           ['tvente_stock_service.refService','=',  $id_service],
           ['tvente_stock_service.refProduit','=',  $id_produit]
       ])
        ->get();
        foreach ($listeStockSource as $list) {
            $stockservicesource = $list->id;
        }



        $data2 = DB::update(
            'update tvente_stock_service set qte = qte - :qteVente where (refProduit = :refProduit) and (refService = :refService)',
            ['qteVente' => $qte,'refProduit' => $id_produit,'refService' => $id_service]
        );

        $data3 = DB::update(
            'update tvente_stock_service set qte = qte + :qteVente where (refProduit = :refProduit) and (refService = :refService)',
            ['qteVente' => $qte,'refProduit' => $id_produit,'refService' => $id_source]
        );

        
        $nom_table = 'tvente_detail_transfert';

        $data4 = DB::update(
            'delete from tvente_mouvement_stock where tvente_mouvement_stock.id_data = :id and nom_table=:nom_table',
            ['id' => $id, 'nom_table' => $nom_table]
        );

 

        $data = tvente_detail_transfert::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }

    function insert_dataGlobal(Request $request)
    {
        $id_module = 3;
        $active = "OUI";

        $code = $this->GetCodeData('tvente_param_systeme','module_id',$id_module);
        $data = tvente_entete_transfert::create([
            'refService'       =>  $request->refService,
            'module_id'       =>  $id_module,
            'date_transfert'       =>  $request->date_transfert,         
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser
        ]);



            $nom_service_source = '';
            $nom_service_destination = '';    
            $date_serv_source = DB::table("tvente_services")
            ->select("tvente_services.id","tvente_services.nom_service",
            "tvente_services.created_at","status",
            'tvente_services.active')
             ->where([
                ['tvente_services.id','=',  $request->refService]
            ])      
            ->first();
            if ($date_serv_source) 
            {                 
                 $nom_service_source=$date_serv_source->nom_service; 
            }

            $date_serv_desti = DB::table("tvente_services")
            ->select("tvente_services.id","tvente_services.nom_service",
            "tvente_services.created_at","status",
            'tvente_services.active')
             ->where([
                ['tvente_services.id','=',  $request->refDestination]
            ])      
            ->first();
            if ($date_serv_desti) 
            {                 
                 $nom_service_destination=$date_serv_desti->nom_service; 
            }


        $idmax=0;
        $maxid = DB::table('tvente_entete_transfert')       
        ->selectRaw('MAX(tvente_entete_transfert.id) as code_entete')
        ->where('tvente_entete_transfert.refService', $request->refService)
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_entete;
        }
        $detailData = $request->detailData;

        foreach ($detailData as $data) {
            
            $refIdStockSource = $data['idStockService'];
            $id_produit = 0;

            $cmup_data = floatval($this->calculerCoutMoyen($refIdStockSource, $request->date_transfert, $request->date_transfert));
    
            $temp_idservice = 0;
            $temp_idproduit = 0;
            $temp_id=0;

            $puTransfert=0;
            $qteTransfert=0;
            $uniteTransfert='';
            $puBase=0;
            $qteBase=0;
            $uniteBase='';
            $estunite = '';
    
            $data4=DB::table('tvente_detail_unite')
            ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
            ->join('tvente_produit','tvente_produit.id','=','tvente_detail_unite.refProduit')
            ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
            ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
            'compte_perte','compte_produit','compte_destockage','compte_stockage','uniteBase','qteBase',
            'puBase','nom_unite','qteUnite','puUnite','refProduit','estunite')
             ->where([
                ['tvente_detail_unite.id','=',  $data['refDetailUnite']]
            ])      
            ->get();      
            
            foreach ($data4 as $row) 
            {                 
                 $qteTransfert=$row->qteUnite;               
                 $uniteTransfert=$row->nom_unite;                 
                 $qteBase=$row->qteBase;
                 $uniteBase=$row->uniteBase;
                 $id_produit = $row->refProduit;
                 $estunite = $row->estunite;
            }
    
           $stockservicedest = DB::table('tvente_stock_service')       
            ->select('id','refService','refProduit','pu','qte','uniteBase','cmup',
            'devise','taux','active','refUser','author')
            ->where([
               ['tvente_stock_service.refService','=',  $request->refDestination],
               ['tvente_stock_service.refProduit','=',  $id_produit]
           ])
            ->get();
            foreach ($stockservicedest as $list) {
                $temp_idservice = $list->refService;
                $temp_idproduit = $list->refProduit;
                $temp_id = $list->id;

 
                if($estunite = "NON")
                {
                     if ($qteBase != 0) {
                         $puBase=  floatval($cmup_data);
                         $puTransfert = floatval($cmup_data) * floatval($qteBase);  
                     } 
                     else {
                         $puBase=  floatval($cmup_data);
                         $puTransfert = floatval($cmup_data) * floatval($qteBase);
                     }                           
                }
                else
                {
                   $puBase=  floatval($cmup_data);
                   $puTransfert=floatval($cmup_data);
                }
            }
  
            $compte_achat = 0;
            $compte_vente =0;
            $compte_variationstock=0;
            $compte_perte=0;
            $compte_produit=0;
            $compte_destockage=0;
            $compte_stockage=0;
            $cmupVente=0;
            $cmupTemp=0;
            $SI=0;
    
            $data3=DB::table('tvente_produit')
             ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
             ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
             'compte_perte','compte_produit','compte_destockage','compte_stockage','cmup','qte')
             ->where([
                ['tvente_produit.id','=', $id_produit]
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
                $cmupTemp=$row->cmup;    
                $SI = $row->qte;     
            }



           $taux=0;
           $data5 =  DB::table("tvente_taux")
           ->select("tvente_taux.id", "tvente_taux.taux", 
           "tvente_taux.created_at", "tvente_taux.author")
            ->get();
            foreach ($data5 as $row) 
            {                                
               $taux=$row->taux;                           
            }

           $devise=0;
           $data55 =  DB::table("tvente_devise")
           ->select("tvente_devise.id", "tvente_devise.designation","tvente_devise.created_at")
           ->where([
               ['tvente_devise.active','=', 'OUI']
           ])
            ->get();
            foreach ($data55 as $row) 
            {                                
               $devise=$row->designation;                           
            }
    
           $qteEntree = $qteBase * floatval($data['qteTransfert']);

           $data90 = tvente_detail_transfert::create([
                'refEnteteTransfert'       => $idmax,
                'refProduit'       =>  $id_produit,  
                'refDestination'       =>  $request->refDestination,  
                'idStockService'       =>  $refIdStockSource,         
                'author'       =>  $request->author,
                'refUser'    =>  $request->refUser,

                'puTransfert'       =>  $puTransfert, 
                'qteTransfert'      =>  $data['qteTransfert'], 
                'uniteTransfert'    =>  $uniteTransfert, 
                'puBase'       =>  $puBase, 
                'qteBase'       =>  $qteBase, 
                'uniteBase'       =>  $uniteBase,
            ]);

           if(($request->refDestination == $temp_idservice) && ($id_produit == $temp_idproduit))
           {


            $data22 = DB::update(
                'update tvente_stock_service set qte = qte - :qteTransfert where id = :id',
                ['qteTransfert' => $qteEntree,'id' => $refIdStockSource]
            );


            $id_detail_max1 =0;
            $detail_list1 = DB::table('tvente_detail_transfert')       
            ->selectRaw('MAX(id) as code_entete')
            ->where('refUser', $request->refUser)
            ->get();
            foreach ($detail_list1 as $list) {
                $id_detail_max1 = $list->code_entete;
            }

            // $nom_service_source
            // $nom_service_destination
          
            $data999 = tvente_mouvement_stock::create([             
                'idStockService'    =>  $refIdStockSource,             
                'dateMvt'    =>   $request->date_transfert,   
                'type_mouvement'    =>  'Sortie',
                'libelle_mouvement'    =>  'Transfert Stock'.' vers : '.$nom_service_destination.' N°:'.$id_detail_max1,
                'nom_table'    =>  'tvente_detail_transfert',
                'id_data'    =>  $id_detail_max1, 
                'qteMvt'    =>  $data['qteTransfert'],
                'puMvt'    =>  $puTransfert,                   
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'type_sortie'    =>  'Sortie',
    
                'active'    =>  $active,
                'uniteMvt'    =>  $uniteTransfert,
                'compte_vente'    =>  0,
                'compte_variationstock'    =>  $compte_variationstock,
                'compte_perte'    =>  $compte_perte,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                'compte_achat'    =>  0,
                'compte_stockage'    => 0,
                'puVente'    =>  $puTransfert,
                'devise'    =>  'USD',
                'taux'    =>  $taux,
                'puBase'    =>  $puBase,
                'qteBase'    =>  $qteBase,
                'uniteBase'    =>  $uniteBase,
                'cmupMvt'    =>  $puTransfert
            ]); 

                $data23 = DB::update(
                'update tvente_stock_service set qte = qte + :qteTransfert where id = :id',
                ['qteTransfert' => $qteEntree,'id' => $temp_id]
                );

                $id_detail_max=0;
                $detail_list = DB::table('tvente_detail_transfert')       
                ->selectRaw('MAX(id) as code_entete')
                ->where('refUser', $request->refUser)
                ->get();
                foreach ($detail_list as $list) {
                    $id_detail_max= $list->code_entete;
                }
              
                $data98 = tvente_mouvement_stock::create([             
                    'idStockService'    =>  $temp_id,             
                    'dateMvt'    =>   $request->date_transfert,   
                    'type_mouvement'    =>  'Entree',
                    'libelle_mouvement'    =>  'Reception Stock'.' au près du service : '.$nom_service_source.' N°:'.$id_detail_max1,
                    'nom_table'    =>  'tvente_detail_transfert',
                    'id_data'    =>  $id_detail_max, 
                    'qteMvt'    =>  $data['qteTransfert'],
                    'puMvt'    =>  $puTransfert,                   
                    'author'       =>  $request->author,
                    'refUser'       =>  $request->refUser,
                    'type_sortie'    =>  'Entree',
        
                    'active'    =>  $active,
                    'uniteMvt'    =>  $uniteTransfert,
                    'compte_vente'    =>  0,
                    'compte_variationstock'    =>  $compte_variationstock,
                    'compte_perte'    =>  0,
                    'compte_produit'    =>  $compte_produit,
                    'compte_destockage'    =>  0,
                    'compte_achat'    =>  $compte_achat,
                    'compte_stockage'    =>  $compte_stockage,
                    'puVente'    =>  $puTransfert,
                    'devise'    =>  'USD',
                    'taux'    =>  $taux,
                    'puBase'    =>  $puBase,
                    'qteBase'    =>  $qteBase,
                    'uniteBase'    =>  $uniteBase,
                    'cmupMvt'    =>  $puTransfert
                ]); 




           }
           else
           {
               $data22 = DB::update(
                   'insert into tvente_stock_service (refService,refProduit,pu,qte,uniteBase,cmup,devise,taux,active,refUser,author) 
                   values (:refService,:refProduit,:pu,:qte,:uniteBase,:cmup,:devise,:taux,:active,:refUser,:author)',
                   ['refService' => $request->refDestination,'refProduit' => $id_produit,'pu' => $cmupTemp,'qte' => $qteEntree,
                   'uniteBase' => $uniteBase,'cmup' => $cmupTemp,'devise' => $devise,'taux' => $taux,'active' => $active,
                   'refUser' => $request->refUser,'author' => $request->author]
               );

               
               $data220 = DB::update(
                'update tvente_stock_service set qte = qte - :qteTransfert where id = :id',
                ['qteTransfert' => $qteEntree,'id' => $data['idStockService']] 
                );

                $id_detail_max1 =0;
                $detail_list1 = DB::table('tvente_detail_transfert')       
                ->selectRaw('MAX(id) as code_entete')
                ->where('refUser', $request->refUser)
                ->get();
                foreach ($detail_list1 as $list) {
                    $id_detail_max1 = $list->code_entete;
                }
              
                $data97 = tvente_mouvement_stock::create([             
                    'idStockService'    =>  $data['idStockService'],             
                    'dateMvt'    =>   $request->date_transfert,   
                    'type_mouvement'    =>  'Sortie',
                    'libelle_mouvement'    =>  'Transfert Stock'.' vers : '.$nom_service_destination.' N°:'.$id_detail_max1,
                    'nom_table'    =>  'tvente_detail_transfert',
                    'id_data'    =>  $id_detail_max1, 
                    'qteMvt'    =>  $data['qteTransfert'],
                    'puMvt'    =>  $puTransfert,                   
                    'author'       =>  $request->author,
                    'refUser'       =>  $request->refUser,
                    'type_sortie'    =>  'Sortie',
        
                    'active'    =>  $active,
                    'uniteMvt'    =>  $uniteTransfert,
                    'compte_vente'    =>  0,
                    'compte_variationstock'    =>  $compte_variationstock,
                    'compte_perte'    =>  $compte_perte,
                    'compte_produit'    =>  $compte_produit,
                    'compte_destockage'    =>  0,
                    'compte_achat'    =>  0,
                    'compte_stockage'    =>  $compte_stockage,
                    'puVente'    =>  $puTransfert,
                    'devise'    =>  'USD',
                    'taux'    =>  $taux,
                    'puBase'    =>  $puBase,
                    'qteBase'    =>  $qteBase,
                    'uniteBase'    =>  $uniteBase,
                    'cmupMvt'    =>  $puTransfert
                ]); 





                $id_detail_max=0;
                $detail_list = DB::table('tvente_detail_transfert')       
                ->selectRaw('MAX(id) as code_entete')
                ->where('refUser', $request->refUser)
                ->first();
                if ($detail_list) {
                    $id_detail_max= $detail_list->code_entete;
                }

                $id_stock_servi_dest=0;

                $data_dest = DB::table('tvente_stock_service')       
                ->selectRaw('MAX(id) as code_entete')
                ->where([
                   ['tvente_stock_service.refService','=',  $request->refDestination],
                   ['tvente_stock_service.refProduit','=',  $id_produit]
               ])
                ->first();
                if ($data_dest) {
                    $id_stock_servi_dest = $data_dest->code_entete;
                }
              
                $data98 = tvente_mouvement_stock::create([             
                    'idStockService'    =>  $id_stock_servi_dest,             
                    'dateMvt'    =>   $request->date_transfert,   
                    'type_mouvement'    =>  'Entree',
                    'libelle_mouvement'    =>  'Reception Stock'.' au près du service : '.$nom_service_source.' N°:'.$id_detail_max1,
                    'nom_table'    =>  'tvente_detail_transfert',
                    'id_data'    =>  $id_detail_max, 
                    'qteMvt'    =>  $data['qteTransfert'],
                    'puMvt'    =>  $puTransfert,                   
                    'author'       =>  $request->author,
                    'refUser'       =>  $request->refUser,
                    'type_sortie'    =>  'Entree',
        
                    'active'    =>  $active,
                    'uniteMvt'    =>  $uniteTransfert,
                    'compte_vente'    =>  0,
                    'compte_variationstock'    =>  $compte_variationstock,
                    'compte_perte'    =>  0,
                    'compte_produit'    =>  $compte_produit,
                    'compte_destockage'    =>  0,
                    'compte_achat'    =>  $compte_achat,
                    'compte_stockage'    =>  $compte_stockage,
                    'puVente'    =>  $puTransfert,
                    'devise'    =>  'USD',
                    'taux'    =>  $taux,
                    'puBase'    =>  $puBase,
                    'qteBase'    =>  $qteBase,
                    'uniteBase'    =>  $uniteBase,
                    'cmupMvt'    =>  $puTransfert
                ]); 



 
           }  
           
            
        }

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }

    function insert_dataTransfert(Request $request)
    {
        $current = Carbon::now();
        $id_service_destination = $request->refDestination;
        $id_appro = $request->refAppro;
        $author = $request->author;
        $refUser = $request->refUser;

        $refService = 0;
        $id_module = 3;
        $active = "OUI";
        $date_transfert = '';
        

        $data90 = DB::table('tvente_detail_entree')

        ->join('tvente_entete_entree','tvente_entete_entree.id','=','tvente_detail_entree.refEnteteEntree')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_entree.module_id')

        ->join('tvente_services','tvente_services.id','=','tvente_entete_entree.refService')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_entree.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 

        ->select('tvente_detail_entree.id','refEnteteEntree','refProduit','tvente_entete_entree.refService',
        'tvente_detail_entree.compte_achat','tvente_detail_entree.compte_variationstock',
        'tvente_detail_entree.compte_produit','tvente_detail_entree.compte_stockage','puEntree','qteEntree',
        'uniteEntree',
        'puBase','qteBase','tvente_detail_entree.uniteBase','tvente_detail_entree.devise','tvente_detail_entree.taux',
        'montanttva','montantreduction','tvente_detail_entree.active','tvente_detail_entree.author',
        'tvente_detail_entree.refUser','tvente_detail_entree.created_at','tvente_detail_entree.devise',
        'tvente_detail_entree.taux'
        ,'tvente_entete_entree.code','tvente_entete_entree.refFournisseur',
        'tvente_entete_entree.refRecquisition','tvente_entete_entree.module_id','dateEntree',
        'tvente_entete_entree.libelle','transporteur','niveau1','niveaumax',"tvente_module.nom_module"
        ,'nom_service'
        ,"tvente_produit.designation as designation",'refCategorie','refUniteBase','pu','qte','cmup',
        'Oldcode','Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie")
        ->where([
           ['tvente_detail_entree.refEnteteEntree','=', $id_appro]
       ])      
       ->get();      
      
       foreach ($data90 as $row90) 
       {
           $refService = $row90->refService;
           $date_transfert = $row90->dateEntree;
       }        

        $code = $this->GetCodeData('tvente_param_systeme','module_id', $id_module);
        $data = tvente_entete_transfert::create([
            'refService'       =>  $refService,
            'module_id'       =>  $id_module,
            'date_transfert'       =>  $date_transfert,         
            'author'       =>  $author,
            'refUser'    =>  $refUser
        ]);

        $idmax=0;
        $maxid = DB::table('tvente_entete_transfert')       
        ->selectRaw('MAX(tvente_entete_transfert.id) as code_entete')
        ->where('tvente_entete_transfert.refService', $refService)
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_entete;
        }


       foreach ($data90 as $row91) 
       {    
           $compte_achat = 0;
           $compte_vente =0;
           $compte_variationstock=0;
           $compte_perte=0;
           $compte_produit=0;
           $compte_destockage=0;
           $compte_stockage=0;
           $cmupVente=0;
           $cmupTemp=0;
           $SI=0; 
   
           $data3=DB::table('tvente_produit')
            ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
            ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
            'compte_perte','compte_produit','compte_destockage','compte_stockage','cmup','qte')
            ->where([
               ['tvente_produit.id','=', $row91->refProduit]
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
               $cmupTemp=$row->cmup;    
               $SI = $row->qte;     
           }

  
           $puTransfert = $row91->puEntree;
           $qteTransfert = $row91->qteEntree;
           $uniteTransfert = $row91->uniteEntree;
           $puBase = $row91->puBase;
           $qteBase = $row91->qteBase;
           $uniteBase = $row91->uniteBase;


          $taux=0;
          $data5 =  DB::table("tvente_taux")
          ->select("tvente_taux.id", "tvente_taux.taux", 
          "tvente_taux.created_at", "tvente_taux.author")
           ->get();
           foreach ($data5 as $row) 
           {                                
              $taux=$row->taux;                           
           }

          $devise=0;
          $data55 =  DB::table("tvente_devise")
          ->select("tvente_devise.id", "tvente_devise.designation","tvente_devise.created_at")
          ->where([
              ['tvente_devise.active','=', 'OUI']
          ])
           ->get();
           foreach ($data55 as $row) 
           {                                
              $devise=$row->designation;                           
           }
   
          $qteEntree = $qteBase * floatval($qteTransfert);

          $id_service = $id_service_destination;
          $id_produit = $row91->refProduit;

          $temp_idservice = 0;
          $temp_idproduit = 0;

          $stockservice = DB::table('tvente_stock_service')       
          ->select('id','refService','refProduit','pu','qte','uniteBase','cmup',
          'devise','taux','active','refUser','author')
          ->where([
             ['refService','=',  $id_service],
             ['refProduit','=',  $id_produit]
         ])
          ->get();
          foreach ($stockservice as $list) {
              $temp_idservice = $list->refService;
              $temp_idproduit = $list->refProduit;
          }

          $idStockService=0;
          $data99=DB::table('tvente_stock_service') 
          ->select('id','refService','refProduit','pu','qte','uniteBase','cmup',
          'devise','taux','active','refUser','author')
          ->where([
              ['tvente_stock_service.refService','=', $id_service_destination],
              ['tvente_stock_service.refProduit','=', $row91->refProduit]
          ])      
          ->get();
          foreach ($data99 as $row) 
          {
              $idStockService =  $row->id;           
          }

          $cmup_data = floatval($this->calculerCoutMoyen($idStockService, $date_transfert, $date_transfert));
         

          $data = tvente_detail_transfert::create([
              'refEnteteTransfert'       => $idmax,
              'refProduit'       =>  $row91->refProduit,  
              'refDestination'       =>  $id_service_destination,  
              'idStockService'       =>  $idStockService,         
              'author'       =>  $author,
              'refUser'    =>  $refUser,
  
              'puTransfert'       =>  $cmup_data, 
              'qteTransfert'       =>  $qteTransfert, 
              'uniteTransfert'       =>  $uniteTransfert, 
              'puBase'       =>  $puBase, 
              'qteBase'       =>  $qteBase, 
              'uniteBase'       =>  $uniteBase,
          ]);

          if(($id_service == $temp_idservice) && ($id_produit == $temp_idproduit))
          {
              $data22 = DB::update(
                  'update tvente_stock_service set qte = qte + :qteTransfert where id = :id',
                  ['qteTransfert' => $qteEntree,'id' => $idStockService]
              );
              $id_detail_max=0;
              $detail_list = DB::table('tvente_detail_transfert')       
              ->selectRaw('MAX(id) as code_entete')
              ->where('refUser', $request->refUser)
              ->get();
              foreach ($detail_list as $list) {
                  $id_detail_max= $list->code_entete;
              }
            
              $data99 = tvente_mouvement_stock::create([             
                  'idStockService'    =>  $idStockService,             
                  'dateMvt'    =>   $date_transfert,   
                  'type_mouvement'    =>  'Entree',
                  'libelle_mouvement'    =>  'Entrée Stock',
                  'nom_table'    =>  'tvente_detail_transfert',
                  'id_data'    =>  $id_detail_max, 
                  'qteMvt'    =>  $qteTransfert,
                  'puMvt'    =>  $cmup_data,                   
                  'author'       =>  $request->author,
                  'refUser'       =>  $request->refUser,
                  'type_sortie'    =>  'Entree',
      
                  'active'    =>  $active,
                  'uniteMvt'    =>  $uniteTransfert,
                  'compte_vente'    =>  0,
                  'compte_variationstock'    =>  $compte_variationstock,
                  'compte_perte'    =>  0,
                  'compte_produit'    =>  $compte_produit,
                  'compte_destockage'    =>  0,
                  'compte_achat'    =>  $compte_achat,
                  'compte_stockage'    =>  $compte_stockage,
                  'puVente'    =>  $cmup_data,
                  'devise'    =>  'USD',
                  'taux'    =>  $taux,
                  'puBase'    =>  $puBase,
                  'qteBase'    =>  $qteBase,
                  'uniteBase'    =>  $uniteBase,
                  'cmupMvt'    =>  $cmup_data
              ]); 

          }
          else
          {
              $data22 = DB::update(
                  'insert into tvente_stock_service (refService,refProduit,pu,qte,uniteBase,cmup,devise,taux,active,refUser,author) 
                  values (:refService,:refProduit,:pu,:qte,:uniteBase,:cmup,:devise,:taux,:active,:refUser,:author)',
                  ['refService' => $id_service_destination,'refProduit' => $id_produit,'pu' => $cmupTemp,'qte' => $qteEntree,
                  'uniteBase' => $uniteBase,'cmup' => $cmup_data,'devise' => $devise,'taux' => $taux,'active' => $active,
                  'refUser' => $request->refUser,'author' => $request->author]
              );


          }
          
           $data2 = DB::update(
               'update tvente_produit set qte = qte - :qteTransfert where id = :refProduit',
               ['qteTransfert' => $qteEntree,'refProduit' => $row91->refProduit]
           );           

       }

       $data222 = DB::update(
            'update tvente_entete_entree set active = :active where id = :idAppro',
            ['active' => 'NON','idAppro' => $id_appro]
        );

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }


    function insert_dataGlobalUsage(Request $request)
    {
        $id_module = 3;
        $active = "OUI";

        $code = $this->GetCodeData('tvente_param_systeme','module_id',$id_module);
        $data = tvente_entete_transfert::create([
            'refService'       =>  $request->refService,
            'module_id'       =>  $id_module,
            'date_transfert'       =>  $request->date_transfert,         
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser
        ]);

        $idmax=0;
        $maxid = DB::table('tvente_entete_transfert')       
        ->selectRaw('MAX(tvente_entete_transfert.id) as code_entete')
        ->where('tvente_entete_transfert.refService', $request->refService)
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_entete;
        }


        $id_module_use = 7;
        $code_use = $this->GetCodeData('tvente_param_systeme','module_id',$id_module_use);
        $data66 = tvente_entete_utilisation::create([
            'code'       =>  $code_use,
            'refService'       =>  $request->refDestination,     
            'module_id'       =>  $id_module_use,
            'agent_id'    =>  1,
            'dateUse'    =>  $request->date_transfert,
            'libelle'    =>  'Tranfert et Consommation directe',
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);

        $idmax_use=0;
        $maxid66 = DB::table('tvente_entete_utilisation')       
        ->selectRaw('MAX(tvente_entete_utilisation.id) as code_entete')
        ->where([
            ['tvente_entete_utilisation.refUser','=', $request->refUser],
            ['tvente_entete_utilisation.refService','=', $request->refDestination]
         ])
        ->first();
        if ($maxid66) {
            $idmax_use= $maxid66->code_entete;
        }



        $detailData = $request->detailData;

        foreach ($detailData as $data) {
            
            $refIdStockSource = $data['idStockService'];
            $id_produit = 0;

            $cmup_data = floatval($this->calculerCoutMoyen($refIdStockSource, $request->date_transfert, $request->date_transfert));
    
            $temp_idservice = 0;
            $temp_idproduit = 0;
            $temp_id=0;

            $puTransfert=0;
            $qteTransfert=0;
            $uniteTransfert='';
            $puBase=0;
            $qteBase=0;
            $uniteBase='';
    
            $data4=DB::table('tvente_detail_unite')
            ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
            ->join('tvente_produit','tvente_produit.id','=','tvente_detail_unite.refProduit')
            ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
            ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
            'compte_perte','compte_produit','compte_destockage','compte_stockage','uniteBase','qteBase',
            'puBase','nom_unite','qteUnite','puUnite','refProduit')
             ->where([
                ['tvente_detail_unite.id','=',  $data['refDetailUnite']]
            ])      
            ->get();      
            
            foreach ($data4 as $row) 
            {
                 $puTransfert=$row->puUnite;
                 $qteTransfert=$row->qteUnite;
                 $uniteTransfert=$row->nom_unite;
                 $puBase=$row->puBase;
                 $qteBase=$row->qteBase;
                 $uniteBase=$row->uniteBase;
                 $id_produit = $row->refProduit;
            }
    
           $stockservicedest = DB::table('tvente_stock_service')       
            ->select('id','refService','refProduit','pu','qte','uniteBase','cmup',
            'devise','taux','active','refUser','author')
            ->where([
               ['tvente_stock_service.refService','=',  $request->refDestination],
               ['tvente_stock_service.refProduit','=',  $id_produit]
           ])
            ->get();
            foreach ($stockservicedest as $list) {
                $temp_idservice = $list->refService;
                $temp_idproduit = $list->refProduit;
                $temp_id = $list->id;
            }
  
            $compte_achat = 0;
            $compte_vente =0;
            $compte_variationstock=0;
            $compte_perte=0;
            $compte_produit=0;
            $compte_destockage=0;
            $compte_stockage=0;
            $cmupVente=0;
            $cmupTemp=0;
            $SI=0;
    
            $data3=DB::table('tvente_produit')
             ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
             ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
             'compte_perte','compte_produit','compte_destockage','compte_stockage','cmup','qte')
             ->where([
                ['tvente_produit.id','=', $id_produit]
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
                $cmupTemp=$row->cmup;    
                $SI = $row->qte;     
            }



           $taux=0;
           $data5 =  DB::table("tvente_taux")
           ->select("tvente_taux.id", "tvente_taux.taux", 
           "tvente_taux.created_at", "tvente_taux.author")
            ->get();
            foreach ($data5 as $row) 
            {                                
               $taux=$row->taux;                           
            }

           $devise=0;
           $data55 =  DB::table("tvente_devise")
           ->select("tvente_devise.id", "tvente_devise.designation","tvente_devise.created_at")
           ->where([
               ['tvente_devise.active','=', 'OUI']
           ])
            ->get();
            foreach ($data55 as $row) 
            {                                
               $devise=$row->designation;                           
            }
    
           $qteEntree = $qteBase * floatval($data['qteTransfert']);

           $data90 = tvente_detail_transfert::create([
                'refEnteteTransfert'       => $idmax,
                'refProduit'       =>  $id_produit,  
                'refDestination'       =>  $request->refDestination,  
                'idStockService'       =>  $refIdStockSource,         
                'author'       =>  $request->author,
                'refUser'    =>  $request->refUser,

                'puTransfert'       =>  $puTransfert, 
                'qteTransfert'      =>  $data['qteTransfert'], 
                'uniteTransfert'    =>  $uniteTransfert, 
                'puBase'       =>  $puBase, 
                'qteBase'       =>  $qteBase, 
                'uniteBase'       =>  $uniteBase,
            ]);

           if(($request->refDestination == $temp_idservice) && ($id_produit == $temp_idproduit))
           {


            $data22 = DB::update(
                'update tvente_stock_service set qte = qte - :qteTransfert where id = :id',
                ['qteTransfert' => $qteEntree,'id' => $refIdStockSource]
            );


            $id_detail_max1 =0;
            $detail_list1 = DB::table('tvente_detail_transfert')       
            ->selectRaw('MAX(id) as code_entete')
            ->where('refUser', $request->refUser)
            ->get();
            foreach ($detail_list1 as $list) {
                $id_detail_max1 = $list->code_entete;
            }
          
            $data999 = tvente_mouvement_stock::create([             
                'idStockService'    =>  $refIdStockSource,             
                'dateMvt'    =>   $request->date_transfert,   
                'type_mouvement'    =>  'Sortie',
                'libelle_mouvement'    =>  'Transfert Stock',
                'nom_table'    =>  'tvente_detail_transfert',
                'id_data'    =>  $id_detail_max1, 
                'qteMvt'    =>  $data['qteTransfert'],
                'puMvt'    =>  $puTransfert,                   
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'type_sortie'    =>  'Sortie',
    
                'active'    =>  $active,
                'uniteMvt'    =>  $uniteTransfert,
                'compte_vente'    =>  0,
                'compte_variationstock'    =>  $compte_variationstock,
                'compte_perte'    =>  $compte_perte,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                'compte_achat'    =>  0,
                'compte_stockage'    => 0,
                'puVente'    =>  $puTransfert,
                'devise'    =>  'USD',
                'taux'    =>  $taux,
                'puBase'    =>  $puBase,
                'qteBase'    =>  $qteBase,
                'uniteBase'    =>  $uniteBase,
                'cmupMvt'    =>  $puTransfert
            ]); 

                $data23 = DB::update(
                'update tvente_stock_service set qte = qte + :qteTransfert where id = :id',
                ['qteTransfert' => $qteEntree,'id' => $temp_id]
                );

                $id_detail_max=0;
                $detail_list = DB::table('tvente_detail_transfert')       
                ->selectRaw('MAX(id) as code_entete')
                ->where('refUser', $request->refUser)
                ->get();
                foreach ($detail_list as $list) {
                    $id_detail_max= $list->code_entete;
                }
              
                $data98 = tvente_mouvement_stock::create([             
                    'idStockService'    =>  $temp_id,             
                    'dateMvt'    =>   $request->date_transfert,   
                    'type_mouvement'    =>  'Entree',
                    'libelle_mouvement'    =>  'Entrée Stock',
                    'nom_table'    =>  'tvente_detail_transfert',
                    'id_data'    =>  $id_detail_max, 
                    'qteMvt'    =>  $data['qteTransfert'],
                    'puMvt'    =>  $puTransfert,                   
                    'author'       =>  $request->author,
                    'refUser'       =>  $request->refUser,
                    'type_sortie'    =>  'Entree',
        
                    'active'    =>  $active,
                    'uniteMvt'    =>  $uniteTransfert,
                    'compte_vente'    =>  0,
                    'compte_variationstock'    =>  $compte_variationstock,
                    'compte_perte'    =>  0,
                    'compte_produit'    =>  $compte_produit,
                    'compte_destockage'    =>  0,
                    'compte_achat'    =>  $compte_achat,
                    'compte_stockage'    =>  $compte_stockage,
                    'puVente'    =>  $puTransfert,
                    'devise'    =>  'USD',
                    'taux'    =>  $taux,
                    'puBase'    =>  $puBase,
                    'qteBase'    =>  $qteBase,
                    'uniteBase'    =>  $uniteBase,
                    'cmupMvt'    =>  $puTransfert
                ]); 




           }
           else
           {
               $data22 = DB::update(
                   'insert into tvente_stock_service (refService,refProduit,pu,qte,uniteBase,cmup,devise,taux,active,refUser,author) 
                   values (:refService,:refProduit,:pu,:qte,:uniteBase,:cmup,:devise,:taux,:active,:refUser,:author)',
                   ['refService' => $request->refDestination,'refProduit' => $id_produit,'pu' => $cmupTemp,'qte' => $qteEntree,
                   'uniteBase' => $uniteBase,'cmup' => $cmupTemp,'devise' => $devise,'taux' => $taux,'active' => $active,
                   'refUser' => $request->refUser,'author' => $request->author]
               );

               
               $data220 = DB::update(
                'update tvente_stock_service set qte = qte - :qteTransfert where id = :id',
                ['qteTransfert' => $qteEntree,'id' => $data['idStockService']] 
                );

                $id_detail_max1 =0;
                $detail_list1 = DB::table('tvente_detail_transfert')       
                ->selectRaw('MAX(id) as code_entete')
                ->where('refUser', $request->refUser)
                ->get();
                foreach ($detail_list1 as $list) {
                    $id_detail_max1 = $list->code_entete;
                }
              
                $data97 = tvente_mouvement_stock::create([             
                    'idStockService'    =>  $data['idStockService'],             
                    'dateMvt'    =>   $request->date_transfert,   
                    'type_mouvement'    =>  'Sortie',
                    'libelle_mouvement'    =>  'Transfert Stock',
                    'nom_table'    =>  'tvente_detail_transfert',
                    'id_data'    =>  $id_detail_max1, 
                    'qteMvt'    =>  $data['qteTransfert'],
                    'puMvt'    =>  $puTransfert,                   
                    'author'       =>  $request->author,
                    'refUser'       =>  $request->refUser,
                    'type_sortie'    =>  'Sortie',
        
                    'active'    =>  $active,
                    'uniteMvt'    =>  $uniteTransfert,
                    'compte_vente'    =>  0,
                    'compte_variationstock'    =>  $compte_variationstock,
                    'compte_perte'    =>  $compte_perte,
                    'compte_produit'    =>  $compte_produit,
                    'compte_destockage'    =>  0,
                    'compte_achat'    =>  0,
                    'compte_stockage'    =>  $compte_stockage,
                    'puVente'    =>  $puTransfert,
                    'devise'    =>  'USD',
                    'taux'    =>  $taux,
                    'puBase'    =>  $puBase,
                    'qteBase'    =>  $qteBase,
                    'uniteBase'    =>  $uniteBase,
                    'cmupMvt'    =>  $puTransfert
                ]); 





                $id_detail_max=0;
                $detail_list = DB::table('tvente_detail_transfert')       
                ->selectRaw('MAX(id) as code_entete')
                ->where('refUser', $request->refUser)
                ->first();
                if ($detail_list) {
                    $id_detail_max= $detail_list->code_entete;
                }

                $id_stock_servi_dest=0;

                $data_dest = DB::table('tvente_stock_service')       
                ->selectRaw('MAX(id) as code_entete')
                ->where([
                   ['tvente_stock_service.refService','=',  $request->refDestination],
                   ['tvente_stock_service.refProduit','=',  $id_produit]
               ])
                ->first();
                if ($data_dest) {
                    $id_stock_servi_dest = $data_dest->code_entete;
                }
              
                $data98 = tvente_mouvement_stock::create([             
                    'idStockService'    =>  $id_stock_servi_dest,             
                    'dateMvt'    =>   $request->date_transfert,   
                    'type_mouvement'    =>  'Entree',
                    'libelle_mouvement'    =>  'Entrée Stock',
                    'nom_table'    =>  'tvente_detail_transfert',
                    'id_data'    =>  $id_detail_max, 
                    'qteMvt'    =>  $data['qteTransfert'],
                    'puMvt'    =>  $puTransfert,                   
                    'author'       =>  $request->author,
                    'refUser'       =>  $request->refUser,
                    'type_sortie'    =>  'Entree',
        
                    'active'    =>  $active,
                    'uniteMvt'    =>  $uniteTransfert,
                    'compte_vente'    =>  0,
                    'compte_variationstock'    =>  $compte_variationstock,
                    'compte_perte'    =>  0,
                    'compte_produit'    =>  $compte_produit,
                    'compte_destockage'    =>  0,
                    'compte_achat'    =>  $compte_achat,
                    'compte_stockage'    =>  $compte_stockage,
                    'puVente'    =>  $puTransfert,
                    'devise'    =>  'USD',
                    'taux'    =>  $taux,
                    'puBase'    =>  $puBase,
                    'qteBase'    =>  $qteBase,
                    'uniteBase'    =>  $uniteBase,
                    'cmupMvt'    =>  $puTransfert
                ]); 



 
           }  
           
            
        }

        foreach ($detailData as $data) {

            $active = "OUI";

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
            $devises='USD';
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
                $montants =  $row->cmup;           
            }



            $qte=$data['qteTransfert'];
            $idDetail=$refProduit;
            $idFacture=$idmax_use;
    
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
    
            $uniteVente = '';
            $uniteBase = '';           
            $qteBase =  0;
            $puBase = 0;      
            $estunite = '';
            $cmupVente = $montants;
            
            $data_unite = DB::table('tvente_detail_unite')
            ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
            ->join('tvente_produit','tvente_produit.id','=','tvente_detail_unite.refProduit')
            ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
            ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
            'compte_perte','compte_produit','compte_destockage','compte_stockage','uniteBase','qteBase',
            'puBase','nom_unite','qteUnite','puUnite','estunite','refProduit')
             ->where([
                ['tvente_detail_unite.id','=',  $data['refDetailUnite']]
            ])      
            ->first();
            
            if ($data_unite) 
            {
                 $uniteVente=$data_unite->nom_unite;
                 $uniteBase=$data_unite->uniteBase;
                 $qteBase=$data_unite->qteBase;
                 $puBase=$data_unite->puBase;                 
                 $estunite = $data_unite->estunite;
            }
 
            $qteVente = $qteBase * floatval($data['qteTransfert']);
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
 
        
            $montanttva = (((floatval($data['qteTransfert']) * floatval($montants))*floatval($pourtageTVA))/100);
    
            $data222 = tvente_detail_utilisation::create([
                'refEnteteVente'       =>  $idmax_use,
                'refProduit'    =>  $refProduit,
                'qteVente'    =>  $data['qteTransfert'],
                'idStockService'    =>  $data['idStockService'],                     
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


            $id_detail_max=0;
            $detail_list = DB::table('tvente_detail_utilisation')       
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
                'dateMvt'    =>   $request->date_transfert,   
                'type_mouvement'    =>  'Sortie',
                'libelle_mouvement'    =>  'Consommation directe des Produits',
                'nom_table'    =>  'tvente_detail_utilisation',
                'id_data'    =>  $id_detail_max, 
                'qteMvt'    =>  $data['qteTransfert'],
                'puMvt'    =>  $montants,                   
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'type_sortie'    =>  'Sortie',
    
                'active'    =>  $active,
                'uniteMvt'    =>  $uniteVente,
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
                'puBase'    =>  $puBase,
                'qteBase'    =>  $qteBase,
                'uniteBase'    =>  $uniteBase,
                'cmupMvt'    =>  $cmupVente
            ]); 

    
            $data2 = DB::update(
                'update tvente_stock_service set qte = qte - :qteVente where id = :idStockService',
                ['qteVente' => $qteVente,'idStockService' => $data['idStockService']]
            );
    
        }

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }


}
