<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_detail_utilisation;
use App\Models\Ventes\tvente_entete_utilisation;
use App\Models\Ventes\tvente_mouvement_stock;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tvente_detail_utilisationController extends Controller
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

        $data = DB::table('tvente_detail_utilisation')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_utilisation.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')        

        ->join('tvente_entete_utilisation','tvente_entete_utilisation.id','=','tvente_detail_utilisation.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tvente_entete_utilisation.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_utilisation.refService')
        ->join('tagent','tagent.id','=','tvente_entete_utilisation.agent_id')

        ->select('tvente_detail_utilisation.id','refEnteteVente','refProduit','tvente_detail_utilisation.compte_vente',
        'tvente_detail_utilisation.compte_variationstock','tvente_detail_utilisation.compte_perte',
        'tvente_detail_utilisation.compte_produit','tvente_detail_utilisation.compte_destockage','puVente',
        'qteVente','uniteVente','puBase','qteBase','tvente_detail_utilisation.uniteBase','cmupVente',
        'tvente_detail_utilisation.devise','tvente_detail_utilisation.taux','montantreduction',
        'tvente_detail_utilisation.active','tvente_detail_utilisation.author','tvente_detail_utilisation.refUser',
        'tvente_detail_utilisation.created_at','idStockService',

        'tvente_produit.designation','tvente_produit.refCategorie','tvente_produit.refUniteBase',
        'tvente_produit.pu','tvente_produit.qte','tvente_produit.cmup','tvente_produit.taux',
        'tvente_produit.Oldcode','tvente_produit.Newcode','tvente_produit.tvaapplique',
        'tvente_produit.estvendable',        
        'matricule_agent','noms_agent','sexe_agent','datenaissance_agent',
        'lieunaissnce_agent','provinceOrigine_agent','etatcivil_agent','refAvenue_agent','nummaison_agent',
        'contact_agent','mail_agent','grade_agent','fonction_agent','specialite_agent',
        'Categorie_agent','niveauEtude_agent','anneeFinEtude_agent','Ecole_agent','conjoint_agent', 
        'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
        'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent','photo','slug','cartes','envie',

        'nom_service', "tvente_module.nom_module",'tvente_entete_utilisation.code','refService',
        'module_id','dateUse','libelle',
        'type_sortie')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tvente_detail_utilisation.taux) as PTVenteFC')
       ->selectRaw('(qteBase*puBase) as PTBase');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms_agent', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_utilisation.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_detail_utilisation.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }

    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tvente_detail_utilisation')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_utilisation.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')        

        ->join('tvente_entete_utilisation','tvente_entete_utilisation.id','=','tvente_detail_utilisation.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tvente_entete_utilisation.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_utilisation.refService')
        ->join('tagent','tagent.id','=','tvente_entete_utilisation.agent_id')

        ->select('tvente_detail_utilisation.id','refEnteteVente','refProduit','tvente_detail_utilisation.compte_vente',
        'tvente_detail_utilisation.compte_variationstock','tvente_detail_utilisation.compte_perte',
        'tvente_detail_utilisation.compte_produit','tvente_detail_utilisation.compte_destockage','puVente',
        'qteVente','uniteVente','puBase','qteBase','tvente_detail_utilisation.uniteBase','cmupVente',
        'tvente_detail_utilisation.devise','tvente_detail_utilisation.taux','montantreduction',
        'tvente_detail_utilisation.active','tvente_detail_utilisation.author','tvente_detail_utilisation.refUser',
        'tvente_detail_utilisation.created_at','idStockService',

        'tvente_produit.designation','tvente_produit.refCategorie','tvente_produit.refUniteBase',
        'tvente_produit.pu','tvente_produit.qte','tvente_produit.cmup','tvente_produit.taux',
        'tvente_produit.Oldcode','tvente_produit.Newcode','tvente_produit.tvaapplique',
        'tvente_produit.estvendable',        
        'matricule_agent','noms_agent','sexe_agent','datenaissance_agent',
        'lieunaissnce_agent','provinceOrigine_agent','etatcivil_agent','refAvenue_agent','nummaison_agent',
        'contact_agent','mail_agent','grade_agent','fonction_agent','specialite_agent',
        'Categorie_agent','niveauEtude_agent','anneeFinEtude_agent','Ecole_agent','conjoint_agent', 
        'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
        'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent','photo','slug','cartes','envie',

        'nom_service', "tvente_module.nom_module",'tvente_entete_utilisation.code','refService',
        'module_id','dateUse','libelle',
        'type_sortie')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tvente_detail_utilisation.taux) as PTVenteFC')
       ->selectRaw('(qteBase*puBase) as PTBase')
        ->Where('refEnteteVente',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms_agent', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_utilisation.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_detail_utilisation.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }  

    function fetch_single_data($id)
    {
        $data = DB::table('tvente_detail_utilisation')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_utilisation.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')        

        ->join('tvente_entete_utilisation','tvente_entete_utilisation.id','=','tvente_detail_utilisation.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tvente_entete_utilisation.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_utilisation.refService')
        ->join('tagent','tagent.id','=','tvente_entete_utilisation.agent_id')

        ->select('tvente_detail_utilisation.id','refEnteteVente','refProduit','tvente_detail_utilisation.compte_vente',
        'tvente_detail_utilisation.compte_variationstock','tvente_detail_utilisation.compte_perte',
        'tvente_detail_utilisation.compte_produit','tvente_detail_utilisation.compte_destockage','puVente',
        'qteVente','uniteVente','puBase','qteBase','tvente_detail_utilisation.uniteBase','cmupVente',
        'tvente_detail_utilisation.devise','tvente_detail_utilisation.taux','montantreduction',
        'tvente_detail_utilisation.active','tvente_detail_utilisation.author','tvente_detail_utilisation.refUser',
        'tvente_detail_utilisation.created_at','idStockService',

        'tvente_produit.designation','tvente_produit.refCategorie','tvente_produit.refUniteBase',
        'tvente_produit.pu','tvente_produit.qte','tvente_produit.cmup','tvente_produit.taux',
        'tvente_produit.Oldcode','tvente_produit.Newcode','tvente_produit.tvaapplique',
        'tvente_produit.estvendable',        
        'matricule_agent','noms_agent','sexe_agent','datenaissance_agent',
        'lieunaissnce_agent','provinceOrigine_agent','etatcivil_agent','refAvenue_agent','nummaison_agent',
        'contact_agent','mail_agent','grade_agent','fonction_agent','specialite_agent',
        'Categorie_agent','niveauEtude_agent','anneeFinEtude_agent','Ecole_agent','conjoint_agent', 
        'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
        'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent','photo','slug','cartes','envie',

        'nom_service', "tvente_module.nom_module",'tvente_entete_utilisation.code','refService',
        'module_id','dateUse','libelle',
        'type_sortie')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tvente_detail_utilisation.taux) as PTVenteFC')
       ->selectRaw('(qteBase*puBase) as PTBase')
        ->where('tvente_detail_utilisation.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_detail_facture($id)
    {

        $data = DB::table('tvente_detail_utilisation')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_utilisation.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')        

        ->join('tvente_entete_utilisation','tvente_entete_utilisation.id','=','tvente_detail_utilisation.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tvente_entete_utilisation.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_utilisation.refService')
        ->join('tagent','tagent.id','=','tvente_entete_utilisation.agent_id')

        ->select('tvente_detail_utilisation.id','refEnteteVente','refProduit','tvente_detail_utilisation.compte_vente',
        'tvente_detail_utilisation.compte_variationstock','tvente_detail_utilisation.compte_perte',
        'tvente_detail_utilisation.compte_produit','tvente_detail_utilisation.compte_destockage','puVente',
        'qteVente','uniteVente','puBase','qteBase','tvente_detail_utilisation.uniteBase','cmupVente',
        'tvente_detail_utilisation.devise','tvente_detail_utilisation.taux','montantreduction',
        'tvente_detail_utilisation.active','tvente_detail_utilisation.author','tvente_detail_utilisation.refUser',
        'tvente_detail_utilisation.created_at','idStockService',

        'tvente_produit.designation','tvente_produit.refCategorie','tvente_produit.refUniteBase',
        'tvente_produit.pu','tvente_produit.qte','tvente_produit.cmup','tvente_produit.taux',
        'tvente_produit.Oldcode','tvente_produit.Newcode','tvente_produit.tvaapplique',
        'tvente_produit.estvendable',        
        'matricule_agent','noms_agent','sexe_agent','datenaissance_agent',
        'lieunaissnce_agent','provinceOrigine_agent','etatcivil_agent','refAvenue_agent','nummaison_agent',
        'contact_agent','mail_agent','grade_agent','fonction_agent','specialite_agent',
        'Categorie_agent','niveauEtude_agent','anneeFinEtude_agent','Ecole_agent','conjoint_agent', 
        'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
        'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent','photo','slug','cartes','envie',

        'nom_service', "tvente_module.nom_module",'tvente_entete_utilisation.code','refService',
        'module_id','dateUse','libelle',
        'type_sortie')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tvente_detail_utilisation.taux) as PTVenteFC')
       ->selectRaw('(qteBase*puBase) as PTBase')       
       ->Where('tvente_detail_utilisation.refEnteteVente',$id)               
       ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function insert_data(Request $request)
    {
        $current = Carbon::now();
        $active = "OUI";

        $taux=0;
        $data5 =  DB::table("tvente_taux")
        ->select("tvente_taux.id", "tvente_taux.taux", 
        "tvente_taux.created_at", "tvente_taux.author")
         ->first(); 
         if ($data5) 
         {                                
            $taux=$data5->taux;                           
         }

        $dateUse=0;
        $data_entete =  DB::table("tvente_entete_utilisation")
        ->select("tvente_entete_utilisation.id", "tvente_entete_utilisation.dateUse")
        ->where([
            ['tvente_entete_utilisation.id','=', $request->refEnteteVente]
        ])
        ->first(); 
         if ($data_entete) 
         {                                
            $dateUse=$data_entete->dateUse;                           
         }


         $cmup_data = floatval($this->calculerCoutMoyen($request->idStockService, $dateUse, $dateUse));

        $montants=0;
        $devises='USD';
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

        $uniteVente = $request->nom_unite;
        $uniteBase = $request->nom_unite;           
        $qteBase =  1;
        $puBase = $montants;      
        $estunite = 'OUI';
        $cmupVente = $cmup_data; 

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
        $montantreduction = 0;

    
        $montanttva = (((floatval($request->qteVente) * floatval($montants))*floatval($pourtageTVA))/100);

        $data = tvente_detail_utilisation::create([
            'refEnteteVente'       =>  $request->refEnteteVente,
            'refProduit'    =>  $refProduit,
            'qteVente'    =>  $request->qteVente,
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
            'cmupVente'    =>  $cmup_data,
            'montanttva'    =>  $montanttva,
        ]);


        $id_detail_max=0;
        $detail_list = DB::table('tvente_detail_utilisation')       
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
            'type_mouvement'    =>  'Sortie',
            'libelle_mouvement'    =>  'Consommation des Produits',
            'nom_table'    =>  'tvente_detail_utilisation',
            'id_data'    =>  $id_detail_max, 
            'qteMvt'    =>  $request->qteVente,
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
            ['qteVente' => $qteVente,'idStockService' => $request->idStockService]
        );
    
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {
        $current = Carbon::now();
        $puVente=0;
        $qteVente=0;
        $qteBase=0;
        $montanttvaDeleted = 0;
        $montantreductionDeleted = 0;

        $deleted =  DB::table("tvente_detail_utilisation")
        ->select('id','refEnteteVente','refProduit','compte_vente','compte_variationstock',
        'compte_perte','compte_produit','compte_destockage','puVente','qteVente','uniteVente','puBase','qteBase',
        'uniteBase','cmupVente','devise','taux','montanttva','montantreduction','active','type_sortie',
        'idStockService','author','refUser')
        ->where([
            ['tvente_detail_utilisation.id','=', $id]
         ])
         ->first();
         if ($deleted) 
         {
            $puVente = $deleted->puVente;
            $qteVente = $deleted->qteVente;
            $qteBase = $deleted->qteBase; 
            $montanttvaDeleted = $deleted->montanttva;
            $montantreductionDeleted = $deleted->montantreduction;                     
         }
         $qteDeleted = floatval($qteVente) * floatval($qteBase);
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
        $devises='USD';
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
        $montantreduction = 0;

    
        $montanttva = (((floatval($request->qteVente) * floatval($montants))*floatval($pourtageTVA))/100);

        $data = tvente_detail_utilisation::where('id', $id)->update([
            'refEnteteVente'       =>  $request->refEnteteVente,
            'refProduit'    =>  $refProduit,
            'qteVente'    =>  $request->qteVente,
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
      
        $data99 = tvente_mouvement_stock::where([['id_data','=', $id],['nom_table','=','tvente_detail_utilisation']])->update([             
            'idStockService'    =>  $request->idStockService,             
            'dateMvt'    =>   $current,   
            'type_mouvement'    =>  'Sortie',
            'libelle_mouvement'    =>  'Consommation des Produits',
            'qteMvt'    =>  $request->qteVente,
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

        // $qteDeleted
        // $montantDeleted


        $data2 = DB::update(
            'update tvente_stock_service set qte = qte + :qteDeleted - :qteVente where id = :idStockService',
            ['qteDeleted' => $qteDeleted,'qteVente' => $qteVente,'idStockService' => $request->idStockService]
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

        $deleteds = DB::table('tvente_detail_utilisation')->Where('id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $qte = $deleted->qteVente;            
            $pu = $deleted->puVente;
            $idProduit = $deleted->refProduit;
            $idFacture = $deleted->refEnteteVente;
            $montantreduction = $deleted->montantreduction;
            $montanttva = $deleted->montanttva;
        }

        $refService=0;
        

        $data33=DB::table('tvente_entete_utilisation') 
         ->select('id','code','refService','module_id','dateUse','libelle','author','refUser')
         ->where([
            ['tvente_entete_utilisation.id','=', $idFacture]
        ])      
        ->get();      
        $output='';
        foreach ($data33 as $row) 
        {
            $refService =  $row->refService;           
        }


        $data2 = DB::update(
            'update tvente_stock_service set qte = qte + :qteVente where refProduit = :refProduit and refService = :refService',
            ['qteVente' => $qte,'refProduit' => $idProduit,'refService' => $refService]
        );

        $nom_table = 'tvente_detail_utilisation';

        $data4 = DB::update(
            'delete from tvente_mouvement_stock where tvente_mouvement_stock.id_data = :id and nom_table=:nom_table',
            ['id' => $id, 'nom_table' => $nom_table]
        );

        $data = tvente_detail_utilisation::where('id',$id)->delete();
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }

    function insert_dataGlobal(Request $request)
    {
        $id_module = 7;
        $active = "OUI";

        $code = $this->GetCodeData('tvente_param_systeme','module_id',$id_module);
        $data111 = tvente_entete_utilisation::create([
            'code'       =>  $code,
            'refService'       =>  $request->refService,     
            'module_id'       =>  $id_module,
            'agent_id'    =>  $request->agent_id,
            'dateUse'    =>  $request->dateUse,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);

        $idmax=0;
        $maxid = DB::table('tvente_entete_utilisation')       
        ->selectRaw('MAX(tvente_entete_utilisation.id) as code_entete')
        ->where([
            ['tvente_entete_utilisation.refUser','=', $request->refUser],
            ['tvente_entete_utilisation.agent_id','=', $request->agent_id]
         ])
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_entete;
        }

        $detailData = $request->detailData;

        foreach ($detailData as $data) {

            $cmup_data = floatval($this->calculerCoutMoyen($data['idStockService'], $request->dateUse, $request->dateUse));

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
    
            $montants= $cmup_data;
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
                // $montants =  $row->cmup;           
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
            $cmupVente=$cmup_data;
    
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
                // $cmupVente=$row->cmup;         
            } 
            $uniteVente = '';
            $uniteBase = '';
            $puBase=0;
            $qteBase=0;
            $estunite='';
            $cmupVente=$cmup_data;
    
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
            $montantreduction = 0;
 
        
            $montanttva = (((floatval($data['qteVente']) * floatval($montants))*floatval($pourtageTVA))/100);
    
            $data222 = tvente_detail_utilisation::create([
                'refEnteteVente'       =>  $idmax,
                'refProduit'    =>  $refProduit,
                'qteVente'    =>  $data['qteVente'],
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
                'puVente'    =>  $cmup_data,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'puBase'    =>  $puBase,
                'qteBase'    =>  $qteBase,
                'uniteBase'    =>  $uniteBase,
                'cmupVente'    =>  $cmup_data,
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
                'dateMvt'    =>   $request->dateUse,   
                'type_mouvement'    =>  'Sortie',
                'libelle_mouvement'    =>  'Consommation des Produits',
                'nom_table'    =>  'tvente_detail_utilisation',
                'id_data'    =>  $id_detail_max, 
                'qteMvt'    =>  $data['qteVente'],
                'puMvt'    =>  $cmup_data,                   
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
                'puVente'    =>  $cmup_data,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'puBase'    =>  $puBase,
                'qteBase'    =>  $qteBase,
                'uniteBase'    =>  $uniteBase,
                'cmupMvt'    =>  $cmup_data
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
