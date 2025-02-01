<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_entete_cuisine;
use App\Models\Ventes\tvente_detail_cuisine;
use App\Models\Facture;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tvente_entete_cuisineController extends Controller
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

        $data = DB::table('tvente_entete_cuisine')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_cuisine.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_cuisine.refService')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_cuisine.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->select('tvente_entete_cuisine.id','tvente_entete_cuisine.code','refClient','refService','refReservation',
        'module_id','dateVente','libelle','tvente_entete_cuisine.author','tvente_entete_cuisine.refUser',
        'serveur_id','table_id','estServie','tvente_entete_cuisine.created_at'
        
        ,'nom_service', "tvente_module.nom_module"

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tvente_client.updated_at', "tvente_categorie_client.designation",
        "compte_client",'montant','reduction','totaltva')
        ->selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tvente_entete_cuisine.id) as codeFacture');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_cuisine.created_at", "desc");

            return $this->apiData($data->paginate(10));         

        }
        $data->orderBy("tvente_entete_cuisine.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }

    public function fetch_data_entete(Request $request,$refEntete)
    {
        $data = DB::table('tvente_entete_cuisine')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_cuisine.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_cuisine.refService')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_cuisine.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->select('tvente_entete_cuisine.id','tvente_entete_cuisine.code','refClient','refService','refReservation',
        'module_id','dateVente','libelle','tvente_entete_cuisine.author','tvente_entete_cuisine.refUser',
        'serveur_id','table_id','estServie','tvente_entete_cuisine.created_at'
        
        ,'nom_service', "tvente_module.nom_module"

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tvente_client.updated_at', "tvente_categorie_client.designation",
        "compte_client",'montant','reduction','totaltva')
        ->selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tvente_entete_cuisine.id) as codeFacture')
        ->Where('refClient',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_cuisine.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_entete_cuisine.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }

    public function fetch_data_encours(Request $request)
    {
        $data = DB::table('tvente_entete_cuisine')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_cuisine.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_cuisine.refService')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_cuisine.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->select('tvente_entete_cuisine.id','tvente_entete_cuisine.code','refClient','refService','refReservation',
        'module_id','dateVente','libelle','tvente_entete_cuisine.author','tvente_entete_cuisine.refUser',
        'serveur_id','table_id','estServie','tvente_entete_cuisine.created_at'
        
        ,'nom_service', "tvente_module.nom_module"

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tvente_client.updated_at', "tvente_categorie_client.designation",
        "compte_client",'montant','reduction','totaltva')
        ->selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tvente_entete_cuisine.id) as codeFacture')
        ->Where('tvente_entete_cuisine.estServie','=', 'NON');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_cuisine.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_entete_cuisine.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }

    function fetch_single_data($id)
    {

        $data = DB::table('tvente_entete_cuisine')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_cuisine.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_cuisine.refService')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_cuisine.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->select('tvente_entete_cuisine.id','tvente_entete_cuisine.code','refClient','refService','refReservation',
        'module_id','dateVente','libelle','tvente_entete_cuisine.author','tvente_entete_cuisine.refUser',
        'serveur_id','table_id','estServie','tvente_entete_cuisine.created_at'
        
        ,'nom_service', "tvente_module.nom_module"

        ,'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        'tvente_client.updated_at', "tvente_categorie_client.designation",
        "compte_client",'montant','reduction','totaltva')
        ->selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tvente_entete_cuisine.id) as codeFacture')
        ->where('tvente_entete_cuisine.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function insert_data(Request $request)
    {
        //'id','code','refClient','refService','refReservation','module_id','serveur_id','table_id','estServie','dateVente','libelle','author','refUser'
        //'montant','reduction','totaltva'
        $module_id = 9;
        $code = $this->GetCodeData('tvente_param_systeme','module_id',$module_id);
        $data = tvente_entete_cuisine::create([
            'code'       =>  $code,
            'refClient'       =>  $request->refClient,
            'refService'       =>  $request->refService,  
            'refReservation'       =>  0,            
            'module_id'       =>  $module_id,            
            'serveur_id'    =>  $request->serveur_id,
            'table_id'    =>  $request->table_id,
            'dateVente'    =>  $request->dateVente,
            'libelle'    =>  $request->libelle,
            'estServie'    =>  'NON',
            'montant'    =>  0,
            'reduction'    =>  0,
            'totaltva'    =>  0,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {
        $data = tvente_entete_cuisine::where('id', $id)->update([
            'refClient'       =>  $request->refClient,
            'refService'       =>  $request->refService,        
            'serveur_id'    =>  $request->serveur_id,
            'table_id'    =>  $request->table_id,
            'dateVente'    =>  $request->dateVente,
            'libelle'    =>  $request->libelle,
            'estServie'    =>  $request->estServie,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = tvente_detail_cuisine::where('refEnteteVente',$id)->delete();
        $data = tvente_entete_cuisine::where('id',$id)->delete();

        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
