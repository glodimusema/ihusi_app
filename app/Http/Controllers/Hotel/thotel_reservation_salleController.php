<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hotel\thotel_reservation_salle;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class thotel_reservation_salleController extends Controller
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

     //id,refClient,montant_paie,devise,taux,date_paie,heure_debut,heure_fin,libelle,author

    public function all(Request $request)
    { 

        $data = DB::table('thotel_reservation_salle')
        ->join('thotel_salle','thotel_salle.id','=','thotel_reservation_salle.refClient')
        ->join('tvente_client','tvente_client.id','=','thotel_reservation_salle.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
        ->select('thotel_reservation_salle.id','refClient','refSalle','date_ceremonie','heure_debut',
        'heure_sortie','date_reservation','thotel_reservation_salle.prix_unitaire','reduction','observation','thotel_reservation_salle.author','thotel_reservation_salle.created_at',
        'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'thotel_reservation_salle.devise','thotel_reservation_salle.taux',
        'tvente_categorie_client.designation as CategorieClient', 
        "thotel_salle.designation as nom_salle","thotel_salle.prix_salle","thotel_reservation_salle.refUser")
        ->selectRaw('((prix_unitaire-reduction)/thotel_reservation_salle.taux) as prix_unitaireFC')
        ->selectRaw('((prix_unitaire-reduction)) as prix_unitaireReduit')
        ->selectRaw('IFNULL((prix_unitaire-reduction),0) as totalFacture')
        ->selectRaw('IFNULL(totalPaie,0) as totalPaie')
        ->selectRaw('(IFNULL((prix_unitaire-reduction),0)-IFNULL(totalPaie,0)) as RestePaie')
        ->selectRaw('((IFNULL((prix_unitaire-reduction),0)-IFNULL(totalPaie,0))/thotel_reservation_salle.taux) as RestePaieFC');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("thotel_reservation_salle.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("thotel_reservation_salle.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('thotel_reservation_salle')
        ->join('thotel_salle','thotel_salle.id','=','thotel_reservation_salle.refClient')
        ->join('tvente_client','tvente_client.id','=','thotel_reservation_salle.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
        ->select('thotel_reservation_salle.id','refClient','refSalle','date_ceremonie','heure_debut',
        'heure_sortie','date_reservation','thotel_reservation_salle.prix_unitaire','reduction','observation','thotel_reservation_salle.author','thotel_reservation_salle.created_at',
        'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'thotel_reservation_salle.devise','thotel_reservation_salle.taux',
        'tvente_categorie_client.designation as CategorieClient', 
        "thotel_salle.designation as nom_salle","thotel_salle.prix_salle","thotel_reservation_salle.refUser")
        ->selectRaw('((prix_unitaire-reduction)/thotel_reservation_salle.taux) as prix_unitaireFC')
        ->selectRaw('((prix_unitaire-reduction)) as prix_unitaireReduit')
        ->selectRaw('IFNULL((prix_unitaire-reduction),0) as totalFacture')
        ->selectRaw('IFNULL(totalPaie,0) as totalPaie')
        ->selectRaw('(IFNULL((prix_unitaire-reduction),0)-IFNULL(totalPaie,0)) as RestePaie')
        ->selectRaw('((IFNULL((prix_unitaire-reduction),0)-IFNULL(totalPaie,0))/thotel_reservation_salle.taux) as RestePaieFC')
        ->Where('refClient',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("thotel_reservation_salle.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("thotel_reservation_salle.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    



    function fetch_single_data($id)
    {
        $data= DB::table('thotel_reservation_salle')
        ->join('thotel_salle','thotel_salle.id','=','thotel_reservation_salle.refClient')
        ->join('tvente_client','tvente_client.id','=','thotel_reservation_salle.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
        ->select('thotel_reservation_salle.id','refClient','refSalle','date_ceremonie','heure_debut',
        'heure_sortie','date_reservation','thotel_reservation_salle.prix_unitaire','reduction','observation','thotel_reservation_salle.author','thotel_reservation_salle.created_at',
        'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'thotel_reservation_salle.devise','thotel_reservation_salle.taux',
        'tvente_categorie_client.designation as CategorieClient', 
        "thotel_salle.designation as nom_salle","thotel_salle.prix_salle","thotel_reservation_salle.refUser")
        ->selectRaw('((prix_unitaire-reduction)/thotel_reservation_salle.taux) as prix_unitaireFC')
        ->selectRaw('((prix_unitaire-reduction)) as prix_unitaireReduit')
        ->selectRaw('IFNULL((prix_unitaire-reduction),0) as totalFacture')
        ->selectRaw('IFNULL(totalPaie,0) as totalPaie')
        ->selectRaw('(IFNULL((prix_unitaire-reduction),0)-IFNULL(totalPaie,0)) as RestePaie')
        ->selectRaw('((IFNULL((prix_unitaire-reduction),0)-IFNULL(totalPaie,0))/thotel_reservation_salle.taux) as RestePaieFC')
        ->where('thotel_reservation_salle.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    //'refReservation','montant_paie','date_paie'
    function insert_data(Request $request)
    {
        $heure1=Carbon::parse(trim($request->heure_debut));
        $heure2=Carbon::parse(trim($request->heure_sortie));

        try {
            $carbon1 = Carbon::createFromFormat('H:i', $heure1);
            $carbon2 = Carbon::createFromFormat('H:i', $heure2);
        
        } catch (InvalidFormatException $e) {
            echo "Erreur de format : " . $e->getMessage();
        }

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
            $montants = ($request->prix_unitaire)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->prix_unitaire;
            $devises = $request->devise;
        }


        // id,refClient,refSalle,date_ceremonie,heure_debut,heure_sortie,
        // date_reservation,prix_unitaire,
        // taux,reduction,observation,author,refUser


        $data = thotel_reservation_salle::create([
            'refClient'       =>  $request->refClient,
            'refSalle'       =>  $request->refSalle,
            'date_ceremonie'       =>  $request->date_ceremonie,
            'date_sortie'       =>  $request->date_sortie,
            'heure_debut'       =>  $heure1,
            'heure_sortie'       =>  $heure2,
            'date_reservation'       =>  $request->date_reservation,
            'prix_unitaire'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'reduction'    =>  $request->reduction,
            'observation'    =>  $request->observation,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {
        $heure1=Carbon::parse(trim($request->heure_debut));
        $heure2=Carbon::parse(trim($request->heure_sortie));

        try {
            $carbon1 = Carbon::createFromFormat('H:i', $heure1);
            $carbon2 = Carbon::createFromFormat('H:i', $heure2);
        
        } catch (InvalidFormatException $e) {
            echo "Erreur de format : " . $e->getMessage();
        }

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
            $montants = ($request->prix_unitaire)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->prix_unitaire;
            $devises = $request->devise;
        }


        $data = thotel_reservation_salle::where('id', $id)->update([
            'refClient'       =>  $request->refClient,
            'refSalle'       =>  $request->refSalle,
            'date_ceremonie'       =>  $request->date_ceremonie,
            'date_sortie'       =>  $request->date_sortie,
            'heure_debut'       =>  $heure1,
            'heure_sortie'       =>  $heure2,
            'date_reservation'       =>  $request->date_reservation,
            'prix_unitaire'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'reduction'    =>  $request->reduction,
            'observation'    =>  $request->observation,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = thotel_paiement_salle::where('refReservation',$id)->delete();
        $data = thotel_reservation_salle::where('id',$id)->delete();
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
