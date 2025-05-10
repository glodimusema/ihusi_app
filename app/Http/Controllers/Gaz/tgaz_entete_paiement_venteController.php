<?php

namespace App\Http\Controllers\Gaz;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gaz\tgaz_entete_paiement_vente;
use App\Models\Gaz\tgaz_detail_paiement_vente;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tgaz_entete_paiement_venteController extends Controller
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

        $data = DB::table('tgaz_entete_paiement_vente')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_paiement_vente.refService')
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_paiement_vente.module_id')        
        ->select('tgaz_entete_paiement_vente.id','code','date_entete_paie','tgaz_entete_paiement_vente.author'
        ,'refService','module_id','nom_module','nom_service',
        'tgaz_entete_paiement_vente.created_at','tgaz_entete_paiement_vente.refUser')
        ->selectRaw('CONCAT("R",YEAR(tgaz_entete_paiement_vente.created_at),"",MONTH(tgaz_entete_paiement_vente.created_at),"00",tgaz_entete_paiement_vente.id) as codePaieCmd');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('author', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_entete_paiement_vente.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tgaz_entete_paiement_vente.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tgaz_entete_paiement_vente')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_paiement_vente.refService')
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_paiement_vente.module_id')
        ->select('tgaz_entete_paiement_vente.id','code','date_entete_paie','tgaz_entete_paiement_vente.author'
        ,'refService','module_id','nom_module','nom_service',
        'tgaz_entete_paiement_vente.created_at','tgaz_entete_paiement_vente.refUser')
        ->selectRaw('CONCAT("R",YEAR(tgaz_entete_paiement_vente.created_at),"",MONTH(tgaz_entete_paiement_vente.created_at),"00",tgaz_entete_paiement_vente.id) as codePaieCmd')
        ->Where('refEnteteVente',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('author', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_entete_paiement_vente.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tgaz_entete_paiement_vente.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    



    function fetch_single_data($id)
    {
        $data= DB::table('tgaz_entete_paiement_vente')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_paiement_vente.refService')
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_paiement_vente.module_id')
        ->select('tgaz_entete_paiement_vente.id','code','date_entete_paie','tgaz_entete_paiement_vente.author'
        ,'refService','module_id','nom_module','nom_service',
        'tgaz_entete_paiement_vente.created_at','tgaz_entete_paiement_vente.refUser')
        ->selectRaw('CONCAT("R",YEAR(tgaz_entete_paiement_vente.created_at),"",MONTH(tgaz_entete_paiement_vente.created_at),"00",tgaz_entete_paiement_vente.id) as codePaieCmd')
        ->where('tgaz_entete_paiement_vente.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    
    function insert_data(Request $request)
    {
        $module_id = 14;
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
        //refService module_id
        $code = $this->GetCodeData('tvente_param_systeme','module_id',$request->module_id);
           $data = tgaz_entete_paiement_vente::create([
                'code'       =>  $code,
                'date_entete_paie'    =>  $request->date_entete_paie,
                'refService'    =>  $request->refService,
                'module_id'    =>  $module_id,
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
        $data = tgaz_entete_paiement_vente::where('id', $id)->update([           
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

        $deleteds = DB::table('tgaz_detail_paiement_vente')->Where('refEntetepaie',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $idFacture = $deleted->refEnteteVente;
            $montants = $deleted->montant_paie;

            $data3 = DB::update(
                'update tvente_entete_vente set paie = paie - (:paiement) where id = :refEnteteVente',
                ['paiement' => $montants,'refEnteteVente' => $idFacture]
            );
        }        

        $data = tgaz_detail_paiement_vente::where('refEntetepaie',$id)->delete();
        $data = tgaz_entete_paiement_vente::where('id',$id)->delete();
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
