<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_entete_paiecommande;
use App\Models\Ventes\tvente_paiement_commande;
use App\Traits\{GlobalMethod,Slug};
use DB;
class tvente_entete_paiecommandeController extends Controller
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

        $data = DB::table('tvente_entete_paiecommande')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_paiecommande.refService')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_paiecommande.module_id')
        ->select('tvente_entete_paiecommande.id','tvente_entete_paiecommande.code as codePaie',
        'date_entete_paie','refService','module_id','nom_module','nom_service',
        'tvente_entete_paiecommande.author','tvente_entete_paiecommande.created_at','tvente_entete_paiecommande.refUser')
        ->selectRaw('CONCAT("R",YEAR(tvente_entete_paiecommande.created_at),"",MONTH(tvente_entete_paiecommande.created_at),"00",tvente_entete_paiecommande.id) as codePaieCmd');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('author', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_paiecommande.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_entete_paiecommande.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tvente_entete_paiecommande')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_paiecommande.refService')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_paiecommande.module_id')
        ->select('tvente_entete_paiecommande.id','tvente_entete_paiecommande.code as codePaie',
        'date_entete_paie','refService','module_id','nom_module','nom_service',
        'tvente_entete_paiecommande.author','tvente_entete_paiecommande.created_at','tvente_entete_paiecommande.refUser')
        ->selectRaw('CONCAT("R",YEAR(tvente_entete_paiecommande.created_at),"",MONTH(tvente_entete_paiecommande.created_at),"00",tvente_entete_paiecommande.id) as codePaieCmd')
        ->Where('refEnteteVente',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('author', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_paiecommande.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_entete_paiecommande.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    



    function fetch_single_data($id)
    {
        $data= DB::table('tvente_entete_paiecommande')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_paiecommande.refService')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_paiecommande.module_id')
        ->select('tvente_entete_paiecommande.id','tvente_entete_paiecommande.code as codePaie',
        'date_entete_paie','refService','module_id','nom_module','nom_service',
        'tvente_entete_paiecommande.author','tvente_entete_paiecommande.created_at','tvente_entete_paiecommande.refUser')
        ->selectRaw('CONCAT("R",YEAR(tvente_entete_paiecommande.created_at),"",MONTH(tvente_entete_paiecommande.created_at),"00",tvente_entete_paiecommande.id) as codePaieCmd')
        ->where('tvente_entete_paiecommande.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    ////'id','code','date_entete_paie','author','refUser'
    function insert_data(Request $request)
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
            //,'refService','module_id'
            
            $code = $this->GetCodeData('tvente_param_systeme','module_id',$request->module_id);
           $data = tvente_entete_paiecommande::create([
                'code'       =>  $code,
                'date_entete_paie'    =>  $request->date_entete_paie,
                'refService'    =>  $request->refService,
                'module_id'    =>  $request->module_id,
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
        $data = tvente_entete_paiecommande::where('id', $id)->update([            
                'date_entete_paie'    =>  $request->date_entete_paie,
                'refService'    =>  $request->refService,
                'module_id'    =>  $request->module_id,
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
        $idFacture=0;
        $montants=0;

        $deleteds = DB::table('tvente_paiement_commande')->Where('refEntetepaie',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $idFacture = $deleted->refCommande;
            $montants = $deleted->montant_paie;

            $data3 = DB::update(
                'update tvente_entete_requisition set paie = paie - (:paiement) where id = :refCommande',
                ['paiement' => $montants,'refCommande' => $idFacture]
            );
        }        

        $data = tvente_paiement_commande::where('refEntetepaie',$id)->delete();
        $data = tvente_entete_paiecommande::where('id',$id)->delete();
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
