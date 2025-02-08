<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_detail_facture_groupe;
use App\Models\Ventes\tvente_detail_paiement_groupe;
use App\Models\Ventes\tvente_entete_facture_groupe;
use App\Models\Facture;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tvente_entete_facture_groupeController extends Controller
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

        $data = DB::table('tvente_entete_facture_groupe')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_facture_groupe.module_id')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_facture_groupe.refOrganisation')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_client.compte_client')

        ->select('tvente_entete_facture_groupe.id','tvente_entete_facture_groupe.code','refOrganisation',
        'tvente_entete_facture_groupe.module_id','etat_facture_group','dateGroup',
        'libelle_group','montant_group','reduction_group','totaltva_group','paie_group','date_paie_current_group',
       'nombre_print_group','tvente_entete_facture_groupe.author','tvente_entete_facture_groupe.refUser'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tvente_client.created_at','tvente_client.updated_at', "tvente_categorie_client.designation",
        "compte_client",'refSousCompte','nom_ssouscompte','numero_ssouscompte')

        ->selectRaw('CONCAT("F",YEAR(dateGroup),"",MONTH(dateGroup),"00",tvente_entete_facture_groupe.id) as codeFacture')
        ->selectRaw('ROUND(IFNULL(reduction_group,0),2) as totalReduction')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0)),0),2) as totalMontant')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0),2) as totalFacture')
        ->selectRaw('IFNULL(paie_group,0) as totalPaie')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0) - IFNULL(paie_group,0)),2) as RestePaie');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_facture_groupe.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_entete_facture_groupe.created_at", "desc");
        return $this->apiData($data->paginate(10));

        // $facture = Facture::query()
        // ->with('detail_factures')
        // ->get();

       // $facture->orderBy("created_at", "desc");

        // return $this->apiData($facture);
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    {
        $data = DB::table('tvente_entete_facture_groupe')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_facture_groupe.module_id')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_facture_groupe.refOrganisation')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_client.compte_client')

        ->select('tvente_entete_facture_groupe.id','tvente_entete_facture_groupe.code','refOrganisation',
        'tvente_entete_facture_groupe.module_id','etat_facture_group','dateGroup',
        'libelle_group','montant_group','reduction_group','totaltva_group','paie_group','date_paie_current_group',
       'nombre_print_group','tvente_entete_facture_groupe.author','tvente_entete_facture_groupe.refUser'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tvente_client.created_at','tvente_client.updated_at', "tvente_categorie_client.designation",
        "compte_client",'refSousCompte','nom_ssouscompte','numero_ssouscompte')

        ->selectRaw('CONCAT("F",YEAR(dateGroup),"",MONTH(dateGroup),"00",tvente_entete_facture_groupe.id) as codeFacture')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0),2) as totalFacture')
        ->selectRaw('IFNULL(paie_group,0) as totalPaie')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0) - IFNULL(paie_group,0)),2) as RestePaie')
        ->Where('refOrganisation',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_facture_groupe.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_entete_facture_groupe.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }     
    

    public function fetch_data_encours(Request $request)
    {
        $current = Carbon::now(); 
        $formattedDate = $current->format('Y-m-d');

        $data = DB::table('tvente_entete_facture_groupe')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_facture_groupe.module_id')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_facture_groupe.refOrganisation')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_client.compte_client')

        ->select('tvente_entete_facture_groupe.id','tvente_entete_facture_groupe.code','refOrganisation',
        'tvente_entete_facture_groupe.module_id','etat_facture_group','dateGroup',
        'libelle_group','montant_group','reduction_group','totaltva_group','paie_group','date_paie_current_group',
       'nombre_print_group','tvente_entete_facture_groupe.author','tvente_entete_facture_groupe.refUser'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tvente_client.created_at','tvente_client.updated_at', "tvente_categorie_client.designation",
        "compte_client",'refSousCompte','nom_ssouscompte','numero_ssouscompte')

        ->selectRaw('CONCAT("F",YEAR(dateGroup),"",MONTH(dateGroup),"00",tvente_entete_facture_groupe.id) as codeFacture')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0),2) as totalFacture')
        ->selectRaw('IFNULL(paie_group,0) as totalPaie')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0) - IFNULL(paie_group,0)),2) as RestePaie')
        ->where([
            ['tvente_entete_facture_groupe.nombre_print_group','<',1],
            ['tvente_entete_facture_groupe.created_at','>=', $formattedDate]
        ]) 
        
        ->Where('tvente_entete_facture_groupe.nombre_print_group','< 1',0);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_facture_groupe.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_entete_facture_groupe.created_at", "desc");
        return $this->apiData($data->paginate(10));
    } 


    function fetch_single_data($id)
    {

        $data = DB::table('tvente_entete_facture_groupe')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_facture_groupe.module_id')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_facture_groupe.refOrganisation')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_client.compte_client')

        ->select('tvente_entete_facture_groupe.id','tvente_entete_facture_groupe.code','refOrganisation',
        'tvente_entete_facture_groupe.module_id','etat_facture_group','dateGroup',
        'libelle_group','montant_group','reduction_group','totaltva_group','paie_group','date_paie_current_group',
       'nombre_print_group','tvente_entete_facture_groupe.author','tvente_entete_facture_groupe.refUser'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tvente_client.created_at','tvente_client.updated_at', "tvente_categorie_client.designation",
        "compte_client",'refSousCompte','nom_ssouscompte','numero_ssouscompte')

        ->selectRaw('CONCAT("F",YEAR(dateGroup),"",MONTH(dateGroup),"00",tvente_entete_facture_groupe.id) as codeFacture')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0),2) as totalFacture')
        ->selectRaw('IFNULL(paie_group,0) as totalPaie')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0) - IFNULL(paie_group,0)),2) as RestePaie')
        ->where('tvente_entete_facture_groupe.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }


    function fetch_data_entete_vente_search()
    {

        $data = DB::table('tvente_entete_facture_groupe')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_facture_groupe.module_id')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_facture_groupe.refOrganisation')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tvente_categorie_client.compte_client')

        ->select('tvente_entete_facture_groupe.id','tvente_entete_facture_groupe.code','refOrganisation',
        'tvente_entete_facture_groupe.module_id','etat_facture_group','dateGroup',
        'libelle_group','montant_group','reduction_group','totaltva_group','paie_group','date_paie_current_group',
       'nombre_print_group','tvente_entete_facture_groupe.author','tvente_entete_facture_groupe.refUser'

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tvente_client.created_at','tvente_client.updated_at', "tvente_categorie_client.designation",
        "compte_client",'refSousCompte','nom_ssouscompte','numero_ssouscompte')

        ->selectRaw('CONCAT("F",YEAR(dateGroup),"",MONTH(dateGroup),"00",tvente_entete_facture_groupe.id) as codeFacture')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0),2) as totalFacture')
        ->selectRaw('IFNULL(paie_group,0) as totalPaie')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0) - IFNULL(paie_group,0)),2) as RestePaie')
        ->where('tvente_entete_facture_groupe.paie_group','<=', 0)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function insert_data(Request $request)
    {        
        $module_id = 10;
        $current = Carbon::now(); 
        $formattedDate = $current->format('Y-m-d');
        $code = $this->GetCodeData('tvente_param_systeme','module_id',$module_id);
        $data = tvente_entete_facture_groupe::create([
            'code'       =>  $code,
            'refOrganisation'       =>  $request->refOrganisation,
            'module_id'       =>  $module_id,  
            'etat_facture_group'       =>  $request->etat_facture_group,            
            'dateGroup'    =>  $request->dateGroup,
            'libelle_group'    =>  $request->libelle_group,
            'montant_group'    =>  0,
            'reduction_group'    =>  0,
            'totaltva_group'    =>  0,
            'paie_group'    =>  0,
            'date_paie_current_group'    =>  $current,
            'nombre_print_group'    =>  0,
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
        $data = tvente_entete_facture_groupe::where('id', $id)->update([
            'code'       =>  $code,
            'refOrganisation'       =>  $request->refOrganisation,
            'etat_facture_group'       =>  $request->etat_facture_group,            
            'dateGroup'    =>  $request->dateGroup,
            'libelle_group'    =>  $request->libelle_group,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function update_nombre_print(Request $request, $id)
    {
        
        $code = $this->GetMaxId('tvente_entete_facture_groupe','id',$id);
        $data = tvente_entete_facture_groupe::where('id', $id)->update([
            'nombre_print'       =>  $code
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }
 
    function delete_data($id)
    { 
        $data111 = tvente_detail_facture_groupe::where('refEnteteGroup',$id)->delete();
        $data222 = tvente_detail_paiement_groupe::where('refEnteteVenteGroup',$id)->delete();
        $data = tvente_entete_facture_groupe::where('id',$id)->delete();

        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
