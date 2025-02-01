<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hotel\thotel_incident_reservation_salle;
use App\Traits\{GlobalMethod,Slug};
use DB;
class thotel_incident_reservation_salleController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

     //thotel_incident_reservation_salle

    public function all(Request $request)
    { 

        $data = DB::table('thotel_incident_reservation_salle')
        ->join('thotel_reservation_salle','thotel_reservation_salle.id','=','thotel_incident_reservation_salle.refReservation')
        ->join('thotel_salle','thotel_salle.id','=','thotel_reservation_salle.refClient')
        ->join('tvente_client','tvente_client.id','=','thotel_reservation_salle.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
        ->select('thotel_incident_reservation_salle.id','refReservation','montant_incident','autres_details',
        'refClient','refSalle','date_ceremonie','heure_debut',
        'heure_sortie','date_reservation','thotel_reservation_salle.prix_unitaire','devise',
        'taux','reduction','observation','thotel_incident_reservation_salle.author','thotel_incident_reservation_salle.created_at',
        'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'thotel_incident_reservation_salle.devise','thotel_incident_reservation_salle.taux',
        'tvente_categorie_client.designation as CategorieClient', 
        "thotel_salle.designation as nom_salle","thotel_salle.prix_salle",
        "thotel_incident_reservation_salle.refUser")
        ->selectRaw('((montant_incident)/thotel_incident_reservation_salle.taux) as montant_incidentFC');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("thotel_incident_reservation_salle.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("thotel_incident_reservation_salle.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('thotel_incident_reservation_salle')
        ->join('thotel_reservation_salle','thotel_reservation_salle.id','=','thotel_incident_reservation_salle.refReservation')
        ->join('thotel_salle','thotel_salle.id','=','thotel_reservation_salle.refClient')
        ->join('tvente_client','tvente_client.id','=','thotel_reservation_salle.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
        ->select('thotel_incident_reservation_salle.id','refReservation','montant_incident','autres_details',
        'refClient','refSalle','date_ceremonie','heure_debut',
        'heure_sortie','date_reservation','thotel_reservation_salle.prix_unitaire','devise',
        'taux','reduction','observation','thotel_incident_reservation_salle.author','thotel_incident_reservation_salle.created_at',
        'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'thotel_incident_reservation_salle.devise','thotel_incident_reservation_salle.taux',
        'tvente_categorie_client.designation as CategorieClient', 
        "thotel_salle.designation as nom_salle","thotel_salle.prix_salle",
        "thotel_incident_reservation_salle.refUser")
        ->selectRaw('((montant_incident)/thotel_incident_reservation_salle.taux) as montant_incidentFC')
        ->Where('refReservation',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("thotel_incident_reservation_salle.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("thotel_incident_reservation_salle.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    



    function fetch_single_data($id)
    {
        $data= DB::table('thotel_incident_reservation_salle')
        ->join('thotel_reservation_salle','thotel_reservation_salle.id','=','thotel_incident_reservation_salle.refReservation')
        ->join('thotel_salle','thotel_salle.id','=','thotel_reservation_salle.refClient')
        ->join('tvente_client','tvente_client.id','=','thotel_reservation_salle.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
        ->select('thotel_incident_reservation_salle.id','refReservation','montant_incident','autres_details',
        'refClient','refSalle','date_ceremonie','heure_debut',
        'heure_sortie','date_reservation','thotel_reservation_salle.prix_unitaire','devise',
        'taux','reduction','observation','thotel_incident_reservation_salle.author','thotel_incident_reservation_salle.created_at',
        'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'thotel_incident_reservation_salle.devise','thotel_incident_reservation_salle.taux',
        'tvente_categorie_client.designation as CategorieClient', 
        "thotel_salle.designation as nom_salle","thotel_salle.prix_salle",
        "thotel_incident_reservation_salle.refUser")
        ->selectRaw('((montant_incident)/thotel_incident_reservation_salle.taux) as montant_incidentFC')
        ->where('thotel_incident_reservation_salle.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    //'refEnteteVente','montant_incident','date_paie'
    function insert_data(Request $request)
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
            $montants = ($request->montant_incident)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->montant_incident;
            $devises = $request->devise;
        }

        //id,refReservation,montant_incident,devise,taux,autres_details thotel_incident_reservation_salle

        $data = thotel_incident_reservation_salle::create([
            'refReservation'       =>  $request->refReservation,
            'montant_incident'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'autres_details'    =>  $request->autres_details,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
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
            $montants = ($request->montant_incident)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->montant_incident;
            $devises = $request->devise;
        }


        $data = thotel_incident_reservation_salle::where('id', $id)->update([
            'refReservation'       =>  $request->refReservation,
            'montant_incident'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'autres_details'    =>  $request->autres_details,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = thotel_incident_reservation_salle::where('id',$id)->delete();
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
