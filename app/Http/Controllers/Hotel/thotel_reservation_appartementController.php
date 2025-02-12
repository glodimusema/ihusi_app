<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hotel\thotel_reservation_chambre;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class thotel_reservation_appartementController extends Controller
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

        $data = DB::table('thotel_reservation_chambre')
        ->join('thotel_chambre','thotel_chambre.id','=','thotel_reservation_chambre.refChmabre')
        ->join('thotel_classe_chambre','thotel_classe_chambre.id','=','thotel_chambre.refClasse') 
        ->join('tvente_client as clientHotel','clientHotel.id','=','thotel_reservation_chambre.refClient')
        ->join('tvente_client as priseCharge','priseCharge.id','=','thotel_reservation_chambre.id_prise_charge')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','clientHotel.refCategieClient')
        ->select('thotel_reservation_chambre.id','refClient','refChmabre','id_prise_charge','date_entree','date_sortie',
        'heure_debut','heure_sortie','libelle','prix_unitaire','reduction','observation',
        'type_reservation','nom_accompagner','pays_provenance',
        'thotel_reservation_chambre.author','thotel_reservation_chambre.created_at','clientHotel.noms',
        'clientHotel.sexe','clientHotel.contact','clientHotel.mail','clientHotel.adresse',
        'clientHotel.pieceidentite','clientHotel.numeroPiece','clientHotel.dateLivrePiece',
        'clientHotel.lieulivraisonCarte','clientHotel.nationnalite','clientHotel.datenaissance',
        'clientHotel.lieunaissance','clientHotel.profession','clientHotel.occupation','clientHotel.nombreEnfant',
        'clientHotel.dateArriverGoma','clientHotel.arriverPar','clientHotel.refCategieClient',
        'clientHotel.photo','clientHotel.slug','thotel_reservation_chambre.devise',
        'thotel_reservation_chambre.taux','tvente_categorie_client.designation as CategorieClient', 
        "thotel_chambre.nom_chambre","numero_chambre","refClasse", "thotel_classe_chambre.designation as ClasseChambre",
        "thotel_classe_chambre.prix_chambre","thotel_reservation_chambre.refUser"
        
        ,'priseCharge.noms as noms_charge','priseCharge.sexe as sexe_charge','priseCharge.contact as contact__charge',
        'priseCharge.mail as mail_charge','priseCharge.adresse as adresse_charge')
        ->selectRaw('((prix_unitaire)/thotel_reservation_chambre.taux) as prix_unitaireFC')
        ->selectRaw('TIMESTAMPDIFF(MONTH, date_entree, date_sortie) as NombreJour')
        ->selectRaw('(((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))) as prixTotalSans')
        ->selectRaw('(((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))-reduction) as prixTotal')
        ->selectRaw('((((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))-reduction)/thotel_reservation_chambre.taux) as prixTotalFC')
        ->selectRaw('IFNULL((((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))-reduction),0) as totalFacture')
        ->selectRaw('IFNULL(totalPaie,0) as totalPaie')
        ->selectRaw('(IFNULL((((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0)) as RestePaie')
        ->selectRaw('((IFNULL((((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0))/thotel_reservation_chambre.taux) as RestePaieFC');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("thotel_reservation_chambre.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("thotel_reservation_chambre.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('thotel_reservation_chambre')
        ->join('thotel_chambre','thotel_chambre.id','=','thotel_reservation_chambre.refChmabre')
        ->join('thotel_classe_chambre','thotel_classe_chambre.id','=','thotel_chambre.refClasse') 
        ->join('tvente_client as clientHotel','clientHotel.id','=','thotel_reservation_chambre.refClient')
        ->join('tvente_client as priseCharge','priseCharge.id','=','thotel_reservation_chambre.id_prise_charge')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','clientHotel.refCategieClient')
        ->select('thotel_reservation_chambre.id','refClient','refChmabre','id_prise_charge','date_entree','date_sortie',
        'heure_debut','heure_sortie','libelle','prix_unitaire','reduction','observation',
        'type_reservation','nom_accompagner','pays_provenance',
        'thotel_reservation_chambre.author','thotel_reservation_chambre.created_at','clientHotel.noms',
        'clientHotel.sexe','clientHotel.contact','clientHotel.mail','clientHotel.adresse',
        'clientHotel.pieceidentite','clientHotel.numeroPiece','clientHotel.dateLivrePiece',
        'clientHotel.lieulivraisonCarte','clientHotel.nationnalite','clientHotel.datenaissance',
        'clientHotel.lieunaissance','clientHotel.profession','clientHotel.occupation','clientHotel.nombreEnfant',
        'clientHotel.dateArriverGoma','clientHotel.arriverPar','clientHotel.refCategieClient',
        'clientHotel.photo','clientHotel.slug','thotel_reservation_chambre.devise',
        'thotel_reservation_chambre.taux','tvente_categorie_client.designation as CategorieClient', 
        "thotel_chambre.nom_chambre","numero_chambre","refClasse", "thotel_classe_chambre.designation as ClasseChambre",
        "thotel_classe_chambre.prix_chambre","thotel_reservation_chambre.refUser"
        
        ,'priseCharge.noms as noms_charge','priseCharge.sexe as sexe_charge','priseCharge.contact as contact__charge',
        'priseCharge.mail as mail_charge','priseCharge.adresse as adresse_charge')
        ->selectRaw('((prix_unitaire)/thotel_reservation_chambre.taux) as prix_unitaireFC')
        ->selectRaw('TIMESTAMPDIFF(MONTH, date_entree, date_sortie) as NombreJour')
        ->selectRaw('(((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))) as prixTotalSans')
        ->selectRaw('(((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))-reduction) as prixTotal')
        ->selectRaw('((((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))-reduction)/thotel_reservation_chambre.taux) as prixTotalFC')
        ->selectRaw('IFNULL((((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))-reduction),0) as totalFacture')
        ->selectRaw('IFNULL(totalPaie,0) as totalPaie')
        ->selectRaw('(IFNULL((((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0)) as RestePaie')
        ->selectRaw('((IFNULL((((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0))/thotel_reservation_chambre.taux) as RestePaieFC')
        ->Where('refClient',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("thotel_reservation_chambre.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("thotel_reservation_chambre.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    



    function fetch_single_data($id)
    {
        $data= DB::table('thotel_reservation_chambre')
        ->join('thotel_chambre','thotel_chambre.id','=','thotel_reservation_chambre.refChmabre')
        ->join('thotel_classe_chambre','thotel_classe_chambre.id','=','thotel_chambre.refClasse') 
        ->join('tvente_client as clientHotel','clientHotel.id','=','thotel_reservation_chambre.refClient')
        ->join('tvente_client as priseCharge','priseCharge.id','=','thotel_reservation_chambre.id_prise_charge')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','clientHotel.refCategieClient')
        ->select('thotel_reservation_chambre.id','refClient','refChmabre','id_prise_charge','date_entree','date_sortie',
        'heure_debut','heure_sortie','libelle','prix_unitaire','reduction','observation',
        'type_reservation','nom_accompagner','pays_provenance',
        'thotel_reservation_chambre.author','thotel_reservation_chambre.created_at','clientHotel.noms',
        'clientHotel.sexe','clientHotel.contact','clientHotel.mail','clientHotel.adresse',
        'clientHotel.pieceidentite','clientHotel.numeroPiece','clientHotel.dateLivrePiece',
        'clientHotel.lieulivraisonCarte','clientHotel.nationnalite','clientHotel.datenaissance',
        'clientHotel.lieunaissance','clientHotel.profession','clientHotel.occupation','clientHotel.nombreEnfant',
        'clientHotel.dateArriverGoma','clientHotel.arriverPar','clientHotel.refCategieClient',
        'clientHotel.photo','clientHotel.slug','thotel_reservation_chambre.devise',
        'thotel_reservation_chambre.taux','tvente_categorie_client.designation as CategorieClient', 
        "thotel_chambre.nom_chambre","numero_chambre","refClasse", "thotel_classe_chambre.designation as ClasseChambre",
        "thotel_classe_chambre.prix_chambre","thotel_reservation_chambre.refUser"
        
        ,'priseCharge.noms as noms_charge','priseCharge.sexe as sexe_charge','priseCharge.contact as contact__charge',
        'priseCharge.mail as mail_charge','priseCharge.adresse as adresse_charge')
        ->selectRaw('((prix_unitaire)/thotel_reservation_chambre.taux) as prix_unitaireFC')
        ->selectRaw('TIMESTAMPDIFF(MONTH, date_entree, date_sortie) as NombreJour')
        ->selectRaw('(((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))) as prixTotalSans')
        ->selectRaw('(((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))-reduction) as prixTotal')
        ->selectRaw('((((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))-reduction)/thotel_reservation_chambre.taux) as prixTotalFC')
        ->selectRaw('IFNULL((((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))-reduction),0) as totalFacture')
        ->selectRaw('IFNULL(totalPaie,0) as totalPaie')
        ->selectRaw('(IFNULL((((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0)) as RestePaie')
        ->selectRaw('((IFNULL((((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0))/thotel_reservation_chambre.taux) as RestePaieFC')
        ->where('thotel_reservation_chambre.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }


    function fetch_reservation_search()
    {
        $data= DB::table('thotel_reservation_chambre')
        ->join('thotel_chambre','thotel_chambre.id','=','thotel_reservation_chambre.refChmabre')
        ->join('thotel_classe_chambre','thotel_classe_chambre.id','=','thotel_chambre.refClasse') 
        ->join('tvente_client','tvente_client.id','=','thotel_reservation_chambre.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
        ->select('thotel_reservation_chambre.id','refClient','refChmabre','id_prise_charge','date_entree','date_sortie',
        'heure_debut','heure_sortie','libelle','prix_unitaire','reduction','observation',
        'type_reservation','nom_accompagner','pays_provenance',
        'thotel_reservation_chambre.author','thotel_reservation_chambre.created_at','noms','sexe',
        'contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'thotel_reservation_chambre.devise','thotel_reservation_chambre.taux',
        'tvente_categorie_client.designation as CategorieClient', 
        "thotel_chambre.nom_chambre","numero_chambre","refClasse","thotel_reservation_chambre.refUser", 
        "thotel_classe_chambre.designation as ClasseChambre","thotel_classe_chambre.prix_chambre")
        ->selectRaw('((prix_unitaire)/thotel_reservation_chambre.taux) as prix_unitaireFC')
        ->selectRaw('TIMESTAMPDIFF(MONTH, date_entree, date_sortie) as NombreJour')
        ->selectRaw('(((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))) as prixTotalSans')
        ->selectRaw('(((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))-reduction) as prixTotal')
        ->selectRaw('((((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))-reduction)/thotel_reservation_chambre.taux) as prixTotalFC')
        ->selectRaw('IFNULL((((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))-reduction),0) as totalFacture')
        ->selectRaw('IFNULL(totalPaie,0) as totalPaie')
        ->selectRaw('(IFNULL((((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0)) as RestePaie')
        ->selectRaw('((IFNULL((((TIMESTAMPDIFF(MONTH, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0))/thotel_reservation_chambre.taux) as RestePaieFC')
        ->selectRaw("(CONCAT(tvente_client.noms,' Chambre N° : ',thotel_chambre.nom_chambre,' Du ',DATE_FORMAT(date_entree, '%d/%m/%Y'),' au ',DATE_FORMAT(date_sortie, '%d/%m/%Y'), ' - N° : ',thotel_reservation_chambre.id )) as designationReservation")
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

        $data = thotel_reservation_chambre::create([
            'refClient'       =>  $request->refClient,
            'refChmabre'       =>  $request->refChmabre,
            'id_prise_charge'       =>  $request->id_prise_charge,
            'date_entree'       =>  $request->date_entree,
            'date_sortie'       =>  $request->date_sortie,
            'heure_debut'       =>  $heure1,
            'heure_sortie'       =>  $heure2,
            'libelle'       =>  $request->libelle,
            'prix_unitaire'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'reduction'    =>  $request->reduction,
            'observation'    =>  $request->observation,
            'type_reservation'    =>  $request->type_reservation,
            'nom_accompagner'    =>  $request->nom_accompagner,
            'pays_provenance'    =>  $request->pays_provenance,
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


        $data = thotel_reservation_chambre::where('id', $id)->update([
            'refClient'       =>  $request->refClient,
            'refChmabre'       =>  $request->refChmabre,
            'id_prise_charge'       =>  $request->id_prise_charge,
            'date_entree'       =>  $request->date_entree,
            'date_sortie'       =>  $request->date_sortie,
            'heure_debut'       =>  $heure1,
            'heure_sortie'       =>  $heure2,
            'libelle'       =>  $request->libelle,
            'prix_unitaire'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'reduction'    =>  $request->reduction,
            'observation'    =>  $request->observation,
            'type_reservation'    =>  $request->type_reservation,
            'nom_accompagner'    =>  $request->nom_accompagner,
            'pays_provenance'    =>  $request->pays_provenance,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {       
        $data = thotel_paiement_chambre::where('refReservation',$id)->delete();
        $data = thotel_reservation_chambre::where('id',$id)->delete();        
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
