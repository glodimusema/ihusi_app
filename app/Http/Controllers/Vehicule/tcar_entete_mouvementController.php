<?php

namespace App\Http\Controllers\Vehicule;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vehicule\tcar_entete_mouvement;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tcar_entete_mouvementController extends Controller
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

        $data = DB::table('tcar_entete_mouvement')
        ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
        ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
        ->select('tcar_entete_mouvement.id','refVehicule','refProvenance','dateMvt','numBS',
        'numCD','numSR','nom_vehicule','marque','couleur','numPlaque','nom_producteur',
        'adresse_prod','contact_prod','mail_prod','autres_details',
        'Chauffeur','tcar_entete_mouvement.author','tcar_entete_mouvement.created_at')
        ->selectRaw('CONCAT("F",YEAR(dateMvt),"",MONTH(dateMvt),"00",tcar_entete_mouvement.id) as codeFacture');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('nom_vehicule', 'like', '%'.$query.'%')          
            ->orderBy("tcar_entete_mouvement.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tcar_entete_mouvement.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    {
        $data = DB::table('tcar_entete_mouvement')
        ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
        ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
        ->select('tcar_entete_mouvement.id','refVehicule','refProvenance','dateMvt','numBS',
        'numCD','numSR','nom_vehicule','marque','couleur','numPlaque','nom_producteur',
        'adresse_prod','contact_prod','mail_prod','autres_details',
        'Chauffeur','tcar_entete_mouvement.author','tcar_entete_mouvement.created_at')
        ->selectRaw('CONCAT("F",YEAR(dateMvt),"",MONTH(dateMvt),"00",tcar_entete_mouvement.id) as codeFacture')
        ->Where('refVehicule',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('nom_vehicule', 'like', '%'.$query.'%')          
            ->orderBy("tcar_entete_mouvement.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tcar_entete_mouvement.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }   


    function fetch_single_data($id)
    {

        $data = DB::table('tcar_entete_mouvement')
        ->join('tcar_vehicule','tcar_vehicule.id','=','tcar_entete_mouvement.refVehicule')
        ->join('tcar_producteur','tcar_producteur.id','=','tcar_entete_mouvement.refProvenance')
        ->select('tcar_entete_mouvement.id','refVehicule','refProvenance','dateMvt','numBS',
        'numCD','numSR','nom_vehicule','marque','couleur','numPlaque','nom_producteur',
        'adresse_prod','contact_prod','mail_prod','autres_details',
        'Chauffeur','tcar_entete_mouvement.author','tcar_entete_mouvement.created_at')
        ->selectRaw('CONCAT("F",YEAR(dateMvt),"",MONTH(dateMvt),"00",tcar_entete_mouvement.id) as codeFacture')
        ->where('tcar_entete_mouvement.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   //'id','refVehicule','refProvenance','dateMvt','numBS','numCD','numSR','Chauffeur','author'
    function insert_data(Request $request)
    {
       
        $data = tcar_entete_mouvement::create([
            'refVehicule'       =>  $request->refVehicule,
            'refProvenance'    =>  $request->refProvenance,
            'dateMvt'    =>  $request->dateMvt,
            'numBS'    =>  $request->numBS,
            'numCD'    =>  $request->numCD,
            'numSR'    =>  $request->numSR,
            'Chauffeur'    =>  $request->Chauffeur,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {
        $data = tcar_entete_mouvement::where('id', $id)->update([
            'refVehicule'       =>  $request->refVehicule,
            'refProvenance'    =>  $request->refProvenance,
            'dateMvt'    =>  $request->dateMvt,
            'numBS'    =>  $request->numBS,
            'numCD'    =>  $request->numCD,
            'numSR'    =>  $request->numSR,
            'Chauffeur'    =>  $request->Chauffeur,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = tcar_entete_mouvement::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
