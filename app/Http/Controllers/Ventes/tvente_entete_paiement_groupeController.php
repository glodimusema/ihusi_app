<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_entete_paiement_groupe;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tvente_entete_paiement_groupeController extends Controller
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

    //'id','code','date_entete_paie','author','refUser'


    public function all(Request $request)
    { 
        $data = DB::table('tvente_entete_paiement_groupe')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_paiement_groupe.module_id')
        ->join('tvente_entete_facture_groupe','tvente_entete_facture_groupe.id','=','tvente_entete_paiement_groupe.refFactureGroup') 
        ->join('tvente_client','tvente_client.id','=','tvente_entete_facture_groupe.refOrganisation')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_client.compte_client')
        
        ->select('tvente_entete_paiement_groupe.id','tvente_entete_paiement_groupe.code','refFactureGroup',
        'tvente_entete_paiement_groupe.module_id','datePaieGroup','libelle_paie_group',
        'tvente_entete_paiement_groupe.author','nom_module','tvente_entete_paiement_groupe.created_at',
        'tvente_entete_paiement_groupe.refUser'
        ,'tvente_entete_facture_groupe.code as codeEnteteFacture','refOrganisation',
        'etat_facture_group','dateGroup','libelle_group','montant_group','reduction_group','totaltva_group',
        'paie_group','date_paie_current_group','nombre_print_group'
        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tvente_client.created_at','tvente_client.updated_at', "tvente_categorie_client.designation",
        "compte_client",'refSousCompte','nom_ssouscompte','numero_ssouscompte')
        ->selectRaw('CONCAT("R",YEAR(tvente_entete_paiement_groupe.created_at),"",MONTH(tvente_entete_paiement_groupe.created_at),"00",tvente_entete_paiement_groupe.id) as codePaieGroup')
        ->selectRaw('CONCAT("F",YEAR(dateGroup),"",MONTH(dateGroup),"00",tvente_entete_facture_groupe.id) as codeFacture')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0),2) as totalFacture')
        ->selectRaw('IFNULL(paie_group,0) as totalPaie')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0) - IFNULL(paie_group,0)),2) as RestePaie');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_paiement_groupe.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_entete_paiement_groupe.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }

    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tvente_entete_paiement_groupe')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_paiement_groupe.module_id')
        ->join('tvente_entete_facture_groupe','tvente_entete_facture_groupe.id','=','tvente_entete_paiement_groupe.refFactureGroup') 
        ->join('tvente_client','tvente_client.id','=','tvente_entete_facture_groupe.refOrganisation')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_client.compte_client')
        
        ->select('tvente_entete_paiement_groupe.id','tvente_entete_paiement_groupe.code','refFactureGroup',
        'tvente_entete_paiement_groupe.module_id','datePaieGroup','libelle_paie_group',
        'tvente_entete_paiement_groupe.author','nom_module','tvente_entete_paiement_groupe.created_at',
        'tvente_entete_paiement_groupe.refUser'
        ,'tvente_entete_facture_groupe.code as codeEnteteFacture','refOrganisation',
        'etat_facture_group','dateGroup','libelle_group','montant_group','reduction_group','totaltva_group',
        'paie_group','date_paie_current_group','nombre_print_group'
        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tvente_client.created_at','tvente_client.updated_at', "tvente_categorie_client.designation",
        "compte_client",'refSousCompte','nom_ssouscompte','numero_ssouscompte')
        ->selectRaw('CONCAT("R",YEAR(tvente_entete_paiement_groupe.created_at),"",MONTH(tvente_entete_paiement_groupe.created_at),"00",tvente_entete_paiement_groupe.id) as codePaieGroup')
        ->selectRaw('CONCAT("F",YEAR(dateGroup),"",MONTH(dateGroup),"00",tvente_entete_facture_groupe.id) as codeFacture')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0),2) as totalFacture')
        ->selectRaw('IFNULL(paie_group,0) as totalPaie')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0) - IFNULL(paie_group,0)),2) as RestePaie')
        ->Where('refFactureGroup',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_paiement_groupe.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_entete_paiement_groupe.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    

    function fetch_single_data($id)
    {
        $data= DB::table('tvente_entete_paiement_groupe')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_paiement_groupe.module_id')
        ->join('tvente_entete_facture_groupe','tvente_entete_facture_groupe.id','=','tvente_entete_paiement_groupe.refFactureGroup') 
        ->join('tvente_client','tvente_client.id','=','tvente_entete_facture_groupe.refOrganisation')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_client.compte_client')
        
        ->select('tvente_entete_paiement_groupe.id','tvente_entete_paiement_groupe.code','refFactureGroup',
        'tvente_entete_paiement_groupe.module_id','datePaieGroup','libelle_paie_group',
        'tvente_entete_paiement_groupe.author','nom_module','tvente_entete_paiement_groupe.created_at',
        'tvente_entete_paiement_groupe.refUser'
        ,'tvente_entete_facture_groupe.code as codeEnteteFacture','refOrganisation',
        'etat_facture_group','dateGroup','libelle_group','montant_group','reduction_group','totaltva_group',
        'paie_group','date_paie_current_group','nombre_print_group'
        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tvente_client.created_at','tvente_client.updated_at', "tvente_categorie_client.designation",
        "compte_client",'refSousCompte','nom_ssouscompte','numero_ssouscompte')
        ->selectRaw('CONCAT("R",YEAR(tvente_entete_paiement_groupe.created_at),"",MONTH(tvente_entete_paiement_groupe.created_at),"00",tvente_entete_paiement_groupe.id) as codePaieGroup')
        ->selectRaw('CONCAT("F",YEAR(dateGroup),"",MONTH(dateGroup),"00",tvente_entete_facture_groupe.id) as codeFacture')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0),2) as totalFacture')
        ->selectRaw('IFNULL(paie_group,0) as totalPaie')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0) - IFNULL(paie_group,0)),2) as RestePaie')
        ->where('tvente_entete_paiement_groupe.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function insert_data(Request $request)
    {
        $module_id = 11;
        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', $request->date_entete_paie)
       ->take(1)
       ->orderBy('id', 'desc')         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == $request->date_entete_paie)
       {
            return response()->json([
                'data'  =>  "La Caisse est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
            ]);            
       }
       else
       {
        $code = $this->GetCodeData('tvente_param_systeme','module_id',$request->module_id);
           $data = tvente_entete_paiement_groupe::create([
                'code'       =>  $code,
                'refFactureGroup'    =>  $request->refFactureGroup,
                'module_id'    =>  $module_id,
                'datePaieGroup'    =>  $request->datePaieGroup,
                'libelle_paie_group'    =>  $request->libelle_paie_group,                
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser
            ]);

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
       ->where('date_cloture','=', $request->date_entete_paie)
       ->take(1)
       ->orderBy('id', 'desc')         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == $request->date_entete_paie)
       {
            return response()->json([
                'data'  =>  "La Caisse est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
            ]);            
       }
       else
       {
        $data = tvente_entete_paiement_groupe::where('id', $id)->update([  
            'refFactureGroup'    =>  $request->refFactureGroup,
            'module_id'    =>  $module_id,
            'datePaieGroup'    =>  $request->datePaieGroup,
            'libelle_paie_group'    =>  $request->libelle_paie_group,                
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);

       }
    }

    function delete_data($id)
    {
        $data = tvente_entete_paiement_groupe::where('id',$id)->delete();              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
