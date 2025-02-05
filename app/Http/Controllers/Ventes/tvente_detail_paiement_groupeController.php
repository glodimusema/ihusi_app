<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_detail_paiement_groupe;
use App\Models\Ventes\tvente_entete_paiement_groupe;
use App\Models\Ventes\tvente_entete_paievente;
use App\Models\Ventes\tvente_paiement;
use App\Models\Hotel\thotel_paiement_chambre;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tvente_detail_paiement_groupeController extends Controller
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
        $data = DB::table('tvente_detail_paiement_groupe')
        ->join('tvente_entete_paiement_groupe','tvente_entete_paiement_groupe.id','=','tvente_detail_paiement_groupe.refEntetepaieGroup')
        ->join('tvente_entete_facture_groupe','tvente_entete_facture_groupe.id','=','tvente_entete_paiement_groupe.refFactureGroup') 
        ->join('tvente_client','tvente_client.id','=','tvente_entete_facture_groupe.refOrganisation')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        
        ->join('tconf_banque' , 'tconf_banque.id','=','tvente_detail_paiement_groupe.refBanque')
        ->join('tfin_ssouscompte as comptebanque','comptebanque.id','=','tconf_banque.refSscompte')

        ->select('tvente_detail_paiement_groupe.id','refEntetepaieGroup','refEnteteVenteGroup','refBanque',
        'montant_paie','tvente_detail_paiement_groupe.devise','tvente_detail_paiement_groupe.taux',
        'date_paie','modepaie','libellepaie','numeroBordereau','tvente_detail_paiement_groupe.author',
        'tvente_detail_paiement_groupe.refUser','tvente_detail_paiement_groupe.active',
        'tvente_detail_paiement_groupe.created_at'
        //Entete Paiement groupe
        ,'tvente_entete_paiement_groupe.code','refFactureGroup','tvente_entete_paiement_groupe.module_id',
        'datePaieGroup','libelle_paie_group','tvente_entete_paiement_groupe.author',
        'tvente_entete_paiement_groupe.created_at','tvente_entete_paiement_groupe.refUser'
        ,'tvente_entete_facture_groupe.code as codeEnteteFacture','refOrganisation','etat_facture_group',
        'dateGroup','libelle_group','montant_group','reduction_group','totaltva_group','paie_group',
        'date_paie_current_group','nombre_print_group','noms','sexe','contact','mail','adresse',
        'pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte','nationnalite','datenaissance',
        'lieunaissance','profession','occupation','nombreEnfant','dateArriverGoma','arriverPar',
        'refCategieClient','photo','slug'
        //Banque
        ,"tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
        "tconf_banque.refSscompte as refSscompteBanque",'compteBanque.nom_ssouscompte as nom_ssouscompteBanque',
        'compteBanque.numero_ssouscompte as numero_ssouscompteBanque')
        ->selectRaw('((montant_paie)/tvente_detail_paiement_groupe.taux) as montant_paieFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",tvente_detail_paiement_groupe.id) as codeRecuGroup')
        ->selectRaw('CONCAT("R",YEAR(tvente_entete_paiement_groupe.created_at),"",MONTH(tvente_entete_paiement_groupe.created_at),"00",tvente_entete_paiement_groupe.id) as codePaieGroup')
        ->selectRaw('CONCAT("F",YEAR(dateGroup),"",MONTH(dateGroup),"00",tvente_entete_facture_groupe.id) as codeFactureGroup')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0),2) as totalFactureGroup')
        ->selectRaw('IFNULL(paie_group,0) as totalPaieGroup')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0) - IFNULL(paie_group,0)),2) as RestePaieGroup');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_paiement_groupe.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_detail_paiement_groupe.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }

    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tvente_detail_paiement_groupe')
        ->join('tvente_entete_paiement_groupe','tvente_entete_paiement_groupe.id','=','tvente_detail_paiement_groupe.refEntetepaieGroup')
        ->join('tvente_entete_facture_groupe','tvente_entete_facture_groupe.id','=','tvente_entete_paiement_groupe.refFactureGroup') 
        ->join('tvente_client','tvente_client.id','=','tvente_entete_facture_groupe.refOrganisation')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        
        ->join('tconf_banque' , 'tconf_banque.id','=','tvente_detail_paiement_groupe.refBanque')
        ->join('tfin_ssouscompte as comptebanque','comptebanque.id','=','tconf_banque.refSscompte')

        ->select('tvente_detail_paiement_groupe.id','refEntetepaieGroup','refEnteteVenteGroup','refBanque',
        'montant_paie','tvente_detail_paiement_groupe.devise','tvente_detail_paiement_groupe.taux',
        'date_paie','modepaie','libellepaie','numeroBordereau','tvente_detail_paiement_groupe.author',
        'tvente_detail_paiement_groupe.refUser','tvente_detail_paiement_groupe.active',
        'tvente_detail_paiement_groupe.created_at'
        //Entete Paiement groupe
        ,'tvente_entete_paiement_groupe.code','refFactureGroup','tvente_entete_paiement_groupe.module_id',
        'datePaieGroup','libelle_paie_group','tvente_entete_paiement_groupe.author',
        'tvente_entete_paiement_groupe.created_at','tvente_entete_paiement_groupe.refUser'
        ,'tvente_entete_facture_groupe.code as codeEnteteFacture','refOrganisation','etat_facture_group',
        'dateGroup','libelle_group','montant_group','reduction_group','totaltva_group','paie_group',
        'date_paie_current_group','nombre_print_group','noms','sexe','contact','mail','adresse',
        'pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte','nationnalite','datenaissance',
        'lieunaissance','profession','occupation','nombreEnfant','dateArriverGoma','arriverPar',
        'refCategieClient','photo','slug'
        //Banque
        ,"tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
        "tconf_banque.refSscompte as refSscompteBanque",'compteBanque.nom_ssouscompte as nom_ssouscompteBanque',
        'compteBanque.numero_ssouscompte as numero_ssouscompteBanque')
        ->selectRaw('((montant_paie)/tvente_detail_paiement_groupe.taux) as montant_paieFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",tvente_detail_paiement_groupe.id) as codeRecuGroup')
        ->selectRaw('CONCAT("R",YEAR(tvente_entete_paiement_groupe.created_at),"",MONTH(tvente_entete_paiement_groupe.created_at),"00",tvente_entete_paiement_groupe.id) as codePaieGroup')
        ->selectRaw('CONCAT("F",YEAR(dateGroup),"",MONTH(dateGroup),"00",tvente_entete_facture_groupe.id) as codeFactureGroup')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0),2) as totalFactureGroup')
        ->selectRaw('IFNULL(paie_group,0) as totalPaieGroup')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0) - IFNULL(paie_group,0)),2) as RestePaieGroup')
        ->Where('refEnteteVenteGroup',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_paiement_groupe.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_detail_paiement_groupe.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }  

    public function fetch_data_entete_paie(Request $request,$refEntete)
    { 

        $data = DB::table('tvente_detail_paiement_groupe')
        ->join('tvente_entete_paiement_groupe','tvente_entete_paiement_groupe.id','=','tvente_detail_paiement_groupe.refEntetepaieGroup')
        ->join('tvente_entete_facture_groupe','tvente_entete_facture_groupe.id','=','tvente_entete_paiement_groupe.refFactureGroup') 
        ->join('tvente_client','tvente_client.id','=','tvente_entete_facture_groupe.refOrganisation')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        
        ->join('tconf_banque' , 'tconf_banque.id','=','tvente_detail_paiement_groupe.refBanque')
        ->join('tfin_ssouscompte as comptebanque','comptebanque.id','=','tconf_banque.refSscompte')

        ->select('tvente_detail_paiement_groupe.id','refEntetepaieGroup','refEnteteVenteGroup','refBanque',
        'montant_paie','tvente_detail_paiement_groupe.devise','tvente_detail_paiement_groupe.taux',
        'date_paie','modepaie','libellepaie','numeroBordereau','tvente_detail_paiement_groupe.author',
        'tvente_detail_paiement_groupe.refUser','tvente_detail_paiement_groupe.active',
        'tvente_detail_paiement_groupe.created_at'
        //Entete Paiement groupe
        ,'tvente_entete_paiement_groupe.code','refFactureGroup','tvente_entete_paiement_groupe.module_id',
        'datePaieGroup','libelle_paie_group','tvente_entete_paiement_groupe.author',
        'tvente_entete_paiement_groupe.created_at','tvente_entete_paiement_groupe.refUser'
        ,'tvente_entete_facture_groupe.code as codeEnteteFacture','refOrganisation','etat_facture_group',
        'dateGroup','libelle_group','montant_group','reduction_group','totaltva_group','paie_group',
        'date_paie_current_group','nombre_print_group','noms','sexe','contact','mail','adresse',
        'pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte','nationnalite','datenaissance',
        'lieunaissance','profession','occupation','nombreEnfant','dateArriverGoma','arriverPar',
        'refCategieClient','photo','slug'
        //Banque
        ,"tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
        "tconf_banque.refSscompte as refSscompteBanque",'compteBanque.nom_ssouscompte as nom_ssouscompteBanque',
        'compteBanque.numero_ssouscompte as numero_ssouscompteBanque')
        ->selectRaw('((montant_paie)/tvente_detail_paiement_groupe.taux) as montant_paieFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",tvente_detail_paiement_groupe.id) as codeRecuGroup')
        ->selectRaw('CONCAT("R",YEAR(tvente_entete_paiement_groupe.created_at),"",MONTH(tvente_entete_paiement_groupe.created_at),"00",tvente_entete_paiement_groupe.id) as codePaieGroup')
        ->selectRaw('CONCAT("F",YEAR(dateGroup),"",MONTH(dateGroup),"00",tvente_entete_facture_groupe.id) as codeFactureGroup')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0),2) as totalFactureGroup')
        ->selectRaw('IFNULL(paie_group,0) as totalPaieGroup')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0) - IFNULL(paie_group,0)),2) as RestePaieGroup')
        ->Where('refEntetepaieGroup',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_paiement_groupe.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_detail_paiement_groupe.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }

    function fetch_single_data($id)
    {
        $data= DB::table('tvente_detail_paiement_groupe')
        ->join('tvente_entete_paiement_groupe','tvente_entete_paiement_groupe.id','=','tvente_detail_paiement_groupe.refEntetepaieGroup')
        ->join('tvente_entete_facture_groupe','tvente_entete_facture_groupe.id','=','tvente_entete_paiement_groupe.refFactureGroup') 
        ->join('tvente_client','tvente_client.id','=','tvente_entete_facture_groupe.refOrganisation')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        
        ->join('tconf_banque' , 'tconf_banque.id','=','tvente_detail_paiement_groupe.refBanque')
        ->join('tfin_ssouscompte as comptebanque','comptebanque.id','=','tconf_banque.refSscompte')

        ->select('tvente_detail_paiement_groupe.id','refEntetepaieGroup','refEnteteVenteGroup','refBanque',
        'montant_paie','tvente_detail_paiement_groupe.devise','tvente_detail_paiement_groupe.taux',
        'date_paie','modepaie','libellepaie','numeroBordereau','tvente_detail_paiement_groupe.author',
        'tvente_detail_paiement_groupe.refUser','tvente_detail_paiement_groupe.active',
        'tvente_detail_paiement_groupe.created_at'
        //Entete Paiement groupe
        ,'tvente_entete_paiement_groupe.code','refFactureGroup','tvente_entete_paiement_groupe.module_id',
        'datePaieGroup','libelle_paie_group','tvente_entete_paiement_groupe.author',
        'tvente_entete_paiement_groupe.created_at','tvente_entete_paiement_groupe.refUser'
        ,'tvente_entete_facture_groupe.code as codeEnteteFacture','refOrganisation','etat_facture_group',
        'dateGroup','libelle_group','montant_group','reduction_group','totaltva_group','paie_group',
        'date_paie_current_group','nombre_print_group','noms','sexe','contact','mail','adresse',
        'pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte','nationnalite','datenaissance',
        'lieunaissance','profession','occupation','nombreEnfant','dateArriverGoma','arriverPar',
        'refCategieClient','photo','slug'
        //Banque
        ,"tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
        "tconf_banque.refSscompte as refSscompteBanque",'compteBanque.nom_ssouscompte as nom_ssouscompteBanque',
        'compteBanque.numero_ssouscompte as numero_ssouscompteBanque')
        ->selectRaw('((montant_paie)/tvente_detail_paiement_groupe.taux) as montant_paieFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",tvente_detail_paiement_groupe.id) as codeRecuGroup')
        ->selectRaw('CONCAT("R",YEAR(tvente_entete_paiement_groupe.created_at),"",MONTH(tvente_entete_paiement_groupe.created_at),"00",tvente_entete_paiement_groupe.id) as codePaieGroup')
        ->selectRaw('CONCAT("F",YEAR(dateGroup),"",MONTH(dateGroup),"00",tvente_entete_facture_groupe.id) as codeFactureGroup')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0),2) as totalFactureGroup')
        ->selectRaw('IFNULL(paie_group,0) as totalPaieGroup')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0) - IFNULL(paie_group,0)),2) as RestePaieGroup')
        ->where('tvente_detail_paiement_groupe.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
    
    function insert_data(Request $request)
    {
        $current = Carbon::now(); 
        $refEntetepaieGroup=0; 
        $active = "OUI";
        $module_id = 11;      

        $code = $this->GetCodeData('tvente_param_systeme','module_id',$module_id); 

        $data13 = tvente_entete_paiement_groupe::create([
            'code'       =>  $code,
            'refFactureGroup'    =>  $request->refEnteteVenteGroup,
            'module_id'    =>  $module_id,
            'datePaieGroup'    =>  $request->date_paie,
            'libelle_paie_group'    =>  'Paiement des Factures',                    
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);

       
        $idmax=0;
        $maxid = DB::table('tvente_entete_paiement_groupe')       
        ->selectRaw('MAX(tvente_entete_paiement_groupe.id) as code_entete')
        ->where([
            ['tvente_entete_paiement_groupe.refUser', $request->refUser],
            ['tvente_entete_paiement_groupe.refFactureGroup','=', $request->refEnteteVenteGroup]
         ])
        ->first();
        if ($maxid) {
            $idmax= $maxid->code_entete;
        }

        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', $request->date_paie)
       ->take(1)
       ->orderBy('id', 'desc')         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == $request->date_paie)
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
        ->first();
        if ($data5) 
        {                                
           $taux=$data5->taux;                           
        }

        $montants=0;
        $devises='';
        if($request->devise != 'USD')
        {
            $montants = ($request->montant_paie)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->montant_paie;
            $devises = $request->devise;
        }
        $idFacture = $request->refEnteteVenteGroup;

        $data = tvente_detail_paiement_groupe::create([
            'refEntetepaieGroup'       =>  $idmax,
            'refEnteteVenteGroup'       =>  $idFacture,
            'montant_paie'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'date_paie'    =>  $request->date_paie,
            'modepaie'       =>  $request->modepaie,
            'libellepaie'       =>  $request->libellepaie, 
            'refBanque'       =>  $request->refBanque,
            'numeroBordereau'       =>  $request->numeroBordereau,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser,
            'active'       =>  $active
        ]);

        $data3 = DB::update(
            'update tvente_entete_facture_groupe set paie_group = paie_group + (:paiement) where id = :refEnteteVente',
            ['paiement' => $montants,'refEnteteVente' => $idFacture]
        );




        $data999=DB::table('tvente_detail_facture_groupe')
        ->select('id','refEnteteGroup','id_vente','id_reservation','active','author','refUser')                    
        ->where([
           ['tvente_detail_facture_groupe.refEnteteGroup','=', $idFacture]
        ])      
        ->get();
        foreach ($data999 as $row999) 
        { 
            $refEntetepaie=0; 
            $module_id_paie_data = 5;                
            $codepaie_data = $this->GetCodeData('tvente_param_systeme','module_id',$module_id_paie_data); 
            $refService = 0; 

            $montants=0;
            $ventes_data = DB::table('tvente_entete_vente')
            ->select('id','code','refClient','refService','refReservation','module_id',
            'dateVente','libelle','serveur_id','table_id','etat_facture','montant','paie','reduction',
            'totaltva','author','refUser')
            ->selectRaw('(tvente_entete_vente.montant - tvente_entete_vente.reduction + tvente_entete_vente.totaltva) as montant')
            ->Where('id',$row999->id_vente)
            ->first(); 
            if ($ventes_data) {
                $montants = $ventes_data->montant;
                $refService = $ventes_data->refService;
            } 
    
            $data15 = tvente_entete_paievente::create([
                'code'       =>  $codepaie_data,
                'date_entete_paie'    =>  $current,
                'refService'    =>  $refService,
                'module_id'    =>  $module_id_paie_data,
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser
            ]);
            
            $idmax_paie_data=0;
            $maxid_data = DB::table('tvente_entete_paievente')       
            ->selectRaw('MAX(tvente_entete_paievente.id) as code_entete')
            ->where([
                ['tvente_entete_paievente.refUser','=', $request->refUser],
                ['tvente_entete_paievente.refService','=', $refService] 
             ])
            ->first();
            if ($maxid_data) {
                $idmax_paie_data= $maxid_data->code_entete;
            }
    
            $refEnteteVente = 0;
            if ($row999->id_vente === null) {
                $refEnteteVente = 0;
            } else {
                $refEnteteVente = $row999->id_vente;
            }  
          

            $data16 = tvente_paiement::create([
                'refEntetepaie'       =>  $idmax_paie_data,
                'refEnteteVente'       => $refEnteteVente,
                'montant_paie'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'date_paie'    =>  $request->date_paie,
                'modepaie'       =>  $request->modepaie,
                'libellepaie'       =>  $request->libellepaie, 
                'refBanque'       =>  $request->refBanque,
                'numeroBordereau'       =>  $request->numeroBordereau,
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'active'       =>  'OUI'
            ]);

            $data17 = DB::update(
                'update tvente_entete_vente set paie = paie + (:paiement) where id = :refEnteteVente',
                ['paiement' => $montants,'refEnteteVente' => $refEnteteVente]
            );       


        } 

        foreach ($data999 as $row100) 
        { 
            $montants=0;
            $refReservation = 0;
            if ($row100->id_reservation === null) {
                $refReservation = 0;
            } else {
                $refReservation = $row100->id_reservation;
            }

            $ventes_data = DB::table('thotel_reservation_chambre')
            ->select('thotel_reservation_chambre.id','refClient','refChmabre','id_prise_charge','date_entree','date_sortie',
            'heure_debut','heure_sortie','libelle','prix_unitaire','reduction','observation',
            'type_reservation','nom_accompagner','pays_provenance',
            'thotel_reservation_chambre.author','thotel_reservation_chambre.created_at')
            ->selectRaw('TIMESTAMPDIFF(DAY, date_entree, date_sortie) as NombreJour')
            ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))) as prixTotalChambre')
            ->selectRaw('IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0) as totalFacture')
            ->selectRaw('IFNULL(totalPaie,0) as totalPaie')
            ->selectRaw('(IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0)) as RestePaie')
            ->Where('thotel_reservation_chambre.id','=', $refReservation)
            ->first(); 
            if ($ventes_data) {
                $montants = $ventes_data->RestePaie;
            } 
    
            $data15 = thotel_paiement_chambre::create([
                'refReservation'       =>  $refReservation,            
                'montant_paie'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'modepaie'       =>  $request->modepaie,
                'libellepaie'       =>  $request->libellepaie, 
                'refBanque'       =>  $request->refBanque,
                'numeroBordereau'       =>  $request->numeroBordereau,
                'date_paie'       =>  $request->date_paie,
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser
            ]);
            

            $data17 = DB::update(
                'update thotel_reservation_chambre set totalPaie = totalPaie + (:paiement) where id = :refReservation',
                ['paiement' => $montants,'refReservation' => $refReservation]
            );       


        } 




        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);

       }



    }


    function update_data(Request $request, $id)
    {
        $idFactureDeleted=0;
        $montant_group_deleted=0;

        $deleteds = DB::table('tvente_detail_paiement_groupe')->Where('id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $idFactureDeleted = $deleted->refEnteteVenteGroup;
            $montant_group_deleted = $deleted->montant_paie;
        }

        $data21 = DB::update(
            'update tvente_entete_facture_groupe set paie_group = paie_group - (:paiement) where id = :refEnteteVente',
            ['paiement' => $montant_group_deleted,'refEnteteVente' => $idFactureDeleted]
        );


        $data22=DB::table('tvente_detail_facture_groupe')
        ->select('id','refEnteteGroup','id_vente','id_reservation','active','author','refUser')                    
        ->where([
           ['tvente_detail_facture_groupe.refEnteteGroup','=', $idFactureDeleted]
        ])      
        ->get();
        foreach ($data22 as $row22) 
        { 
            $montant_deleted=0;
            $hotel_data = DB::table('thotel_reservation_chambre')
            ->select('thotel_reservation_chambre.id','refClient','refChmabre','id_prise_charge','date_entree','date_sortie',
            'heure_debut','heure_sortie','libelle','prix_unitaire','reduction','observation',
            'type_reservation','nom_accompagner','pays_provenance',
            'thotel_reservation_chambre.author','thotel_reservation_chambre.created_at')
            ->selectRaw('TIMESTAMPDIFF(DAY, date_entree, date_sortie) as NombreJour')
            ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))) as prixTotalChambre')
            ->selectRaw('IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0) as totalFacture')
            ->selectRaw('IFNULL(totalPaie,0) as totalPaie')
            ->selectRaw('(IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0)) as RestePaie')
            ->Where('thotel_reservation_chambre.id',$row22->id_reservation)
            ->first(); 
            if ($hotel_data) {
                $montant_deleted = $hotel_data->RestePaie;
            }
            else
            {
                $montant_deleted = 0;
            } 

            $data11 = thotel_paiement_chambre::where('refReservation',$row22->id_reservation)->delete();
            $data12 = DB::update(
                'update thotel_reservation_chambre set totalPaie = totalPaie - (:paiement) where id = :refReservation',
                ['paiement' => $montant_deleted,'refReservation' => $row22->id_reservation]
            ); 
            
            
            $ventes_data = DB::table('tvente_entete_vente')
            ->select('id','code','refClient','refService','refReservation','module_id',
            'dateVente','libelle','serveur_id','table_id','etat_facture','montant','paie','reduction',
            'totaltva','author','refUser')
            ->selectRaw('(tvente_entete_vente.montant - tvente_entete_vente.reduction + tvente_entete_vente.totaltva) as montant')
            ->Where('tvente_entete_vente.id',$row22->id_vente)
            ->first(); 
            if ($ventes_data) {
                $montant_deleted = $ventes_data->montant;
            }
            else
            {
                $montant_deleted = 0;
            }
            
            $data13 = tvente_paiement::where('refEnteteVente',$row22->id_vente)->delete();
            $data14 = DB::update(
                'update tvente_entete_vente set paie = paie - (:paiement) where id = :refEnteteVente',
                ['paiement' => $montant_deleted,'refEnteteVente' => $row22->id_vente]
            ); 


        } 




        // ============= Update

        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', $request->date_paie)
       ->take(1)
       ->orderBy('id', 'desc')         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == $request->date_paie)
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
        ->first();
        if ($data5) 
        {                                
           $taux=$data5->taux;                           
        }

        $montants=0;
        $devises='';
        if($request->devise != 'USD')
        {
            $montants = ($request->montant_paie)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->montant_paie;
            $devises = $request->devise;
        }
        $idFacture = $request->refEnteteVenteGroup;

        $data = tvente_detail_paiement_groupe::where('id', $id)->update([
            'refEntetepaieGroup'       =>  $request->refEntetepaieGroup,
            'refEnteteVenteGroup'       =>  $idFacture,
            'montant_paie'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'date_paie'    =>  $request->date_paie,
            'modepaie'       =>  $request->modepaie,
            'libellepaie'       =>  $request->libellepaie, 
            'refBanque'       =>  $request->refBanque,
            'numeroBordereau'       =>  $request->numeroBordereau,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser,
            'active'       =>  $active
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);

       }
    }

    function delete_data($id)
    {
        $idFacture=0;
        $montant_group_deleted=0;

        $deleteds = DB::table('tvente_detail_paiement_groupe')->Where('id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $idFacture = $deleted->refEnteteVenteGroup;
            $montant_group_deleted = $deleted->montant_paie;
        }

        $data3 = DB::update(
            'update tvente_entete_facture_groupe set paie_group = paie_group - (:paiement) where id = :refEnteteVente',
            ['paiement' => $montant_group_deleted,'refEnteteVente' => $idFacture]
        );


        $data999=DB::table('tvente_detail_facture_groupe')
        ->select('id','refEnteteGroup','id_vente','id_reservation','active','author','refUser')                    
        ->where([
           ['tvente_detail_facture_groupe.refEnteteGroup','=', $idFacture]
        ])      
        ->get();
        foreach ($data999 as $row999) 
        { 
            $montants=0;
            $hotel_data = DB::table('thotel_reservation_chambre')
            ->select('thotel_reservation_chambre.id','refClient','refChmabre','id_prise_charge','date_entree','date_sortie',
            'heure_debut','heure_sortie','libelle','prix_unitaire','reduction','observation',
            'type_reservation','nom_accompagner','pays_provenance',
            'thotel_reservation_chambre.author','thotel_reservation_chambre.created_at')
            ->selectRaw('TIMESTAMPDIFF(DAY, date_entree, date_sortie) as NombreJour')
            ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))) as prixTotalChambre')
            ->selectRaw('IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0) as totalFacture')
            ->selectRaw('IFNULL(totalPaie,0) as totalPaie')
            ->selectRaw('(IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0)) as RestePaie')
            ->Where('thotel_reservation_chambre.id',$row999->id_reservation)
            ->first(); 
            if ($hotel_data) {
                $montants = $hotel_data->RestePaie;
            }
            else
            {
                $montants = 0;
            } 

            $data11 = thotel_paiement_chambre::where('refReservation',$row999->id_reservation)->delete();
            $data12 = DB::update(
                'update thotel_reservation_chambre set totalPaie = totalPaie - (:paiement) where id = :refReservation',
                ['paiement' => $montants,'refReservation' => $row999->id_reservation]
            ); 
            
            
            $ventes_data = DB::table('tvente_entete_vente')
            ->select('id','code','refClient','refService','refReservation','module_id',
            'dateVente','libelle','serveur_id','table_id','etat_facture','montant','paie','reduction',
            'totaltva','author','refUser')
            ->selectRaw('(tvente_entete_vente.montant - tvente_entete_vente.reduction + tvente_entete_vente.totaltva) as montant')
            ->Where('tvente_entete_vente.id',$row999->id_vente)
            ->first(); 
            if ($ventes_data) {
                $montants = $ventes_data->montant;
            }
            else
            {
                $montants = 0;
            }
            
            $data13 = tvente_paiement::where('refEnteteVente',$row999->id_vente)->delete();
            $data14 = DB::update(
                'update tvente_entete_vente set paie = paie - (:paiement) where id = :refEnteteVente',
                ['paiement' => $montants,'refEnteteVente' => $row999->id_vente]
            ); 


        } 

        $data = tvente_detail_paiement_groupe::where('id',$id)->delete();
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
