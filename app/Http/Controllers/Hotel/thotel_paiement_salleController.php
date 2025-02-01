<?php

namespace App\Http\Controllers\Hotel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hotel\thotel_paiement_salle;
use App\Traits\{GlobalMethod,Slug};
use DB;
class thotel_paiement_salleController extends Controller
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

     //thotel_paiement_salle

    public function all(Request $request)
    { 

        $data = DB::table('thotel_paiement_salle')
        ->join('thotel_reservation_salle','thotel_reservation_salle.id','=','thotel_paiement_salle.refReservation')
        ->join('thotel_salle','thotel_salle.id','=','thotel_reservation_salle.refClient')
        ->join('tvente_client','tvente_client.id','=','thotel_reservation_salle.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')

        ->join('tconf_banque' , 'tconf_banque.id','=','thotel_paiement_salle.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')

        ->select('thotel_paiement_salle.id','refReservation','montant_paie','date_paie',
        'refClient','refSalle','date_ceremonie','heure_debut','thotel_paiement_salle.refUser',
        'heure_sortie','date_reservation','thotel_reservation_salle.prix_unitaire','reduction','observation','thotel_paiement_salle.author','thotel_paiement_salle.created_at',
        'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'thotel_paiement_salle.devise','thotel_paiement_salle.taux',
        'tvente_categorie_client.designation as CategorieClient', 
        "thotel_salle.designation as nom_salle","thotel_salle.prix_salle",
        'modepaie','libellepaie','refBanque','numeroBordereau',"tconf_banque.nom_banque","tconf_banque.numerocompte",
        'tconf_banque.nom_mode',"tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte',
        'nom_souscompte','numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte',
        'numero_compte','refClasse','refTypecompte','refPosition','nom_classe',
        'numero_classe','nom_typeposition',"nom_typecompte")
        ->selectRaw('((prix_unitaire)/thotel_paiement_salle.taux) as prix_unitaireFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",thotel_paiement_salle.id) as codeRecu');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("thotel_paiement_salle.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("thotel_paiement_salle.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('thotel_paiement_salle')
        ->join('thotel_reservation_salle','thotel_reservation_salle.id','=','thotel_paiement_salle.refReservation')
        ->join('thotel_salle','thotel_salle.id','=','thotel_reservation_salle.refClient')
        ->join('tvente_client','tvente_client.id','=','thotel_reservation_salle.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')

        ->join('tconf_banque' , 'tconf_banque.id','=','thotel_paiement_salle.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')

        ->select('thotel_paiement_salle.id','refReservation','montant_paie','date_paie',
        'refClient','refSalle','date_ceremonie','heure_debut','thotel_paiement_salle.refUser',
        'heure_sortie','date_reservation','thotel_reservation_salle.prix_unitaire',
        'reduction','observation','thotel_paiement_salle.author','thotel_paiement_salle.created_at',
        'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'thotel_paiement_salle.devise','thotel_paiement_salle.taux',
        'tvente_categorie_client.designation as CategorieClient', 
        "thotel_salle.designation as nom_salle","thotel_salle.prix_salle",
        'modepaie','libellepaie','refBanque','numeroBordereau',"tconf_banque.nom_banque","tconf_banque.numerocompte",
        'tconf_banque.nom_mode',"tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte',
        'nom_souscompte','numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte',
        'numero_compte','refClasse','refTypecompte','refPosition','nom_classe',
        'numero_classe','nom_typeposition',"nom_typecompte")
        ->selectRaw('((prix_unitaire)/thotel_paiement_salle.taux) as prix_unitaireFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",thotel_paiement_salle.id) as codeRecu')
        ->Where('refReservation',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("thotel_paiement_salle.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("thotel_paiement_salle.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    



    function fetch_single_data($id)
    {
        $data= DB::table('thotel_paiement_salle')
        ->join('thotel_reservation_salle','thotel_reservation_salle.id','=','thotel_paiement_salle.refReservation')
        ->join('thotel_salle','thotel_salle.id','=','thotel_reservation_salle.refClient')
        ->join('tvente_client','tvente_client.id','=','thotel_reservation_salle.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')

        ->join('tconf_banque' , 'tconf_banque.id','=','thotel_paiement_salle.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')

        ->select('thotel_paiement_salle.id','refReservation','montant_paie','date_paie',
        'refClient','refSalle','date_ceremonie','heure_debut','thotel_paiement_salle.refUser',
        'heure_sortie','date_reservation','thotel_reservation_salle.prix_unitaire',
        'reduction','observation','thotel_paiement_salle.author','thotel_paiement_salle.created_at',
        'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'thotel_paiement_salle.devise','thotel_paiement_salle.taux',
        'tvente_categorie_client.designation as CategorieClient', 
        "thotel_salle.designation as nom_salle","thotel_salle.prix_salle",
        'modepaie','libellepaie','refBanque','numeroBordereau',"tconf_banque.nom_banque","tconf_banque.numerocompte",
        'tconf_banque.nom_mode',"tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte',
        'nom_souscompte','numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte',
        'numero_compte','refClasse','refTypecompte','refPosition','nom_classe',
        'numero_classe','nom_typeposition',"nom_typecompte")
        ->selectRaw('((prix_unitaire)/thotel_paiement_salle.taux) as prix_unitaireFC')
        ->selectRaw('CONCAT("R",YEAR(date_paie),"",MONTH(date_paie),"00",thotel_paiement_salle.id) as codeRecu')
        ->where('thotel_paiement_salle.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    //'refEnteteVente','montant_paie','date_paie'
    function insert_data(Request $request)
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

        $idFacture=$request->refReservation;

        $data = thotel_paiement_salle::create([
            'refReservation'       =>  $request->refReservation,
            'montant_paie'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'date_paie'    =>  $request->date_paie,
            'modepaie'       =>  $request->modepaie,
            'libellepaie'       =>  $request->libellepaie, 
            'refBanque'       =>  $request->refBanque,
            'numeroBordereau'       =>  $request->numeroBordereau,
            'date_paie'       =>  $request->date_paie,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);

        $data3 = DB::update(
            'update thotel_reservation_salle set totalPaie = totalPaie + (:paiement) where id = :refReservation',
            ['paiement' => $montants,'refReservation' => $idFacture]
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


        $data = thotel_paiement_salle::where('id', $id)->update([
            'refReservation'       =>  $request->refReservation,
            'montant_paie'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'date_paie'    =>  $request->date_paie,
            'modepaie'       =>  $request->modepaie,
            'libellepaie'       =>  $request->libellepaie, 
            'refBanque'       =>  $request->refBanque,
            'numeroBordereau'       =>  $request->numeroBordereau,
            'date_paie'       =>  $request->date_paie,
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

        $deleteds = DB::table('thotel_paiement_salle')->Where('id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $idFacture = $deleted->refReservation;
            $montants = $deleted->montant_paie;
        }
        $data3 = DB::update(
            'update thotel_reservation_salle set totalPaie = totalPaie - (:paiement) where id = :refReservation',
            ['paiement' => $montants,'refReservation' => $idFacture]
        );

        $data = thotel_paiement_salle::where('id',$id)->delete();
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
