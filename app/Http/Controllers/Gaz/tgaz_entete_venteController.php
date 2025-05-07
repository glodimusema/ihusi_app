<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tgaz_entete_vente;
use App\Models\Ventes\tgaz_detail_vente;
use App\Models\Ventes\tgaz_detail_paiement_vente;
use App\Models\Facture;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tgaz_entete_venteController extends Controller
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
        $data = DB::table('tgaz_entete_vente')
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tgaz_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_client.compte_client')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tgaz_entete_vente.id','tgaz_entete_vente.code','refClient','refService',
        'module_id','serveur_id','etat_facture','dateVente','libelle',
        'tgaz_entete_vente.montant','reduction','totaltva','tgaz_entete_vente.paie',
        'tgaz_entete_vente.author','tgaz_entete_vente.refUser','etat_facture',
        'tgaz_entete_vente.created_at'
        
        ,'nom_service', "tvente_module.nom_module",'date_paie_current','nombre_print'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tgaz_entete_vente.updated_at', "tvente_categorie_client.designation",
        "compte_client",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse','refTypecompte','refPosition',
        'nom_classe','numero_classe','nom_typeposition',"nom_typecompte"        
        )
        ->selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tgaz_entete_vente.id) as codeFacture')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0),2) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0) - IFNULL(paie,0)),2) as RestePaie');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_entete_vente.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tgaz_entete_vente.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    {
        $data = DB::table('tgaz_entete_vente')
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tgaz_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_client.compte_client')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tgaz_entete_vente.id','tgaz_entete_vente.code','refClient','refService',
        'module_id','serveur_id','etat_facture','dateVente','libelle',
        'tgaz_entete_vente.montant','reduction','totaltva','tgaz_entete_vente.paie',
        'tgaz_entete_vente.author','tgaz_entete_vente.refUser','etat_facture',
        'tgaz_entete_vente.created_at'
        
        ,'nom_service', "tvente_module.nom_module",'date_paie_current','nombre_print'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tgaz_entete_vente.updated_at', "tvente_categorie_client.designation",
        "compte_client",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse','refTypecompte','refPosition',
        'nom_classe','numero_classe','nom_typeposition',"nom_typecompte"        
        )
        ->selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tgaz_entete_vente.id) as codeFacture')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0),2) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0) - IFNULL(paie,0)),2) as RestePaie')
        ->Where('refClient',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_entete_vente.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tgaz_entete_vente.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }     
    

    public function fetch_data_encours(Request $request)
    {
        $current = Carbon::now(); 
        $formattedDate = $current->format('Y-m-d');

        $data = DB::table('tgaz_entete_vente')
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tgaz_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_client.compte_client')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tgaz_entete_vente.id','tgaz_entete_vente.code','refClient','refService',
        'module_id','serveur_id','etat_facture','dateVente','libelle',
        'tgaz_entete_vente.montant','reduction','totaltva','tgaz_entete_vente.paie',
        'tgaz_entete_vente.author','tgaz_entete_vente.refUser','etat_facture',
        'tgaz_entete_vente.created_at'
        
        ,'nom_service', "tvente_module.nom_module",'date_paie_current','nombre_print'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tgaz_entete_vente.updated_at', "tvente_categorie_client.designation",
        "compte_client",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse','refTypecompte','refPosition',
        'nom_classe','numero_classe','nom_typeposition',"nom_typecompte"        
        )
        ->selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tgaz_entete_vente.id) as codeFacture')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0),2) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0) - IFNULL(paie,0)),2) as RestePaie')
        ->where([
            ['tgaz_entete_vente.nombre_print','<',1],
            ['tgaz_entete_vente.created_at','>=', $formattedDate]
        ]) 
        
        ->Where('tgaz_entete_vente.nombre_print','< 1',0);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_entete_vente.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tgaz_entete_vente.created_at", "desc");
        return $this->apiData($data->paginate(10));
    } 


    function fetch_single_data($id)
    {

        $data = DB::table('tgaz_entete_vente')
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tgaz_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_client.compte_client')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tgaz_entete_vente.id','tgaz_entete_vente.code','refClient','refService',
        'module_id','serveur_id','etat_facture','dateVente','libelle',
        'tgaz_entete_vente.montant','reduction','totaltva','tgaz_entete_vente.paie',
        'tgaz_entete_vente.author','tgaz_entete_vente.refUser','etat_facture',
        'tgaz_entete_vente.created_at'
        
        ,'nom_service', "tvente_module.nom_module",'date_paie_current','nombre_print'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tgaz_entete_vente.updated_at', "tvente_categorie_client.designation",
        "compte_client",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse','refTypecompte','refPosition',
        'nom_classe','numero_classe','nom_typeposition',"nom_typecompte"        
        )
        ->selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tgaz_entete_vente.id) as codeFacture')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0),2) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0) - IFNULL(paie,0)),2) as RestePaie')
        ->where('tgaz_entete_vente.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }


    function fetch_data_entete_vente_search()
    {

        $data = DB::table('tgaz_entete_vente')
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tgaz_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_client.compte_client')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tgaz_entete_vente.id','tgaz_entete_vente.code','refClient','refService',
        'module_id','serveur_id','etat_facture','dateVente','libelle','tgaz_entete_vente.montant',
        'reduction','totaltva','tgaz_entete_vente.paie','tgaz_entete_vente.author',
        'tgaz_entete_vente.refUser','etat_facture','tgaz_entete_vente.created_at'
        
        ,'nom_service', "tvente_module.nom_module",'date_paie_current','nombre_print'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tgaz_entete_vente.updated_at', "tvente_categorie_client.designation",
        "compte_client",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse','refTypecompte','refPosition',
        'nom_classe','numero_classe','nom_typeposition',"nom_typecompte"        
        )
        ->selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tgaz_entete_vente.id) as codeFacture')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0),2) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0) - IFNULL(paie,0)),2) as RestePaie')
        ->selectRaw('(CONCAT(tvente_client.noms," - ",tgaz_entete_vente.dateVente, " - N° : ",tgaz_entete_vente.id )) as designationVente')
        ->where('tgaz_entete_vente.paie','<=', 0)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }


    function insert_data(Request $request)
    {
        //'id','code','refClient','refService','module_id','serveur_id','etat_facture',
        // 'dateVente','libelle','montant','reduction','totaltva','paie','date_paie_current',
        // 'nombre_print','author','refUser'
        $module_id = 13;
        $code = $this->GetCodeData('tvente_param_systeme','module_id',$module_id);
        $data = tgaz_entete_vente::create([
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
        $data = tgaz_entete_vente::where('id', $id)->update([
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
        $code = $this->GetMaxId('tgaz_entete_vente','id',$id);
        $data = tgaz_entete_vente::where('id', $id)->update([
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

        $deleteds = DB::table('tgaz_detail_vente')->Where('refEnteteVente',$id)->get(); 
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
                'update tgaz_entete_vente set montant = montant + (:pu * :qte),reduction = reduction - :reduction, totaltva = totaltva - :totaltva where id = :refEnteteVente',
                ['pu' => $pu,'qte' => $qte,'reduction' => $montantreduction,'totaltva' => $montanttva,'refEnteteVente' => $id]
            );

            $nom_table = 'tgaz_detail_vente';

            $data4 = DB::update(
                'delete from tvente_mouvement_stock where tvente_mouvement_stock.id_data = :id and nom_table=:nom_table',
                ['id' => $idDetail, 'nom_table' => $nom_table]
            );
    
            $data11 = tgaz_detail_vente::where('id',$idDetail)->delete();

        }
        //=================== FIN DETAIL PAIEMENT ===========================================================
        //================= BLOC PAIEMENT ===================================================================
        $montants=0;
        $idPaie = 0;

        $deleteds = DB::table('tgaz_detail_paiement_vente')->Where('refEnteteVente',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $idPaie = $deleted->id;
            $montants = $deleted->montant_paie;

            $data3 = DB::update(
                'update tgaz_entete_vente set paie = paie - (:paiement) where id = :refEnteteVente',
                ['paiement' => $montants,'refEnteteVente' => $id]
            );
            $data22 = tgaz_detail_paiement_vente::where('id',$idPaie)->delete();
        }        
        

        $data111 = tgaz_detail_vente::where('refEnteteVente',$id)->delete();
        $data222 = tgaz_detail_paiement_vente::where('refEnteteVente',$id)->delete();
        $data = tgaz_entete_vente::where('id',$id)->delete();

        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
