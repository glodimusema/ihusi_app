<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_paiement;
use App\Models\Ventes\tvente_entete_paievente;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tvente_paiementController extends Controller
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
 
        $data = DB::table('tvente_paiement')
        ->join('tvente_entete_paievente','tvente_entete_paievente.id','=','tvente_paiement.refEntetepaie')
        ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_paiement.refEnteteVente')
        // ->join('tvente_module','tvente_module.id','=','tvente_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte as compteclient','compteclient.id','=','tvente_categorie_client.compte_client')

        ->join('tconf_banque' , 'tconf_banque.id','=','tvente_paiement.refBanque')
        ->join('tfin_ssouscompte as comptebanque','comptebanque.id','=','tconf_banque.refSscompte')

        ->select('tvente_paiement.id','refEntetepaie','refEnteteVente','refBanque','montant_paie',
        'tvente_paiement.devise','tvente_paiement.taux','date_paie','modepaie','libellepaie','numeroBordereau',
        'tvente_paiement.author','tvente_paiement.refUser','tvente_paiement.active','tvente_paiement.created_at'
        
        ,'date_entete_paie','date_paie_current'

        ,'nom_service','refClient','tvente_entete_vente.refService','tvente_entete_vente.refReservation',
        'tvente_entete_vente.module_id','dateVente','libelle','tvente_entete_vente.montant',
        'tvente_entete_vente.paie'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug', 
        "tvente_categorie_client.designation", "compte_client",
        'compteclient.nom_ssouscompte as nom_ssouscompteClient',
        'compteclient.numero_ssouscompte as numero_ssouscompteClient'

        ,"tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
        "tconf_banque.refSscompte as refSscomptebanque",'comptebanque.nom_ssouscompte as nom_ssouscomptebanque',
        'comptebanque.numero_ssouscompte as numero_ssouscomptebanque')
        ->selectRaw('((montant_paie)/tvente_paiement.taux) as montant_paieFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",tvente_paiement.id) as codeRecu');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_paiement.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_paiement.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tvente_paiement')
        ->join('tvente_entete_paievente','tvente_entete_paievente.id','=','tvente_paiement.refEntetepaie')
        ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_paiement.refEnteteVente')
        // ->join('tvente_module','tvente_module.id','=','tvente_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte as compteclient','compteclient.id','=','tvente_categorie_client.compte_client')

        ->join('tconf_banque' , 'tconf_banque.id','=','tvente_paiement.refBanque')
        ->join('tfin_ssouscompte as comptebanque','comptebanque.id','=','tconf_banque.refSscompte')

        ->select('tvente_paiement.id','refEntetepaie','refEnteteVente','refBanque','montant_paie',
        'tvente_paiement.devise','tvente_paiement.taux','date_paie','modepaie','libellepaie','numeroBordereau',
        'tvente_paiement.author','tvente_paiement.refUser','tvente_paiement.active','tvente_paiement.created_at'
        
        ,'date_entete_paie','date_paie_current'

        ,'nom_service','refClient','tvente_entete_vente.refService','tvente_entete_vente.refReservation',
        'tvente_entete_vente.module_id','dateVente','libelle','tvente_entete_vente.montant',
        'tvente_entete_vente.paie'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug', 
        "tvente_categorie_client.designation", "compte_client",
        'compteclient.nom_ssouscompte as nom_ssouscompteClient',
        'compteclient.numero_ssouscompte as numero_ssouscompteClient'

        ,"tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
        "tconf_banque.refSscompte as refSscomptebanque",'comptebanque.nom_ssouscompte as nom_ssouscomptebanque',
        'comptebanque.numero_ssouscompte as numero_ssouscomptebanque')
        ->selectRaw('((montant_paie)/tvente_paiement.taux) as montant_paieFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",tvente_paiement.id) as codeRecu')
        ->Where('refEnteteVente',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_paiement.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_paiement.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }  
    
    


    public function fetch_data_entete_paie(Request $request,$refEntete)
    { 

        $data = DB::table('tvente_paiement')
        ->join('tvente_entete_paievente','tvente_entete_paievente.id','=','tvente_paiement.refEntetepaie')
        ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_paiement.refEnteteVente')
        // ->join('tvente_module','tvente_module.id','=','tvente_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte as compteclient','compteclient.id','=','tvente_categorie_client.compte_client')

        ->join('tconf_banque' , 'tconf_banque.id','=','tvente_paiement.refBanque')
        ->join('tfin_ssouscompte as comptebanque','comptebanque.id','=','tconf_banque.refSscompte')

        ->select('tvente_paiement.id','refEntetepaie','refEnteteVente','refBanque','montant_paie',
        'tvente_paiement.devise','tvente_paiement.taux','date_paie','modepaie','libellepaie','numeroBordereau',
        'tvente_paiement.author','tvente_paiement.refUser','tvente_paiement.active','tvente_paiement.created_at'
        
        ,'date_entete_paie','date_paie_current'

        ,'nom_service','refClient','tvente_entete_vente.refService','tvente_entete_vente.refReservation',
        'tvente_entete_vente.module_id','dateVente','libelle','tvente_entete_vente.montant',
        'tvente_entete_vente.paie'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug', 
        "tvente_categorie_client.designation", "compte_client",
        'compteclient.nom_ssouscompte as nom_ssouscompteClient',
        'compteclient.numero_ssouscompte as numero_ssouscompteClient'

        ,"tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
        "tconf_banque.refSscompte as refSscomptebanque",'comptebanque.nom_ssouscompte as nom_ssouscomptebanque',
        'comptebanque.numero_ssouscompte as numero_ssouscomptebanque')
        ->selectRaw('((montant_paie)/tvente_paiement.taux) as montant_paieFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",tvente_paiement.id) as codeRecu')
        ->Where('refEntetepaie',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_paiement.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_paiement.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }



    function fetch_single_data($id)
    {
        $data= DB::table('tvente_paiement')
        ->join('tvente_entete_paievente','tvente_entete_paievente.id','=','tvente_paiement.refEntetepaie')
        ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_paiement.refEnteteVente')
        // ->join('tvente_module','tvente_module.id','=','tvente_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte as compteclient','compteclient.id','=','tvente_categorie_client.compte_client')

        ->join('tconf_banque' , 'tconf_banque.id','=','tvente_paiement.refBanque')
        ->join('tfin_ssouscompte as comptebanque','comptebanque.id','=','tconf_banque.refSscompte')

        ->select('tvente_paiement.id','refEntetepaie','refEnteteVente','refBanque','montant_paie',
        'tvente_paiement.devise','tvente_paiement.taux','date_paie','modepaie','libellepaie','numeroBordereau',
        'tvente_paiement.author','tvente_paiement.refUser','tvente_paiement.active','tvente_paiement.created_at'
        
        ,'date_entete_paie','date_paie_current'

        ,'nom_service','refClient','tvente_entete_vente.refService','tvente_entete_vente.refReservation',
        'tvente_entete_vente.module_id','dateVente','libelle','tvente_entete_vente.montant',
        'tvente_entete_vente.paie'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug', 
        "tvente_categorie_client.designation", "compte_client",
        'compteclient.nom_ssouscompte as nom_ssouscompteClient',
        'compteclient.numero_ssouscompte as numero_ssouscompteClient'

        ,"tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
        "tconf_banque.refSscompte as refSscomptebanque",'comptebanque.nom_ssouscompte as nom_ssouscomptebanque',
        'comptebanque.numero_ssouscompte as numero_ssouscomptebanque')
        ->selectRaw('((montant_paie)/tvente_paiement.taux) as montant_paieFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",tvente_paiement.id) as codeRecu')
        ->where('tvente_paiement.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    //'id','code','date_entete_paie','refService','module_id','author','refUser'
    function insert_data(Request $request)
    {
        $current = Carbon::now(); 
        $refEntetepaie=0; 
        $active = "OUI";
        $refService = 0;
        $module_id = 5;      

        $data_vente = DB::table('tvente_entete_vente')       
        ->select('id','code','refClient','refService','refReservation','module_id',
                    'dateVente','libelle','montant','paie','author','refUser')
        ->where('tvente_entete_vente.id', $request->refEnteteVente)
        ->get();
        foreach ($data_vente as $list) {
            $refService= $list->refService;
        }
        $code = $this->GetCodeData('tvente_param_systeme','module_id',$module_id); 

        $data = tvente_entete_paievente::create([
            'code'       =>  $code,
            'date_entete_paie'    =>  $current,
            'refService'    =>  $refService,
            'module_id'    =>  $module_id,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        
        $idmax=0;
        $maxid = DB::table('tvente_entete_paievente')       
        ->selectRaw('MAX(tvente_entete_paievente.id) as code_entete')
        ->where('tvente_entete_paievente.refService', $refService)
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_entete;
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
            $montants = ($request->montant_paie)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->montant_paie;
            $devises = $request->devise;
        }
        $idFacture=$request->refEnteteVente;

        $data = tvente_paiement::create([
            'refEntetepaie'       =>  $idmax,
            'refEnteteVente'       =>  $request->refEnteteVente,
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
            'update tvente_entete_vente set paie = paie + (:paiement), tvente_entete_vente.date_paie_current = :date_paie_current where id = :refEnteteVente',
            ['paiement' => $montants,'refEnteteVente' => $idFacture,'date_paie_current' => $current]
        );

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);

       }



    }


    function insert_data2(Request $request)
    {
        $active = "OUI";
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
            $montants = ($request->montant_paie)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->montant_paie;
            $devises = $request->devise;
        }
        $idFacture=$request->refEnteteVente;

        $data = tvente_paiement::create([
            'refEntetepaie'       =>  $request->refEntetepaie,
            'refEnteteVente'       =>  $request->refEnteteVente,
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
           'update tvente_entete_vente set paie = paie + (:paiement), tvente_entete_vente.date_paie_current = :date_paie_current where id = :refEnteteVente',
            ['paiement' => $montants,'refEnteteVente' => $idFacture,'date_paie_current' => $current]
        );

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);

       }



    }

    function update_data(Request $request, $id)
    {
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
            $montants = ($request->montant_paie)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->montant_paie;
            $devises = $request->devise;
        }


        $data = tvente_paiement::where('id', $id)->update([
            'refEntetepaie'       =>  $request->refEntetepaie,
            'refEnteteVente'       =>  $request->refEnteteVente,
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
            'active'       =>  $request->active
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);

       }
    }

    function delete_data($id)
    {
        $idFacture=0;
        $montants=0;

        $deleteds = DB::table('tvente_paiement')->Where('id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $idFacture = $deleted->refEnteteVente;
            $montants = $deleted->montant_paie;
        }
        $data3 = DB::update(
            'update tvente_entete_vente set paie = paie - (:paiement) where id = :refEnteteVente',
            ['paiement' => $montants,'refEnteteVente' => $idFacture]
        );

        $data = tvente_paiement::where('id',$id)->delete();
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
