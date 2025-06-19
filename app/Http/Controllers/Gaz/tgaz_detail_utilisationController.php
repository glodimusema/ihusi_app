<?php

namespace App\Http\Controllers\Gaz;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gaz\tgaz_detail_utilisation;
use App\Models\Gaz\tgaz_entete_utilisation;
use App\Models\Gaz\tgaz_mouvement_stock_service_lot;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tgaz_detail_utilisationController extends Controller
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

        $data = DB::table('tgaz_detail_utilisation')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_utilisation.idStockService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')

        ->join('tgaz_entete_utilisation','tgaz_entete_utilisation.id','=','tgaz_detail_utilisation.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_utilisation.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_utilisation.refService')
        ->join('tagent','tagent.id','=','tgaz_entete_utilisation.agent_id')

        ->select('tgaz_detail_utilisation.id','refEnteteVente','refProduit','puVente',
        'qteVente','uniteVente','cmupVente','tgaz_detail_utilisation.devise',
        'tgaz_detail_utilisation.taux','montantreduction','tgaz_detail_utilisation.active',
        'tgaz_detail_utilisation.author','tgaz_detail_utilisation.refUser',
        'tgaz_detail_utilisation.created_at','idStockService',

        'tgaz_stock_service_lot.refLot','tgaz_stock_service_lot.pu_lot','qte_lot',
        'cmup_lot','tgaz_stock_service_lot.active','nom_lot','code_lot','unite_lot',
        'stock_alerte',

        'matricule_agent','noms_agent','sexe_agent','datenaissance_agent',
        'lieunaissnce_agent','provinceOrigine_agent','etatcivil_agent','refAvenue_agent','nummaison_agent',
        'contact_agent','mail_agent','grade_agent','fonction_agent','specialite_agent',
        'Categorie_agent','niveauEtude_agent','anneeFinEtude_agent','Ecole_agent','conjoint_agent', 
        'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
        'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent','photo','slug','cartes','envie',

        'nom_service', "tvente_module.nom_module",'tgaz_entete_utilisation.code','refService',
        'module_id','dateUse','libelle',
        'type_sortie')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tgaz_detail_utilisation.taux) as PTVenteFC');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms_agent', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_detail_utilisation.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tgaz_detail_utilisation.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }

    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tgaz_detail_utilisation')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_utilisation.idStockService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')

        ->join('tgaz_entete_utilisation','tgaz_entete_utilisation.id','=','tgaz_detail_utilisation.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_utilisation.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_utilisation.refService')
        ->join('tagent','tagent.id','=','tgaz_entete_utilisation.agent_id')

        ->select('tgaz_detail_utilisation.id','refEnteteVente','refProduit','puVente',
        'qteVente','uniteVente','cmupVente','tgaz_detail_utilisation.devise',
        'tgaz_detail_utilisation.taux','montantreduction','tgaz_detail_utilisation.active',
        'tgaz_detail_utilisation.author','tgaz_detail_utilisation.refUser',
        'tgaz_detail_utilisation.created_at','idStockService',

        'tgaz_stock_service_lot.refLot','tgaz_stock_service_lot.pu_lot','qte_lot',
        'cmup_lot','tgaz_stock_service_lot.active','nom_lot','code_lot','unite_lot',
        'stock_alerte',

        'matricule_agent','noms_agent','sexe_agent','datenaissance_agent',
        'lieunaissnce_agent','provinceOrigine_agent','etatcivil_agent','refAvenue_agent','nummaison_agent',
        'contact_agent','mail_agent','grade_agent','fonction_agent','specialite_agent',
        'Categorie_agent','niveauEtude_agent','anneeFinEtude_agent','Ecole_agent','conjoint_agent', 
        'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
        'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent','photo','slug','cartes','envie',

        'nom_service', "tvente_module.nom_module",'tgaz_entete_utilisation.code','refService',
        'module_id','dateUse','libelle',
        'type_sortie')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tgaz_detail_utilisation.taux) as PTVenteFC')
        ->Where('refEnteteVente',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms_agent', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_detail_utilisation.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tgaz_detail_utilisation.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }  

    function fetch_single_data($id)
    {
        $data = DB::table('tgaz_detail_utilisation')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_utilisation.idStockService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')

        ->join('tgaz_entete_utilisation','tgaz_entete_utilisation.id','=','tgaz_detail_utilisation.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_utilisation.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_utilisation.refService')
        ->join('tagent','tagent.id','=','tgaz_entete_utilisation.agent_id')

        ->select('tgaz_detail_utilisation.id','refEnteteVente','refProduit','puVente',
        'qteVente','uniteVente','cmupVente','tgaz_detail_utilisation.devise',
        'tgaz_detail_utilisation.taux','montantreduction','tgaz_detail_utilisation.active',
        'tgaz_detail_utilisation.author','tgaz_detail_utilisation.refUser',
        'tgaz_detail_utilisation.created_at','idStockService',

        'tgaz_stock_service_lot.refLot','tgaz_stock_service_lot.pu_lot','qte_lot',
        'cmup_lot','tgaz_stock_service_lot.active','nom_lot','code_lot','unite_lot',
        'stock_alerte',

        'matricule_agent','noms_agent','sexe_agent','datenaissance_agent',
        'lieunaissnce_agent','provinceOrigine_agent','etatcivil_agent','refAvenue_agent','nummaison_agent',
        'contact_agent','mail_agent','grade_agent','fonction_agent','specialite_agent',
        'Categorie_agent','niveauEtude_agent','anneeFinEtude_agent','Ecole_agent','conjoint_agent', 
        'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
        'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent','photo','slug','cartes','envie',

        'nom_service', "tvente_module.nom_module",'tgaz_entete_utilisation.code','refService',
        'module_id','dateUse','libelle',
        'type_sortie')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tgaz_detail_utilisation.taux) as PTVenteFC')
        ->where('tgaz_detail_utilisation.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_detail_facture($id)
    {

        $data = DB::table('tgaz_detail_utilisation')
        ->join('tgaz_stock_service_lot','tgaz_stock_service_lot.id','=','tgaz_detail_utilisation.idStockService')
        ->join('tgaz_lot','tgaz_lot.id','=','tgaz_stock_service_lot.refLot')

        ->join('tgaz_entete_utilisation','tgaz_entete_utilisation.id','=','tgaz_detail_utilisation.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_utilisation.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_utilisation.refService')
        ->join('tagent','tagent.id','=','tgaz_entete_utilisation.agent_id')

        ->select('tgaz_detail_utilisation.id','refEnteteVente','refProduit','puVente',
        'qteVente','uniteVente','cmupVente','tgaz_detail_utilisation.devise',
        'tgaz_detail_utilisation.taux','montantreduction','tgaz_detail_utilisation.active',
        'tgaz_detail_utilisation.author','tgaz_detail_utilisation.refUser',
        'tgaz_detail_utilisation.created_at','idStockService',

        'tgaz_stock_service_lot.refLot','tgaz_stock_service_lot.pu_lot','qte_lot',
        'cmup_lot','tgaz_stock_service_lot.active','nom_lot','code_lot','unite_lot',
        'stock_alerte',

        'matricule_agent','noms_agent','sexe_agent','datenaissance_agent',
        'lieunaissnce_agent','provinceOrigine_agent','etatcivil_agent','refAvenue_agent','nummaison_agent',
        'contact_agent','mail_agent','grade_agent','fonction_agent','specialite_agent',
        'Categorie_agent','niveauEtude_agent','anneeFinEtude_agent','Ecole_agent','conjoint_agent', 
        'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
        'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent','photo','slug','cartes','envie',

        'nom_service', "tvente_module.nom_module",'tgaz_entete_utilisation.code','refService',
        'module_id','dateUse','libelle',
        'type_sortie')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tgaz_detail_utilisation.taux) as PTVenteFC')       
       ->Where('tgaz_detail_utilisation.refEnteteVente',$id)               
       ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function insert_data(Request $request)
    {
        $current = Carbon::now();
        $active = "OUI";

        $dateUse=0;
        $data_entete =  DB::table("tgaz_entete_utilisation")
        ->select("tgaz_entete_utilisation.id", "tgaz_entete_utilisation.dateUse")
        ->where([
            ['tgaz_entete_utilisation.id','=', $request->refEnteteVente]
        ])
        ->first(); 
         if ($data_entete) 
         {                                
            $dateUse=$data_entete->dateUse;                           
         }

        $cmup_data = floatval($this->calculerCoutGazMoyen($request->idStockService, $dateUse, $dateUse));

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
        $data_entete =  DB::table("tgaz_entete_utilisation")
        ->select("tgaz_entete_utilisation.id", "tgaz_entete_utilisation.dateUse")
        ->where([
            ['tgaz_entete_utilisation.id','=', $request->refEnteteVente]
        ])
        ->first(); 
         if ($data_entete) 
         {                                
            $dateUse=$data_entete->dateUse;                           
         }


        $montants = $cmup_data;
        $devises='USD';

        $qte=$request->qteVente;
        $idFacture=$request->refEnteteVente;
        $uniteVente = $request->nom_unite;  
        $qteVente = floatval($request->qteVente);
        
        $montanttva=0;
        $pourtageTVA=0;
        $montantreduction = 0;

    
        $montanttva = (((floatval($request->qteVente) * floatval($montants))*floatval($pourtageTVA))/100);

        $data = tgaz_detail_utilisation::create([
            'refEnteteVente'       =>  $request->refEnteteVente,
            'qteVente'    =>  $request->qteVente,
            'idStockService'    =>  $request->idStockService,                     
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser,
            
            'montantreduction'    =>  $montantreduction,  
            'active'    =>  $active,
            'uniteVente'    =>  $uniteVente,
            'puVente'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'cmupVente'    =>  $cmup_data,
            'montanttva'    =>  $montanttva,
        ]);


        $id_detail_max=0;
        $detail_list = DB::table('tgaz_detail_utilisation')       
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
            'libelle_mouvement'    =>  'Consommation des Kits',
            'nom_table'    =>  'tgaz_detail_utilisation',
            'id_data'    =>  $id_detail_max, 
            'qteMvt'    =>  $request->qteVente,
            'puMvt'    =>  $montants,                   
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser,
            'type_sortie'    =>  'Sortie',

            'active'    =>  $active,
            'uniteMvt'    =>  $uniteVente,
            'puVente'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'cmupMvt'    =>  $cmup_data
        ]); 


        $data2 = DB::update(
            'update tgaz_stock_service_lot set qte_lot = qte_lot - :qteVente where id = :idStockService',
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
        $montanttvaDeleted = 0;
        $montantreductionDeleted = 0;

        $dateUse=0;
        $data_entete =  DB::table("tgaz_entete_utilisation")
        ->select("tgaz_entete_utilisation.id", "tgaz_entete_utilisation.dateUse")
        ->where([
            ['tgaz_entete_utilisation.id','=', $request->refEnteteVente]
        ])
        ->first(); 
         if ($data_entete) 
         {                                
            $dateUse=$data_entete->dateUse;                           
         }
        $cmup_data = floatval($this->calculerCoutGazMoyen($request->idStockService, $dateUse, $dateUse));

        $deleted =  DB::table("tgaz_detail_utilisation")
        ->select('id','refEnteteVente','puVente','qteVente','uniteVente','cmupVente',
        'devise','taux','montanttva','montantreduction','active','type_sortie',
        'idStockService','author','refUser')
        ->where([
            ['tgaz_detail_utilisation.id','=', $id]
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

        $montants = $cmup_data;
        $devises='USD';

        $qte=$request->qteVente;
        $idFacture=$request->refEnteteVente;

        $uniteVente = '';
        $cmupVente = $cmup_data;

        $uniteVente = $request->nom_unite;
        $cmupVente = $cmup_data; 

        $qteVente = floatval($request->qteVente);

        
        $montanttva=0;
        $pourtageTVA=0;
        $montantreduction = 0;

    
        $montanttva = (((floatval($request->qteVente) * floatval($montants))*floatval($pourtageTVA))/100);

        $data = tgaz_detail_utilisation::where('id', $id)->update([
            'refEnteteVente'       =>  $request->refEnteteVente,
            'refProduit'    =>  $refProduit,
            'qteVente'    =>  $request->qteVente,
            'idStockService'    =>  $request->idStockService,                     
            'author'       =>  $request->author,
            'refUser'    =>  $request->refUser,
            
            'montantreduction'    =>  $montantreduction,  
            'active'    =>  $active,
            'uniteVente'    =>  $uniteVente,
            'puVente'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'cmupVente'    =>  $cmupVente,
            'montanttva'    =>  $montanttva,
        ]);
      
        $data99 = tgaz_mouvement_stock_service_lot::where([['id_data','=', $id],['nom_table','=','tgaz_detail_utilisation']])->update([             
            'idStockService'    =>  $request->idStockService,             
            'dateMvt'    =>   $current,   
            'type_mouvement'    =>  'Sortie',
            'libelle_mouvement'    =>  'Consommation des Kits',
            'qteMvt'    =>  $request->qteVente,
            'puMvt'    =>  $montants,                   
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser,
            'type_sortie'    =>  'Sortie',

            'active'    =>  $active,
            'uniteMvt'    =>  $uniteVente,
            'puVente'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'cmupMvt'    =>  $cmupVente
        ]); 

        $data2 = DB::update(
            'update tgaz_stock_service_lot set qte_lot = qte_lot + :qteDeleted - :qteVente where id = :idStockService',
            ['qteDeleted' => $qteDeleted,'qteVente' => $qteVente,'idStockService' => $request->idStockService]
        );
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $qte=0;
        $idStockService=0;
        $idFacture=0;
        $pu=0;
        $montantreduction=0;
        $montanttva=0;

        $deleteds = DB::table('tgaz_detail_utilisation')->Where('id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $qte = $deleted->qteVente;            
            $pu = $deleted->puVente;
            $idStockService = $deleted->idStockService;
            $idFacture = $deleted->refEnteteVente;
            $montantreduction = $deleted->montantreduction;
            $montanttva = $deleted->montanttva;
        }


        $data2 = DB::update(
            'update tgaz_stock_service_lot set qte_lot = qte_lot + :qteVente where id = :id',
            ['qteVente' => $qte,'id' => $idStockService]
        );

        $nom_table = 'tgaz_detail_utilisation';

        $data4 = DB::update(
            'delete from tgaz_mouvement_stock_service_lot where tgaz_mouvement_stock_service_lot.id_data = :id and nom_table=:nom_table',
            ['id' => $id, 'nom_table' => $nom_table]
        );

        $data = tgaz_detail_utilisation::where('id',$id)->delete();
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }

    function insert_dataGlobal(Request $request)
    {
        $id_module = 7;
        $active = "OUI";

        $code = $this->GetCodeData('tvente_param_systeme','module_id',$id_module);
        $data111 = tgaz_entete_utilisation::create([
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
        $maxid = DB::table('tgaz_entete_utilisation')       
        ->selectRaw('MAX(tgaz_entete_utilisation.id) as code_entete')
        ->where([
            ['tgaz_entete_utilisation.refUser','=', $request->refUser],
            ['tgaz_entete_utilisation.agent_id','=', $request->agent_id]
         ])
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_entete;
        }

        $detailData = $request->detailData;

        foreach ($detailData as $data) {

            $cmup_data = floatval($this->calculerCoutGazMoyen($data['idStockService'], $request->dateUse, $request->dateUse));

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

            $qte=$data['qteVente'];
            $idFacture=$idmax;
    
   
            $uniteVente = '';
            $cmupVente = $cmup_data;
    
            $uniteVente = $data['nom_unite'];
            $cmupVente = $montants;  
            $qteVente = floatval($data['qteVente']);
            
            $montanttva=0;
            $pourtageTVA=0;
            $montantreduction = 0; 
        
            $montanttva = (((floatval($data['qteVente']) * floatval($montants))*floatval($pourtageTVA))/100);
    
            $data222 = tgaz_detail_utilisation::create([
                'refEnteteVente'       =>  $idmax,
                'qteVente'    =>  $data['qteVente'],
                'idStockService'    =>  $data['idStockService'],                     
                'author'       =>  $request->author,
                'refUser'    =>  $request->refUser,
                
                'montantreduction'    =>  $montantreduction,  
                'active'    =>  $active,
                'uniteVente'    =>  $uniteVente,
                'puVente'    =>  $cmup_data,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'cmupVente'    =>  $cmup_data,
                'montanttva'    =>  $montanttva,
            ]);


            $id_detail_max=0;
            $detail_list = DB::table('tgaz_detail_utilisation')       
            ->selectRaw('MAX(id) as code_entete')
            ->where([
                ['refUser','=', $request->refUser],
                ['idStockService','=', $data['idStockService']]
             ])
            ->get();
            foreach ($detail_list as $list) {
                $id_detail_max= $list->code_entete;
            }
          
            $data99 = tgaz_mouvement_stock_service_lot::create([             
                'idStockService'    =>  $data['idStockService'],             
                'dateMvt'    =>   $request->dateUse,   
                'type_mouvement'    =>  'Sortie',
                'libelle_mouvement'    =>  'Consommation des Kits',
                'nom_table'    =>  'tgaz_detail_utilisation',
                'id_data'    =>  $id_detail_max, 
                'qteMvt'    =>  $data['qteVente'],
                'puMvt'    =>  $cmup_data,                   
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'type_sortie'    =>  'Sortie',
    
                'active'    =>  $active,
                'uniteMvt'    =>  $uniteVente,
                'puVente'    =>  $cmup_data,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'cmupMvt'    =>  $cmup_data
            ]); 

    
            $data2 = DB::update(
                'update tgaz_stock_service_lot set qte_lot = qte_lot - :qteVente where id = :idStockService',
                ['qteVente' => $qteVente,'idStockService' => $data['idStockService']]
            );
    
        }

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }




}
