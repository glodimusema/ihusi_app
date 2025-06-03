<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_detail_entree;
use App\Models\Ventes\tvente_entete_entree;
use App\Models\Ventes\tvente_mouvement_stock;
//tvente_entete_entree
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tvente_detail_entreeController extends Controller
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

        $data = DB::table('tvente_detail_entree')

        ->join('tvente_entete_entree','tvente_entete_entree.id','=','tvente_detail_entree.refEnteteEntree')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_entree.module_id')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_entree.refFournisseur')

        ->join('tvente_services','tvente_services.id','=','tvente_entete_entree.refService')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_entree.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        
        ->join('tfin_ssouscompte as compteachat','compteachat.id','=','tvente_categorie_produit.compte_achat')       
        ->join('tfin_ssouscompte as comptevariation','comptevariation.id','=','tvente_categorie_produit.compte_variationstock')       
        ->join('tfin_ssouscompte as compteproduit','compteproduit.id','=','tvente_categorie_produit.compte_produit')        
        ->join('tfin_ssouscompte as comptestockage','comptestockage.id','=','tvente_categorie_produit.compte_stockage')      

        ->select('tvente_detail_entree.id','refEnteteEntree','refProduit','tvente_entete_entree.refService',
        'tvente_detail_entree.compte_achat','tvente_detail_entree.compte_variationstock',
        'tvente_detail_entree.compte_produit','tvente_detail_entree.compte_stockage','puEntree','qteEntree',
        'uniteEntree','idStockService',
        'puBase','qteBase','tvente_detail_entree.uniteBase','tvente_detail_entree.devise','tvente_detail_entree.taux',
        'montanttva','montantreduction','tvente_detail_entree.active','tvente_detail_entree.author',
        'tvente_detail_entree.refUser','tvente_detail_entree.created_at','tvente_detail_entree.devise',
        'tvente_detail_entree.taux'

        ,'noms','contact','mail','adresse','tvente_entete_entree.code','tvente_entete_entree.refFournisseur',
        'tvente_entete_entree.refRecquisition','tvente_entete_entree.module_id','dateEntree',
        'tvente_entete_entree.libelle','transporteur','niveau1','niveaumax',"tvente_module.nom_module"

        ,'nom_service'

        ,"tvente_produit.designation as designation",'refCategorie','refUniteBase','pu','qte',
        'cmup','Oldcode','Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie"

        ,'compteachat.refSousCompte as refSousCompteAchat','compteachat.nom_ssouscompte as nom_ssouscompteAchat',
        'compteachat.numero_ssouscompte as numero_ssouscompteAchat'
        ,'comptevariation.refSousCompte as refSousCompteVariation','comptevariation.nom_ssouscompte as nom_ssouscompteVariation',
        'comptevariation.numero_ssouscompte as numero_ssouscompteVariation'
        ,'compteproduit.refSousCompte as refSousCompteProduit','compteproduit.nom_ssouscompte as nom_ssouscompteProduit',
        'compteproduit.numero_ssouscompte as numero_ssouscompteProduit'
        ,'comptestockage.refSousCompte as refSousCompteStockage','comptestockage.nom_ssouscompte as nom_ssouscompteStockage',
        'comptestockage.numero_ssouscompte as numero_ssouscompteStockage' 
        )
        ->selectRaw('((qteEntree) * (puEntree)) as PTEntree')
        ->selectRaw('(((qteEntree) * (puEntree))/tvente_detail_entree.taux) as PTEntreeFC')
        ->selectRaw('(qteBase*puBase) as PTBase')
        ->selectRaw('((qteBase*puBase)/tvente_detail_entree.taux) as PTBaseFC');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tvente_produit.designation', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_entree.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_detail_entree.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tvente_detail_entree')

        ->join('tvente_entete_entree','tvente_entete_entree.id','=','tvente_detail_entree.refEnteteEntree')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_entree.module_id')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_entree.refFournisseur')

        ->join('tvente_services','tvente_services.id','=','tvente_entete_entree.refService')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_entree.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        
        ->join('tfin_ssouscompte as compteachat','compteachat.id','=','tvente_categorie_produit.compte_achat')       
        ->join('tfin_ssouscompte as comptevariation','comptevariation.id','=','tvente_categorie_produit.compte_variationstock')       
        ->join('tfin_ssouscompte as compteproduit','compteproduit.id','=','tvente_categorie_produit.compte_produit')        
        ->join('tfin_ssouscompte as comptestockage','comptestockage.id','=','tvente_categorie_produit.compte_stockage')      

        ->select('tvente_detail_entree.id','refEnteteEntree','refProduit','tvente_entete_entree.refService',
        'tvente_detail_entree.compte_achat','tvente_detail_entree.compte_variationstock',
        'tvente_detail_entree.compte_produit','tvente_detail_entree.compte_stockage','puEntree','qteEntree',
        'uniteEntree','idStockService',
        'puBase','qteBase','tvente_detail_entree.uniteBase','tvente_detail_entree.devise','tvente_detail_entree.taux',
        'montanttva','montantreduction','tvente_detail_entree.active','tvente_detail_entree.author',
        'tvente_detail_entree.refUser','tvente_detail_entree.created_at','tvente_detail_entree.devise',
        'tvente_detail_entree.taux'

        ,'noms','contact','mail','adresse','tvente_entete_entree.code','tvente_entete_entree.refFournisseur',
        'tvente_entete_entree.refRecquisition','tvente_entete_entree.module_id','dateEntree',
        'tvente_entete_entree.libelle','transporteur','niveau1','niveaumax',"tvente_module.nom_module"

        ,'nom_service'

        ,"tvente_produit.designation as designation",'refCategorie','refUniteBase','pu','qte',
        'cmup','Oldcode','Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie"

        ,'compteachat.refSousCompte as refSousCompteAchat','compteachat.nom_ssouscompte as nom_ssouscompteAchat',
        'compteachat.numero_ssouscompte as numero_ssouscompteAchat'
        ,'comptevariation.refSousCompte as refSousCompteVariation','comptevariation.nom_ssouscompte as nom_ssouscompteVariation',
        'comptevariation.numero_ssouscompte as numero_ssouscompteVariation'
        ,'compteproduit.refSousCompte as refSousCompteProduit','compteproduit.nom_ssouscompte as nom_ssouscompteProduit',
        'compteproduit.numero_ssouscompte as numero_ssouscompteProduit'
        ,'comptestockage.refSousCompte as refSousCompteStockage','comptestockage.nom_ssouscompte as nom_ssouscompteStockage',
        'comptestockage.numero_ssouscompte as numero_ssouscompteStockage' 
        )
        ->selectRaw('((qteEntree) * (puEntree)) as PTEntree')
        ->selectRaw('(((qteEntree) * (puEntree))/tvente_detail_entree.taux) as PTEntreeFC')
        ->selectRaw('(qteBase*puBase) as PTBase')
        ->selectRaw('((qteBase*puBase)/tvente_detail_entree.taux) as PTBaseFC')
        ->Where('refEnteteEntree',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_entree.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_detail_entree.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    

    function fetch_detail_entree_vente($id)
    {
        $data = DB::table('tvente_detail_entree')

        ->join('tvente_entete_entree','tvente_entete_entree.id','=','tvente_detail_entree.refEnteteEntree')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_entree.module_id')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_entree.refFournisseur')

        ->join('tvente_services','tvente_services.id','=','tvente_entete_entree.refService')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_entree.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        
        ->join('tfin_ssouscompte as compteachat','compteachat.id','=','tvente_categorie_produit.compte_achat')       
        ->join('tfin_ssouscompte as comptevariation','comptevariation.id','=','tvente_categorie_produit.compte_variationstock')       
        ->join('tfin_ssouscompte as compteproduit','compteproduit.id','=','tvente_categorie_produit.compte_produit')        
        ->join('tfin_ssouscompte as comptestockage','comptestockage.id','=','tvente_categorie_produit.compte_stockage')      

        ->select('tvente_detail_entree.id','refEnteteEntree','refProduit','tvente_entete_entree.refService',
        'tvente_detail_entree.compte_achat','tvente_detail_entree.compte_variationstock',
        'tvente_detail_entree.compte_produit','tvente_detail_entree.compte_stockage','puEntree','qteEntree',
        'uniteEntree','idStockService',
        'puBase','qteBase','tvente_detail_entree.uniteBase','tvente_detail_entree.devise','tvente_detail_entree.taux',
        'montanttva','montantreduction','tvente_detail_entree.active','tvente_detail_entree.author',
        'tvente_detail_entree.refUser','tvente_detail_entree.created_at','tvente_detail_entree.devise',
        'tvente_detail_entree.taux'

        ,'noms','contact','mail','adresse','tvente_entete_entree.code','tvente_entete_entree.refFournisseur',
        'tvente_entete_entree.refRecquisition','tvente_entete_entree.module_id',
        'tvente_entete_entree.libelle','transporteur','niveau1','niveaumax',"tvente_module.nom_module"

        ,'nom_service'

        ,"tvente_produit.designation as designation",'refCategorie','refUniteBase','pu','qte',
        'cmup','Oldcode','Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie"

        ,'compteachat.refSousCompte as refSousCompteAchat','compteachat.nom_ssouscompte as nom_ssouscompteAchat',
        'compteachat.numero_ssouscompte as numero_ssouscompteAchat'
        ,'comptevariation.refSousCompte as refSousCompteVariation','comptevariation.nom_ssouscompte as nom_ssouscompteVariation',
        'comptevariation.numero_ssouscompte as numero_ssouscompteVariation'
        ,'compteproduit.refSousCompte as refSousCompteProduit','compteproduit.nom_ssouscompte as nom_ssouscompteProduit',
        'compteproduit.numero_ssouscompte as numero_ssouscompteProduit'
        ,'comptestockage.refSousCompte as refSousCompteStockage','comptestockage.nom_ssouscompte as nom_ssouscompteStockage',
        'comptestockage.numero_ssouscompte as numero_ssouscompteStockage' 
        )
        ->selectRaw('((qteEntree) * (puEntree)) as PTEntree')
        ->selectRaw('(((qteEntree) * (puEntree))/tvente_detail_entree.taux) as PTEntreeFC')
        ->selectRaw('(qteBase*puBase) as PTBase')
        ->selectRaw('((qteBase*puBase)/tvente_detail_entree.taux) as PTBaseFC')
        ->selectRaw('((montant) * tvente_detail_entree.taux) as TotalEntreeFC')
        ->selectRaw('(ROUND(montant,0)) as TotalEntree')
        ->selectRaw("DATE_FORMAT(dateEntree,'%d/%M/%Y') as dateEntree")
        ->Where('tvente_detail_entree.refEnteteEntree',$id)               
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    } 
      

    function fetch_single_data($id)
    {
        $data = DB::table('tvente_detail_entree')

        ->join('tvente_entete_entree','tvente_entete_entree.id','=','tvente_detail_entree.refEnteteEntree')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_entree.module_id')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_entree.refFournisseur')

        ->join('tvente_services','tvente_services.id','=','tvente_entete_entree.refService')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_entree.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        
        ->join('tfin_ssouscompte as compteachat','compteachat.id','=','tvente_categorie_produit.compte_achat')       
        ->join('tfin_ssouscompte as comptevariation','comptevariation.id','=','tvente_categorie_produit.compte_variationstock')       
        ->join('tfin_ssouscompte as compteproduit','compteproduit.id','=','tvente_categorie_produit.compte_produit')        
        ->join('tfin_ssouscompte as comptestockage','comptestockage.id','=','tvente_categorie_produit.compte_stockage')      

        ->select('tvente_detail_entree.id','refEnteteEntree','refProduit','tvente_entete_entree.refService',
        'tvente_detail_entree.compte_achat','tvente_detail_entree.compte_variationstock',
        'tvente_detail_entree.compte_produit','tvente_detail_entree.compte_stockage','puEntree','qteEntree',
        'uniteEntree','idStockService',
        'puBase','qteBase','tvente_detail_entree.uniteBase','tvente_detail_entree.devise','tvente_detail_entree.taux',
        'montanttva','montantreduction','tvente_detail_entree.active','tvente_detail_entree.author',
        'tvente_detail_entree.refUser','tvente_detail_entree.created_at','tvente_detail_entree.devise',
        'tvente_detail_entree.taux'

        ,'noms','contact','mail','adresse','tvente_entete_entree.code','tvente_entete_entree.refFournisseur',
        'tvente_entete_entree.refRecquisition','tvente_entete_entree.module_id','dateEntree',
        'tvente_entete_entree.libelle','transporteur','niveau1','niveaumax',"tvente_module.nom_module"

        ,'nom_service'

        ,"tvente_produit.designation as designation",'refCategorie','refUniteBase','pu','qte',
        'cmup','Oldcode','Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie"

        ,'compteachat.refSousCompte as refSousCompteAchat','compteachat.nom_ssouscompte as nom_ssouscompteAchat',
        'compteachat.numero_ssouscompte as numero_ssouscompteAchat'
        ,'comptevariation.refSousCompte as refSousCompteVariation','comptevariation.nom_ssouscompte as nom_ssouscompteVariation',
        'comptevariation.numero_ssouscompte as numero_ssouscompteVariation'
        ,'compteproduit.refSousCompte as refSousCompteProduit','compteproduit.nom_ssouscompte as nom_ssouscompteProduit',
        'compteproduit.numero_ssouscompte as numero_ssouscompteProduit'
        ,'comptestockage.refSousCompte as refSousCompteStockage','comptestockage.nom_ssouscompte as nom_ssouscompteStockage',
        'comptestockage.numero_ssouscompte as numero_ssouscompteStockage' 
        )
        ->selectRaw('((qteEntree) * (puEntree)) as PTEntree')
        ->selectRaw('(((qteEntree) * (puEntree))/tvente_detail_entree.taux) as PTEntreeFC')
        ->selectRaw('(qteBase*puBase) as PTBase')
        ->selectRaw('((qteBase*puBase)/tvente_detail_entree.taux) as PTBaseFC')
        ->where('tvente_detail_entree.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
     
    function insert_data(Request $request)
    {
        $current = Carbon::now(); 

        $taux=DB::table("tvente_taux")->pluck('taux')->first();
    
        $montants=0;
        $devises='';
        if($request->devise != 'USD')
        {
            $montants = ($request->puEntree)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puEntree;
            $devises = $request->devise;
        }

        $refProduit=0;
        $cmupTemp=0;
        $SI=0;
        $data99=DB::table('tvente_stock_service') 
        ->select('id','refService','refProduit','pu','qte','uniteBase','cmup',
        'devise','taux','active','refUser','author')
        ->where([
           ['tvente_stock_service.id','=', $request->idStockService]
        ])      
        ->first();
        if ($data99) 
        {
            $refProduit =  $data99->refProduit;    
            $cmupTemp = $data99->cmup;    
            $SI = $data99->qte;        
        }

        $idCommande=0;
        $data999=DB::table('tvente_entete_entree') 
        ->select('id','code','refFournisseur','refRecquisition','module_id','refService',
        'dateEntree','libelle','transporteur','niveau1','niveaumax','active','author','refUser')
        ->where([
           ['tvente_entete_entree.id','=', $request->refEnteteEntree]
        ])      
        ->first();
        if ($data999) 
        {
            $idCommande =  $data999->refRecquisition; 
        }

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
         'compte_perte','compte_produit','compte_destockage','compte_stockage','cmup','qte')
         ->where([
            ['tvente_produit.id','=', $refProduit]
        ])      
        ->first();      
       
        if ($data3) {
            // Accéder aux propriétés de l'objet car il existe
            $compte_achat = $data3->compte_achat;
            $compte_vente = $data3->compte_vente;
            $compte_variationstock = $data3->compte_variationstock;
            $compte_perte = $data3->compte_perte;
            $compte_produit = $data3->compte_produit;
            $compte_destockage = $data3->compte_destockage;
            $compte_stockage = $data3->compte_stockage; 
        } 
        else {
            // Gérer le cas où aucun produit n'est trouvé
            // Par exemple, vous pourriez lancer une exception ou définir des valeurs par défaut
            return response()->json(['error' => 'Produit non trouvé'], 404);
        }

        $uniteEntree = '';
        $uniteBase = '';
        $puBase=0;
        $qteBase=0;
        $estunite='';
        

        $data4=DB::table('tvente_detail_unite')
        ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_unite.refProduit') 
        ->select('tvente_detail_unite.id','refProduit','refUnite','puUnite','qteUnite','puBase','qteBase','estunite',
        'tvente_detail_unite.active','tvente_detail_unite.author','tvente_detail_unite.refUser',
        'nom_unite','uniteBase')
        ->where([
           ['tvente_detail_unite.id','=', $request->refDetailUnite]
       ])      
       ->first();       
       
       if ($data4) 
       {
           $uniteEntree = $data4->nom_unite;
           $uniteBase = $data4->uniteBase;           
           $qteBase=$data4->qteBase;
           $puBase=$data4->puBase;      
           $estunite=$data4->estunite;
       }

       $qteEntree = $qteBase * floatval($request->qteEntree);
       if($estunite = "NON")
       {
          $puBase=  floatval($montants) / floatval($qteBase);              
       }
       else
       {
          $puBase=  floatval($montants);
       }


       $cmupVente = (((floatval($cmupTemp)*floatval($SI))+(floatval($puBase) * (floatval($qteEntree) * floatval($qteBase))))/(floatval($SI) + (floatval($qteEntree)* floatval($qteBase))));

       
      $montanttva=0;
    
        //id_tva

        $montanttva = DB::table("tvente_tva")->where([
            ['tvente_tva.id','=', $request->id_tva],
            ['tvente_tva.active','=', 'OUI']
        ])->pluck('montant_tva')->first();

        $active = 'OUI';

        $data = tvente_detail_entree::create([
            'refEnteteEntree'       =>  $request->refEnteteEntree,
            'refProduit'    =>  $refProduit,
            'idStockService'    =>  $request->idStockService, 
            'qteEntree'    =>  $request->qteEntree,
            'montantreduction'    =>  $request->montantreduction,
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
            'uniteEntree'    =>  $uniteEntree,
            'puBase'    =>  $puBase,
            'qteBase'    =>  $qteBase,
            'uniteBase'    =>  $uniteBase,
            'montanttva'    =>  $montanttva            
        ]);


        $data222 = DB::update(
            'update tvente_detail_requisition set qteTempo = qteTempo - :qteTempo where refEnteteCmd = :refEnteteCmd and idStockService = :idStockService',
                ['qteTempo' => $request->qteEntree,'refEnteteCmd' => $idCommande,'idStockService' => $request->idStockService]
        );



        $id_detail_max=0;
        $detail_list = DB::table('tvente_detail_entree')       
        ->selectRaw('MAX(id) as code_entete')
        ->where([
            ['refUser','=', $request->refUser],
            ['idStockService','=', $request->idStockService]
        ]) 
        ->get();
        foreach ($detail_list as $list) {
            $id_detail_max= $list->code_entete;
        }

        $data99 = tvente_mouvement_stock::create([             
            'idStockService'    =>  $request->idStockService,             
            'dateMvt'    =>   $current,   
            'type_mouvement'    =>  'Entree',
            'libelle_mouvement'    =>  $request->libelle .':'. $id_detail_max,
            'nom_table'    =>  'tvente_detail_entree',
            'id_data'    =>  $id_detail_max, 
            'qteMvt'    =>  $request->qteEntree,
            'puMvt'    =>  $montants,                   
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser,
            'type_sortie'    =>  'Entree',

            'active'    =>  'OUI',
            'uniteMvt'    =>  $uniteEntree,
            'compte_vente'    =>  0,
            'compte_variationstock'    =>  $compte_variationstock,
            'compte_perte'    =>  0,
            'compte_produit'    =>  $compte_produit,
            'compte_destockage'    =>  0,
            'compte_achat'    =>  $compte_achat,
            'compte_stockage'    =>  $compte_stockage,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'puBase'    =>  $puBase,
            'qteBase'    =>  $qteBase,
            'uniteBase'    =>  $uniteBase,
            'cmupMvt'    =>  $cmupVente
        ]);


        $data2 = DB::update(
            'update tvente_stock_service set qte = qte + :qteEntree, cmup = :cmup where id = :idStockService',
            ['qteEntree' => $qteEntree,'cmup' => $cmupVente,'idStockService' => $request->idStockService]
        );

        $data34 = DB::update(
            'update tvente_entete_entree set montant = montant + (:pu * :qte) where id = :refEnteteEntree',
            ['pu' => $montants,'qte' => $request->qteEntree,'refEnteteEntree' => $request->refEnteteEntree]
        );

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }

    function update_data(Request $request, $id)
    {
        $puEntree=0;
        $qteEntree=0;
        $qteBase=0;

        $deleted =  DB::table("tvente_detail_entree")
        ->select('id','refEnteteEntree','refProduit','idStockService','compte_achat',
        'compte_variationstock','compte_produit','compte_stockage','puEntree','qteEntree','uniteEntree',
        'puBase','qteBase','uniteBase','devise','taux','montanttva','montantreduction','active','author','refUser')
        ->where([
            ['tvente_detail_entree.id','=', $id]
         ])
         ->first();
         if ($deleted) 
         {
            $puEntree = $deleted->puEntree;
            $qteEntree = $deleted->qteEntree;
            $qteBase = $deleted->qteBase;                      
         }
         $qteDeleted = floatval($qteEntree) * floatval($qteBase);
         $montantDeleted = floatval($qteEntree) * floatval($puEntree);

         $taux=DB::table("tvente_taux")->pluck('taux')->first();
    
         $montants=0;
         $devises='';
         if($request->devise != 'USD')
         {
             $montants = ($request->puEntree)/$taux;
             $devises='USD';
         }
         else
         {
             $montants = $request->puEntree;
             $devises = $request->devise;
         }
 
         $refProduit=0;
         $cmupTemp=0;
         $SI=0;
         $data99=DB::table('tvente_stock_service') 
         ->select('id','refService','refProduit','pu','qte','uniteBase','cmup',
         'devise','taux','active','refUser','author')
         ->where([
            ['tvente_stock_service.id','=', $request->idStockService]
         ])      
         ->first();
         if ($data99) 
         {
             $refProduit =  $data99->refProduit;    
             $cmupTemp = $data99->cmup;    
             $SI = $data99->qte;        
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
             ['tvente_produit.id','=', $request->refProduit]
         ])      
         ->first();      
        
         if ($data3) {
             // Accéder aux propriétés de l'objet car il existe
             $compte_achat = $data3->compte_achat;
             $compte_vente = $data3->compte_vente;
             $compte_variationstock = $data3->compte_variationstock;
             $compte_perte = $data3->compte_perte;
             $compte_produit = $data3->compte_produit;
             $compte_destockage = $data3->compte_destockage;
             $compte_stockage = $data3->compte_stockage; 
         } 
         else {
             // Gérer le cas où aucun produit n'est trouvé
             // Par exemple, vous pourriez lancer une exception ou définir des valeurs par défaut
             return response()->json(['error' => 'Produit non trouvé'], 404);
         }
 
 
         $uniteEntree = '';
         $uniteBase = '';
         $puBase=0;
         $qteBase=0;
         $estunite='';
         
 
         $data4=DB::table('tvente_detail_unite')
         ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
         ->join('tvente_produit','tvente_produit.id','=','tvente_detail_unite.refProduit') 
         ->select('tvente_detail_unite.id','refProduit','refUnite','puUnite','qteUnite','puBase','qteBase','estunite',
         'tvente_detail_unite.active','tvente_detail_unite.author','tvente_detail_unite.refUser',
         'nom_unite','uniteBase')
         ->where([
            ['tvente_detail_unite.id','=', $request->refDetailUnite]
        ])      
        ->first();       
        
        if ($data4) 
        {
            $uniteEntree = $data4->nom_unite;
            $uniteBase = $data4->uniteBase;           
            $qteBase=$data4->qteBase;
            $puBase=$data4->puBase;      
            $estunite=$data4->estunite;
        }
 
        $qteEntree = $qteBase * floatval($request->qteEntree);
        if($estunite = "NON")
        {
           $puBase=  floatval($montants) / floatval($qteBase);              
        }
        else
        {
           $puBase=  floatval($montants);
        }

        $cmupVente = (((floatval($cmupTemp)*floatval($SI))+(floatval($puBase) * (floatval($qteEntree) * floatval($qteBase))))/(floatval($SI) + (floatval($qteEntree)* floatval($qteBase))));
        
        // $cmupVente = (((floatval($cmupTemp)*floatval($SI))+(floatval($puBase)*floatval($qteEntree)))/(floatval($SI)+floatval($qteEntree)));
 
        
         $montanttva=0;
     
         //id_tva
 
         $montanttva = DB::table("tvente_tva")->where([
             ['tvente_tva.id','=', $request->id_tva],
             ['tvente_tva.active','=', 'OUI']
         ])->pluck('montant_tva')->first();

         $data = tvente_detail_entree::where('id', $id)->update([           
            'refEnteteEntree'       =>  $request->refEnteteEntree,
            'refProduit'    =>  $refProduit,
            'idStockService'    =>  $request->idStockService, 
            'qteEntree'    =>  $request->qteEntree,
            'montantreduction'    =>  $request->montantreduction,
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
            'uniteEntree'    =>  $uniteEntree,
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
            ['idStockService','=', $request->idStockService]
        ]) 
        ->get();
        foreach ($detail_list as $list) {
            $id_detail_max= $list->code_entete;
        }

        $data99 = tvente_mouvement_stock::where([['id_data','=', $id],['nom_table','=','tvente_detail_entree']])->update([             
            'idStockService'    =>  $request->idStockService,             
            'dateMvt'    =>   $request->dateEntree,            
            'qteMvt'    =>  $request->qteEntree,
            'puMvt'    =>  $montants,                   
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser,          

            'uniteMvt'    =>  $uniteEntree,
            'compte_vente'    =>  0,
            'compte_variationstock'    =>  $compte_variationstock,
            'compte_perte'    =>  0,
            'compte_produit'    =>  $compte_produit,
            'compte_destockage'    =>  0,
            'compte_achat'    =>  $compte_achat,
            'compte_stockage'    =>  $compte_stockage,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'puBase'    =>  $puBase,
            'qteBase'    =>  $qteBase,
            'uniteBase'    =>  $uniteBase,
            'cmupMvt'    =>  $cmupVente
        ]);

        $idCommande=0;
        $data999=DB::table('tvente_entete_entree') 
        ->select('id','code','refFournisseur','refRecquisition','module_id','refService',
        'dateEntree','libelle','transporteur','niveau1','niveaumax','active','author','refUser')
        ->where([
           ['tvente_entete_entree.id','=', $request->refEnteteEntree]
        ])      
        ->first();
        if ($data999) 
        {
            $idCommande =  $data999->refRecquisition; 
        }
        $data222 = DB::update(
            'update tvente_detail_requisition set qteTempo = qteTempo + :qteTempoDeleted - :qteTempo where refEnteteCmd = :refEnteteCmd and idStockService = :idStockService',
                ['qteTempoDeleted' => $qteDeleted,'qteTempo' => $request->qteEntree,'refEnteteCmd' => $idCommande,'idStockService' => $request->idStockService]
        );

        $data2 = DB::update(
            'update tvente_stock_service set qte = qte - :qteDeleted + :qteEntree, cmup = :cmup where id = :idStockService',
            ['qteDeleted' => $qteDeleted,'qteEntree' => $qteEntree,'cmup' => $cmupVente,'idStockService' => $request->idStockService]
        );

        $data34 = DB::update(
            'update tvente_entete_entree set montant = montant - :montantDeleted + (:pu * :qte) where id = :refEnteteEntree',
            ['montantDeleted' => $montantDeleted,'pu' => $montants,'qte' => $request->qteEntree,'refEnteteEntree' => $request->refEnteteEntree]
        );
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
        $idStockService=0;

        $deleteds = DB::table('tvente_detail_entree')->Where('id',$id)->first(); 
        if ($deleteds) {
            $qte = $deleteds->qteEntree;            
            $pu = $deleteds->puEntree;
            $idProduit = $deleteds->refProduit;
            $idFacture = $deleteds->refEnteteEntree;
            $montantreduction = $deleteds->montantreduction;
            $montanttva = $deleteds->montanttva;
            $idStockService = $deleteds->idStockService;
        }

        $refService=0;

        $idCommande=0;
        $data999=DB::table('tvente_entete_entree') 
        ->select('id','code','refFournisseur','refRecquisition','module_id','refService',
        'dateEntree','libelle','transporteur','niveau1','niveaumax','active','author','refUser')
        ->where([
           ['tvente_entete_entree.id','=', $idFacture]
        ])      
        ->first();
        if ($data999) 
        {
            $idCommande =  $data999->refRecquisition; 
        }

        $data222 = DB::update(
            'update tvente_detail_requisition set qteTempo = qteTempo + :qteTempo where refEnteteCmd = :refEnteteCmd and idStockService = :idStockService',
                ['qteTempo' => $deleteds->qteEntree,'refEnteteCmd' => $idCommande,'idStockService' => $idStockService]
        );
        

        $data33=DB::table('tvente_entete_entree') 
         ->select('id','code','refFournisseur','refRecquisition','module_id','refService','dateEntree',
            'libelle','transporteur','niveau1','niveaumax','active','author','refUser')
         ->where([
            ['tvente_entete_entree.id','=', $idFacture]
        ])      
        ->get();      
        $output='';
        foreach ($data33 as $row) 
        {
            $refService =  $row->refService;           
        }


        $data2 = DB::update(
            'update tvente_stock_service set qte = qte - :qteEntree where refProduit = :refProduit and refService = :refService',
            ['qteEntree' => $qte,'refProduit' => $idProduit,'refService' => $refService]
        );

        $data3 = DB::update(
            'update tvente_entete_entree set montant = montant - (:pu * :qte) where id = :refEnteteEntree',
            ['pu' => $pu,'qte' => $qte,'refEnteteEntree' => $idFacture]
        );

        $nom_table = 'tvente_detail_entree';

        $data4 = DB::update(
            'delete from tvente_mouvement_stock where tvente_mouvement_stock.id_data = :id and nom_table=:nom_table',
            ['id' => $id, 'nom_table' => $nom_table]
        );



        $data = tvente_detail_entree::where('id',$id)->delete();

        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);        
    }


    function insert_dataGlobal(Request $request)
    {
        $id_module = 2;
        $active = "OUI";

        $code = $this->GetCodeData('tvente_param_systeme','module_id',$id_module);
        $data111 = tvente_entete_entree::create([
            'code'       =>  $code,
            'refRecquisition'       =>  $request->refRecquisition,
            'refFournisseur'       =>  $request->refFournisseur,
            'transporteur'       =>  $request->transporteur,
            'module_id'       =>  $id_module,
            'refService'       =>  $request->refService,
            'dateEntree'    =>  $request->dateEntree,
            'libelle'    =>  $request->libelle,
            'niveau1'    =>  0,
            'niveaumax'    =>  3,
            'active'    => $active,            
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser
        ]); 

        $idmax=DB::table('tvente_entete_entree')
        ->where([
            ['tvente_entete_entree.refUser','=', $request->refUser],
            ['tvente_entete_entree.refFournisseur','=', $request->refFournisseur]
         ])
        ->max('id');

        $detailData = $request->detailData;

        foreach ($detailData as $data) {

            $taux=DB::table("tvente_taux")->pluck('taux')->first();
    
            $montants=0;
            $devises='';
            if($request->devise != 'USD')
            {
                $montants = ($data['puEntree'])/$taux;
                $devises='USD';
            }
            else
            {
                $montants = $data['puEntree'];
                $devises = $request->devise;
            }

            $refProduit=0;
            $cmupTemp = 0;    
            $SI = 0;
            $data99=DB::table('tvente_stock_service') 
            ->select('id','refService','refProduit','pu','qte','uniteBase','cmup',
            'devise','taux','active','refUser','author')
            ->where([
               ['tvente_stock_service.id','=', $data['idStockService']]
            ])      
            ->first();
            if ($data99) 
            {
                $refProduit =  $data99->refProduit;  
                $cmupTemp = $data99->cmup;    
                $SI = $data99->qte;         
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
                ['tvente_produit.id','=', $refProduit]
            ])      
            ->first();      
           
            if ($data3) {
                // Accéder aux propriétés de l'objet car il existe
                $compte_achat = $data3->compte_achat;
                $compte_vente = $data3->compte_vente;
                $compte_variationstock = $data3->compte_variationstock;
                $compte_perte = $data3->compte_perte;
                $compte_produit = $data3->compte_produit;
                $compte_destockage = $data3->compte_destockage;
                $compte_stockage = $data3->compte_stockage; 
            } 
            else {
                // Gérer le cas où aucun produit n'est trouvé
                // Par exemple, vous pourriez lancer une exception ou définir des valeurs par défaut
                return response()->json(['error' => 'Produit non trouvé'], 404);
            }


            $uniteEntree = '';
            $uniteBase = '';
            $puBase=0;
            $qteBase=0;
            $estunite='';
            
    
            $data4=DB::table('tvente_detail_unite')
            ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
            ->join('tvente_produit','tvente_produit.id','=','tvente_detail_unite.refProduit') 
            ->select('tvente_detail_unite.id','refProduit','refUnite','puUnite','qteUnite','puBase','qteBase','estunite',
            'tvente_detail_unite.active','tvente_detail_unite.author','tvente_detail_unite.refUser',
            'nom_unite','uniteBase')
            ->where([
               ['tvente_detail_unite.id','=', $data['refDetailUnite']]
           ])      
           ->first();       
           
           if ($data4) 
           {
               $uniteEntree = $data4->nom_unite;
               $uniteBase = $data4->uniteBase;           
               $qteBase=$data4->qteBase;
               $puBase=$data4->puBase;      
               $estunite=$data4->estunite;
           }

           $qteEntree = $qteBase * floatval($data['qteEntree']);
           if($estunite = "NON")
           {
              $puBase=  floatval($montants) / floatval($qteBase);              
           }
           else
           {
              $puBase=  floatval($montants);
           }
           
           $cmupVente = (((floatval($cmupTemp)*floatval($SI))+(floatval($puBase) * (floatval($qteEntree) * floatval($qteBase))))/(floatval($SI) + (floatval($qteEntree)* floatval($qteBase))));
           
          $montanttva=0;
     
          //id_tva

          $montanttva = DB::table("tvente_tva")->where([
            ['tvente_tva.id','=', $data['id_tva']],
             ['tvente_tva.active','=', 'OUI']
          ])->pluck('montant_tva')->first();
    
   
            $data2222 = tvente_detail_entree::create([
                'refEnteteEntree'       =>  $idmax,
                'refProduit'    =>  $refProduit,
                'idStockService'    =>  $data['idStockService'], 
                'qteEntree'    =>  $data['qteEntree'],
                'montantreduction'    =>  $data['montantreduction'],
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
                'uniteEntree'    =>  $uniteEntree,
                'puBase'    =>  $puBase,
                'qteBase'    =>  $qteBase,
                'uniteBase'    =>  $uniteBase,
                'montanttva'    =>  $montanttva            
            ]);

        
        $data222 = DB::update(
            'update tvente_detail_requisition set qteTempo = qteTempo - :qteTempo where refEnteteCmd = :refEnteteCmd and idStockService = :idStockService',
                ['qteTempo' => $data['qteEntree'],'refEnteteCmd' => $request->refRecquisition,'idStockService' => $data['idStockService']]
        );

    
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
            'dateMvt'    =>   $request->dateEntree,   
            'type_mouvement'    =>  'Entree',
            'libelle_mouvement'    =>  $request->libelle .':'. $id_detail_max,
            'nom_table'    =>  'tvente_detail_entree',
            'id_data'    =>  $id_detail_max, 
            'qteMvt'    =>  $data['qteEntree'],
            'puMvt'    =>  $montants,                   
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser,
            'type_sortie'    =>  'Entree',

            'active'    =>  $active,
            'uniteMvt'    =>  $uniteEntree,
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


        $data2 = DB::update(
            'update tvente_stock_service set qte = qte + :qteEntree, cmup = :cmup where id = :idStockService',
            ['qteEntree' => $qteEntree,'cmup' => $cmupVente,'idStockService' => $data['idStockService']]
        );

            $data34 = DB::update(
                'update tvente_entete_entree set montant = montant + (:pu * :qte) where id = :refEnteteEntree',
                ['pu' => $montants,'qte' => $data['qteEntree'],'refEnteteEntree' => $idmax]
            );
            
        }

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }




    function insert_dataGlobalQuickCommande(Request $request)
    {
        $id_module = 2;
        $active = "OUI";

        $code = $this->GetCodeData('tvente_param_systeme','module_id',$id_module);
        $data = tvente_entete_entree::create([
            'code'       =>  $code,
            'refRecquisition'       =>  $request->refRecquisition,
            'refFournisseur'       =>  $request->refFournisseur,
            'transporteur'       =>  $request->transporteur,
            'module_id'       =>  $id_module,
            'refService'       =>  $request->refService,
            'dateEntree'    =>  $request->dateEntree,
            'libelle'    =>  $request->libelle,
            'niveau1'    =>  0,
            'niveaumax'    =>  3,
            'active'    => $active,            
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser
        ]); 

        $idmax=DB::table('tvente_entete_entree')
        ->where([
            ['tvente_entete_entree.refUser','=', $request->refUser],
            ['tvente_entete_entree.refFournisseur','=', $request->refFournisseur]
         ])
        ->max('id');

        $detailData = $request->detailData;

        foreach ($detailData as $data) {

            $taux=DB::table("tvente_taux")->pluck('taux')->first();
    
            $montants=0;
            $devises='';
            if($request->devise != 'USD')
            {
                $montants = ($data['puEntree'])/$taux;
                $devises='USD';
            }
            else
            {
                $montants = $data['puEntree'];
                $devises = $request->devise;
            }

            $refProduit=0;
            $qteBase=1;
            $qtePivot=0;
            $cmupTemp=0;
            $SI=0;
            $data99=DB::table('tvente_stock_service') 
            ->select('id','refService','refProduit','pu','qte','uniteBase','cmup','devise',
            'taux','active','refUser','author','unitePivot')
            ->selectRaw("(CASE 
                    WHEN qtePivot IS NULL OR qtePivot = 0 THEN 1 
                    ELSE qtePivot 
                END) as qtePivot")
            ->where([
               ['tvente_stock_service.id','=', $data['idStockService']]
            ])      
            ->first();
            if ($data99) 
            {
                $refProduit =  $data99->refProduit; 
                $qtePivot= $data99->qtePivot;
                $cmupTemp = $data99->cmup;    
                $SI = $data99->qte;          
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
    
            $data3=DB::table('tvente_produit')
             ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
             ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
             'compte_perte','compte_produit','compte_destockage','compte_stockage','cmup','qte')
             ->where([
                ['tvente_produit.id','=', $data['refProduit']]
            ])      
            ->first();      
           
            if ($data3) {
                // Accéder aux propriétés de l'objet car il existe
                $compte_achat = $data3->compte_achat;
                $compte_vente = $data3->compte_vente;
                $compte_variationstock = $data3->compte_variationstock;
                $compte_perte = $data3->compte_perte;
                $compte_produit = $data3->compte_produit;
                $compte_destockage = $data3->compte_destockage;
                $compte_stockage = $data3->compte_stockage; 
            } 
            else {
                // Gérer le cas où aucun produit n'est trouvé
                // Par exemple, vous pourriez lancer une exception ou définir des valeurs par défaut
                return response()->json(['error' => 'Produit non trouvé'], 404);
            }


            $uniteEntree = '';
            $uniteBase = '';
            $puBase=0;            
            $estunite='';            
    
            $data4=DB::table('tvente_detail_unite')
            ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
            ->join('tvente_produit','tvente_produit.id','=','tvente_detail_unite.refProduit') 
            ->select('tvente_detail_unite.id','refProduit','refUnite','puUnite','qteUnite',
            'puBase','qteBase','estunite',
            'tvente_detail_unite.active','tvente_detail_unite.author','tvente_detail_unite.refUser',
            'nom_unite','uniteBase')
            ->where([
               ['tvente_detail_unite.refProduit','=', $data['refProduit']],
               ['tvente_unite.nom_unite','=', $data['nom_unite']]
           ])      
           ->first();           
           if ($data4) 
           {
               $uniteEntree = $data4->nom_unite;
               $qteBase = $data4->qteBase;
               $uniteBase = $data4->uniteBase;
               $puBase=$data4->puBase;      
               $estunite=$data4->estunite;
           }

           $qteEntree = floatval($qteBase) * floatval($data['qteEntree']);
           if($estunite = "NON")
           {
                if ($qteBase != 0) {
                    $puBase=  floatval($montants) / floatval($qteBase);
                } else {
                    $puBase=  floatval($montants) / 1;
                }                           
           }
           else
           {
              $puBase=  floatval($montants);
           }


           
           if ($SI != 0 || $qteEntree != 0) {
                $cmupVente = (((floatval($cmupTemp)*floatval($SI))+(floatval($puBase) * (floatval($qteEntree) * floatval($qteBase))))/(floatval($SI) + (floatval($qteEntree)* floatval($qteBase))));
            } else {
                $cmupVente = (((floatval($cmupTemp)*floatval($SI))+(floatval($puBase) * (floatval($qteEntree) * floatval($qteBase))))/1);
            }           
    
   
            $data = tvente_detail_entree::create([
                'refEnteteEntree'       =>  $idmax,
                'refProduit'    =>  $refProduit,
                'idStockService'    =>  $data['idStockService'], 
                'qteEntree'    =>  $data['qteEntree'],
                'montantreduction'    =>  $data['montantreduction'],
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
                'uniteEntree'    =>  $uniteEntree,
                'puBase'    =>  $puBase,
                'qteBase'    =>  $qteBase,
                'uniteBase'    =>  $uniteBase,
                'montanttva'    =>  $data['montanttva']            
            ]);

        
        $data222 = DB::update(
            'update tvente_detail_requisition set qteTempo = qteTempo - :qteTempo where refEnteteCmd = :refEnteteCmd and idStockService = :idStockService',
                ['qteTempo' => $data['qteEntree'],'refEnteteCmd' => $request->refRecquisition,'idStockService' => $data['idStockService']]
        );

        $data2 = DB::update(
            'update tvente_stock_service set qte = qte + :qteEntree, cmup = :cmup where id = :idStockService',
            ['qteEntree' => $qteEntree,'cmup' => $cmupVente,'idStockService' => $data['idStockService']]
        );

        $data34 = DB::update(
            'update tvente_entete_entree set montant = montant + (:pu * :qte) where id = :refEnteteEntree',
            ['pu' => $montants,'qte' => $data['qteEntree'],'refEnteteEntree' => $idmax]
        );

    
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
            'dateMvt'    =>   $request->dateEntree,   
            'type_mouvement'    =>  'Entree',
            'libelle_mouvement'    => $request->libelle .':'. $id_detail_max,
            'nom_table'    =>  'tvente_detail_entree',
            'id_data'    =>  $id_detail_max, 
            'qteMvt'    =>  $data['qteEntree'],
            'puMvt'    =>  $montants,                   
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser,
            'type_sortie'    =>  'Entree',

            'active'    =>  $active,
            'uniteMvt'    =>  $uniteEntree,
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






}
