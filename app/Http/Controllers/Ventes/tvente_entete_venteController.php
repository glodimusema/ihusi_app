<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_entete_vente;
use App\Models\Ventes\tvente_detail_vente;
use App\Models\Ventes\tvente_paiement;
use App\Models\Facture;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tvente_entete_venteController extends Controller
{
    use GlobalMethod, Slug;
    //vEnteteEntree
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

        $data = DB::table('tvente_entete_vente')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_client.compte_client')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tvente_entete_vente.id','tvente_entete_vente.code','refClient','refService','refReservation','module_id',
        'dateVente','libelle','tvente_entete_vente.montant','tvente_entete_vente.paie','tvente_entete_vente.author',
        'tvente_entete_vente.refUser','serveur_id','table_id','etat_facture',
        'tvente_entete_vente.created_at','reduction','totaltva'
        
        ,'nom_service', "tvente_module.nom_module",'date_paie_current','nombre_print'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tvente_entete_vente.updated_at', "tvente_categorie_client.designation",
        "compte_client",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse','refTypecompte','refPosition',
        'nom_classe','numero_classe','nom_typeposition',"nom_typecompte"        
        )
        ->selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tvente_entete_vente.id) as codeFacture')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0),2) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0) - IFNULL(paie,0)),2) as RestePaie');
        // ->selectRaw('(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0) - IFNULL(paie,0)) as RestePaie');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_vente.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_entete_vente.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }

    public function all_dette(Request $request)
    {      

        $data = DB::table('tvente_entete_vente')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_client.compte_client')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tvente_entete_vente.id','tvente_entete_vente.code','refClient','refService','refReservation','module_id',
        'dateVente','libelle','tvente_entete_vente.montant','tvente_entete_vente.paie','tvente_entete_vente.author',
        'tvente_entete_vente.refUser','serveur_id','table_id','etat_facture',
        'tvente_entete_vente.created_at','reduction','totaltva'
        
        ,'nom_service', "tvente_module.nom_module",'date_paie_current','nombre_print'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tvente_entete_vente.updated_at', "tvente_categorie_client.designation",
        "compte_client",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse','refTypecompte','refPosition',
        'nom_classe','numero_classe','nom_typeposition',"nom_typecompte"        
        )
        ->selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tvente_entete_vente.id) as codeFacture')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0),2) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0) - IFNULL(paie,0)),2) as RestePaie')
        ->selectRaw('TIMESTAMPDIFF(DAY, dateVente, CURDATE()) as jour_paiement')
        ->whereRaw('ROUND((IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0) - IFNULL(paie,0)),2) > 0');
       
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_vente.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_entete_vente.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    {
        $data = DB::table('tvente_entete_vente')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_client.compte_client')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tvente_entete_vente.id','tvente_entete_vente.code','refClient','refService','refReservation','module_id',
        'dateVente','libelle','tvente_entete_vente.montant','tvente_entete_vente.paie','tvente_entete_vente.author',
        'tvente_entete_vente.refUser','serveur_id','table_id','etat_facture',
        'tvente_entete_vente.created_at','reduction','totaltva'
        
        ,'nom_service', "tvente_module.nom_module",'date_paie_current','nombre_print'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tvente_entete_vente.updated_at', "tvente_categorie_client.designation",
        "compte_client",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse','refTypecompte','refPosition',
        'nom_classe','numero_classe','nom_typeposition',"nom_typecompte"        
        )
        ->selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tvente_entete_vente.id) as codeFacture')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0),2) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0) - IFNULL(paie,0)),2) as RestePaie')
        ->Where('refClient',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_vente.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_entete_vente.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }     
    

    public function fetch_data_encours(Request $request)
    {
        $current = Carbon::now(); 
        $formattedDate = $current->format('Y-m-d');

        $data = DB::table('tvente_entete_vente')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_client.compte_client')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tvente_entete_vente.id','tvente_entete_vente.code','refClient','refService','refReservation','module_id',
        'dateVente','libelle','tvente_entete_vente.montant','tvente_entete_vente.paie','tvente_entete_vente.author',
        'tvente_entete_vente.refUser','serveur_id','table_id','etat_facture',
        'tvente_entete_vente.created_at','reduction','totaltva'
        
        ,'nom_service', "tvente_module.nom_module",'date_paie_current','nombre_print'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tvente_entete_vente.updated_at', "tvente_categorie_client.designation",
        "compte_client",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse','refTypecompte','refPosition',
        'nom_classe','numero_classe','nom_typeposition',"nom_typecompte"        
        )
        ->selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tvente_entete_vente.id) as codeFacture')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0),2) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0) - IFNULL(paie,0)),2) as RestePaie')
        ->where([
            ['tvente_entete_vente.nombre_print','<',1],
            ['tvente_entete_vente.created_at','>=', $formattedDate]
        ]) 
        
        ->Where('tvente_entete_vente.nombre_print','< 1',0);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_vente.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_entete_vente.created_at", "desc");
        return $this->apiData($data->paginate(10));
    } 


    function fetch_single_data($id)
    {

        $data = DB::table('tvente_entete_vente')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_client.compte_client')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tvente_entete_vente.id','tvente_entete_vente.code','refClient','refService','refReservation','module_id',
        'dateVente','libelle','tvente_entete_vente.montant','tvente_entete_vente.paie','tvente_entete_vente.author',
        'tvente_entete_vente.refUser','serveur_id','table_id','etat_facture',
        'tvente_entete_vente.created_at','reduction','totaltva'
        
        ,'nom_service', "tvente_module.nom_module",'date_paie_current','nombre_print'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tvente_entete_vente.updated_at', "tvente_categorie_client.designation",
        "compte_client",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse','refTypecompte','refPosition',
        'nom_classe','numero_classe','nom_typeposition',"nom_typecompte"        
        )
        ->selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tvente_entete_vente.id) as codeFacture')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0),2) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0) - IFNULL(paie,0)),2) as RestePaie')
        ->where('tvente_entete_vente.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }


    function fetch_data_entete_vente_search()
    {

        $data = DB::table('tvente_entete_vente')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_client.compte_client')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tvente_entete_vente.id','tvente_entete_vente.code','refClient','refService','refReservation','module_id',
        'dateVente','libelle','tvente_entete_vente.montant','tvente_entete_vente.paie','tvente_entete_vente.author',
        'tvente_entete_vente.refUser','serveur_id','table_id','etat_facture',
        'tvente_entete_vente.created_at','reduction','totaltva'        
        ,'nom_service', "tvente_module.nom_module",'date_paie_current','nombre_print'
        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tvente_entete_vente.updated_at', "tvente_categorie_client.designation",
        "compte_client",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse','refTypecompte','refPosition',
        'nom_classe','numero_classe','nom_typeposition',"nom_typecompte"        
        )
        ->selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tvente_entete_vente.id) as codeFacture')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0),2) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0) - IFNULL(paie,0)),2) as RestePaie')
        ->selectRaw('(CONCAT(tvente_client.noms," - ",tvente_entete_vente.dateVente, " - N° : ",tvente_entete_vente.id )) as designationVente')
        ->where('tvente_entete_vente.paie','<=', 0)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }


    function insert_data(Request $request)
    {
        //'date_paie_current','nombre_print'
        $module_id = 4;
        $code = $this->GetCodeData('tvente_param_systeme','module_id',$module_id);
        $data = tvente_entete_vente::create([
            'code'       =>  $code,
            'refClient'       =>  $request->refClient,
            'refService'       =>  $request->refService,  
            'refReservation'       =>  0,            
            'module_id'       =>  $module_id,
            'dateVente'    =>  $request->dateVente,
            'libelle'    =>  $request->libelle,
            'serveur_id'    =>  $request->serveur_id,
            'table_id'    =>  $request->table_id,
            'etat_facture'    =>  $request->etat_facture,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {
        //'date_paie_current','nombre_print'
        $data = tvente_entete_vente::where('id', $id)->update([
            'refClient'       =>  $request->refClient,
            'refService'       =>  $request->refService,
            'refReservation'       =>  $request->refReservation,
            'module_id'       =>  $request->module_id,
            'dateVente'    =>  $request->dateVente,
            'libelle'    =>  $request->libelle,
            'serveur_id'    =>  $request->serveur_id,
            'table_id'    =>  $request->table_id,
            'etat_facture'    =>  $request->etat_facture,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function update_nombre_print(Request $request, $id)
    {        
        $code = $this->GetMaxId('tvente_entete_vente','id',$id);
        $data = tvente_entete_vente::where('id', $id)->update([
            'nombre_print'       =>  $code
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {

        //========= DETAIL PAIEMENT ============================================================
        $qte=0;
        $idProduit=0;        
        $pu=0;
        $montantreduction=0;
        $montanttva=0;
        $idStockService=0;
        $idDetail=0;

        $deleteds = DB::table('tvente_detail_vente')->Where('refEnteteVente',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $idDetail = $deleted->id;
            $qte = $deleted->qteVente;            
            $pu = $deleted->puVente;
            $idProduit = $deleted->refProduit;
            $montantreduction = $deleted->montantreduction;
            $montanttva = $deleted->montanttva;   
            $idStockService = $deleted->idStockService;

   
            $data2 = DB::update(
                'update tvente_stock_service set qte = qte + :qteVente where refProduit = :id',
                ['qteVente' => $qte,'id' => $idStockService]
            );     
            $data3 = DB::update(
                'update tvente_entete_vente set montant = montant + (:pu * :qte),reduction = reduction - :reduction, totaltva = totaltva - :totaltva where id = :refEnteteVente',
                ['pu' => $pu,'qte' => $qte,'reduction' => $montantreduction,'totaltva' => $montanttva,'refEnteteVente' => $id]
            );

            $nom_table = 'tvente_detail_vente';

            $data4 = DB::update(
                'delete from tvente_mouvement_stock where tvente_mouvement_stock.id_data = :id and nom_table=:nom_table',
                ['id' => $idDetail, 'nom_table' => $nom_table]
            );
    
            $data11 = tvente_detail_vente::where('id',$idDetail)->delete();

        }
        //=================== FIN DETAIL PAIEMENT ===========================================================
        //================= BLOC PAIEMENT ===================================================================
        $montants=0;
        $idPaie = 0;

        $deleteds = DB::table('tvente_paiement')->Where('refEnteteVente',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $idPaie = $deleted->id;
            $montants = $deleted->montant_paie;

            $data3 = DB::update(
                'update tvente_entete_vente set paie = paie - (:paiement) where id = :refEnteteVente',
                ['paiement' => $montants,'refEnteteVente' => $id]
            );
            $data22 = tvente_paiement::where('id',$idPaie)->delete();
        }        
        

        $data111 = tvente_detail_vente::where('refEnteteVente',$id)->delete();
        $data222 = tvente_paiement::where('refEnteteVente',$id)->delete();
        $data = tvente_entete_vente::where('id',$id)->delete();

        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
