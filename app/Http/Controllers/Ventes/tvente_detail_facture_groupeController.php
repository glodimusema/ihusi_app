<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_detail_facture_groupe;
use App\Models\Ventes\tvente_entete_facture_groupe;
use App\Models\Ventes\tvente_entete_paiement_groupe;
use App\Models\Ventes\tvente_detail_paiement_groupe;
use App\Models\Ventes\tvente_entete_paievente;
use App\Models\Ventes\tvente_paiement;
use App\Models\Hotel\thotel_paiement_chambre;
use App\Models\Facture;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tvente_detail_facture_groupeController extends Controller
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
        //'id','refEnteteGroup','id_vente','id_reservation','active','author','refUser'
        $data = DB::table('tvente_detail_facture_groupe')
        ->join('tvente_entete_facture_groupe','tvente_entete_facture_groupe.id','=','tvente_detail_facture_groupe.refEnteteGroup')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_facture_groupe.module_id')
        ->join('tvente_client as Organiation','Organiation.id','=','tvente_entete_facture_groupe.refOrganisation')
        ->join('tvente_categorie_client as CatOrg','CatOrg.id','=','Organiation.refCategieClient')  

        ->join('thotel_reservation_chambre','thotel_reservation_chambre.id','=','tvente_detail_facture_groupe.id_reservation')
        ->join('thotel_chambre','thotel_chambre.id','=','thotel_reservation_chambre.refChmabre')
        ->join('thotel_classe_chambre','thotel_classe_chambre.id','=','thotel_chambre.refClasse') 
        ->join('tvente_client as clientHotel','clientHotel.id','=','thotel_reservation_chambre.refClient')
        ->join('tvente_client as priseCharge','priseCharge.id','=','thotel_reservation_chambre.id_prise_charge')
        ->join('tvente_categorie_client as CatClient','CatClient.id','=','clientHotel.refCategieClient')
        
        ->select('tvente_detail_facture_groupe.id','refEnteteGroup','tvente_detail_facture_groupe.id_vente',
        'tvente_detail_facture_groupe.id_reservation','tvente_detail_facture_groupe.active',
        'tvente_entete_facture_groupe.code','refOrganisation','tvente_detail_facture_groupe.created_at',
        'tvente_entete_facture_groupe.module_id','etat_facture_group','dateGroup',
        'libelle_group','montant_group','reduction_group','totaltva_group','paie_group','date_paie_current_group',
        'nombre_print_group','tvente_detail_facture_groupe.author','tvente_detail_facture_groupe.refUser'

        ,'Organiation.noms','Organiation.sexe','Organiation.contact','Organiation.mail','Organiation.adresse',
        'Organiation.pieceidentite','Organiation.numeroPiece','Organiation.dateLivrePiece',
        'Organiation.lieulivraisonCarte','Organiation.nationnalite','Organiation.datenaissance',
        'Organiation.lieunaissance','Organiation.profession','Organiation.occupation',
        'Organiation.nombreEnfant','Organiation.dateArriverGoma','Organiation.arriverPar',
        'Organiation.refCategieClient','Organiation.photo','Organiation.slug',
        "CatOrg.designation"
        
        ,'refClient','refChmabre','id_prise_charge','date_entree','date_sortie',
        'heure_debut','heure_sortie','libelle','prix_unitaire','reduction','observation',
        'type_reservation','nom_accompagner','pays_provenance','clientHotel.noms as nomsClient',
        'clientHotel.sexe as sexeClient','clientHotel.contact as Client','clientHotel.mail as mailClient',
        'clientHotel.adresse as adresseClient','clientHotel.pieceidentite as pieceidentiteClient',
        'clientHotel.numeroPiece as numeroPieceClient','clientHotel.dateLivrePiece as dateLivrePieceClient',
        'clientHotel.lieulivraisonCarte as lieulivraisonCarteClient','clientHotel.nationnalite as nationnaliteClient',
        'clientHotel.datenaissance as datenaissanceClient',
        'clientHotel.lieunaissance as lieunaissanceClient','clientHotel.profession as professionClient',
        'clientHotel.occupation as occupationClient','clientHotel.nombreEnfant as nombreEnfantClient',
        'clientHotel.dateArriverGoma as dateArriverGomaClient','clientHotel.arriverPar as arriverParClient',
        'clientHotel.refCategieClient as refCategieClientClient',
        'clientHotel.photo as photoCLient','CatClient.designation as CategorieClient', 
        "thotel_chambre.nom_chambre","numero_chambre","refClasse", "thotel_classe_chambre.designation as ClasseChambre",
        "thotel_classe_chambre.prix_chambre"
        
        ,'priseCharge.noms as noms_charge','priseCharge.sexe as sexe_charge','priseCharge.contact as contact_charge',
        'priseCharge.mail as mail_charge','priseCharge.adresse as adresse_charge')

        ->selectRaw('CONCAT("F",YEAR(dateGroup),"",MONTH(dateGroup),"00",tvente_entete_facture_groupe.id) as codeFacture')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0),2) as totalFacture')
        ->selectRaw('IFNULL(paie_group,0) as totalPaie')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0) - IFNULL(paie_group,0)),2) as RestePaie')
        
        ->selectRaw('((prix_unitaire)/thotel_reservation_chambre.taux) as prix_unitaireFCHotel')
        ->selectRaw('TIMESTAMPDIFF(DAY, date_entree, date_sortie) as NombreJour')
        ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))) as prixTotalSansHotel')
        ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction) as prixTotalHotel')
        ->selectRaw('((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction)/thotel_reservation_chambre.taux) as prixTotalFCHotel')
        ->selectRaw('IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0) as totalFactureHotel')
        ->selectRaw('IFNULL(totalPaie,0) as totalPaieHotel')
        ->selectRaw('(IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0)) as RestePaieHotel')
        ->selectRaw('((IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0))/thotel_reservation_chambre.taux) as RestePaieFCHotel');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('Organiation.noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_entete_facture_groupe.created_at", "desc");

            return $this->apiData($data->paginate(10));          

        }
        $data->orderBy("tvente_entete_facture_groupe.created_at", "desc");
        return $this->apiData($data->paginate(10));       
    }

    public function fetch_data_entete(Request $request,$refEntete)
    {
        $data = DB::table('tvente_detail_facture_groupe')
        ->join('tvente_entete_facture_groupe','tvente_entete_facture_groupe.id','=','tvente_detail_facture_groupe.refEnteteGroup')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_facture_groupe.module_id')
        ->join('tvente_client as Organiation','Organiation.id','=','tvente_entete_facture_groupe.refOrganisation')
        ->join('tvente_categorie_client as CatOrg','CatOrg.id','=','Organiation.refCategieClient')  

        ->join('thotel_reservation_chambre','thotel_reservation_chambre.id','=','tvente_detail_facture_groupe.id_reservation')
        ->join('thotel_chambre','thotel_chambre.id','=','thotel_reservation_chambre.refChmabre')
        ->join('thotel_classe_chambre','thotel_classe_chambre.id','=','thotel_chambre.refClasse') 
        ->join('tvente_client as clientHotel','clientHotel.id','=','thotel_reservation_chambre.refClient')
        ->join('tvente_client as priseCharge','priseCharge.id','=','thotel_reservation_chambre.id_prise_charge')
        ->join('tvente_categorie_client as CatClient','CatClient.id','=','clientHotel.refCategieClient')
        
        ->select('tvente_detail_facture_groupe.id','refEnteteGroup','tvente_detail_facture_groupe.id_vente',
        'tvente_detail_facture_groupe.id_reservation','tvente_detail_facture_groupe.active',
        'tvente_entete_facture_groupe.code','refOrganisation','tvente_detail_facture_groupe.created_at',
        'tvente_entete_facture_groupe.module_id','etat_facture_group','dateGroup',
        'libelle_group','montant_group','reduction_group','totaltva_group','paie_group','date_paie_current_group',
        'nombre_print_group','tvente_detail_facture_groupe.author','tvente_detail_facture_groupe.refUser'

        ,'Organiation.noms','Organiation.sexe','Organiation.contact','Organiation.mail','Organiation.adresse',
        'Organiation.pieceidentite','Organiation.numeroPiece','Organiation.dateLivrePiece',
        'Organiation.lieulivraisonCarte','Organiation.nationnalite','Organiation.datenaissance',
        'Organiation.lieunaissance','Organiation.profession','Organiation.occupation',
        'Organiation.nombreEnfant','Organiation.dateArriverGoma','Organiation.arriverPar',
        'Organiation.refCategieClient','Organiation.photo','Organiation.slug',
        "CatOrg.designation"
        
        ,'clientHotel.id as idClient','refChmabre','id_prise_charge','date_entree','date_sortie',
        'heure_debut','heure_sortie','libelle','prix_unitaire','reduction','observation',
        'type_reservation','nom_accompagner','pays_provenance','clientHotel.noms as nomsClient',
        'clientHotel.sexe as sexeClient','clientHotel.contact as Client','clientHotel.mail as mailClient',
        'clientHotel.adresse as adresseClient','clientHotel.pieceidentite as pieceidentiteClient',
        'clientHotel.numeroPiece as numeroPieceClient','clientHotel.dateLivrePiece as dateLivrePieceClient',
        'clientHotel.lieulivraisonCarte as lieulivraisonCarteClient','clientHotel.nationnalite as nationnaliteClient',
        'clientHotel.datenaissance as datenaissanceClient',
        'clientHotel.lieunaissance as lieunaissanceClient','clientHotel.profession as professionClient',
        'clientHotel.occupation as occupationClient','clientHotel.nombreEnfant as nombreEnfantClient',
        'clientHotel.dateArriverGoma as dateArriverGomaClient','clientHotel.arriverPar as arriverParClient',
        'clientHotel.refCategieClient as refCategieClientClient',
        'clientHotel.photo as photoCLient','CatClient.designation as CategorieClient', 
        "thotel_chambre.nom_chambre","numero_chambre","refClasse", "thotel_classe_chambre.designation as ClasseChambre",
        "thotel_classe_chambre.prix_chambre"
        
        ,'priseCharge.noms as noms_charge','priseCharge.sexe as sexe_charge','priseCharge.contact as contact_charge',
        'priseCharge.mail as mail_charge','priseCharge.adresse as adresse_charge'
        )

        ->selectRaw('CONCAT("F",YEAR(dateGroup),"",MONTH(dateGroup),"00",tvente_entete_facture_groupe.id) as codeFacture')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0),2) as totalFacture')
        ->selectRaw('IFNULL(paie_group,0) as totalPaie')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0) - IFNULL(paie_group,0)),2) as RestePaie')
        
        ->selectRaw('((prix_unitaire)/thotel_reservation_chambre.taux) as prix_unitaireFCHotel')
        ->selectRaw('TIMESTAMPDIFF(DAY, date_entree, date_sortie) as NombreJour')
        ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))) as prixTotalSansHotel')
        ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction) as prixTotalHotel')
        ->selectRaw('((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction)/thotel_reservation_chambre.taux) as prixTotalFCHotel')
        ->selectRaw('IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0) as totalFactureHotel')
        ->selectRaw('IFNULL(totalPaie,0) as totalPaieHotel')
        ->selectRaw('(IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0)) as RestePaieHotel')
        ->selectRaw('((IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0))/thotel_reservation_chambre.taux) as RestePaieFCHotel')
        ->Where('refEnteteGroup',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_facture_groupe.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_detail_facture_groupe.created_at", "desc");
        return $this->apiData($data->paginate(10));
    } 

    function fetch_single_data($id)
    {

        $data = DB::table('tvente_detail_facture_groupe')
        ->join('tvente_entete_facture_groupe','tvente_entete_facture_groupe.id','=','tvente_detail_facture_groupe.refEnteteGroup')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_facture_groupe.module_id')
        ->join('tvente_client as Organiation','Organiation.id','=','tvente_entete_facture_groupe.refOrganisation')
        ->join('tvente_categorie_client as CatOrg','CatOrg.id','=','Organiation.refCategieClient')  

        ->join('thotel_reservation_chambre','thotel_reservation_chambre.id','=','tvente_detail_facture_groupe.id_reservation')
        ->join('thotel_chambre','thotel_chambre.id','=','thotel_reservation_chambre.refChmabre')
        ->join('thotel_classe_chambre','thotel_classe_chambre.id','=','thotel_chambre.refClasse') 
        ->join('tvente_client as clientHotel','clientHotel.id','=','thotel_reservation_chambre.refClient')
        ->join('tvente_client as priseCharge','priseCharge.id','=','thotel_reservation_chambre.id_prise_charge')
        ->join('tvente_categorie_client as CatClient','CatClient.id','=','clientHotel.refCategieClient')
        
        ->select('tvente_detail_facture_groupe.id','refEnteteGroup','tvente_detail_facture_groupe.id_vente',
        'tvente_detail_facture_groupe.id_reservation','tvente_detail_facture_groupe.active',
        'tvente_entete_facture_groupe.code','refOrganisation','tvente_detail_facture_groupe.created_at',
        'tvente_entete_facture_groupe.module_id','etat_facture_group','dateGroup',
        'libelle_group','montant_group','reduction_group','totaltva_group','paie_group','date_paie_current_group',
        'nombre_print_group','tvente_detail_facture_groupe.author','tvente_detail_facture_groupe.refUser'

        ,'Organiation.noms','Organiation.sexe','Organiation.contact','Organiation.mail','Organiation.adresse',
        'Organiation.pieceidentite','Organiation.numeroPiece','Organiation.dateLivrePiece',
        'Organiation.lieulivraisonCarte','Organiation.nationnalite','Organiation.datenaissance',
        'Organiation.lieunaissance','Organiation.profession','Organiation.occupation',
        'Organiation.nombreEnfant','Organiation.dateArriverGoma','Organiation.arriverPar',
        'Organiation.refCategieClient','Organiation.photo','Organiation.slug',
        "CatOrg.designation"
        
        ,'refClient','refChmabre','id_prise_charge','date_entree','date_sortie',
        'heure_debut','heure_sortie','libelle','prix_unitaire','reduction','observation',
        'type_reservation','nom_accompagner','pays_provenance','clientHotel.noms as nomsClient',
        'clientHotel.sexe as sexeClient','clientHotel.contact as Client','clientHotel.mail as mailClient',
        'clientHotel.adresse as adresseClient','clientHotel.pieceidentite as pieceidentiteClient',
        'clientHotel.numeroPiece as numeroPieceClient','clientHotel.dateLivrePiece as dateLivrePieceClient',
        'clientHotel.lieulivraisonCarte as lieulivraisonCarteClient','clientHotel.nationnalite as nationnaliteClient',
        'clientHotel.datenaissance as datenaissanceClient',
        'clientHotel.lieunaissance as lieunaissanceClient','clientHotel.profession as professionClient',
        'clientHotel.occupation as occupationClient','clientHotel.nombreEnfant as nombreEnfantClient',
        'clientHotel.dateArriverGoma as dateArriverGomaClient','clientHotel.arriverPar as arriverParClient',
        'clientHotel.refCategieClient as refCategieClientClient',
        'clientHotel.photo as photoCLient','CatClient.designation as CategorieClient', 
        "thotel_chambre.nom_chambre","numero_chambre","refClasse", "thotel_classe_chambre.designation as ClasseChambre",
        "thotel_classe_chambre.prix_chambre"
        
        ,'priseCharge.noms as noms_charge','priseCharge.sexe as sexe_charge','priseCharge.contact as contact_charge',
        'priseCharge.mail as mail_charge','priseCharge.adresse as adresse_charge')

        ->selectRaw('CONCAT("F",YEAR(dateGroup),"",MONTH(dateGroup),"00",tvente_entete_facture_groupe.id) as codeFacture')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0),2) as totalFacture')
        ->selectRaw('IFNULL(paie_group,0) as totalPaie')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0) - IFNULL(paie_group,0)),2) as RestePaie')
        
        ->selectRaw('((prix_unitaire)/thotel_reservation_chambre.taux) as prix_unitaireFCHotel')
        ->selectRaw('TIMESTAMPDIFF(DAY, date_entree, date_sortie) as NombreJour')
        ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))) as prixTotalSansHotel')
        ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction) as prixTotalHotel')
        ->selectRaw('((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction)/thotel_reservation_chambre.taux) as prixTotalFCHotel')
        ->selectRaw('IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0) as totalFactureHotel')
        ->selectRaw('IFNULL(totalPaie,0) as totalPaieHotel')
        ->selectRaw('(IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0)) as RestePaieHotel')
        ->selectRaw('((IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0))/thotel_reservation_chambre.taux) as RestePaieFCHotel')
        ->where('tvente_detail_facture_groupe.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_detail_facture($id)
    {      

        $data = DB::table('tvente_detail_facture_groupe')
        ->join('tvente_entete_facture_groupe','tvente_entete_facture_groupe.id','=','tvente_detail_facture_groupe.refEnteteGroup')
        ->join('tvente_module','tvente_module.id','=','tvente_entete_facture_groupe.module_id')
        ->join('tvente_client as Organiation','Organiation.id','=','tvente_entete_facture_groupe.refOrganisation')
        ->join('tvente_categorie_client as CatOrg','CatOrg.id','=','Organiation.refCategieClient')  

        ->join('thotel_reservation_chambre','thotel_reservation_chambre.id','=','tvente_detail_facture_groupe.id_reservation')
        ->join('thotel_chambre','thotel_chambre.id','=','thotel_reservation_chambre.refChmabre')
        ->join('thotel_classe_chambre','thotel_classe_chambre.id','=','thotel_chambre.refClasse') 
        ->join('tvente_client as clientHotel','clientHotel.id','=','thotel_reservation_chambre.refClient')
        ->join('tvente_client as priseCharge','priseCharge.id','=','thotel_reservation_chambre.id_prise_charge')
        ->join('tvente_categorie_client as CatClient','CatClient.id','=','clientHotel.refCategieClient')
        
        ->select('tvente_detail_facture_groupe.id','refEnteteGroup','tvente_detail_facture_groupe.id_vente',
        'tvente_detail_facture_groupe.id_reservation','tvente_detail_facture_groupe.active',
        'tvente_entete_facture_groupe.code','refOrganisation','tvente_detail_facture_groupe.created_at',
        'tvente_entete_facture_groupe.module_id','etat_facture_group','dateGroup',
        'libelle_group','montant_group','reduction_group','totaltva_group','paie_group','date_paie_current_group',
        'nombre_print_group','tvente_detail_facture_groupe.author','tvente_detail_facture_groupe.refUser'

        ,'Organiation.noms','Organiation.sexe','Organiation.contact','Organiation.mail','Organiation.adresse',
        'Organiation.pieceidentite','Organiation.numeroPiece','Organiation.dateLivrePiece',
        'Organiation.lieulivraisonCarte','Organiation.nationnalite','Organiation.datenaissance',
        'Organiation.lieunaissance','Organiation.profession','Organiation.occupation',
        'Organiation.nombreEnfant','Organiation.dateArriverGoma','Organiation.arriverPar',
        'Organiation.refCategieClient','Organiation.photo','Organiation.slug',
        "CatOrg.designation"
        
        ,'refClient','refChmabre','id_prise_charge','date_entree','date_sortie',
        'heure_debut','heure_sortie','libelle','prix_unitaire','reduction','observation',
        'type_reservation','nom_accompagner','pays_provenance','clientHotel.noms as nomsClient',
        'clientHotel.sexe as sexeClient','clientHotel.contact as Client','clientHotel.mail as mailClient',
        'clientHotel.adresse as adresseClient','clientHotel.pieceidentite as pieceidentiteClient',
        'clientHotel.numeroPiece as numeroPieceClient','clientHotel.dateLivrePiece as dateLivrePieceClient',
        'clientHotel.lieulivraisonCarte as lieulivraisonCarteClient','clientHotel.nationnalite as nationnaliteClient',
        'clientHotel.datenaissance as datenaissanceClient',
        'clientHotel.lieunaissance as lieunaissanceClient','clientHotel.profession as professionClient',
        'clientHotel.occupation as occupationClient','clientHotel.nombreEnfant as nombreEnfantClient',
        'clientHotel.dateArriverGoma as dateArriverGomaClient','clientHotel.arriverPar as arriverParClient',
        'clientHotel.refCategieClient as refCategieClientClient',
        'clientHotel.photo as photoCLient','CatClient.designation as CategorieClient', 
        "thotel_chambre.nom_chambre","numero_chambre","refClasse", "thotel_classe_chambre.designation as ClasseChambre",
        "thotel_classe_chambre.prix_chambre"
        
        ,'priseCharge.noms as noms_charge','priseCharge.sexe as sexe_charge','priseCharge.contact as contact_charge',
        'priseCharge.mail as mail_charge','priseCharge.adresse as adresse_charge')

        ->selectRaw('CONCAT("F",YEAR(dateGroup),"",MONTH(dateGroup),"00",tvente_entete_facture_groupe.id) as codeFacture')
        ->selectRaw('ROUND(IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0),2) as totalFacture')
        ->selectRaw('IFNULL(paie_group,0) as totalPaie')
        ->selectRaw('ROUND((IFNULL((IFNULL(montant_group,0) + IFNULL(totaltva_group,0) - IFNULL(reduction_group,0)),0) - IFNULL(paie_group,0)),2) as RestePaie')
        
        ->selectRaw('((prix_unitaire)/thotel_reservation_chambre.taux) as prix_unitaireFCHotel')
        ->selectRaw('TIMESTAMPDIFF(DAY, date_entree, date_sortie) as NombreJour')
        ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))) as prixTotalSansHotel')
        ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction) as prixTotalHotel')
        ->selectRaw('((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction)/thotel_reservation_chambre.taux) as prixTotalFCHotel')
        ->selectRaw('IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0) as totalFactureHotel')
        ->selectRaw('IFNULL(totalPaie,0) as totalPaieHotel')
        ->selectRaw('(IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0)) as RestePaieHotel')
        ->selectRaw('((IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0))/thotel_reservation_chambre.taux) as RestePaieFCHotel')       
       ->Where('tvente_detail_facture_groupe.refEnteteGroup',$id)               
       ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function insert_data(Request $request)
    {     
        $refEnteteVente = 0;
        if ($request->id_vente === null) {
            $refEnteteVente = 0;
        } else {
            $refEnteteVente = $request->id_vente;
        }

        $refReservation = 0;
        if ($request->id_reservation === null) {
            $refReservation = 0;
        } else {
            $refReservation = $request->id_reservation;
        }
        
        $current = Carbon::now();
        $data = tvente_detail_facture_groupe::create([            
            'refEnteteGroup'       =>  $request->refEnteteGroup,
            'id_vente'       =>  $refEnteteVente,  
            'id_reservation'       =>  $refReservation,            
            'active'    =>  $request->active,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);

        $montant_group = 0;
        $reduction_group = 0;
        $totaltva_group = 0;
        $paie_group = 0;

        $data99=DB::table('tvente_entete_vente')
        ->select('id','code','refClient','refService','refReservation','module_id',
         'dateVente','libelle','serveur_id','table_id','etat_facture','montant','paie','reduction',
         'date_paie_current','nombre_print','totaltva','author','refUser')
        ->where([
           ['tvente_entete_vente.id','=', $refEnteteVente]
        ])      
        ->first();
        if ($data99) 
        { 
             $montant_group = $data99->montant;
             $reduction_group = $data99->reduction;
             $totaltva_group = $data99->totaltva;
             $paie_group = $data99->paie;        
        }
        else
        {
            $montant_group = 0;
            $reduction_group = 0;
            $totaltva_group = 0;
            $paie_group = 0;
        } 
        $data3 = DB::update(
             'update tvente_entete_facture_groupe set montant_group = montant_group + (:montant_group),reduction_group = reduction_group + :reduction_group,totaltva_group = totaltva_group + :totaltva_group,paie_group= paie_group + :paie_group where id = :id',
             ['montant_group' => $montant_group,'reduction_group' => $reduction_group,'totaltva_group' => $totaltva_group,'paie_group' => $paie_group,'id' => $request->refEnteteGroup]
        );



        $data999 = DB::table('thotel_reservation_chambre')
        ->select('thotel_reservation_chambre.id','refClient','refChmabre','id_prise_charge','date_entree','date_sortie',
        'heure_debut','heure_sortie','libelle','prix_unitaire','reduction','observation',
        'type_reservation','nom_accompagner','pays_provenance',
        'thotel_reservation_chambre.author','thotel_reservation_chambre.created_at')
        ->selectRaw('TIMESTAMPDIFF(DAY, date_entree, date_sortie) as NombreJour')
        ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))) as prixTotalChambre')
        ->selectRaw('IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0) as totalFacture')
        ->selectRaw('IFNULL(totalPaie,0) as totalPaie')
        ->selectRaw('(IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0)) as RestePaie')
        ->where([
           ['thotel_reservation_chambre.id','=', $refReservation]
        ])      
        ->first();
        if ($data999) 
        {
             $montant_group = $data999->totalFacture;
             $reduction_group = $data999->reduction;
             $totaltva_group = 0;
             $paie_group = $data999->totalPaie;        
        } 
        else
        {
            $montant_group = 0;
            $reduction_group = 0;
            $totaltva_group = 0;
            $paie_group = 0;
        }
        $data33 = DB::update(
             'update tvente_entete_facture_groupe set montant_group = montant_group + (:montant_group),reduction_group = reduction_group + :reduction_group,totaltva_group = totaltva_group + :totaltva_group,paie_group= paie_group + :paie_group where id = :id',
             ['montant_group' => $montant_group,'reduction_group' => $reduction_group,'totaltva_group' => $totaltva_group,'paie_group' => $paie_group,'id' => $request->refEnteteGroup]
        );

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {

        $id_vente_deleted = 0;
        $id_reservation_deleted = 0;
        $deleted =  DB::table("tvente_detail_facture_groupe")
        ->select('id','refEnteteGroup','id_vente','id_reservation')
        ->where([
            ['tvente_detail_facture_groupe.id','=', $id]
         ])
         ->first();
         if ($deleted) 
         {
            $id_vente_deleted = $deleted->id_vente;
            $id_reservation_deleted = $deleted->id_reservation;                  
         }

         $montant_group_deleted = 0;
         $reduction_group_deleted = 0;
         $totaltva_group_deleted = 0;
         $paie_group_deleted = 0;
 
         $data99=DB::table('tvente_entete_vente')
         ->select('id','code','refClient','refService','refReservation','module_id',
          'dateVente','libelle','serveur_id','table_id','etat_facture','montant','paie','reduction',
          'date_paie_current','nombre_print','totaltva','author','refUser')
         ->where([
            ['tvente_entete_vente.id','=', $id_vente_deleted]
         ])      
         ->first();
         if ($data99) 
         { 
              $montant_group_deleted = $data99->montant;
              $reduction_group_deleted = $data99->reduction;
              $totaltva_group_deleted = $data99->totaltva;
              $paie_group_deleted = $data99->paie;        
         }
         else
         {
             $montant_group_deleted = 0;
             $reduction_group_deleted = 0;
             $totaltva_group_deleted = 0;
             $paie_group_deleted = 0;
         } 
         $data3 = DB::update(
              'update tvente_entete_facture_groupe set montant_group = montant_group - (:montant_group),reduction_group = reduction_group - :reduction_group,totaltva_group = totaltva_group - :totaltva_group,paie_group= paie_group - :paie_group where id = :id',
              ['montant_group' => $montant_group_deleted,'reduction_group' => $reduction_group_deleted,'totaltva_group' => $totaltva_group_deleted,'paie_group' => $paie_group_deleted,'id' => $request->refEnteteGroup]
         );




         $data999 = DB::table('thotel_reservation_chambre')
         ->select('thotel_reservation_chambre.id','refClient','refChmabre','id_prise_charge','date_entree','date_sortie',
         'heure_debut','heure_sortie','libelle','prix_unitaire','reduction','observation',
         'type_reservation','nom_accompagner','pays_provenance',
         'thotel_reservation_chambre.author','thotel_reservation_chambre.created_at')
         ->selectRaw('TIMESTAMPDIFF(DAY, date_entree, date_sortie) as NombreJour')
         ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))) as prixTotalChambre')
         ->selectRaw('IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0) as totalFacture')
         ->selectRaw('IFNULL(totalPaie,0) as totalPaie')
         ->selectRaw('(IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0)) as RestePaie')
         ->where([
            ['thotel_reservation_chambre.id','=', $id_reservation_deleted]
         ])      
         ->first();
         if ($data999) 
         { 
              $montant_group_deleted = $data999->montant;
              $reduction_group_deleted = $data999->reduction;
              $totaltva_group_deleted = $data999->totaltva;
              $paie_group_deleted = $data999->paie;        
         }
         else
         {
             $montant_group_deleted = 0;
             $reduction_group_deleted = 0;
             $totaltva_group_deleted = 0;
             $paie_group_deleted = 0;
         } 
         $data33 = DB::update(
              'update tvente_entete_facture_groupe set montant_group = montant_group - (:montant_group),reduction_group = reduction_group - :reduction_group,totaltva_group = totaltva_group - :totaltva_group,paie_group= paie_group - :paie_group where id = :id',
              ['montant_group' => $montant_group_deleted,'reduction_group' => $reduction_group_deleted,'totaltva_group' => $totaltva_group_deleted,'paie_group' => $paie_group_deleted,'id' => $request->refEnteteGroup]
         );

 

        $data = tvente_detail_facture_groupe::where('id', $id)->update([
            'refEnteteGroup'       =>  $request->refEnteteGroup,
            'id_vente'       =>  $request->id_vente,  
            'id_reservation'       =>  $request->id_reservation,            
            'active'    =>  $request->active,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);


        $montant_group = 0;
        $reduction_group = 0;
        $totaltva_group = 0;
        $paie_group = 0;

        $data99=DB::table('tvente_entete_vente')
        ->select('id','code','refClient','refService','refReservation','module_id',
         'dateVente','libelle','serveur_id','table_id','etat_facture','montant','paie','reduction',
         'date_paie_current','nombre_print','totaltva','author','refUser')
        ->where([
           ['tvente_entete_vente.id','=', $request->id_vente]
        ])      
        ->first();
        if ($data99) 
        { 
             $montant_group = $data99->montant;
             $reduction_group = $data99->reduction;
             $totaltva_group = $data99->totaltva;
             $paie_group = $data99->paie;        
        }
        else
        {
            $montant_group = 0;
            $reduction_group = 0;
            $totaltva_group = 0;
            $paie_group = 0;
        } 
        $data3 = DB::update(
             'update tvente_entete_facture_groupe set montant_group = montant_group + (:montant_group),reduction_group = reduction_group + :reduction_group,totaltva_group = totaltva_group + :totaltva_group,paie_group= paie_group + :paie_group where id = :id',
             ['montant_group' => $montant_group,'reduction_group' => $reduction_group,'totaltva_group' => $totaltva_group,'paie_group' => $paie_group,'id' => $request->refEnteteGroup]
        );



        $data999 = DB::table('thotel_reservation_chambre')
        ->select('thotel_reservation_chambre.id','refClient','refChmabre','id_prise_charge','date_entree','date_sortie',
        'heure_debut','heure_sortie','libelle','prix_unitaire','reduction','observation',
        'type_reservation','nom_accompagner','pays_provenance',
        'thotel_reservation_chambre.author','thotel_reservation_chambre.created_at')
        ->selectRaw('TIMESTAMPDIFF(DAY, date_entree, date_sortie) as NombreJour')
        ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))) as prixTotalChambre')
        ->selectRaw('IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0) as totalFacture')
        ->selectRaw('IFNULL(totalPaie,0) as totalPaie')
        ->selectRaw('(IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0)) as RestePaie')
        ->where([
           ['thotel_reservation_chambre.id','=', $request->id_reservation]
        ])      
        ->first();
        if ($data999) 
        {
             $montant_group = $data999->totalFacture;
             $reduction_group = $data999->reduction;
             $totaltva_group = 0;
             $paie_group = $data999->totalPaie;        
        } 
        else
        {
            $montant_group = 0;
            $reduction_group = 0;
            $totaltva_group = 0;
            $paie_group = 0;
        }
        $data33 = DB::update(
             'update tvente_entete_facture_groupe set montant_group = montant_group + (:montant_group),reduction_group = reduction_group + :reduction_group,totaltva_group = totaltva_group + :totaltva_group,paie_group= paie_group + :paie_group where id = :id',
             ['montant_group' => $montant_group,'reduction_group' => $reduction_group,'totaltva_group' => $totaltva_group,'paie_group' => $paie_group,'id' => $request->refEnteteGroup]
        );


        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $id_vente_deleted = 0;
        $id_reservation_deleted = 0;
        $deleted =  DB::table("tvente_detail_facture_groupe")
        ->select('id','refEnteteGroup','id_vente','id_reservation')
        ->where([
            ['tvente_detail_facture_groupe.id','=', $id]
         ])
         ->first();
         if ($deleted) 
         {
            $id_vente_deleted = $deleted->id_vente;
            $id_reservation_deleted = $deleted->id_reservation;                  
         }

         $montant_group_deleted = 0;
         $reduction_group_deleted = 0;
         $totaltva_group_deleted = 0;
         $paie_group_deleted = 0;
 
         $data99=DB::table('tvente_entete_vente')
         ->select('id','code','refClient','refService','refReservation','module_id',
          'dateVente','libelle','serveur_id','table_id','etat_facture','montant','paie','reduction',
          'date_paie_current','nombre_print','totaltva','author','refUser')
         ->where([
            ['tvente_entete_vente.id','=', $id_vente_deleted]
         ])      
         ->first();
         if ($data99) 
         { 
              $montant_group_deleted = $data99->montant;
              $reduction_group_deleted = $data99->reduction;
              $totaltva_group_deleted = $data99->totaltva;
              $paie_group_deleted = $data99->paie;        
         }
         else
         {
             $montant_group_deleted = 0;
             $reduction_group_deleted = 0;
             $totaltva_group_deleted = 0;
             $paie_group_deleted = 0;
         } 
         $data3 = DB::update(
              'update tvente_entete_facture_groupe set montant_group = montant_group - (:montant_group),reduction_group = reduction_group - :reduction_group,totaltva_group = totaltva_group - :totaltva_group,paie_group= paie_group - :paie_group where id = :id',
              ['montant_group' => $montant_group_deleted,'reduction_group' => $reduction_group_deleted,'totaltva_group' => $totaltva_group_deleted,'paie_group' => $paie_group_deleted,'id' => $request->refEnteteGroup]
         );




         $data999 = DB::table('thotel_reservation_chambre')
         ->select('thotel_reservation_chambre.id','refClient','refChmabre','id_prise_charge','date_entree','date_sortie',
         'heure_debut','heure_sortie','libelle','prix_unitaire','reduction','observation',
         'type_reservation','nom_accompagner','pays_provenance',
         'thotel_reservation_chambre.author','thotel_reservation_chambre.created_at')
         ->selectRaw('TIMESTAMPDIFF(DAY, date_entree, date_sortie) as NombreJour')
         ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))) as prixTotalChambre')
         ->selectRaw('IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0) as totalFacture')
         ->selectRaw('IFNULL(totalPaie,0) as totalPaie')
         ->selectRaw('(IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0)) as RestePaie')
         ->where([
            ['thotel_reservation_chambre.id','=', $id_reservation_deleted]
         ])      
         ->first();
         if ($data999) 
         { 
              $montant_group_deleted = $data999->montant;
              $reduction_group_deleted = $data999->reduction;
              $totaltva_group_deleted = $data999->totaltva;
              $paie_group_deleted = $data999->paie;        
         }
         else
         {
             $montant_group_deleted = 0;
             $reduction_group_deleted = 0;
             $totaltva_group_deleted = 0;
             $paie_group_deleted = 0;
         } 
         $data33 = DB::update(
              'update tvente_entete_facture_groupe set montant_group = montant_group - (:montant_group),reduction_group = reduction_group - :reduction_group,totaltva_group = totaltva_group - :totaltva_group,paie_group= paie_group - :paie_group where id = :id',
              ['montant_group' => $montant_group_deleted,'reduction_group' => $reduction_group_deleted,'totaltva_group' => $totaltva_group_deleted,'paie_group' => $paie_group_deleted,'id' => $request->refEnteteGroup]
         );


        $data = tvente_detail_facture_groupe::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }


    function insert_dataGlobalHotel(Request $request)
    {
        $module_id = 10;
        $current = Carbon::now(); 
        $formattedDate = $current->format('Y-m-d');
        $code = $this->GetCodeData('tvente_param_systeme','module_id',$module_id);

        $data1 = tvente_entete_facture_groupe::create([
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

        $idmax=0;
        $maxid = DB::table('tvente_entete_facture_groupe')       
        ->selectRaw('MAX(tvente_entete_facture_groupe.id) as code_entete')
        ->where([
            ['tvente_entete_facture_groupe.refUser', $request->refUser],
            ['tvente_entete_facture_groupe.refOrganisation','=', $request->refOrganisation]
         ])
        ->first();
        if ($maxid) {
            $idmax= $maxid->code_entete;
        }

        //'id','refEnteteGroup','id_vente','id_reservation','active','author','refUser'

        $detailData = $request->detailData;
        //$data['qteVente']

        foreach ($detailData as $data) {

            $active = "OUI";

            $data2 = tvente_detail_facture_groupe::create([
                'refEnteteGroup'       =>  $idmax,
                // 'id_vente'       =>  $data['id_vente'],  
                'id_reservation'       =>  $data['id_reservation'],            
                'active'    =>  $active,
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser
           ]);

           $montant_group = 0;
           $reduction_group = 0;
           $totaltva_group = 0;
           $paie_group = 0; 

           $data99=DB::table('thotel_reservation_chambre')
           ->select('thotel_reservation_chambre.id','refClient','refChmabre','id_prise_charge','date_entree','date_sortie',
           'heure_debut','heure_sortie','libelle','prix_unitaire','reduction','observation',
           'type_reservation','nom_accompagner','pays_provenance',
           'thotel_reservation_chambre.author','thotel_reservation_chambre.created_at')
           ->selectRaw('TIMESTAMPDIFF(DAY, date_entree, date_sortie) as NombreJour')
           ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))) as prixTotalChambre')
           ->selectRaw('IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0) as totalFacture')
           ->selectRaw('IFNULL(totalPaie,0) as totalPaie')
           ->selectRaw('(IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0)) as RestePaie')
           ->where([
              ['thotel_reservation_chambre.id','=', $data['id_reservation']]
           ])      
           ->first();
           if ($data99) 
           {
                $montant_group = $data99->totalFacture;
                $reduction_group = $data99->reduction;
                $totaltva_group = 0;
                $paie_group = $data99->totalPaie;        
           }    
           $data3 = DB::update(
                'update tvente_entete_facture_groupe set montant_group = montant_group + (:montant_group),reduction_group = reduction_group + :reduction_group,totaltva_group = totaltva_group + :totaltva_group,paie_group= paie_group + :paie_group where id = :id',
                ['montant_group' => $montant_group,'reduction_group' => $reduction_group,'totaltva_group' => $totaltva_group,'paie_group' => $paie_group,'id' => $idmax]
           );

        }

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }


    function insert_dataGlobalVente(Request $request)
    {
        $module_id = 10;
        $current = Carbon::now(); 
        $formattedDate = $current->format('Y-m-d');
        $code = $this->GetCodeData('tvente_param_systeme','module_id',$module_id);

        $data1 = tvente_entete_facture_groupe::create([
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

        $idmax=0;
        $maxid = DB::table('tvente_entete_facture_groupe')       
        ->selectRaw('MAX(tvente_entete_facture_groupe.id) as code_entete')
        ->where([
            ['tvente_entete_facture_groupe.refUser', $request->refUser],
            ['tvente_entete_facture_groupe.refOrganisation','=', $request->refOrganisation]
         ])
        ->first();
        if ($maxid) {
            $idmax= $maxid->code_entete;
        }

        //'id','refEnteteGroup','id_vente','id_reservation','active','author','refUser'

        $detailData = $request->detailData;
        //$data['qteVente']

        foreach ($detailData as $data) {

            $active = "OUI";

            $data2 = tvente_detail_facture_groupe::create([
                'refEnteteGroup'       =>  $idmax,
                'id_vente'       =>  $data['id_vente'],  
                //'id_reservation'       =>  $data['id_reservation'],            
                'active'    =>  $active,
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser
           ]);

           $montant_group = 0;
           $reduction_group = 0;
           $totaltva_group = 0;
           $paie_group = 0; 

           $data99=DB::table('tvente_entete_vente')
           ->select('id','code','refClient','refService','refReservation','module_id',
            'dateVente','libelle','serveur_id','table_id','etat_facture','montant','paie','reduction',
            'date_paie_current','nombre_print','totaltva','author','refUser')
           ->where([
              ['tvente_entete_vente.id','=', $data['id_vente']]
           ])      
           ->first();
           if ($data99) 
           { 
                $montant_group = $data99->montant;
                $reduction_group = $data99->reduction;
                $totaltva_group = $data99->totaltva;
                $paie_group = $data99->paie;        
           }    
           $data3 = DB::update(
                'update tvente_entete_facture_groupe set montant_group = montant_group + (:montant_group),reduction_group = reduction_group + :reduction_group,totaltva_group = totaltva_group + :totaltva_group,paie_group= paie_group + :paie_group where id = :id',
                ['montant_group' => $montant_group,'reduction_group' => $reduction_group,'totaltva_group' => $totaltva_group,'paie_group' => $paie_group,'id' => $idmax]
           );

        }

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }


    function insert_dataGlobalVenteCash(Request $request)
    {
        $module_id = 10;
        $current = Carbon::now(); 
        $formattedDate = $current->format('Y-m-d');
        $code = $this->GetCodeData('tvente_param_systeme','module_id',$module_id);

        $data1 = tvente_entete_facture_groupe::create([
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

        $idmax=0;
        $maxid = DB::table('tvente_entete_facture_groupe')       
        ->selectRaw('MAX(tvente_entete_facture_groupe.id) as code_entete')
        ->where([
            ['tvente_entete_facture_groupe.refUser', $request->refUser],
            ['tvente_entete_facture_groupe.refOrganisation','=', $request->refOrganisation]
         ])
        ->first();
        if ($maxid) {
            $idmax= $maxid->code_entete;
        }

        $active = "OUI";
        //'id','refEnteteGroup','id_vente','id_reservation','active','author','refUser'

        $detailData = $request->detailData;
        //$data['qteVente']

        foreach ($detailData as $data) {            

            $data2 = tvente_detail_facture_groupe::create([
                'refEnteteGroup'       =>  $idmax,
                'id_vente'       =>  $data['id_vente'],  
                // 'id_reservation'       =>  $data['id_reservation'],            
                'active'    =>  $active,
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser
           ]);

           $montant_group = 0;
           $reduction_group = 0;
           $totaltva_group = 0;
           $paie_group = 0; 

           $data99=DB::table('tvente_entete_vente')
           ->select('id','code','refClient','refService','refReservation','module_id',
            'dateVente','libelle','serveur_id','table_id','etat_facture','montant','paie','reduction',
            'date_paie_current','nombre_print','totaltva','author','refUser')
           ->where([
              ['tvente_entete_vente.id','=', $data['id_vente']]
           ])      
           ->first();
           if ($data99) 
           { 
                $montant_group = $data99->montant;
                $reduction_group = $data99->reduction;
                $totaltva_group = $data99->totaltva;
                $paie_group = $data99->paie;        
           }     
           $data3 = DB::update(
                'update tvente_entete_facture_groupe set montant_group = montant_group + (:montant_group),reduction_group = reduction_group + :reduction_group,totaltva_group = totaltva_group + :totaltva_group,paie_group= paie_group + :paie_group where id = :id',
                ['montant_group' => $montant_group,'reduction_group' => $reduction_group,'totaltva_group' => $totaltva_group,'paie_group' => $paie_group,'id' => $idmax]
           );

        }

                //PAIEMENT DE LA FACTURE ===================================================================
        
                $montants=0;
                $ventes = DB::table('tvente_entete_facture_groupe')
                ->selectRaw('(tvente_entete_facture_groupe.montant_group - tvente_entete_facture_groupe.reduction_group + tvente_entete_facture_groupe.totaltva_group) as montant')
                ->Where('id',$idmax)->first(); 
                if ($ventes) {
                    $montants = $ventes->montant;
                }
        
        
                $current = Carbon::now(); 
                $module_id_paie = 11; 
                $codepaie = $this->GetCodeData('tvente_param_systeme','module_id',$module_id_paie); 
        
               
                $data13 = tvente_entete_paiement_groupe::create([
                    'code'       =>  $codepaie,
                    'refFactureGroup'    =>  $idmax,
                    'module_id'    =>  $module_id_paie,
                    'datePaieGroup'    =>  $request->dateGroup,
                    'libelle_paie_group'    =>  'Paiement des Factures',                    
                    'author'       =>  $request->author,
                    'refUser'       =>  $request->refUser
                ]);
                
                $idmax_paie=0;
                $maxid = DB::table('tvente_entete_paiement_groupe')       
                ->selectRaw('MAX(tvente_entete_paiement_groupe.id) as code_entete')
                ->where([
                    ['tvente_entete_paiement_groupe.refUser', $request->refUser],
                    ['tvente_entete_paiement_groupe.refFactureGroup','=', $idmax]
                 ])
                ->first();
                if ($maxid) {
                    $idmax_paie= $maxid->code_entete;
                }
        
                $datetest='';
                $data3 = DB::table('tfin_cloture_caisse')
               ->select('date_cloture')
               ->where('date_cloture','=', $request->dateGroup)
               ->take(1)
               ->orderBy('id', 'desc')         
               ->get();    
               foreach ($data3 as $row) 
               {                           
                  $datetest=$row->date_cloture;          
               }
        
               if($datetest == $request->dateGroup)
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
                    ->first();                     
                    if ($data5) 
                    {                                
                        $taux=$data5->taux;                           
                    }
        
                    $modepaie = 'CASH';
                    $libellepaie = 'Paiement vente Cash';
                    $refBanque = 0;
                    $numeroBordereau = '0000000000';
        
                    $data44 = DB::table('tconf_banque')
                    ->select('id','nom_banque','numerocompte','nom_mode','refSscompte')
                    ->where('nom_mode','=', $modepaie)
                    ->get();    
                    foreach ($data44 as $row) 
                    {                           
                        $refBanque=$row->id;          
                    }
       
                    $data14 = tvente_detail_paiement_groupe::create([
                        'refEntetepaieGroup'       =>  $idmax_paie,
                        'refEnteteVenteGroup'       => $idmax,
                        'refBanque'       =>  $refBanque,
                        'montant_paie'    =>  $montants,
                        'devise'    =>  $devises,
                        'taux'    =>  $taux,
                        'date_paie'    =>  $request->dateGroup,
                        'modepaie'       =>  $modepaie,
                        'libellepaie'       =>  $libellepaie, 
                        'numeroBordereau'       =>  $numeroBordereau,
                        'author'       =>  $request->author,
                        'refUser'       =>  $request->refUser,
                        'active'       =>  $active
                    ]);
        
                    $data3 = DB::update(
                        'update tvente_entete_facture_groupe set paie_group = paie_group + (:paiement) where id = :refEnteteVente',
                        ['paiement' => $montants,'refEnteteVente' => $idmax]
                    );
       
                    $data999=DB::table('tvente_detail_facture_groupe')
                    ->select('id','refEnteteGroup','id_vente','id_reservation','active','author','refUser')                    
                    ->where([
                       ['tvente_detail_facture_groupe.refEnteteGroup','=', $idmax]
                    ])      
                    ->get();
                    foreach ($data999 as $row999) 
                    { 
                        $refEntetepaie=0; 
                        $module_id_paie_data = 5;                
                        $codepaie_data = $this->GetCodeData('tvente_param_systeme','module_id',$module_id_paie_data); 
                        $refService = 0; 

                        $montants=0;
                        $ventes_data = DB::table('tvente_entete_vente')
                        ->select('id','code','refClient','refService','refReservation','module_id',
                        'dateVente','libelle','serveur_id','table_id','etat_facture','montant','paie','reduction',
                        'totaltva','author','refUser')
                        ->selectRaw('(tvente_entete_vente.montant - tvente_entete_vente.reduction + tvente_entete_vente.totaltva) as montant')
                        ->Where('id',$row999->id_vente)
                        ->first(); 
                        if ($ventes_data) {
                            $montants = $ventes_data->montant;
                            $refService = $ventes_data->refService;
                        } 
                
                        $data15 = tvente_entete_paievente::create([
                            'code'       =>  $codepaie_data,
                            'date_entete_paie'    =>  $request->dateGroup,
                            'refService'    =>  $refService,
                            'module_id'    =>  $module_id_paie_data,
                            'author'       =>  $request->author,
                            'refUser'       =>  $request->refUser
                        ]);
                        
                        $idmax_paie_data=0;
                        $maxid_data = DB::table('tvente_entete_paievente')       
                        ->selectRaw('MAX(tvente_entete_paievente.id) as code_entete')
                        ->where([
                            ['tvente_entete_paievente.refUser','=', $request->refUser],
                            ['tvente_entete_paievente.refService','=', $refService]
                         ])
                        ->first();
                        if ($maxid_data) {
                            $idmax_paie_data= $maxid_data->code_entete;
                        }
                

                        $data16 = tvente_paiement::create([
                            'refEntetepaie'       =>  $idmax_paie_data,
                            'refEnteteVente'       => $row999->id_vente,
                            'montant_paie'    =>  $montants,
                            'devise'    =>  $devises,
                            'taux'    =>  $taux,
                            'date_paie'    =>  $current,
                            'modepaie'       =>  $modepaie,
                            'libellepaie'       =>  $libellepaie, 
                            'refBanque'       =>  $refBanque,
                            'numeroBordereau'       =>  $numeroBordereau,
                            'author'       =>  $request->author,
                            'refUser'       =>  $request->refUser,
                            'active'       =>  $active
                        ]);
            
                        $data17 = DB::update(
                            'update tvente_entete_vente set paie = paie + (:paiement) where id = :refEnteteVente',
                            ['paiement' => $montants,'refEnteteVente' => $row999->id_vente]
                        );       

     
                    } 
        
               }



        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }

    function insert_paiement_vente_cash(Request $request, $id)
    {
                $idmax = $id;
                $montants=0;
                $ventes = DB::table('tvente_entete_facture_groupe')
                ->selectRaw('(tvente_entete_facture_groupe.montant_group - tvente_entete_facture_groupe.reduction_group + tvente_entete_facture_groupe.totaltva_group) as montant')
                ->Where('id',$idmax)->first(); 
                if ($ventes) {
                    $montants = $ventes->montant;
                }
        
        
                $current = Carbon::now(); 
                $formattedDate = $current->format('Y-m-d');
                $module_id_paie = 11; 
                $codepaie = $this->GetCodeData('tvente_param_systeme','module_id',$module_id_paie); 
        
               
                $data13 = tvente_entete_paiement_groupe::create([
                    'code'       =>  $codepaie,
                    'refFactureGroup'    =>  $idmax,
                    'module_id'    =>  $module_id_paie,
                    'datePaieGroup'    =>  $current,
                    'libelle_paie_group'    =>  'Paiement des Factures',                    
                    'author'       =>  $request->author,
                    'refUser'       =>  $request->refUser
                ]);
                
                $idmax_paie=0;
                $maxid = DB::table('tvente_entete_paiement_groupe')       
                ->selectRaw('MAX(tvente_entete_paiement_groupe.id) as code_entete')
                ->where([
                    ['tvente_entete_paiement_groupe.refUser', $request->refUser],
                    ['tvente_entete_paiement_groupe.refFactureGroup','=', $idmax]
                 ])
                ->first();
                if ($maxid) {
                    $idmax_paie= $maxid->code_entete;
                }
        
                $datetest='';
                $data3 = DB::table('tfin_cloture_caisse')
               ->select('date_cloture')
               ->where('date_cloture','=', $formattedDate)
               ->take(1)
               ->orderBy('id', 'desc')         
               ->get();    
               foreach ($data3 as $row) 
               {                           
                  $datetest=$row->date_cloture;          
               }
        
               if($datetest == $formattedDate)
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
                    ->first();                     
                    if ($data5) 
                    {                                
                        $taux=$data5->taux;                           
                    }
        
                    $modepaie = 'CASH';
                    $libellepaie = 'Paiement vente Cash';
                    $refBanque = 0;
                    $numeroBordereau = '0000000000';
        
                    $data44 = DB::table('tconf_banque')
                    ->select('id','nom_banque','numerocompte','nom_mode','refSscompte')
                    ->where('nom_mode','=', $modepaie)
                    ->get();    
                    foreach ($data44 as $row) 
                    {                           
                        $refBanque=$row->id;          
                    }
       
                    $data14 = tvente_detail_paiement_groupe::create([
                        'refEntetepaieGroup'       =>  $idmax_paie,
                        'refEnteteVenteGroup'       => $idmax,
                        'refBanque'       =>  $refBanque,
                        'montant_paie'    =>  $montants,
                        'devise'    =>  'USD',
                        'taux'    =>  $taux,
                        'date_paie'    =>  $current,
                        'modepaie'       =>  $modepaie,
                        'libellepaie'       =>  $libellepaie, 
                        'numeroBordereau'       =>  $numeroBordereau,
                        'author'       =>  $request->author,
                        'refUser'       =>  $request->refUser,
                        'active'       =>  'OUI'
                    ]);
        
                    $data3 = DB::update(
                        'update tvente_entete_facture_groupe set paie_group = paie_group + (:paiement) where id = :refEnteteVente',
                        ['paiement' => $montants,'refEnteteVente' => $idmax]
                    );
       
                    $data999=DB::table('tvente_detail_facture_groupe')
                    ->select('id','refEnteteGroup','id_vente','id_reservation','active','author','refUser')                    
                    ->where([
                       ['tvente_detail_facture_groupe.refEnteteGroup','=', $idmax]
                    ])      
                    ->get();
                    foreach ($data999 as $row999) 
                    { 
                        $refEntetepaie=0; 
                        $module_id_paie_data = 5;                
                        $codepaie_data = $this->GetCodeData('tvente_param_systeme','module_id',$module_id_paie_data); 
                        $refService = 0; 

                        $montant_vente=0;
                        $ventes_data = DB::table('tvente_entete_vente')
                        ->select('id','code','refClient','refService','refReservation','module_id',
                        'dateVente','libelle','serveur_id','table_id','etat_facture','montant','paie','reduction',
                        'totaltva','author','refUser')
                        ->selectRaw('(tvente_entete_vente.montant - tvente_entete_vente.reduction + tvente_entete_vente.totaltva) as montant')
                        ->Where('id',$row999->id_vente)
                        ->get(); 
                        foreach ($ventes_data as $data_paies) {
                            $montant_vente = $data_paies->montant;
                            $refService = $data_paies->refService;

                            $data15 = tvente_entete_paievente::create([
                                'code'       =>  $codepaie_data,
                                'date_entete_paie'    =>  $current,
                                'refService'    =>  $refService,
                                'module_id'    =>  $module_id_paie_data,
                                'author'       =>  $request->author,
                                'refUser'       =>  $request->refUser
                            ]);
                            
                            $idmax_paie_data=0;
                            $maxid_data = DB::table('tvente_entete_paievente')       
                            ->selectRaw('MAX(tvente_entete_paievente.id) as code_entete')
                            ->where([
                                ['tvente_entete_paievente.refUser','=', $request->refUser],
                                ['tvente_entete_paievente.refService','=', $refService]
                             ])
                            ->first();
                            if ($maxid_data) {
                                $idmax_paie_data= $maxid_data->code_entete;
                            }
                    
                            $refEnteteVente = 0;
                            if ($row999->id_vente === null) {
                                $refEnteteVente = 0;
                            } else {
                                $refEnteteVente = $row999->id_vente;
                            }
    
                            $data16 = tvente_paiement::create([
                                'refEntetepaie'       =>  $idmax_paie_data,
                                'refEnteteVente'       => $refEnteteVente,
                                'montant_paie'    =>  $montant_vente,
                                'devise'    =>  'USD',
                                'taux'    =>  $taux,
                                'date_paie'    =>  $current,
                                'modepaie'       =>  $modepaie,
                                'libellepaie'       =>  $libellepaie, 
                                'refBanque'       =>  $refBanque,
                                'numeroBordereau'       =>  $numeroBordereau,
                                'author'       =>  $request->author,
                                'refUser'       =>  $request->refUser,
                                'active'       =>  'OUI'
                            ]);
                
                            $data17 = DB::update(
                                'update tvente_entete_vente set paie = paie + (:paiement) where id = :refEnteteVente',
                                ['paiement' => $montant_vente,'refEnteteVente' => $row999->id_vente]
                            );       
    

                        } 
                

     
                    } 


                    foreach ($data999 as $row901) 
                    { 
                        $montant_res=0;
                        $ventes_data = DB::table('thotel_reservation_chambre')
                        ->select('thotel_reservation_chambre.id','refClient','refChmabre','id_prise_charge','date_entree','date_sortie',
                        'heure_debut','heure_sortie','libelle','prix_unitaire','reduction','observation',
                        'type_reservation','nom_accompagner','pays_provenance',
                        'thotel_reservation_chambre.author','thotel_reservation_chambre.created_at')
                        ->selectRaw('TIMESTAMPDIFF(DAY, date_entree, date_sortie) as NombreJour')
                        ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))) as prixTotalChambre')
                        ->selectRaw('IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0) as totalFacture')
                        ->selectRaw('IFNULL(totalPaie,0) as totalPaie')
                        ->selectRaw('(IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0)) as RestePaie')
                        ->Where('thotel_reservation_chambre.id',$row901->id_reservation)
                        ->get(); 
                        foreach ($ventes_data as $date_paie) {
                            $montant_res = $date_paie->RestePaie;


                            $refReservation = 0;
                            if ($row901->id_reservation === null) {
                                $refReservation = 0;
                            } else {
                                $refReservation = $row901->id_reservation;
                            }
                            $data15 = thotel_paiement_chambre::create([
                                'refReservation'       =>  $refReservation,            
                                'montant_paie'    =>  $montant_res,
                                'devise'    =>  'USD',
                                'taux'    =>  $taux,
                                'modepaie'       =>  $modepaie,
                                'libellepaie'       =>  $libellepaie, 
                                'refBanque'       =>  $refBanque,
                                'numeroBordereau'       =>  $numeroBordereau,
                                'date_paie'       =>  $current,
                                'author'       =>  $request->author,
                                'refUser'       =>  $request->refUser
                            ]);
                            
                
                            $data17 = DB::update(
                                'update thotel_reservation_chambre set totalPaie = totalPaie + (:paiement) where id = :refReservation',
                                ['paiement' => $montant_res,'refReservation' => $row901->id_reservation]
                            );       
    

                        } 
                

     
                    } 
        
               }



        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }


    function insert_dataGlobalHotelCash(Request $request)
    {
        $module_id = 10;
        $current = Carbon::now(); 
        $formattedDate = $current->format('Y-m-d');
        $code = $this->GetCodeData('tvente_param_systeme','module_id',$module_id);

        $data1 = tvente_entete_facture_groupe::create([
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

        $idmax=0;
        $maxid = DB::table('tvente_entete_facture_groupe')       
        ->selectRaw('MAX(tvente_entete_facture_groupe.id) as code_entete')
        ->where([
            ['tvente_entete_facture_groupe.refUser', $request->refUser],
            ['tvente_entete_facture_groupe.refOrganisation','=', $request->refOrganisation]
         ])
        ->first();
        if ($maxid) {
            $idmax= $maxid->code_entete;
        }

        //'id','refEnteteGroup','id_vente','id_reservation','active','author','refUser'

        $detailData = $request->detailData;
        //$data['qteVente']

        foreach ($detailData as $data) {

            $active = "OUI";

            $data2 = tvente_detail_facture_groupe::create([
                'refEnteteGroup'       =>  $idmax,
                // 'id_vente'       =>  $data['id_vente'],  
                'id_reservation'       =>  $data['id_reservation'],            
                'active'    =>  $active,
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser
           ]);

           $montant_group = 0;
           $reduction_group = 0;
           $totaltva_group = 0;
           $paie_group = 0; 

           $data99=DB::table('thotel_reservation_chambre')
           ->select('thotel_reservation_chambre.id','refClient','refChmabre','id_prise_charge','date_entree','date_sortie',
           'heure_debut','heure_sortie','libelle','prix_unitaire','reduction','observation',
           'type_reservation','nom_accompagner','pays_provenance',
           'thotel_reservation_chambre.author','thotel_reservation_chambre.created_at')
           ->selectRaw('TIMESTAMPDIFF(DAY, date_entree, date_sortie) as NombreJour')
           ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))) as prixTotalChambre')
           ->selectRaw('IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0) as totalFacture')
           ->selectRaw('IFNULL(totalPaie,0) as totalPaie')
           ->selectRaw('(IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0)) as RestePaie')
           ->where([
              ['thotel_reservation_chambre.id','=', $data['id_reservation']]
           ])      
           ->first();
           if ($data99) 
           {
                $montant_group = $data99->totalFacture;
                $reduction_group = $data99->reduction;
                $totaltva_group = 0;
                $paie_group = $data99->totalPaie;        
           }    
           $data3 = DB::update(
                'update tvente_entete_facture_groupe set montant_group = montant_group + (:montant_group),reduction_group = reduction_group + :reduction_group,totaltva_group = totaltva_group + :totaltva_group,paie_group= paie_group + :paie_group where id = :id',
                ['montant_group' => $montant_group,'reduction_group' => $reduction_group,'totaltva_group' => $totaltva_group,'paie_group' => $paie_group,'id' => $idmax]
           );

        }

            //PAIEMENT DE LA FACTURE ===================================================================
        
                $montants=0;
                $ventes = DB::table('tvente_entete_facture_groupe')
                ->selectRaw('(tvente_entete_facture_groupe.montant_group - tvente_entete_facture_groupe.reduction_group + tvente_entete_facture_groupe.totaltva_group) as montant')
                ->Where('id',$idmax)
                ->first(); 
                if ($ventes) {
                    $montants = $ventes->montant;
                }
        
                $current = Carbon::now(); 
                $module_id_paie = 11; 
                $codepaie = $this->GetCodeData('tvente_param_systeme','module_id',$module_id_paie); 
        
               
                $data13 = tvente_entete_paiement_groupe::create([
                    'code'       =>  $codepaie,
                    'refFactureGroup'    =>  $idmax,
                    'module_id'    =>  $module_id_paie,
                    'datePaieGroup'    =>  $request->dateGroup,
                    'libelle_paie_group'    =>  'Paiement des Factures',                    
                    'author'       =>  $request->author,
                    'refUser'       =>  $request->refUser
                ]);
                
                $idmax_paie=0;
                $maxid = DB::table('tvente_entete_paiement_groupe')       
                ->selectRaw('MAX(tvente_entete_paiement_groupe.id) as code_entete')
                ->where([
                    ['tvente_entete_paiement_groupe.refUser', $request->refUser],
                    ['tvente_entete_paiement_groupe.refFactureGroup','=', $idmax]
                 ])
                ->first();
                if ($maxid) {
                    $idmax_paie= $maxid->code_entete;
                }
        
                $datetest='';
                $data3 = DB::table('tfin_cloture_caisse')
               ->select('date_cloture')
               ->where('date_cloture','=', $request->dateGroup)
               ->take(1)
               ->orderBy('id', 'desc')         
               ->get();    
               foreach ($data3 as $row) 
               {                           
                  $datetest=$row->date_cloture;          
               }
        
               if($datetest == $request->dateGroup)
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
                    ->first();                     
                    if ($data5) 
                    {                                
                        $taux=$data5->taux;                           
                    }
        
                    $modepaie = 'CASH';
                    $libellepaie = 'Paiement vente Cash';
                    $refBanque = 0;
                    $numeroBordereau = '0000000000';
        
                    $data44 = DB::table('tconf_banque')
                    ->select('id','nom_banque','numerocompte','nom_mode','refSscompte')
                    ->where('nom_mode','=', $modepaie)
                    ->get();    
                    foreach ($data44 as $row) 
                    {                           
                        $refBanque=$row->id;          
                    }
       
                    $data14 = tvente_detail_paiement_groupe::create([
                        'refEntetepaieGroup'       =>  $idmax_paie,
                        'refEnteteVenteGroup'       => $idmax,
                        'refBanque'       =>  $refBanque,
                        'montant_paie'    =>  $montants,
                        'devise'    =>  'USD',
                        'taux'    =>  $taux,
                        'date_paie'    =>  $request->dateGroup,
                        'modepaie'       =>  $modepaie,
                        'libellepaie'       =>  $libellepaie, 
                        'numeroBordereau'       =>  $numeroBordereau,
                        'author'       =>  $request->author,
                        'refUser'       =>  $request->refUser,
                        'active'       =>  $active
                    ]);
        
                    $data18 = DB::update(
                        'update tvente_entete_facture_groupe set paie_group = paie_group + (:paiement) where id = :refEnteteVente',
                        ['paiement' => $montants,'refEnteteVente' => $idmax]
                    );
       
                    $data999 = DB::table('tvente_detail_facture_groupe')
                    ->select('id','refEnteteGroup','id_vente','id_reservation','active','author','refUser')                    
                    ->where([
                       ['tvente_detail_facture_groupe.refEnteteGroup','=', $idmax]
                    ])      
                    ->get();
                    foreach ($data999 as $row999) 
                    { 
                        $montant_res=0;
                        $ventes_data = DB::table('thotel_reservation_chambre')
                        ->select('thotel_reservation_chambre.id','refClient','refChmabre','id_prise_charge','date_entree','date_sortie',
                        'heure_debut','heure_sortie','libelle','prix_unitaire','reduction','observation',
                        'type_reservation','nom_accompagner','pays_provenance',
                        'thotel_reservation_chambre.author','thotel_reservation_chambre.created_at')
                        ->selectRaw('TIMESTAMPDIFF(DAY, date_entree, date_sortie) as NombreJour')
                        ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))) as prixTotalChambre')
                        ->selectRaw('IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0) as totalFacture')
                        ->selectRaw('IFNULL(totalPaie,0) as totalPaie')
                        ->selectRaw('(IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0)) as RestePaie')
                        ->Where('thotel_reservation_chambre.id', $row999->id_reservation)
                        ->get(); 
                        foreach ($ventes_data as $row_paie) {
                            $montant_res = $row_paie->RestePaie;

                            $data15 = thotel_paiement_chambre::create([
                                'refReservation'       =>  $row999->id_reservation,            
                                'montant_paie'    =>  $montant_res,
                                'devise'    =>  'USD',
                                'taux'    =>  $taux,
                                'date_paie'       =>  $request->dateGroup,
                                'modepaie'       =>  'CASH',
                                'libellepaie'       =>  'Paiement reservation de la chambre', 
                                'refBanque'       =>  $refBanque,
                                'numeroBordereau'       =>  $numeroBordereau,                            
                                'author'       =>  $request->author,
                                'refUser'       =>  $request->refUser
                            ]);                       
                
                            $data17 = DB::update(
                                'update thotel_reservation_chambre set totalPaie = totalPaie + (:paiement) where id = :refReservation',
                                ['paiement' => $montant_res,'refReservation' => $row999->id_reservation]
                            ); 

                        }
     
                    } 
        
               }



        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }

    // function insert_paiement_hotel_cash(Request $request, $id)
    // {
    //             $idmax = $id;
    //             $montants=0;
    //             $ventes = DB::table('tvente_entete_facture_groupe')
    //             ->selectRaw('(tvente_entete_facture_groupe.montant_group - tvente_entete_facture_groupe.reduction_group + tvente_entete_facture_groupe.totaltva_group) as montant')
    //             ->Where('id',$idmax)
    //             ->first(); 
    //             if ($ventes) {
    //                 $montants = $ventes->montant;
    //             }        
        
    //             $current = Carbon::now(); 
    //             $formattedDate = $current->format('Y-m-d');
    //             $module_id_paie = 11; 
    //             $codepaie = $this->GetCodeData('tvente_param_systeme','module_id',$module_id_paie); 
        
               
    //             $data13 = tvente_entete_paiement_groupe::create([
    //                 'code'       =>  $codepaie,
    //                 'refFactureGroup'    =>  $idmax,
    //                 'module_id'    =>  $module_id_paie,
    //                 'datePaieGroup'    =>  $current,
    //                 'libelle_paie_group'    =>  'Paiement des Factures',                    
    //                 'author'       =>  $request->author,
    //                 'refUser'       =>  $request->refUser
    //             ]);
                
    //             $idmax_paie=0;
    //             $maxid = DB::table('tvente_entete_paiement_groupe')       
    //             ->selectRaw('MAX(tvente_entete_paiement_groupe.id) as code_entete')
    //             ->where([
    //                 ['tvente_entete_paiement_groupe.refUser', $request->refUser],
    //                 ['tvente_entete_paiement_groupe.refFactureGroup','=', $idmax]
    //              ])
    //             ->first();
    //             if ($maxid) {
    //                 $idmax_paie= $maxid->code_entete;
    //             }
        
    //             $datetest='';
    //             $data3 = DB::table('tfin_cloture_caisse')
    //            ->select('date_cloture')
    //            ->where('date_cloture','=', $formattedDate)
    //            ->take(1)
    //            ->orderBy('id', 'desc')         
    //            ->get();    
    //            foreach ($data3 as $row) 
    //            {                           
    //               $datetest=$row->date_cloture;          
    //            }
        
    //            if($datetest == $formattedDate)
    //            {
    //                 return response()->json([
    //                     'data'  =>  "La Caisse est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
    //                 ]);            
    //            }
    //            else
    //            {
    //                 $taux=0;
    //                 $data5 =  DB::table("tvente_taux")
    //                 ->select("tvente_taux.id", "tvente_taux.taux", 
    //                 "tvente_taux.created_at", "tvente_taux.author")
    //                 ->first();                     
    //                 if ($data5) 
    //                 {                                
    //                     $taux=$data5->taux;                           
    //                 }
        
    //                 $modepaie = 'CASH';
    //                 $libellepaie = 'Paiement vente Cash';
    //                 $refBanque = 0;
    //                 $numeroBordereau = '0000000000';
        
    //                 $data44 = DB::table('tconf_banque')
    //                 ->select('id','nom_banque','numerocompte','nom_mode','refSscompte')
    //                 ->where('nom_mode','=', $modepaie)
    //                 ->get();    
    //                 foreach ($data44 as $row) 
    //                 {                           
    //                     $refBanque=$row->id;          
    //                 }
       
    //                 $data14 = tvente_detail_paiement_groupe::create([
    //                     'refEntetepaieGroup'       =>  $idmax_paie,
    //                     'refEnteteVenteGroup'       => $idmax,
    //                     'refBanque'       =>  $refBanque,
    //                     'montant_paie'    =>  $montants,
    //                     'devise'    =>  'USD',
    //                     'taux'    =>  $taux,
    //                     'date_paie'    =>  $current,
    //                     'modepaie'       =>  $modepaie,
    //                     'libellepaie'       =>  $libellepaie, 
    //                     'numeroBordereau'       =>  $numeroBordereau,
    //                     'author'       =>  $request->author,
    //                     'refUser'       =>  $request->refUser,
    //                     'active'       =>  $active
    //                 ]);
        
    //                 $data3 = DB::update(
    //                     'update tvente_entete_facture_groupe set paie_group = paie_group + (:paiement) where id = :refEnteteVente',
    //                     ['paiement' => $montants,'refEnteteVente' => $idmax]
    //                 );
       
    //                 $data999=DB::table('tvente_detail_facture_groupe')
    //                 ->select('id','refEnteteGroup','id_vente','id_reservation','active','author','refUser')                    
    //                 ->where([
    //                    ['tvente_detail_facture_groupe.refEnteteGroup','=', $idmax]
    //                 ])      
    //                 ->get();
    //                 foreach ($data999 as $row999) 
    //                 { 
    //                     $montants=0;
    //                     $ventes_data = DB::table('thotel_reservation_chambre')
    //                     ->select('thotel_reservation_chambre.id','refClient','refChmabre','id_prise_charge','date_entree','date_sortie',
    //                     'heure_debut','heure_sortie','libelle','prix_unitaire','reduction','observation',
    //                     'type_reservation','nom_accompagner','pays_provenance',
    //                     'thotel_reservation_chambre.author','thotel_reservation_chambre.created_at')
    //                     ->selectRaw('TIMESTAMPDIFF(DAY, date_entree, date_sortie) as NombreJour')
    //                     ->selectRaw('(((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))) as prixTotalChambre')
    //                     ->selectRaw('IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0) as totalFacture')
    //                     ->selectRaw('IFNULL(totalPaie,0) as totalPaie')
    //                     ->selectRaw('(IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-reduction),0)-IFNULL(totalPaie,0)) as RestePaie')
    //                     ->Where('thotel_reservation_chambre.id',$row999->id_reservation)
    //                     ->first(); 
    //                     if ($ventes_data) {
    //                         $montants = $ventes_data->RestePaie;
    //                     } 
                
    //                     $data15 = thotel_paiement_chambre::create([
    //                         'refReservation'       =>  $row999->id_reservation,            
    //                         'montant_paie'    =>  $montants,
    //                         'devise'    =>  $devises,
    //                         'taux'    =>  $taux,
    //                         'modepaie'       =>  $modepaie,
    //                         'libellepaie'       =>  $libellepaie, 
    //                         'refBanque'       =>  $refBanque,
    //                         'numeroBordereau'       =>  $numeroBordereau,
    //                         'date_paie'       =>  $current,
    //                         'author'       =>  $request->author,
    //                         'refUser'       =>  $request->refUser
    //                     ]);
                        
            
    //                     $data17 = DB::update(
    //                         'update thotel_reservation_chambre set totalPaie = totalPaie + (:paiement) where id = :refReservation',
    //                         ['paiement' => $montants,'refReservation' => $row999->id_reservation]
    //                     );       

     
    //                 } 
        
    //            }



    //     return response()->json([
    //         'data'  =>  "Insertion avec succès!!!",
    //     ]);
       
    // }





}
