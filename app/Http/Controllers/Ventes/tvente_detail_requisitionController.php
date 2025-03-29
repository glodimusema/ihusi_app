<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_detail_requisition;
use App\Models\Ventes\tvente_entete_requisition;
use App\Models\Ventes\tvente_detail_entree;
use App\Models\Ventes\tvente_mouvement_stock;
use App\Models\Ventes\tvente_entete_entree;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tvente_detail_requisitionController extends Controller
{

    use GlobalMethod, Slug;

    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
    }

    // 'id','refEnteteCmd','refProduit','compte_achat','compte_produit','puCmd',
    // 'qteCmd','uniteCmd','puBase','qteBase','uniteBase','montanttva','montantreduction',
    // 'active','author','refUser'

    public function all(Request $request)
    {
        $data = DB::table('tvente_detail_requisition')
        ->join('tfin_ssouscompte as compteachat','compteachat.id','=','tvente_detail_requisition.compte_achat')
        ->join('tfin_ssouscompte as compteproduit','compteproduit.id','=','tvente_detail_requisition.compte_produit')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_requisition.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_requisition','tvente_entete_requisition.id','=','tvente_detail_requisition.refEnteteCmd')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
        ->select('tvente_detail_requisition.id','refEnteteCmd','refProduit','tvente_detail_requisition.compte_achat',
        'tvente_detail_requisition.compte_produit','puCmd','qteCmd','uniteCmd','tvente_detail_requisition.puBase',
        'tvente_detail_requisition.qteBase','tvente_detail_requisition.uniteBase','tvente_detail_requisition.devise',
        'tvente_detail_requisition.taux','montanttva','montantreduction','tvente_detail_requisition.active',
        'tvente_detail_requisition.author','tvente_detail_requisition.refUser','tvente_detail_requisition.created_at'
        ,"tvente_produit.designation as designation",'refCategorie','pu','qte',
        'cmup','Oldcode','Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie"
        ,'compteachat.refSousCompte as refSousCompteAchat','compteachat.nom_ssouscompte as nom_ssouscompteAchat',
        'compteachat.numero_ssouscompte as numero_ssouscompteAchat'
        ,'compteproduit.refSousCompte as refSousCompteProduit','compteproduit.nom_ssouscompte as nom_ssouscompteProduit',
        'compteproduit.numero_ssouscompte as numero_ssouscompteProduit','noms','contact','mail','adresse','dateCmd')
        ->selectRaw('(qteCmd*puCmd) as PTCmd')
        ->selectRaw('(qteCmd*puCmd) as PTBase')
        ->selectRaw('((qteTempo)) as resteCmd')
        ->selectRaw('(qteTempo) as qteTempo')
        // ->selectRaw('(qteTempo * (-1)) as qteTempo')
        // ->selectRaw('((qteCmd + qteTempo)) as resteCmd')
        ->selectRaw('((qteCmd*puCmd)/tvente_detail_requisition.taux) as PTCmdFC')
        ->selectRaw('((qteCmd*puCmd)/tvente_detail_requisition.taux) as PTBaseFC');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_requisition.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_detail_requisition.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tvente_detail_requisition')
        ->join('tfin_ssouscompte as compteachat','compteachat.id','=','tvente_detail_requisition.compte_achat')
        ->join('tfin_ssouscompte as compteproduit','compteproduit.id','=','tvente_detail_requisition.compte_produit')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_requisition.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_requisition','tvente_entete_requisition.id','=','tvente_detail_requisition.refEnteteCmd')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
        ->select('tvente_detail_requisition.id','refEnteteCmd','refProduit','tvente_detail_requisition.compte_achat',
        'tvente_detail_requisition.compte_produit','puCmd','qteCmd','uniteCmd','tvente_detail_requisition.puBase',
        'tvente_detail_requisition.qteBase','tvente_detail_requisition.uniteBase','tvente_detail_requisition.devise',
        'tvente_detail_requisition.taux','montanttva','montantreduction','tvente_detail_requisition.active',
        'tvente_detail_requisition.author','tvente_detail_requisition.refUser','tvente_detail_requisition.created_at'
        ,"tvente_produit.designation as designation",'refCategorie','pu','qte',
        'cmup','Oldcode','Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie"
        ,'compteachat.refSousCompte as refSousCompteAchat','compteachat.nom_ssouscompte as nom_ssouscompteAchat',
        'compteachat.numero_ssouscompte as numero_ssouscompteAchat'
        ,'compteproduit.refSousCompte as refSousCompteProduit','compteproduit.nom_ssouscompte as nom_ssouscompteProduit',
        'compteproduit.numero_ssouscompte as numero_ssouscompteProduit','noms','contact','mail','adresse','dateCmd')
        ->selectRaw('(qteCmd*puCmd) as PTCmd')
        ->selectRaw('(qteCmd*puCmd) as PTBase')
        ->selectRaw('((qteTempo)) as resteCmd')
        ->selectRaw('(qteTempo) as qteTempo')
        // ->selectRaw('(qteTempo * (-1)) as qteTempo')
        // ->selectRaw('((qteCmd + qteTempo)) as resteCmd')
        ->selectRaw('((qteCmd*puCmd)/tvente_detail_requisition.taux) as PTCmdFC')
        ->selectRaw('((qteCmd*puCmd)/tvente_detail_requisition.taux) as PTBaseFC')
        ->Where('refEnteteCmd',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_requisition.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_detail_requisition.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    



    function fetch_detail_requisition_vente($id)
    {
        $data = DB::table('tvente_detail_requisition')
        ->join('tfin_ssouscompte as compteachat','compteachat.id','=','tvente_detail_requisition.compte_achat')
        ->join('tfin_ssouscompte as compteproduit','compteproduit.id','=','tvente_detail_requisition.compte_produit')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_requisition.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_requisition','tvente_entete_requisition.id','=','tvente_detail_requisition.refEnteteCmd')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
        ->select('tvente_detail_requisition.id','refEnteteCmd','refProduit','tvente_detail_requisition.compte_achat',
        'tvente_detail_requisition.compte_produit','puCmd','qteCmd','uniteCmd','tvente_detail_requisition.puBase',
        'tvente_detail_requisition.qteBase','tvente_detail_requisition.uniteBase','tvente_detail_requisition.devise',
        'tvente_detail_requisition.taux','montanttva','montantreduction','tvente_detail_requisition.active',
        'tvente_detail_requisition.author','tvente_detail_requisition.refUser','tvente_detail_requisition.created_at'
        ,"tvente_produit.designation as designation",'refCategorie','pu','qte',
        'cmup','Oldcode','Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie"
        ,'compteachat.refSousCompte as refSousCompteAchat','compteachat.nom_ssouscompte as nom_ssouscompteAchat',
        'compteachat.numero_ssouscompte as numero_ssouscompteAchat'
        ,'compteproduit.refSousCompte as refSousCompteProduit','compteproduit.nom_ssouscompte as nom_ssouscompteProduit',
        'compteproduit.numero_ssouscompte as numero_ssouscompteProduit','noms','contact','mail','adresse','dateCmd','libelle')
        ->selectRaw('(qteCmd * puCmd) as PTCmd')
        ->selectRaw('((qteTempo)) as resteCmd')
        ->selectRaw('(qteTempo) as qteTempo')
        // ->selectRaw('(qteTempo * (-1)) as qteTempo')
        // ->selectRaw('((qteCmd + qteTempo)) as resteCmd')
        ->selectRaw('((qteCmd * puCmd) * tvente_detail_requisition.taux) as PTCmdFC')
        ->selectRaw('((montant) * tvente_detail_requisition.taux) as TotalCmdFC')
        ->selectRaw('(ROUND(montant,2)) as TotalCmd')
        ->selectRaw('(ROUND(paie,2)) as PaieCmd')
        ->selectRaw('(ROUND(montant,2) - ROUND(paie,2)) as RestePaieCmd')
        ->selectRaw("DATE_FORMAT(dateCmd,'%d/%M/%Y') as dateCmd")
        ->Where('tvente_detail_requisition.refEnteteCmd',$id)               
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    } 


    function fetch_single_data($id)
    {
        $data = DB::table('tvente_detail_requisition')
        ->join('tfin_ssouscompte as compteachat','compteachat.id','=','tvente_detail_requisition.compte_achat')
        ->join('tfin_ssouscompte as compteproduit','compteproduit.id','=','tvente_detail_requisition.compte_produit')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_requisition.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_requisition','tvente_entete_requisition.id','=','tvente_detail_requisition.refEnteteCmd')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
        ->select('tvente_detail_requisition.id','refEnteteCmd','refProduit','tvente_detail_requisition.compte_achat',
        'tvente_detail_requisition.compte_produit','puCmd','qteCmd','uniteCmd','tvente_detail_requisition.puBase',
        'tvente_detail_requisition.qteBase','tvente_detail_requisition.uniteBase','tvente_detail_requisition.devise',
        'tvente_detail_requisition.taux','montanttva','montantreduction','tvente_detail_requisition.active',
        'tvente_detail_requisition.author','tvente_detail_requisition.refUser','tvente_detail_requisition.created_at'
        ,"tvente_produit.designation as designation",'refCategorie','pu','qte',
        'cmup','Oldcode','Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie"
        ,'compteachat.refSousCompte as refSousCompteAchat','compteachat.nom_ssouscompte as nom_ssouscompteAchat',
        'compteachat.numero_ssouscompte as numero_ssouscompteAchat'
        ,'compteproduit.refSousCompte as refSousCompteProduit','compteproduit.nom_ssouscompte as nom_ssouscompteProduit',
        'compteproduit.numero_ssouscompte as numero_ssouscompteProduit','noms','contact','mail','adresse','dateCmd')
        ->selectRaw('(qteCmd*puCmd) as PTCmd')
        ->selectRaw('((qteTempo)) as resteCmd')
        ->selectRaw('(qteTempo) as qteTempo')
        // ->selectRaw('(qteCmd*puCmd) as PTBase')
        // ->selectRaw('(qteTempo * (-1)) as qteTempo')
        ->selectRaw('((qteCmd + qteTempo)) as resteCmd')
        ->selectRaw('((qteCmd*puCmd)/tvente_detail_requisition.taux) as PTCmdFC')
        ->selectRaw('((qteCmd*puCmd)/tvente_detail_requisition.taux) as PTBaseFC')
        ->where('tvente_detail_requisition.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_data_commande($refEnteteCmd)
    {
        $data = DB::table('tvente_detail_requisition')        
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_requisition.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_requisition','tvente_entete_requisition.id','=','tvente_detail_requisition.refEnteteCmd')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
        ->select('tvente_detail_requisition.id','refEnteteCmd','refProduit','tvente_detail_requisition.compte_achat',
        'tvente_detail_requisition.compte_produit','puCmd as puCmd','qteCmd as qteCmd',
        'uniteCmd as uniteCmd','tvente_detail_requisition.puBase',
        'tvente_detail_requisition.qteBase','tvente_detail_requisition.uniteBase','tvente_detail_requisition.devise',
        'tvente_detail_requisition.taux','montanttva','montantreduction','tvente_detail_requisition.active',
        'tvente_detail_requisition.author','tvente_detail_requisition.refUser','tvente_detail_requisition.created_at'
        ,"tvente_produit.designation as designation",'refCategorie','pu','qte','cmup','Oldcode','Newcode',
        'tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie",'noms','contact',
        'mail','adresse','dateCmd as dateCmd','idStockService')
        ->selectRaw('(qteCmd*puCmd) as PTCmd')
        ->selectRaw('((qteTempo)) as resteCmd')
        ->selectRaw('(qteTempo) as qteTempo')
        ->selectRaw('(qteCmd*puCmd) as PTBase')
        // ->selectRaw('((qteCmd*puCmd)/tvente_detail_requisition.taux) as PTCmdFC')
        // ->selectRaw('((qteCmd*puCmd)/tvente_detail_requisition.taux) as PTBaseFC')
        ->where('tvente_detail_requisition.refEnteteCmd', $refEnteteCmd)
        ->orderBy("tvente_detail_requisition.created_at", "desc")
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }





    // 'id','refEnteteCmd','refProduit','compte_achat','compte_produit','puCmd',
    // 'qteCmd','uniteCmd','puBase','qteBase','uniteBase','montanttva','montantreduction',
    // 'active','author','refUser'
   
    function insert_datas(Request $request)
    {
        $id_module = 1;
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
            $montants = ($request->puCmd)/$taux;
            $devises='USD';
        }
        else
        { 
            $montants = $request->puCmd;
            $devises = $request->devise;
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
         'compte_perte','compte_produit','compte_destockage','compte_stockage','cmup')
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
            $cmupTemp=$row->cmup;         
        }

        $uniteCmd = '';
        $uniteBase = '';
        $puBase=0;
        $qteBase=0;
        $estunite='';

        $data4=DB::table('tvente_detail_unite')
        ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_unite.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
        ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
        'compte_perte','compte_produit','compte_destockage','compte_stockage','qteUnite',
        'puUnite','uniteBase','nom_unite','estunite')
        ->where([
           ['tvente_detail_unite.id','=', $request->refDetailUnite]
       ])      
       ->get();      
       $output='';
       foreach ($data4 as $row) 
       {
           $uniteCmd = $row->nom_unite;
           $uniteBase = $row->uniteBase;
           $puTemp=$row->puUnite;
           $qteTemp=$row->qteUnite; 
           $estunite=$row->estunite;      
       }

       //floatval($count)
       $qteBase= floatval($qteTemp) * floatval($request->qteCmd);
       if($estunite = "OUI")
       {
         $puBase = floatval($montants);
       }
       else
       {
         $puBase=  floatval($montants) / floatval($request->qteCmd);
       }           
       $cmupVente = ((floatval($cmupTemp) + floatval($puBase))/2);

       
      $montanttva=0;


      $data5=DB::table('tvente_tva')     
      ->select('montant_tva')
      ->where([
        ['tvente_tva.id','=', $request->id_tva],
         ['tvente_tva.active','=', 'OUI']
      ])      
      ->get();      
      $output='';
      foreach ($data5 as $row) 
      {
          $montanttva = $row->montant_tva;
      }

      //qteTempo
        $data = tvente_detail_requisition::create([
            'refEnteteCmd'       =>   $request->refEnteteCmd,
            'refProduit'    =>  $request->refProduit,
            'qteCmd'    =>  $request->qteCmd,
            'qteTempo'    =>  $request->qteCmd,
            'montantreduction'    =>  $request->montantreduction,
            'active'    =>  $active,            
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser,

            'compte_achat'    =>  $compte_achat,
            'compte_produit'    =>  $compte_produit,
            'puCmd'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'uniteCmd'    =>  $uniteCmd,
            'puBase'    =>  $puBase,
            'qteBase'    =>  $qteBase,
            'uniteBase'    =>  $uniteBase,
            'montanttva'    =>  $montanttva            
        ]);

        $data3 = DB::update(
            'update tvente_entete_requisition set montant = montant + (:pu * :qte) where id = :refEnteteCmd',
            ['pu' => $puBase,'qte' => $qteBase,'refEnteteCmd' => $request->refEnteteCmd]
        );

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }



    function insert_data(Request $request)
    {
        $taux=DB::table("tvente_taux")->pluck('taux')->first();
    
        $montants=0;
        $devises='';
        if($request->devise != 'USD')
        {
            $montants = ($request->puCmd)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puCmd;
            $devises = $request->devise;
        }

        $refProduit=0;
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
            $cmupTemp = $data3->cmup;    
            $SI = $data3->qte;     
        } 
        else {
            // Gérer le cas où aucun produit n'est trouvé
            // Par exemple, vous pourriez lancer une exception ou définir des valeurs par défaut
            return response()->json(['error' => 'Produit non trouvé'], 404);
        }

        $uniteCmd = '';
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
           $uniteCmd = $data4->nom_unite;
           $uniteBase = $data4->uniteBase;           
           $qteBase=$data4->qteBase;
           $puBase=$data4->puBase;      
           $estunite=$data4->estunite;
       }

       $qteCmd = $qteBase * floatval($request->qteCmd);
       if($estunite = "NON")
       {
          $puBase=  floatval($montants) / floatval($qteBase);              
       }
       else
       {
          $puBase=  floatval($montants);
       }
       $cmupVente = (((floatval($cmupTemp)*floatval($SI))+(floatval($puBase)*floatval($qteCmd)))/(floatval($SI)+floatval($qteCmd)));

       
      $montanttva=0;
 
      //id_tva

      $montanttva = DB::table("tvente_tva")->where([
        ['tvente_tva.id','=', $request->id_tva],
         ['tvente_tva.active','=', 'OUI']
      ])->pluck('montant_tva')->first();


        $data = tvente_detail_requisition::create([
            'refEnteteCmd'       =>  $request->refEnteteCmd,
            'refProduit'    =>  $refProduit,
            'idStockService'    =>  $request->idStockService, 
            'qteCmd'    =>  $request->qteCmd,
            'qteTempo'    =>  $request->qteCmd,
            'montantreduction'    =>  $request->montantreduction,
            'active'    =>  "OUI",            
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser,

            'compte_achat'    =>  $compte_achat,
            'compte_produit'    =>  $compte_produit,
            'puCmd'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'uniteCmd'    =>  $uniteCmd,
            'puBase'    =>  $puBase,
            'qteBase'    =>  $qteBase,
            'uniteBase'    =>  $uniteBase,
            'montanttva'    =>  $montanttva            
        ]);   


        $data34 = DB::update(
            'update tvente_entete_requisition set montant = montant + (:pu * :qte) where id = :refEnteteCmd',
            ['pu' => $montants,'qte' => $request->qteCmd,'refEnteteCmd' => $request->refEnteteCmd]
        );


        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }
 


    function update_data(Request $request, $id)
    {
        $puCmd=0;
        $qteCmd=0;
        $qteBase=0;

        $deleted =  DB::table("tvente_detail_requisition")
        ->select('id','refEnteteCmd','refProduit','idStockService','compte_achat','compte_produit','puCmd',
        'qteCmd','uniteCmd','puBase','qteBase','uniteBase','devise','taux','montanttva','montantreduction',
        'active','author','refUser')
        ->where([
            ['tvente_detail_requisition.id','=', $id]
         ])
         ->first();
         if ($deleted) 
         {
            $puCmd = $deleted->puCmd;
            $qteCmd = $deleted->qteCmd;
            $qteBase = $deleted->qteBase;                      
         }
         $qteDeleted = floatval($qteCmd) * floatval($qteBase);
         $montantDeleted = floatval($qteCmd) * floatval($puCmd);

        $taux=DB::table("tvente_taux")->pluck('taux')->first();
    
        $montants=0;
        $devises='';
        if($request->devise != 'USD')
        {
            $montants = ($request->puCmd)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puCmd;
            $devises = $request->devise;
        }

        $refProduit=0;
        $cmupTemp = 0;    
        $SI = 0; 
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

        $uniteCmd = '';
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
           $uniteCmd = $data4->nom_unite;
           $uniteBase = $data4->uniteBase;           
           $qteBase=$data4->qteBase;
           $puBase=$data4->puBase;      
           $estunite=$data4->estunite;
       }

       $qteCmd = $qteBase * floatval($request->qteCmd);
       if($estunite = "NON")
       {
          $puBase=  floatval($montants) / floatval($qteBase);              
       }
       else
       {
          $puBase=  floatval($montants);
       }
       $cmupVente = (((floatval($cmupTemp)*floatval($SI))+(floatval($puBase)*floatval($qteCmd)))/(floatval($SI)+floatval($qteCmd)));

       
      $montanttva=0;
 
      //id_tva

      $montanttva = DB::table("tvente_tva")->where([
        ['tvente_tva.id','=', $request->id_tva],
         ['tvente_tva.active','=', 'OUI']
      ])->pluck('montant_tva')->first();

        $data = tvente_detail_requisition::where('id', $id)->update([
            'refEnteteCmd'       =>  $request->refEnteteCmd,
            'refProduit'    =>  $refProduit,
            'idStockService'    =>  $request->idStockService, 
            'qteCmd'    =>  $request->qteCmd,
            'qteTempo'    =>  $request->qteCmd,
            'montantreduction'    =>  $request->montantreduction,
            'active'    =>  "OUI",            
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser,

            'compte_achat'    =>  $compte_achat,
            'compte_produit'    =>  $compte_produit,
            'puCmd'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'uniteCmd'    =>  $uniteCmd,
            'puBase'    =>  $puBase,
            'qteBase'    =>  $qteBase,
            'uniteBase'    =>  $uniteBase,
            'montanttva'    =>  $montanttva            
        ]);   

        //$montantDeleted

        $data34 = DB::update(
            'update tvente_entete_requisition set montant = montant - :montantDeleted + (:pu * :qte) where id = :refEnteteCmd',
            ['montantDeleted' => $montantDeleted,'pu' => $montants,'qte' => $request->qteCmd,'refEnteteCmd' => $request->refEnteteCmd]
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

        $deleteds = DB::table('tvente_detail_requisition')->Where('id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $qte = $deleted->qteCmd;            
            $pu = $deleted->puCmd;
            $idProduit = $deleted->refProduit;
            $idFacture = $deleted->refEnteteCmd;
            $montantreduction = $deleted->montantreduction;
            $montanttva = $deleted->montanttva;
        }
        $data = tvente_detail_requisition::where('id',$id)->delete(); 
        
        $data3 = DB::update(
            'update tvente_entete_requisition set montant = montant - (:pu * :qte) where id = :refEnteteCmd',
            ['pu' => $pu,'qte' => $qte,'refEnteteCmd' => $idFacture]
        );
        
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);        
    }


 
   function insert_dataGlobal(Request $request)
    {
        $id_module = 1;
        $active = "OUI";

        $code = $this->GetCodeData('tvente_param_systeme','module_id',$id_module);
        $data111 = tvente_entete_requisition::create([
            'code'       =>  $code,
            'refFournisseur'       =>  $request->refFournisseur,
            'module_id'       =>  $id_module,
            'refService'       =>  $request->refService,
            'dateCmd'    =>  $request->dateCmd,
            'libelle'    =>  $request->libelle,
            'niveau1'    =>  0,
            'niveaumax'    =>  3,
            'active'    =>  $active,            
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser
        ]);

        $idmax=DB::table('tvente_entete_requisition')
        ->where([
            ['tvente_entete_requisition.refUser','=', $request->refUser],
            ['tvente_entete_requisition.refFournisseur','=', $request->refFournisseur]
         ])
        ->max('id');

        $detailData = $request->detailData;

        foreach ($detailData as $data) {

            $taux=DB::table("tvente_taux")->pluck('taux')->first();
    
            $montants=0;
            $devises='';
            if($request->devise != 'USD')
            {
                $montants = ($data['puCmd'])/$taux;
                $devises='USD';
            }
            else
            {
                $montants = $data['puCmd'];
                $devises = $request->devise;
            }

            $refProduit=0;
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
                $cmupTemp = $data3->cmup;    
                $SI = $data3->qte;     
            } 
            else {
                // Gérer le cas où aucun produit n'est trouvé
                // Par exemple, vous pourriez lancer une exception ou définir des valeurs par défaut
                return response()->json(['error' => 'Produit non trouvé'], 404);
            }
 
            $uniteCmd = '';
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
               $uniteCmd = $data4->nom_unite;
               $uniteBase = $data4->uniteBase;           
               $qteBase=$data4->qteBase;
               $puBase=$data4->puBase;      
               $estunite=$data4->estunite;
           }

           $qteCmd = $qteBase * floatval($data['qteCmd']);
           if($estunite = "NON")
           {
              $puBase=  floatval($montants) / floatval($qteBase);              
           }
           else
           {
              $puBase=  floatval($montants);
           }
           $cmupVente = (((floatval($cmupTemp)*floatval($SI))+(floatval($puBase)*floatval($qteCmd)))/(floatval($SI)+floatval($qteCmd)));
    
           
          $montanttva=0;
     
          //id_tva

          $montanttva = DB::table("tvente_tva")->where([
            ['tvente_tva.id','=', $data['id_tva']],
             ['tvente_tva.active','=', 'OUI']
          ])->pluck('montant_tva')->first();

   
            $data2222 = tvente_detail_requisition::create([
                'refEnteteCmd'       =>  $idmax,
                'refProduit'    =>  $refProduit,
                'idStockService'    =>  $data['idStockService'], 
                'qteCmd'    =>  $data['qteCmd'],
                'qteTempo'    =>  $data['qteCmd'],
                'montantreduction'    =>  $data['montantreduction'],
                'active'    =>  "OUI",            
                'author'       =>  $request->author,
                'refUser'    =>  $request->refUser,
    
                'compte_achat'    =>  $compte_achat,
                'compte_produit'    =>  $compte_produit,
                'puCmd'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'uniteCmd'    =>  $uniteCmd,
                'puBase'    =>  $puBase,
                'qteBase'    =>  $qteBase,
                'uniteBase'    =>  $uniteBase,
                'montanttva'    =>  $montanttva            
            ]);   


            $data34 = DB::update(
                'update tvente_entete_requisition set montant = montant + (:pu * :qte) where id = :refEnteteCmd',
                ['pu' => $montants,'qte' => $data['qteCmd'],'refEnteteCmd' => $idmax]
            );
            
        }

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }




 




    function insert_dataValidate(Request $request)
    {
        $current = Carbon::now();
        $id_appro = $request->refCcommande;
        $author = $request->author;
        $refUser = $request->refUser;

        $refService = $request->refDestination;
        $id_module = 1;
        $active = "OUI";
        $dateCmd = '';
        $refFournisseur=0;
        

        $data90 = DB::table('tvente_detail_requisition')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_requisition.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
        ->join('tvente_entete_requisition','tvente_entete_requisition.id','=','tvente_detail_requisition.refEnteteCmd')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tvente_entete_requisition.refFournisseur')
        ->select('tvente_detail_requisition.id','refEnteteCmd','refProduit','tvente_detail_requisition.compte_achat',
        'tvente_detail_requisition.compte_produit','puCmd','qteCmd','uniteCmd','tvente_detail_requisition.puBase',
        'tvente_detail_requisition.qteBase','tvente_detail_requisition.uniteBase','tvente_detail_requisition.devise',
        'tvente_detail_requisition.taux','montanttva','montantreduction','tvente_detail_requisition.active',
        'tvente_detail_requisition.author','tvente_detail_requisition.refUser','tvente_detail_requisition.created_at'
        ,"tvente_produit.designation as designation",'refCategorie','pu','qte',
        'cmup','Oldcode','Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie"
        ,'noms','contact','mail','adresse','dateCmd',
        'libelle','refFournisseur','refService','idStockService')
        ->where([
           ['tvente_detail_requisition.refEnteteCmd','=', $id_appro]
       ])      
       ->get();      
      
       foreach ($data90 as $row90) 
       {
        //    $refService = $row90->refService;
           $dateCmd = $row90->dateCmd;
           $refFournisseur = $row90->refFournisseur;
       }        

       $module_id = 2;
        $code = $this->GetCodeData('tvente_param_systeme','module_id', $id_module);
        $data = tvente_entete_entree::create([
            'code'       =>  $code,
            'refRecquisition'       =>  $id_appro,
            'refFournisseur'       =>  $refFournisseur,
            'transporteur'       =>  'Cash',
            'module_id'       =>  $module_id,
            'refService'       =>  $refService,
            'dateEntree'    =>  $dateCmd,
            'libelle'    =>  'Approvisionnement Cash des Produits',
            'niveau1'    =>  0,
            'niveaumax'    =>  3,
            'active'    => $active,            
            'author'       =>  $author,
            'refUser'    =>  $refUser
        ]);

        $idmax=0;
        $maxid = DB::table('tvente_entete_entree')       
        ->selectRaw('MAX(tvente_entete_entree.id) as code_entete')
        ->where([
            ['tvente_entete_entree.refService','=', $refService],
            ['tvente_entete_entree.refUser','<=', $refUser]
        ])
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
           ->first();      
          
           if ($data3) 
           {
               $compte_achat =  $data3->compte_achat;
               $compte_vente = $data3->compte_vente;
               $compte_variationstock= $data3->compte_variationstock;
               $compte_perte= $data3->compte_perte;
               $compte_produit= $data3->compte_produit;
               $compte_destockage= $data3->compte_destockage;
               $compte_stockage= $data3->compte_stockage; 
               $cmupTemp=$data3->cmup;    
               $SI = $data3->qte;     
           }
 
           $puAppro = $row91->puCmd;
           $qteAppro = $row91->qteCmd;
           $uniteAppro = $row91->uniteCmd;
           $puBase = $row91->puBase;
           $qteBase = $row91->qteBase;
           $uniteBase = $row91->uniteBase;

          $taux=$row91->taux;
          $devise=$row91->devise;
          $qteEntree = $qteBase * floatval($qteAppro);
          $id_produit = $row91->refProduit;
          $montanttva = $row91->montanttva;
          $idStockService = $row91->idStockService;
          $montantreduction = $row91->montantreduction;
          $montants = $row91->puCmd;

          $data = tvente_detail_entree::create([
            'refEnteteEntree'       =>  $idmax,
            'refProduit'    =>  $id_produit,
            'idStockService'    =>  $idStockService, 
            'qteEntree'    =>  $qteAppro,
            'montantreduction'    =>  $montantreduction,
            'active'    =>  "OUI",            
            'author'       =>  $author,
            'refUser'    =>  $refUser,

            'compte_achat'    =>  $compte_achat,
            'compte_variationstock'    =>  $compte_variationstock,
            'compte_produit'    =>  $compte_produit,
            'compte_stockage'    =>  $compte_stockage,
            'puEntree'    =>  $montants,
            'devise'    =>  $devise,
            'taux'    =>  $taux,
            'uniteEntree'    =>  $uniteAppro,
            'puBase'    =>  $puBase,
            'qteBase'    =>  $qteBase,
            'uniteBase'    =>  $uniteBase,
            'montanttva'    =>  $montanttva            
        ]);

          $data22 = DB::update(
            'update tvente_stock_service set qte = qte + :qteEntree where id = :id',
            ['qteEntree' => $qteEntree,'id' => $idStockService]
        );

        $data34 = DB::update(
            'update tvente_entete_entree set montant = montant + (:pu * :qte) where id = :refEnteteEntree',
            ['pu' => $montants,'qte' => $qteAppro,'refEnteteEntree' => $idmax]
        );

        $id_detail_max=0;
        $detail_list = DB::table('tvente_detail_entree')       
        ->selectRaw('MAX(id) as code_entete')
        ->where('refUser', $refUser)
        ->get();
        foreach ($detail_list as $list) {
            $id_detail_max= $list->code_entete;
        }
      
        $data99 = tvente_mouvement_stock::create([             
            'idStockService'    =>  $idStockService,             
            'dateMvt'    =>   $dateCmd,   
            'type_mouvement'    =>  'Entree',
            'libelle_mouvement'    =>  'Entrée Stock',
            'nom_table'    =>  'tvente_detail_entree',
            'id_data'    =>  $id_detail_max, 
            'qteMvt'    =>  $qteAppro,
            'puMvt'    =>  $puAppro,                   
            'author'       =>  $author,
            'refUser'       =>  $refUser,
            'type_sortie'    =>  'Entree',

            'active'    =>  $active,
            'uniteMvt'    =>  $uniteAppro,
            'compte_vente'    =>  0,
            'compte_variationstock'    =>  $compte_variationstock,
            'compte_perte'    =>  0,
            'compte_produit'    =>  $compte_produit,
            'compte_destockage'    =>  0,
            'compte_achat'    =>  $compte_achat,
            'compte_stockage'    =>  $compte_stockage,
            'puVente'    =>  $puAppro,
            'devise'    =>  'USD',
            'taux'    =>  $taux,
            'puBase'    =>  $puBase,
            'qteBase'    =>  $qteBase,
            'uniteBase'    =>  $uniteBase,
            'cmupMvt'    =>  $puAppro
        ]);

            $data222 = DB::update(
                'update tvente_detail_requisition set qteTempo = qteTempo - :qteTempo where refEnteteCmd = :refEnteteCmd and idStockService = :idStockService',
                ['qteTempo' => $qteAppro,'refEnteteCmd' => $id_appro,'idStockService' => $idStockService]
            );   


       }

       $data224 = DB::update(
            'update tvente_entete_requisition set active = :active where id = :idAppro',
            ['active' => 'NON','idAppro' => $id_appro]
       );




        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }










}
