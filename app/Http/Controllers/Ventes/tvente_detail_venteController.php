<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_detail_vente;
use App\Models\Ventes\tvente_mouvement_stock;
use App\Models\Ventes\tvente_entete_vente;
use App\Models\Ventes\tvente_paiement;
use App\Models\Ventes\tvente_entete_paievente;
use App\Models\Hotel\thotel_reservation_chambre;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tvente_detail_venteController extends Controller
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

        $data = DB::table('tvente_detail_vente')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')

        ->join('tfin_ssouscompte as comptevente','comptevente.id','=','tvente_categorie_produit.compte_vente')
        ->join('tfin_ssouscompte as comptevariation','comptevariation.id','=','tvente_categorie_produit.compte_variationstock')
        ->join('tfin_ssouscompte as compteperte','compteperte.id','=','tvente_categorie_produit.compte_perte')
        ->join('tfin_ssouscompte as compteproduit','compteproduit.id','=','tvente_categorie_produit.compte_produit')
        ->join('tfin_ssouscompte as comptedestockage','comptedestockage.id','=','tvente_categorie_produit.compte_destockage')

        ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tvente_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte as compteclient','compteclient.id','=','tvente_categorie_client.compte_client')

        ->select('tvente_detail_vente.id','refEnteteVente','refProduit','tvente_detail_vente.compte_vente',
        'tvente_detail_vente.compte_variationstock','tvente_detail_vente.compte_perte','tvente_detail_vente.compte_produit',
        'tvente_detail_vente.compte_destockage','puVente','qteVente','uniteVente','puBase','qteBase',
        'tvente_detail_vente.uniteBase','cmupVente','tvente_detail_vente.devise',
        'tvente_detail_vente.taux','montantreduction',
        'tvente_detail_vente.active','tvente_detail_vente.author','tvente_detail_vente.refUser',
        'tvente_detail_vente.created_at','idStockService','date_paie_current',

        'tvente_produit.designation','tvente_produit.refCategorie','tvente_produit.refUniteBase',
        'tvente_produit.pu','tvente_produit.qte','tvente_produit.cmup','tvente_produit.taux',
        'tvente_produit.Oldcode','tvente_produit.Newcode','tvente_produit.tvaapplique',
        'tvente_produit.estvendable',
        
        'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        "tvente_categorie_client.designation as CategorieClient","compte_client",'compteclient.refSousCompte',
        'compteclient.nom_ssouscompte','compteclient.numero_ssouscompte',

        'nom_service', "tvente_module.nom_module",'tvente_entete_vente.code','refClient','refService','refReservation',
        'module_id','dateVente','libelle','tvente_entete_vente.montant','tvente_entete_vente.paie','reduction','totaltva',

        'comptevente.refSousCompte as refSousCompteVente','comptevente.nom_ssouscompte as nom_ssouscompteVente',
        'comptevente.numero_ssouscompte as numero_ssouscompteVente'
        ,'comptevariation.refSousCompte as refSousCompteVariation','comptevariation.nom_ssouscompte as nom_ssouscompteVariation',
        'comptevariation.numero_ssouscompte as numero_ssouscompteVariation'
        ,'compteperte.refSousCompte as refSousComptePerte','compteperte.nom_ssouscompte as nom_ssouscomptePerte',
        'compteperte.numero_ssouscompte as numero_ssouscomptePerte'
        ,'compteproduit.refSousCompte as refSousCompteProduit','compteproduit.nom_ssouscompte as nom_ssouscompteProduit',
        'compteproduit.numero_ssouscompte as numero_ssouscompteProduit'
        ,'comptedestockage.refSousCompte as refSousCompteDestockage','comptedestockage.nom_ssouscompte as nom_ssouscompteDestockage',
        'comptedestockage.numero_ssouscompte as numero_ssouscompteDestockage','priseencharge'
       )
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tvente_detail_vente.taux) as PTVenteFC')
       ->selectRaw('(qteBase*puBase) as PTBase')
       ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0),2) as totalFacture')
       ->selectRaw('IFNULL(paie,0) as totalPaie')
       ->selectRaw('ROUND((IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0) - IFNULL(paie,0)),2) as RestePaie');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_vente.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_detail_vente.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }

    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tvente_detail_vente')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')

        // ->join('tfin_ssouscompte as comptevente','comptevente.id','=','tvente_categorie_produit.compte_vente')
        // ->join('tfin_ssouscompte as comptevariation','comptevariation.id','=','tvente_categorie_produit.compte_variationstock')
        // ->join('tfin_ssouscompte as compteperte','compteperte.id','=','tvente_categorie_produit.compte_perte')
        // ->join('tfin_ssouscompte as compteproduit','compteproduit.id','=','tvente_categorie_produit.compte_produit')
        // ->join('tfin_ssouscompte as comptedestockage','comptedestockage.id','=','tvente_categorie_produit.compte_destockage')

        ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tvente_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte as compteclient','compteclient.id','=','tvente_categorie_client.compte_client')

        ->select('tvente_detail_vente.id','refEnteteVente','refProduit','tvente_detail_vente.compte_vente',
        'tvente_detail_vente.compte_variationstock','tvente_detail_vente.compte_perte','tvente_detail_vente.compte_produit',
        'tvente_detail_vente.compte_destockage','puVente','qteVente','uniteVente','puBase','qteBase',
        'tvente_detail_vente.uniteBase','cmupVente','tvente_detail_vente.devise',
        'tvente_detail_vente.taux','montantreduction',
        'tvente_detail_vente.active','tvente_detail_vente.author','tvente_detail_vente.refUser',
        'tvente_detail_vente.created_at','idStockService','date_paie_current',

        'tvente_produit.designation','tvente_produit.refCategorie','tvente_produit.refUniteBase',
        'tvente_produit.pu','tvente_produit.qte','tvente_produit.cmup','tvente_produit.taux',
        'tvente_produit.Oldcode','tvente_produit.Newcode','tvente_produit.tvaapplique',
        'tvente_produit.estvendable',
        
        'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        "tvente_categorie_client.designation as CategorieClient","compte_client",'compteclient.refSousCompte',
        'compteclient.nom_ssouscompte','compteclient.numero_ssouscompte',

        'nom_service', "tvente_module.nom_module",'tvente_entete_vente.code','refClient','refService','refReservation','module_id',
        'dateVente','libelle','tvente_entete_vente.montant','tvente_entete_vente.paie','reduction','totaltva',

        // 'comptevente.refSousCompte as refSousCompteVente','comptevente.nom_ssouscompte as nom_ssouscompteVente',
        // 'comptevente.numero_ssouscompte as numero_ssouscompteVente'
        // ,'comptevariation.refSousCompte as refSousCompteVariation','comptevariation.nom_ssouscompte as nom_ssouscompteVariation',
        // 'comptevariation.numero_ssouscompte as numero_ssouscompteVariation'
        // ,'compteperte.refSousCompte as refSousComptePerte','compteperte.nom_ssouscompte as nom_ssouscomptePerte',
        // 'compteperte.numero_ssouscompte as numero_ssouscomptePerte'
        // ,'compteproduit.refSousCompte as refSousCompteProduit','compteproduit.nom_ssouscompte as nom_ssouscompteProduit',
        // 'compteproduit.numero_ssouscompte as numero_ssouscompteProduit'
        // ,'comptedestockage.refSousCompte as refSousCompteDestockage','comptedestockage.nom_ssouscompte as nom_ssouscompteDestockage',
        // 'comptedestockage.numero_ssouscompte as numero_ssouscompteDestockage',
        'priseencharge'
       )
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tvente_detail_vente.taux) as PTVenteFC')
       ->selectRaw('(qteBase*puBase) as PTBase')
       ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0),2) as totalFacture')
       ->selectRaw('IFNULL(paie,0) as totalPaie')
       ->selectRaw('ROUND((IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0) - IFNULL(paie,0)),2) as RestePaie')
        ->Where('refEnteteVente',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_vente.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_detail_vente.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }  

    function fetch_single_data($id)
    {
        $data= DB::table('tvente_detail_vente')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')

        ->join('tfin_ssouscompte as comptevente','comptevente.id','=','tvente_categorie_produit.compte_vente')
        ->join('tfin_ssouscompte as comptevariation','comptevariation.id','=','tvente_categorie_produit.compte_variationstock')
        ->join('tfin_ssouscompte as compteperte','compteperte.id','=','tvente_categorie_produit.compte_perte')
        ->join('tfin_ssouscompte as compteproduit','compteproduit.id','=','tvente_categorie_produit.compte_produit')
        ->join('tfin_ssouscompte as comptedestockage','comptedestockage.id','=','tvente_categorie_produit.compte_destockage')

        ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tvente_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte as compteclient','compteclient.id','=','tvente_categorie_client.compte_client')

        ->select('tvente_detail_vente.id','refEnteteVente','refProduit','tvente_detail_vente.compte_vente',
        'tvente_detail_vente.compte_variationstock','tvente_detail_vente.compte_perte','tvente_detail_vente.compte_produit',
        'tvente_detail_vente.compte_destockage','puVente','qteVente','uniteVente','puBase','qteBase',
        'tvente_detail_vente.uniteBase','cmupVente','tvente_detail_vente.devise',
        'tvente_detail_vente.taux','montantreduction','date_paie_current',
        'tvente_detail_vente.active','tvente_detail_vente.author','tvente_detail_vente.refUser',
        'tvente_detail_vente.created_at','idStockService',

        'tvente_produit.designation','tvente_produit.refCategorie','tvente_produit.refUniteBase',
        'tvente_produit.pu','tvente_produit.qte','tvente_produit.cmup','tvente_produit.taux',
        'tvente_produit.Oldcode','tvente_produit.Newcode','tvente_produit.tvaapplique',
        'tvente_produit.estvendable',
        
        'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        "tvente_categorie_client.designation as CategorieClient","compte_client",'compteclient.refSousCompte',
        'compteclient.nom_ssouscompte','compteclient.numero_ssouscompte',

        'nom_service', "tvente_module.nom_module",'tvente_entete_vente.code','refClient','refService','refReservation','module_id',
        'dateVente','libelle','tvente_entete_vente.montant','tvente_entete_vente.paie','reduction','totaltva',

        'comptevente.refSousCompte as refSousCompteVente','comptevente.nom_ssouscompte as nom_ssouscompteVente',
        'comptevente.numero_ssouscompte as numero_ssouscompteVente'
        ,'comptevariation.refSousCompte as refSousCompteVariation','comptevariation.nom_ssouscompte as nom_ssouscompteVariation',
        'comptevariation.numero_ssouscompte as numero_ssouscompteVariation'
        ,'compteperte.refSousCompte as refSousComptePerte','compteperte.nom_ssouscompte as nom_ssouscomptePerte',
        'compteperte.numero_ssouscompte as numero_ssouscomptePerte'
        ,'compteproduit.refSousCompte as refSousCompteProduit','compteproduit.nom_ssouscompte as nom_ssouscompteProduit',
        'compteproduit.numero_ssouscompte as numero_ssouscompteProduit'
        ,'comptedestockage.refSousCompte as refSousCompteDestockage','comptedestockage.nom_ssouscompte as nom_ssouscompteDestockage',
        'comptedestockage.numero_ssouscompte as numero_ssouscompteDestockage','priseencharge'
       )
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction + montanttva),2) as PTVenteTTC')
       ->selectRaw('ROUND(montanttva,2) as montanttva')
       ->selectRaw('((qteVente*puVente)/tvente_detail_vente.taux) as PTVenteFC')
       ->selectRaw('(qteBase*puBase) as PTBase')
       ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0),2) as totalFacture')
       ->selectRaw('IFNULL(paie,0) as totalPaie')
       ->selectRaw('ROUND((IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0) - IFNULL(paie,0)),2) as RestePaie')
        ->where('tvente_detail_vente.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_detail_facture($id)
    {      

        $data = DB::table('tvente_detail_vente')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')

        ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tvente_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_vente.refService')
        ->join('tvente_client','tvente_client.id','=','tvente_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
        ->join('tfin_ssouscompte as compteclient','compteclient.id','=','tvente_categorie_client.compte_client')

        ->join('tfin_ssouscompte as comptevente','comptevente.id','=','tvente_categorie_produit.compte_vente')
        ->join('tfin_ssouscompte as comptevariation','comptevariation.id','=','tvente_categorie_produit.compte_variationstock')
        ->join('tfin_ssouscompte as compteperte','compteperte.id','=','tvente_categorie_produit.compte_perte')
        ->join('tfin_ssouscompte as compteproduit','compteproduit.id','=','tvente_categorie_produit.compte_produit')
        ->join('tfin_ssouscompte as comptedestockage','comptedestockage.id','=','tvente_categorie_produit.compte_destockage')
      

        ->select('tvente_detail_vente.id','refEnteteVente','refProduit','tvente_detail_vente.compte_vente',
        'tvente_detail_vente.compte_variationstock','tvente_detail_vente.compte_perte','tvente_detail_vente.compte_produit',
        'tvente_detail_vente.compte_destockage','puVente','qteVente','uniteVente','puBase','qteBase',
        'tvente_detail_vente.uniteBase','cmupVente','tvente_detail_vente.devise','tvente_detail_vente.taux',
        'montanttva','montantreduction',
        'tvente_detail_vente.active','tvente_detail_vente.author','tvente_detail_vente.refUser',
        'tvente_detail_vente.created_at','idStockService',
        //Produit
        'tvente_produit.designation','tvente_produit.refCategorie','tvente_produit.refUniteBase',
        'tvente_produit.pu','tvente_produit.qte','tvente_produit.cmup','tvente_produit.taux',
        'tvente_produit.Oldcode','tvente_produit.Newcode','tvente_produit.tvaapplique',
        'tvente_produit.estvendable',
        //client 
        'noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug','tvente_client.author',
        "tvente_categorie_client.designation as CategorieClient","compte_client",'compteclient.refSousCompte',
        'compteclient.nom_ssouscompte','compteclient.numero_ssouscompte',
        //ente vente
        'nom_service', "tvente_module.nom_module",'tvente_entete_vente.code','refClient','refService','refReservation','module_id',
        'dateVente','libelle','tvente_entete_vente.montant','tvente_entete_vente.paie','reduction','totaltva',
        //compte produit
        'comptevente.refSousCompte as refSousCompteVente','comptevente.nom_ssouscompte as nom_ssouscompteVente',
        'comptevente.numero_ssouscompte as numero_ssouscompteVente'
        ,'comptevariation.refSousCompte as refSousCompteVariation','comptevariation.nom_ssouscompte as nom_ssouscompteVariation',
        'comptevariation.numero_ssouscompte as numero_ssouscompteVariation'
        ,'compteperte.refSousCompte as refSousComptePerte','compteperte.nom_ssouscompte as nom_ssouscomptePerte',
        'compteperte.numero_ssouscompte as numero_ssouscomptePerte'
        ,'compteproduit.refSousCompte as refSousCompteProduit','compteproduit.nom_ssouscompte as nom_ssouscompteProduit',
        'compteproduit.numero_ssouscompte as numero_ssouscompteProduit'
        ,'comptedestockage.refSousCompte as refSousCompteDestockage','comptedestockage.nom_ssouscompte as nom_ssouscompteDestockage',
        'comptedestockage.numero_ssouscompte as numero_ssouscompteDestockage','priseencharge')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) - IFNULL(reduction,0)),0),2) as totalFacture')
       ->selectRaw('ROUND((totaltva),2) as TotalTVA')
       ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0),2) as PTTTC')
       ->selectRaw('((qteVente*puVente)/tvente_detail_vente.taux) as PTVenteFC')
       ->selectRaw('ROUND((IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(reduction,0)),0) - IFNULL(paie,0)),2) as RestePaie')
       ->selectRaw("DATE_FORMAT(date_paie_current,'%d/%M/%Y') as date_paie_current")
       ->selectRaw('(qteBase*puBase) as PTBase')
       ->selectRaw('IFNULL(paie,0) as totalPaie')       
       ->Where('tvente_detail_vente.refEnteteVente',$id)               
       ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_detail_facture_chambre($id)
    {      

        $data = DB::table('tvente_detail_vente')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_vente.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')

        ->join('tvente_entete_vente','tvente_entete_vente.id','=','tvente_detail_vente.refEnteteVente')        
        ->join('tvente_module','tvente_module.id','=','tvente_entete_vente.module_id')
        ->join('tvente_services','tvente_services.id','=','tvente_entete_vente.refService')
        ->join('tvente_client as clientVente','clientVente.id','=','tvente_entete_vente.refClient')

        ->join('thotel_reservation_chambre','thotel_reservation_chambre.id','=','tvente_entete_vente.refReservation')
        ->join('thotel_chambre','thotel_chambre.id','=','thotel_reservation_chambre.refChmabre')
        ->join('thotel_classe_chambre','thotel_classe_chambre.id','=','thotel_chambre.refClasse') 
        ->join('tvente_client as clientHotel','clientHotel.id','=','thotel_reservation_chambre.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','clientHotel.refCategieClient')

        ->select('tvente_detail_vente.id','refEnteteVente','refProduit','tvente_detail_vente.compte_vente',
        'tvente_detail_vente.compte_variationstock','tvente_detail_vente.compte_perte','tvente_detail_vente.compte_produit',
        'tvente_detail_vente.compte_destockage','puVente','qteVente','uniteVente','puBase','qteBase',
        'tvente_detail_vente.uniteBase','cmupVente','tvente_detail_vente.devise as deviseVente','tvente_detail_vente.taux',
        'montanttva','montantreduction',
        'tvente_detail_vente.active','tvente_detail_vente.author','tvente_detail_vente.refUser',
        'tvente_detail_vente.created_at','idStockService',
        //Produit
        'tvente_produit.designation','tvente_produit.refCategorie','tvente_produit.refUniteBase',
        'tvente_produit.pu','tvente_produit.qte','tvente_produit.cmup','tvente_produit.taux',
        'tvente_produit.Oldcode','tvente_produit.Newcode','tvente_produit.tvaapplique',
        'tvente_produit.estvendable',
        //Client Vente
        'clientVente.noms as nomsVente','clientVente.sexe as sexeVente','clientVente.contact as contactVente',
        'clientVente.mail as mailVente','clientVente.adresse as adresseVente',
        //client Hotel
        'clientHotel.noms','clientHotel.sexe','clientHotel.contact','clientHotel.mail','clientHotel.adresse',
        'clientHotel.pieceidentite','clientHotel.numeroPiece','clientHotel.dateLivrePiece',
        'clientHotel.lieulivraisonCarte','clientHotel.nationnalite','clientHotel.datenaissance',
        'clientHotel.lieunaissance','clientHotel.profession','clientHotel.occupation',
        'clientHotel.nombreEnfant','clientHotel.dateArriverGoma','clientHotel.arriverPar',
        'clientHotel.refCategieClient','clientHotel.photo','clientHotel.slug',
        "tvente_categorie_client.designation as CategorieClient","compte_client",
        //ente vente
        'nom_service', "tvente_module.nom_module",'tvente_entete_vente.code',
        'tvente_entete_vente.refClient as idClientVente','tvente_entete_vente.refService',
        'tvente_entete_vente.refReservation','tvente_entete_vente.module_id',
        'tvente_entete_vente.dateVente','tvente_entete_vente.libelle as libelleVente','tvente_entete_vente.montant',
        'tvente_entete_vente.paie','tvente_entete_vente.reduction as reductionVente','tvente_entete_vente.totaltva',
        //compte produit
        'priseencharge',
       
       
       'thotel_reservation_chambre.refClient','refChmabre',
        'heure_debut','heure_sortie','thotel_reservation_chambre.libelle as libelleChambre','prix_unitaire',
        'thotel_reservation_chambre.reduction as reductionChambre','observation',
        'type_reservation','nom_accompagner','pays_provenance',
        'thotel_reservation_chambre.author','thotel_reservation_chambre.devise as deviseChambre',
        'thotel_reservation_chambre.taux','tvente_categorie_client.designation as CategorieClient', 
        "thotel_chambre.nom_chambre","numero_chambre","refClasse", "thotel_classe_chambre.designation as ClasseChambre",
        "thotel_classe_chambre.prix_chambre"
       
       )
       ->selectRaw('TIMESTAMPDIFF(DAY, date_entree, date_sortie) as NombreJour')
       ->selectRaw('(IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-thotel_reservation_chambre.reduction),0)-IFNULL(totalPaie,0)) as RestePaieChambre')
       ->selectRaw('IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-thotel_reservation_chambre.reduction),0) as totalFactureChambre')
       ->selectRaw('ROUND(((qteVente*puVente) - montantreduction),2) as PTVente')
       ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) - IFNULL(tvente_entete_vente.reduction,0)),0),2) as totalFacture')
       ->selectRaw('ROUND((totaltva),2) as TotalTVA')
       ->selectRaw('ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(tvente_entete_vente.reduction,0)),0),2) as PTTTC')
       ->selectRaw('((qteVente*puVente)/tvente_detail_vente.taux) as PTVenteFC')
       ->selectRaw('ROUND((IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(tvente_entete_vente.reduction,0)),0) - IFNULL(paie,0)),2) as RestePaie')
       ->selectRaw("DATE_FORMAT(date_paie_current,'%d/%M/%Y') as date_paie_current")
       ->selectRaw("DATE_FORMAT(date_entree,'%d/%M/%Y') as date_entree")
       ->selectRaw("DATE_FORMAT(date_sortie,'%d/%M/%Y') as date_sortie")
       ->selectRaw("DATE_FORMAT(thotel_reservation_chambre.created_at,'%d/%M/%Y') as dateReservation")
       ->selectRaw('(qteBase*puBase) as PTBase')
       ->selectRaw('IFNULL(paie,0) as totalPaie')  
       ->selectRaw('((IFNULL((((TIMESTAMPDIFF(DAY, date_entree, date_sortie))*(prix_unitaire))-thotel_reservation_chambre.reduction),0)) + (ROUND(IFNULL((IFNULL(montant,0) + IFNULL(totaltva,0) - IFNULL(tvente_entete_vente.reduction,0)),0),2))) as TotalGeneral')      
       ->Where('tvente_entete_vente.refReservation',$id)               
       ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    public function ventesParMois($annee = null)
    {
        $annee = $annee ?? Carbon::now()->year;

        $ventes = DB::table('tvente_entete_vente')
            ->selectRaw("DATE_FORMAT(dateVente, '%M') as mois, SUM(montant) as total_ventes")
            ->whereYear('dateVente', $annee)
            ->groupByRaw("MONTH(dateVente), DATE_FORMAT(dateVente, '%M')")
            ->orderByRaw("MONTH(dateVente)")
            ->get();

        return response()->json($ventes);
    }

    function insert_data(Request $request)
    {
        $current = Carbon::now();
        $active = "OUI";

        $taux=0;
        $data5 =  DB::table("tvente_taux")
        ->select("tvente_taux.id", "tvente_taux.taux", 
        "tvente_taux.created_at", "tvente_taux.author")
         ->first(); 
         $output='';
         if ($data5) 
         {                                
            $taux=$data5->taux;                           
         }

        $dateVente=0;
        $data_entete =  DB::table("tvente_entete_vente")
        ->select("tvente_entete_vente.id", "tvente_entete_vente.dateVente")
        ->where([
            ['tvente_entete_vente.id','=', $request->refEnteteVente]
        ])
        ->first(); 
         if ($data_entete) 
         {                                
            $dateVente=$data_entete->dateVente;                           
         }
        
        $cmup_data = floatval($this->calculerCoutMoyen($request->idStockService, $dateVente, $dateVente));

        $montants=0;
        $devises='';
        if($request->devise != 'USD')
        {
            $montants = ($request->puVente)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puVente;
            $devises = $request->devise;
        }  


            
            $refProduit=0;
            $data99=DB::table('tvente_stock_service') 
            ->select('id','refService','refProduit','pu','qte','uniteBase','cmup',
            'devise','taux','active','refUser','author')
            ->where([
                ['tvente_stock_service.id','=', $request->idStockService]
            ])      
            ->first();
            if ($data99) 
            {
                $refProduit =  $data99->refProduit;
            }



            $qte=$request->qteVente;
            $idDetail=$refProduit;
            $idFacture=$request->refEnteteVente;

            $compte_achat = 0;
            $compte_vente =0;
            $compte_variationstock=0;
            $compte_perte=0;
            $compte_produit=0;
            $compte_destockage=0;
            $compte_stockage=0;
            $cmupVente = $cmup_data;

            $data3=DB::table('tvente_produit')
            ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
            ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
            'compte_perte','compte_produit','compte_destockage','compte_stockage','cmup')
            ->where([
                ['tvente_produit.id','=', $refProduit]
            ])      
            ->first();
            if ($data3) 
            {
                $compte_achat =  $data3->compte_achat;
                $compte_vente = $data3->compte_vente;
                $compte_variationstock= $data3->compte_variationstock;
                $compte_perte= $data3->compte_perte;
                $compte_produit= $data3->compte_produit;
                $compte_destockage= $data3->compte_destockage;
                $compte_stockage= $data3->compte_stockage;       
            }

            $uniteVente = '';
            $uniteBase = '';
            $puBase=0;
            $qteBase=0;
            $estunite='';
            $cmupVente = $cmup_data;

            $uniteVente = $request->nom_unite;
            $uniteBase = $request->nom_unite;           
            $qteBase =  1;
            $puBase = $montants;      
            $estunite = 'OUI';

            $qteVente = $qteBase * floatval($request->qteVente);
            if($estunite = "OUI")
            {
              $puBase=  floatval($montants);
            }
            else
            {
              $puBase=  floatval($montants) / floatval($qteBase);
            }
            
        $montanttva=0;
        $pourtageTVA=0;

        $data5=DB::table('tvente_tva')     
        ->select('montant_tva')
        ->where([
            ['tvente_tva.id','=', $request->id_tva],
            ['tvente_tva.active','=', 'OUI']
        ])      
        ->first();
        if ($data5) 
        {
            $pourtageTVA = $data5->montant_tva;
        }

        $montanttva = (((floatval($request->qteVente) * floatval($montants))*floatval($pourtageTVA))/100);

            $data = tvente_detail_vente::create([
                'refEnteteVente'       =>  $request->refEnteteVente,
                'refProduit'    =>  $refProduit,
                'qteVente'    =>  $request->qteVente,            
                'montantreduction'    =>  $request->montantreduction,  
                'idStockService'    =>  $request->idStockService,                     
                'author'       =>  $request->author,
                'refUser'    =>  $request->refUser,

                'active'    =>  $active,
                'uniteVente'    =>  $uniteVente,
                'compte_vente'    =>  $compte_vente,
                'compte_variationstock'    =>  $compte_variationstock,
                'compte_perte'    =>  $compte_perte,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                'puVente'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'puBase'    =>  $puBase,
                'qteBase'    =>  $qteBase,
                'uniteBase'    =>  $uniteBase,
                'cmupVente'    =>  $cmup_data,
                'montanttva'    =>  $montanttva,
            ]);

            $id_detail_max=0;
            $detail_list = DB::table('tvente_detail_vente')       
            ->selectRaw('MAX(id) as code_entete')
            ->where([
                ['refUser','=', $request->refUser],
                ['idStockService','=', $request->idStockService]
            ]) 
            ->get();
            foreach ($detail_list as $list) {
                $id_detail_max= $list->code_entete;
            }
        
            $data99 = tvente_mouvement_stock::create([             
                'idStockService'    =>  $request->idStockService,             
                'dateMvt'    =>   $current,   
                'type_mouvement'    =>  'Sortie',
                'libelle_mouvement'    =>  'Vente des Produits',
                'nom_table'    =>  'tvente_detail_vente',
                'id_data'    =>  $id_detail_max, 
                'qteMvt'    =>  $request->qteVente,
                'puMvt'    =>  $montants,                   
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'type_sortie'    =>  'Sortie',

                'active'    =>  $active,
                'uniteMvt'    =>  $uniteVente,
                'compte_vente'    =>  $compte_vente,
                'compte_variationstock'    =>  $compte_variationstock,
                'compte_perte'    =>  $compte_perte,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                'compte_achat'    =>  $compte_achat,
                'compte_stockage'    =>  $compte_stockage,
                //'puVente'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'puBase'    =>  $puBase,
                'qteBase'    =>  $qteBase,
                'uniteBase'    =>  $uniteBase,
                'cmupMvt'    =>  $cmup_data
            ]); 

            $data2 = DB::update(
                'update tvente_stock_service set qte = qte - :qteVente where id = :idStockService',
                ['qteVente' => $qteVente,'idStockService' => $request->idStockService]
            );

            $data3 = DB::update(
                'update tvente_entete_vente set montant = montant + (:pu * :qte),reduction = reduction + :reduction,totaltva = totaltva + :totaltva where id = :refEnteteVente',
                ['pu' => $montants,'qte' => $request->qteVente,'reduction' => $request->montantreduction,'totaltva' => $montanttva,'refEnteteVente' => $request->refEnteteVente]
            );

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {

        $puVente=0;
        $qteVente=0;
        $qteBase=0;
        $montanttvaDeleted = 0;
        $montantreductionDeleted = 0;

        $deleted =  DB::table("tvente_detail_vente")
        ->select('id','refEnteteVente','refProduit','compte_vente','compte_variationstock',
        'compte_perte','compte_produit','compte_destockage','puVente','qteVente','uniteVente','puBase','qteBase',
        'uniteBase','cmupVente','devise','taux','montanttva','montantreduction','active','priseencharge',
        'idStockService','author','refUser')
        ->where([
            ['tvente_detail_vente.id','=', $id]
         ])
         ->first();
         if ($deleted) 
         {
            $puVente = $deleted->puVente;
            $qteVente = $deleted->qteVente;
            $qteBase = $deleted->qteBase; 
            $montanttvaDeleted = $deleted->montanttva;
            $montantreductionDeleted = $deleted->montantreduction;                     
         }
         $qteDeleted = floatval($qteVente) * floatval($qteBase);
         $montantDeleted = floatval($qteVente) * floatval($puVente);

        $active = "OUI";

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
            $montants = ($request->puVente)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puVente;
            $devises = $request->devise;
        }  


        $cmup_data = 0;
        $refProduit=0;
        $data99=DB::table('tvente_stock_service') 
        ->select('id','refService','refProduit','pu','qte','uniteBase','cmup',
        'devise','taux','active','refUser','author')
        ->where([
            ['tvente_stock_service.id','=', $request->idStockService]
        ])      
        ->first();
        if ($data99) 
        {
            $refProduit =  $data99->refProduit; 
            $cmup_data =  $data99->cmup;           
        }



            $qte=$request->qteVente;
            $idDetail=$refProduit;
            $idFacture=$request->refEnteteVente;

            $compte_achat = 0;
            $compte_vente =0;
            $compte_variationstock=0;
            $compte_perte=0;
            $compte_produit=0;
            $compte_destockage=0;
            $compte_stockage=0;

            $data3=DB::table('tvente_produit')
            ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
            ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
            'compte_perte','compte_produit','compte_destockage','compte_stockage','cmup')
            ->where([
                ['tvente_produit.id','=', $refProduit]
            ])      
            ->get();
            foreach ($data3 as $row) 
            {
                $compte_achat =  $row->compte_achat;
                $compte_vente = $row->compte_vente;
                $compte_variationstock= $row->compte_variationstock;
                $compte_perte= $row->compte_perte;
                $compte_produit= $row->compte_produit;
                $compte_destockage= $row->compte_destockage;
                $compte_stockage= $row->compte_stockage; 
            }

            $uniteVente = '';
            $uniteBase = '';
            $puBase=0;
            $qteBase=0;
            $estunite='';
            $cmupVente=0;

            $uniteVente = $request->nom_unite;
            $uniteBase = $request->nom_unite;           
            $qteBase =  1;
            $puBase = $montants;      
            $estunite = 'OUI';
            $cmupVente = $cmup_data; 

            $qteVente = $qteBase * floatval($request->qteVente);
            if($estunite = "OUI")
            {
            $puBase=  floatval($montants);
            }
            else
            {
            $puBase=  floatval($montants) / floatval($qteBase);
            }
            
        $montanttva=0;
        $pourtageTVA=0;

        $data5=DB::table('tvente_tva')     
        ->select('montant_tva')
        ->where([
            ['tvente_tva.id','=', $request->id_tva],
            ['tvente_tva.active','=', 'OUI']
        ])      
        ->get();
        foreach ($data5 as $row) 
        {
            $pourtageTVA = $row->montant_tva;
        }

        $montanttva = (((floatval($request->qteVente) * floatval($montants))*floatval($pourtageTVA))/100);

            $data = tvente_detail_vente::where('id', $id)->update([
                'refEnteteVente'       =>  $request->refEnteteVente,
                'refProduit'    =>  $refProduit,
                'qteVente'    =>  $request->qteVente,            
                'montantreduction'    =>  $request->montantreduction,  
                'idStockService'    =>  $request->idStockService,                     
                'author'       =>  $request->author,
                'refUser'    =>  $request->refUser,

                'active'    =>  $active,
                'uniteVente'    =>  $uniteVente,
                'compte_vente'    =>  $compte_vente,
                'compte_variationstock'    =>  $compte_variationstock,
                'compte_perte'    =>  $compte_perte,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                'puVente'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'puBase'    =>  $puBase,
                'qteBase'    =>  $qteBase,
                'uniteBase'    =>  $uniteBase,
                'cmupVente'    =>  $cmupVente,
                'montanttva'    =>  $montanttva,
            ]);

      
            $data99 = tvente_mouvement_stock::where([['id_data','=', $id],['nom_table','=','tvente_detail_vente']])->update([             
                'idStockService'    =>  $request->idStockService,             
                'dateMvt'    =>   $request->dateVente,   
                'type_mouvement'    =>  'Sortie',
                'libelle_mouvement'    =>  'Vente des Produits',
                'qteMvt'    =>  $request->qteVente,
                'puMvt'    =>  $montants,                   
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'type_sortie'    =>  'Sortie',

                'active'    =>  $active,
                'uniteMvt'    =>  $uniteVente,
                'compte_vente'    =>  $compte_vente,
                'compte_variationstock'    =>  $compte_variationstock,
                'compte_perte'    =>  $compte_perte,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                // 'compte_achat'    =>  $compte_achat,
                // 'compte_stockage'    =>  $compte_stockage,
                // 'puVente'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'puBase'    =>  $puBase,
                'qteBase'    =>  $qteBase,
                'uniteBase'    =>  $uniteBase,
                'cmupMvt'    =>  $cmupVente
            ]); 

            $data2 = DB::update(
                'update tvente_stock_service set qte = qte + :qteDeleted - :qteVente where id = :idStockService',
                ['qteDeleted' => $qteDeleted,'qteVente' => $qteVente,'idStockService' => $request->idStockService]
            );

            $data3 = DB::update(
                'update tvente_entete_vente set montant = montant - :montantDeleted + (:pu * :qte),reduction = reduction - :montantreductionDeleted + :reduction,totaltva = totaltva - :montanttvaDeleted + :totaltva where id = :refEnteteVente',
                ['montantDeleted' => $montantDeleted,'pu' => $montants,'qte' => $request->qteVente,'montantreductionDeleted' => $montantreductionDeleted,'reduction' => $request->montantreduction,'montanttvaDeleted' => $montanttvaDeleted,'totaltva' => $montanttva,'refEnteteVente' => $request->refEnteteVente]
            );

        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $qte=0;
        $idProduit=0;
        $idFacture=0;
        $pu=0;
        $montantreduction=0;
        $montanttva=0;

        $deleteds = DB::table('tvente_detail_vente')->Where('id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $qte = $deleted->qteVente;            
            $pu = $deleted->puVente;
            $idProduit = $deleted->refProduit;
            $idFacture = $deleted->refEnteteVente;
            $montantreduction = $deleted->montantreduction;
            $montanttva = $deleted->montanttva;
        }

        $refService=0;
        

        $data33=DB::table('tvente_entete_vente') 
         ->select('id','code','refClient','refService','refReservation','module_id','dateVente',
         'libelle','montant','paie','author','refUser')
         ->where([
            ['tvente_entete_vente.id','=', $idFacture]
        ])      
        ->get();      
        $output='';
        foreach ($data33 as $row) 
        {
            $refService =  $row->refService;           
        }


        $data2 = DB::update(
            'update tvente_stock_service set qte = qte + :qteVente where refProduit = :refProduit and refService = :refService',
            ['qteVente' => $qte,'refProduit' => $idProduit,'refService' => $refService]
        );

        $data3 = DB::update(
            'update tvente_entete_vente set montant = montant + (:pu * :qte),reduction = reduction - :reduction, totaltva = totaltva - :totaltva where id = :refEnteteVente',
            ['pu' => $pu,'qte' => $qte,'reduction' => $montantreduction,'totaltva' => $montanttva,'refEnteteVente' => $idFacture]
        );

        $nom_table = 'tvente_detail_vente';

        $data4 = DB::update(
            'delete from tvente_mouvement_stock where tvente_mouvement_stock.id_data = :id and nom_table=:nom_table',
            ['id' => $id, 'nom_table' => $nom_table]
        );

        $data = tvente_detail_vente::where('id',$id)->delete();


              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }

    function insert_dataGlobal(Request $request)
    {
        $id_module = 4;
        $active = "OUI";

        $code = $this->GetCodeData('tvente_param_systeme','module_id',$id_module);
        $data11 = tvente_entete_vente::create([
            'code'       =>  $code,
            'refClient'       =>  $request->refClient,
            'refService'       =>  $request->refService,  
            'refReservation'       =>  0,          
            'module_id'       =>  $id_module,
            'dateVente'    =>  $request->dateVente,
            'libelle'    =>  $request->libelle,
            'serveur_id'    =>  $request->serveur_id,
            'table_id'    =>  $request->table_id,
            'etat_facture'    =>  $request->etat_facture,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);

        $idmax=0;
        $maxid = DB::table('tvente_entete_vente')       
        ->selectRaw('MAX(tvente_entete_vente.id) as code_entete')
        ->where([
            ['tvente_entete_vente.refUser','=', $request->refUser],
            ['tvente_entete_vente.refClient','=', $request->refClient]
         ])
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_entete;
        }

        $detailData = $request->detailData;

        foreach ($detailData as $data) {

            $cmup_data = floatval($this->calculerCoutMoyen($data['idStockService'], $request->dateVente, $request->dateVente));

            $active = "OUI";

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
                $montants = ($data['puVente'])/$taux;
                $devises='USD';
            }
            else
            {
                $montants = $data['puVente'];
                $devises = $request->devise;
            }  

         $cmup_data = 0;
         $refProduit=0;
         $data99=DB::table('tvente_stock_service') 
         ->select('id','refService','refProduit','pu','qte','uniteBase','cmup',
         'devise','taux','active','refUser','author')
         ->where([
            ['tvente_stock_service.id','=', $data['idStockService']]
         ])      
         ->get();
         foreach ($data99 as $row) 
         {
             $refProduit =  $row->refProduit;
             $cmup_data =  $row->cmup;           
         }



         $qte=$data['qteVente'];
         $idDetail=$refProduit;
         $idFacture=$idmax;
 
         $compte_achat = 0;
         $compte_vente =0;
         $compte_variationstock=0;
         $compte_perte=0;
         $compte_produit=0;
         $compte_destockage=0;
         $compte_stockage=0;
         $cmupVente=0;
 
         $data3=DB::table('tvente_produit')
          ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
          ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
          'compte_perte','compte_produit','compte_destockage','compte_stockage','cmup')
          ->where([
             ['tvente_produit.id','=', $refProduit]
         ])      
         ->get();
         foreach ($data3 as $row) 
         {
             $compte_achat =  $row->compte_achat;
             $compte_vente = $row->compte_vente;
             $compte_variationstock= $row->compte_variationstock;
             $compte_perte= $row->compte_perte;
             $compte_produit= $row->compte_produit;
             $compte_destockage= $row->compte_destockage;
             $compte_stockage= $row->compte_stockage; 
         }
 

 
         $uniteVente = '';
         $uniteBase = '';
         $puBase=0;
         $qteBase=0;
         $estunite='';
 
         $uniteVente = $data['nom_unite'];
         $uniteBase = $data['nom_unite'];           
         $qteBase =  1;
         $puBase = $montants;      
         $estunite = 'OUI';
         $cmupVente = $cmup_data; 
 
        $qteVente = $qteBase * floatval($data['qteVente']);
        if($estunite = "OUI")
        {
           $puBase=  floatval($montants);
        }
        else
        {
           $puBase=  floatval($montants) / floatval($qteBase);
        }
        
       $montanttva=0;
       $pourtageTVA=0;
 
       $data5=DB::table('tvente_tva')     
       ->select('montant_tva')
       ->where([
         ['tvente_tva.id','=', $data['id_tva']],
          ['tvente_tva.active','=', 'OUI']
       ])      
      ->get();
      foreach ($data5 as $row) 
      {
          $pourtageTVA = $row->montant_tva;
      }
         
         $montanttva = (((floatval($data['qteVente']) * floatval($montants))*floatval($pourtageTVA))/100);
    
            $data12 = tvente_detail_vente::create([
                'refEnteteVente'       =>  $idmax,
                'refProduit'    =>  $refProduit,
                'qteVente'    =>  $data['qteVente'],            
                'montantreduction'    =>  $data['montantreduction'],  
                'idStockService'    =>  $data['idStockService'],                     
                'author'       =>  $request->author,
                'refUser'    =>  $request->refUser,
    
                'active'    =>  $active,
                'uniteVente'    =>  $uniteVente,
                'compte_vente'    =>  $compte_vente,
                'compte_variationstock'    =>  $compte_variationstock,
                'compte_perte'    =>  $compte_perte,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                'puVente'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'puBase'    =>  $puBase,
                'qteBase'    =>  $qteBase,
                'uniteBase'    =>  $uniteBase,
                'cmupVente'    =>  $cmup_data,
                'montanttva'    =>  $montanttva,
            ]);

            $id_detail_max=0;
            $detail_list = DB::table('tvente_detail_vente')       
            ->selectRaw('MAX(id) as code_entete')
            ->where([
                ['refUser','=', $request->refUser],
                ['idStockService','=', $data['idStockService']]
             ]) 
            ->get();
            foreach ($detail_list as $list) {
                $id_detail_max= $list->code_entete;
            }
          
            $data99 = tvente_mouvement_stock::create([             
                'idStockService'    =>  $data['idStockService'],             
                'dateMvt'    =>   $request->dateVente,   
                'type_mouvement'    =>  'Sortie',
                'libelle_mouvement'    =>  'Vente des Produits',
                'nom_table'    =>  'tvente_detail_vente',
                'id_data'    =>  $id_detail_max, 
                'qteMvt'    =>  $data['qteVente'],
                'puMvt'    =>  $montants,                   
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'type_sortie'    =>  'Sortie',
    
                'active'    =>  $active,
                'uniteMvt'    =>  $uniteVente,
                'compte_vente'    =>  $compte_vente,
                'compte_variationstock'    =>  $compte_variationstock,
                'compte_perte'    =>  $compte_perte,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                'compte_achat'    =>  $compte_achat,
                'compte_stockage'    =>  $compte_stockage,
                'puVente'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'puBase'    =>  $puBase,
                'qteBase'    =>  $qteBase,
                'uniteBase'    =>  $uniteBase,
                'cmupMvt'    =>  $cmupVente
            ]); 
    
            $data2 = DB::update(
                'update tvente_stock_service set qte = qte - :qteVente where id = :idStockService',
                ['qteVente' => $qteVente,'idStockService' => $data['idStockService']]
            );
    
            $data3 = DB::update(
                'update tvente_entete_vente set montant = montant + (:pu * :qte),reduction = reduction + :reduction,totaltva = totaltva + :totaltva where id = :refEnteteVente',
                ['pu' => $montants,'qte' => $data['qteVente'],'reduction' => $data['montantreduction'],'totaltva' => $montanttva,'refEnteteVente' => $idmax]
            );

        }

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }

    function insert_dataGlobalGros(Request $request)
    {
        $id_module = 4;
        $active = "OUI";

        $code = $this->GetCodeData('tvente_param_systeme','module_id',$id_module);
        $data11 = tvente_entete_vente::create([
            'code'       =>  $code,
            'refClient'       =>  $request->refClient,
            'refService'       =>  $request->refService,  
            'refReservation'       =>  0,          
            'module_id'       =>  $id_module,
            'dateVente'    =>  $request->dateVente,
            'libelle'    =>  $request->libelle,
            'serveur_id'    =>  $request->serveur_id,
            'table_id'    =>  $request->table_id,
            'etat_facture'    =>  $request->etat_facture,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);

        $idmax=0;
        $maxid = DB::table('tvente_entete_vente')       
        ->selectRaw('MAX(tvente_entete_vente.id) as code_entete')
        ->where([
            ['tvente_entete_vente.refUser','=', $request->refUser],
            ['tvente_entete_vente.refClient','=', $request->refClient]
         ])
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_entete;
        }

        $detailData = $request->detailData;

        foreach ($detailData as $data) {

            $cmup_data = floatval($this->calculerCoutMoyen($data['idStockService'], $request->dateVente, $request->dateVente));

            $active = "OUI";

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
                $montants = ($data['puVente'])/$taux;
                $devises='USD';
            }
            else
            {
                $montants = $data['puVente'];
                $devises = $request->devise;
            }  

         $cmup_data = 0;
         $refProduit=0;
         $data99=DB::table('tvente_stock_service') 
         ->select('id','refService','refProduit','pu','qte','uniteBase','cmup',
         'devise','taux','active','refUser','author')
         ->where([
            ['tvente_stock_service.id','=', $data['idStockService']]
         ])      
         ->get();
         foreach ($data99 as $row) 
         {
             $refProduit =  $row->refProduit;
             $cmup_data =  $row->cmup;           
         }



         $qte=$data['qteVente'];
         $idDetail=$refProduit;
         $idFacture=$idmax;
 
         $compte_achat = 0;
         $compte_vente =0;
         $compte_variationstock=0;
         $compte_perte=0;
         $compte_produit=0;
         $compte_destockage=0;
         $compte_stockage=0;
         $cmupVente=0;
 
         $data3=DB::table('tvente_produit')
          ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
          ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
          'compte_perte','compte_produit','compte_destockage','compte_stockage','cmup')
          ->where([
             ['tvente_produit.id','=', $refProduit]
         ])      
         ->get();
         foreach ($data3 as $row) 
         {
             $compte_achat =  $row->compte_achat;
             $compte_vente = $row->compte_vente;
             $compte_variationstock= $row->compte_variationstock;
             $compte_perte= $row->compte_perte;
             $compte_produit= $row->compte_produit;
             $compte_destockage= $row->compte_destockage;
             $compte_stockage= $row->compte_stockage; 
         }
 

 
         $uniteVente = '';
         $uniteBase = '';
         $puBase=0;
         $qteBase=0;
         $estunite='';

        $data_unite=DB::table('tvente_detail_unite')
        ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_unite.refProduit') 
        ->select('tvente_detail_unite.id','refProduit','refUnite','puUnite','qteUnite','puBase','qteBase','estunite',
        'tvente_detail_unite.active','tvente_detail_unite.author','tvente_detail_unite.refUser',
        'nom_unite','uniteBase')
        ->where([
           ['tvente_detail_unite.id','=', $data['refDetailUnite']]
        ])      
        ->first();       
           
        if ($data_unite) 
        {
            $uniteVente = $data_unite->nom_unite;
            $uniteBase = $data_unite->uniteBase;           
            $qteBase=$data_unite->qteBase;
            $puBase=$data_unite->puBase;      
            $estunite=$data_unite->estunite;
        }

 
        $cmupVente = $cmup_data; 
 
        $qteVente = $qteBase * floatval($data['qteVente']);
        if($estunite = "OUI")
        {
           $puBase=  floatval($montants);
        }
        else
        {
           $puBase=  floatval($montants) / floatval($qteBase);
        }
        
       $montanttva=0;
       $pourtageTVA=0;
 
       $data5=DB::table('tvente_tva')     
       ->select('montant_tva')
       ->where([
         ['tvente_tva.id','=', $data['id_tva']],
          ['tvente_tva.active','=', 'OUI']
       ])      
      ->get();
      foreach ($data5 as $row) 
      {
          $pourtageTVA = $row->montant_tva;
      }
         
         $montanttva = (((floatval($data['qteVente']) * floatval($montants))*floatval($pourtageTVA))/100);
    
            $data12 = tvente_detail_vente::create([
                'refEnteteVente'       =>  $idmax,
                'refProduit'    =>  $refProduit,
                'qteVente'    =>  $data['qteVente'],            
                'montantreduction'    =>  $data['montantreduction'],  
                'idStockService'    =>  $data['idStockService'],                     
                'author'       =>  $request->author,
                'refUser'    =>  $request->refUser,
    
                'active'    =>  $active,
                'uniteVente'    =>  $uniteVente,
                'compte_vente'    =>  $compte_vente,
                'compte_variationstock'    =>  $compte_variationstock,
                'compte_perte'    =>  $compte_perte,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                'puVente'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'puBase'    =>  $puBase,
                'qteBase'    =>  $qteBase,
                'uniteBase'    =>  $uniteBase,
                'cmupVente'    =>  $cmup_data,
                'montanttva'    =>  $montanttva,
            ]);

            $id_detail_max=0;
            $detail_list = DB::table('tvente_detail_vente')       
            ->selectRaw('MAX(id) as code_entete')
            ->where([
                ['refUser','=', $request->refUser],
                ['idStockService','=', $data['idStockService']]
             ]) 
            ->get();
            foreach ($detail_list as $list) {
                $id_detail_max= $list->code_entete;
            }
          
            $data99 = tvente_mouvement_stock::create([             
                'idStockService'    =>  $data['idStockService'],             
                'dateMvt'    =>   $request->dateVente,   
                'type_mouvement'    =>  'Sortie',
                'libelle_mouvement'    =>  'Vente des Produits',
                'nom_table'    =>  'tvente_detail_vente',
                'id_data'    =>  $id_detail_max, 
                'qteMvt'    =>  $data['qteVente'],
                'puMvt'    =>  $montants,                   
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'type_sortie'    =>  'Sortie',
    
                'active'    =>  $active,
                'uniteMvt'    =>  $uniteVente,
                'compte_vente'    =>  $compte_vente,
                'compte_variationstock'    =>  $compte_variationstock,
                'compte_perte'    =>  $compte_perte,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                'compte_achat'    =>  $compte_achat,
                'compte_stockage'    =>  $compte_stockage,
                'puVente'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'puBase'    =>  $puBase,
                'qteBase'    =>  $qteBase,
                'uniteBase'    =>  $uniteBase,
                'cmupMvt'    =>  $cmupVente
            ]); 
    
            $data2 = DB::update(
                'update tvente_stock_service set qte = qte - :qteVente where id = :idStockService',
                ['qteVente' => $qteVente,'idStockService' => $data['idStockService']]
            );
    
            $data3 = DB::update(
                'update tvente_entete_vente set montant = montant + (:pu * :qte),reduction = reduction + :reduction,totaltva = totaltva + :totaltva where id = :refEnteteVente',
                ['pu' => $montants,'qte' => $data['qteVente'],'reduction' => $data['montantreduction'],'totaltva' => $montanttva,'refEnteteVente' => $idmax]
            );

        }

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }


    function insert_dataGlobalCash(Request $request)
    {
        $id_module = 4;
        $active = "OUI";

        $code = $this->GetCodeData('tvente_param_systeme','module_id',$id_module);
        $data11 = tvente_entete_vente::create([
            'code'       =>  $code,
            'refClient'       =>  $request->refClient,
            'refService'       =>  $request->refService,  
            'refReservation'       =>  0,          
            'module_id'       =>  $id_module,
            'dateVente'    =>  $request->dateVente,
            'libelle'    =>  $request->libelle,
            'serveur_id'    =>  $request->serveur_id,
            'table_id'    =>  $request->table_id,
            'etat_facture'    =>  $request->etat_facture,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);

        $idmax=0;
        $maxid = DB::table('tvente_entete_vente')       
        ->selectRaw('MAX(tvente_entete_vente.id) as code_entete')
        ->where([
            ['tvente_entete_vente.refUser','=', $request->refUser],
            ['tvente_entete_vente.refClient','=', $request->refClient]
         ])
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_entete;
        }

        $detailData = $request->detailData;

        foreach ($detailData as $data) {

            $cmup_data = floatval($this->calculerCoutMoyen($data['idStockService'], $request->dateVente, $request->dateVente));

            $active = "OUI";

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
                $montants = ($data['puVente'])/$taux;
                $devises='USD';
            }
            else
            {
                $montants = $data['puVente'];
                $devises = $request->devise;
            }

            $refProduit=0;
            $data99=DB::table('tvente_stock_service') 
            ->select('id','refService','refProduit','pu','qte','uniteBase','cmup',
            'devise','taux','active','refUser','author')
            ->where([
               ['tvente_stock_service.id','=', $data['idStockService']]
            ])      
            ->get();
            foreach ($data99 as $row) 
            {
                $refProduit =  $row->refProduit; 
            }



         $qte=$data['qteVente'];
         $idDetail=$refProduit;
         $idFacture=$idmax;
 
         $compte_achat = 0;
         $compte_vente =0;
         $compte_variationstock=0;
         $compte_perte=0;
         $compte_produit=0;
         $compte_destockage=0;
         $compte_stockage=0;
         $cmupVente = $cmup_data;
 
         $data3=DB::table('tvente_produit')
          ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
          ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
          'compte_perte','compte_produit','compte_destockage','compte_stockage','cmup')
          ->where([
             ['tvente_produit.id','=', $refProduit]
         ])      
         ->get();
         foreach ($data3 as $row) 
         {
             $compte_achat =  $row->compte_achat;
             $compte_vente = $row->compte_vente;
             $compte_variationstock= $row->compte_variationstock;
             $compte_perte= $row->compte_perte;
             $compte_produit= $row->compte_produit;
             $compte_destockage= $row->compte_destockage;
             $compte_stockage= $row->compte_stockage;      
         }
 

 
         $uniteVente = '';
         $uniteBase = '';
         $puBase=0;
         $qteBase=0;
         $estunite='';
 
         $uniteVente = $data['nom_unite'];
         $uniteBase = $data['nom_unite'];           
         $qteBase =  1;
         $puBase = $montants;      
         $estunite = 'OUI';
         $cmupVente = $cmup_data; 
 
        $qteVente = $qteBase * floatval($data['qteVente']);
        if($estunite = "OUI")
        {
           $puBase=  floatval($montants);
        }
        else
        {
           $puBase=  floatval($montants) / floatval($qteBase);
        }
        
       $montanttva=0;
       $pourtageTVA=0;
 
       $data5=DB::table('tvente_tva')     
       ->select('montant_tva')
       ->where([
         ['tvente_tva.id','=', $data['id_tva']],
          ['tvente_tva.active','=', 'OUI']
       ])      
       ->get();
        foreach ($data5 as $row) 
        {
            $pourtageTVA = $row->montant_tva;
        }         
            $montanttva = (((floatval($data['qteVente']) * floatval($montants))*floatval($pourtageTVA))/100);
    
            $data12 = tvente_detail_vente::create([
                'refEnteteVente'       =>  $idmax,
                'refProduit'    =>  $refProduit,
                'qteVente'    =>  $data['qteVente'],            
                'montantreduction'    =>  $data['montantreduction'],  
                'idStockService'    =>  $data['idStockService'],                     
                'author'       =>  $request->author,
                'refUser'    =>  $request->refUser,
    
                'active'    =>  $active,
                'uniteVente'    =>  $uniteVente,
                'compte_vente'    =>  $compte_vente,
                'compte_variationstock'    =>  $compte_variationstock,
                'compte_perte'    =>  $compte_perte,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                'puVente'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'puBase'    =>  $puBase,
                'qteBase'    =>  $qteBase,
                'uniteBase'    =>  $uniteBase,
                'cmupVente'    =>  $cmup_data,
                'montanttva'    =>  $montanttva,
            ]);

            $id_detail_max=0;
            $detail_list = DB::table('tvente_detail_vente')       
            ->selectRaw('MAX(id) as code_entete')
            ->where([
                ['refUser','=', $request->refUser],
                ['idStockService','=', $data['idStockService']]
             ]) 
            ->get();
            foreach ($detail_list as $list) {
                $id_detail_max= $list->code_entete;
            }
          
            $data99 = tvente_mouvement_stock::create([             
                'idStockService'    =>  $data['idStockService'],             
                'dateMvt'    =>   $request->dateVente,   
                'type_mouvement'    =>  'Sortie',
                'libelle_mouvement'    =>  'Vente des Produits',
                'nom_table'    =>  'tvente_detail_vente',
                'id_data'    =>  $id_detail_max, 
                'qteMvt'    =>  $data['qteVente'],
                'puMvt'    =>  $montants,                   
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'type_sortie'    =>  'Sortie',
    
                'active'    =>  $active,
                'uniteMvt'    =>  $uniteVente,
                'compte_vente'    =>  $compte_vente,
                'compte_variationstock'    =>  $compte_variationstock,
                'compte_perte'    =>  0,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                'compte_achat'    =>  0,
                'compte_stockage'    =>  0,
                'puVente'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'puBase'    =>  $puBase,
                'qteBase'    =>  $qteBase,
                'uniteBase'    =>  $uniteBase,
                'cmupMvt'    =>  $cmup_data
            ]); 
    
            $data2 = DB::update(
                'update tvente_stock_service set qte = qte - :qteVente where id = :idStockService',
                ['qteVente' => $qteVente,'idStockService' => $data['idStockService']]
            );
    
            $data3 = DB::update(
                'update tvente_entete_vente set montant = montant + (:pu * :qte),reduction = reduction + :reduction,totaltva = totaltva + :totaltva where id = :refEnteteVente',
                ['pu' => $montants,'qte' => $data['qteVente'],'reduction' => $data['montantreduction'],'totaltva' => $montanttva,'refEnteteVente' => $idmax]
            );

        }

        //PAIEMENT DE LA FACTURE ===================================================================


        
        $montants=0;
        $ventes = DB::table('tvente_entete_vente')
        ->selectRaw('(tvente_entete_vente.montant - tvente_entete_vente.reduction + tvente_entete_vente.totaltva) as montant')
        ->Where('id',$idmax)->get(); 
        foreach ($ventes as $vente) {
            $montants = $vente->montant;
        }


        $current = Carbon::now(); 
        $refEntetepaie=0; 
        $refService = $request->refService;
        $module_id_paie = 5;      

        $codepaie = $this->GetCodeData('tvente_param_systeme','module_id',$module_id_paie); 

        $data13 = tvente_entete_paievente::create([
            'code'       =>  $codepaie,
            'date_entete_paie'    =>  $current,
            'refService'    =>  $refService,
            'module_id'    =>  $module_id_paie,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        
        $idmax_paie=0;
        $maxid = DB::table('tvente_entete_paievente')       
        ->selectRaw('MAX(tvente_entete_paievente.id) as code_entete')
        ->where([
            ['tvente_entete_paievente.refUser','=', $request->refUser],
            ['tvente_entete_paievente.refService','=', $refService]
         ])
        ->get();
        foreach ($maxid as $list) {
            $idmax_paie= $list->code_entete;
        }

        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', $request->dateVente)
       ->take(1)
       ->orderBy('id', 'desc')         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == $request->dateVente)
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

            $data14 = tvente_paiement::create([
                'refEntetepaie'       =>  $idmax_paie,
                'refEnteteVente'       => $idmax,
                'montant_paie'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'date_paie'    =>  $request->dateVente,
                'modepaie'       =>  $modepaie,
                'libellepaie'       =>  $libellepaie, 
                'refBanque'       =>  $refBanque,
                'numeroBordereau'       =>  $numeroBordereau,
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'active'       =>  $active
            ]);

            $data3 = DB::update(
                'update tvente_entete_vente set paie = paie + (:paiement) where id = :refEnteteVente',
                ['paiement' => $montants,'refEnteteVente' => $idmax]
            );       

       }

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }

    function insert_dataGlobalGrosCash(Request $request)
    {
        $id_module = 4;
        $active = "OUI";

        $code = $this->GetCodeData('tvente_param_systeme','module_id',$id_module);
        $data11 = tvente_entete_vente::create([
            'code'       =>  $code,
            'refClient'       =>  $request->refClient,
            'refService'       =>  $request->refService,  
            'refReservation'       =>  0,          
            'module_id'       =>  $id_module,
            'dateVente'    =>  $request->dateVente,
            'libelle'    =>  $request->libelle,
            'serveur_id'    =>  $request->serveur_id,
            'table_id'    =>  $request->table_id,
            'etat_facture'    =>  $request->etat_facture,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);

        $idmax=0;
        $maxid = DB::table('tvente_entete_vente')       
        ->selectRaw('MAX(tvente_entete_vente.id) as code_entete')
        ->where([
            ['tvente_entete_vente.refUser','=', $request->refUser],
            ['tvente_entete_vente.refClient','=', $request->refClient]
         ])
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_entete;
        }

        $detailData = $request->detailData;

        foreach ($detailData as $data) {

            $cmup_data = floatval($this->calculerCoutMoyen($data['idStockService'], $request->dateVente, $request->dateVente));

            $active = "OUI";

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
                $montants = ($data['puVente'])/$taux;
                $devises='USD';
            }
            else
            {
                $montants = $data['puVente'];
                $devises = $request->devise;
            }

            $refProduit=0;
            $data99=DB::table('tvente_stock_service') 
            ->select('id','refService','refProduit','pu','qte','uniteBase','cmup',
            'devise','taux','active','refUser','author')
            ->where([
               ['tvente_stock_service.id','=', $data['idStockService']]
            ])      
            ->get();
            foreach ($data99 as $row) 
            {
                $refProduit =  $row->refProduit; 
            }



         $qte=$data['qteVente'];
         $idDetail=$refProduit;
         $idFacture=$idmax;
 
         $compte_achat = 0;
         $compte_vente =0;
         $compte_variationstock=0;
         $compte_perte=0;
         $compte_produit=0;
         $compte_destockage=0;
         $compte_stockage=0;
         $cmupVente = $cmup_data;
 
         $data3=DB::table('tvente_produit')
          ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie') 
          ->select('compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
          'compte_perte','compte_produit','compte_destockage','compte_stockage','cmup')
          ->where([
             ['tvente_produit.id','=', $refProduit]
         ])      
         ->get();
         foreach ($data3 as $row) 
         {
             $compte_achat =  $row->compte_achat;
             $compte_vente = $row->compte_vente;
             $compte_variationstock= $row->compte_variationstock;
             $compte_perte= $row->compte_perte;
             $compte_produit= $row->compte_produit;
             $compte_destockage= $row->compte_destockage;
             $compte_stockage= $row->compte_stockage;      
         }
 

 
         $uniteVente = '';
         $uniteBase = '';
         $puBase=0;
         $qteBase=0;
         $estunite='';

        $data_unite=DB::table('tvente_detail_unite')
        ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_unite.refProduit') 
        ->select('tvente_detail_unite.id','refProduit','refUnite','puUnite','qteUnite','puBase','qteBase','estunite',
        'tvente_detail_unite.active','tvente_detail_unite.author','tvente_detail_unite.refUser',
        'nom_unite','uniteBase')
        ->where([
           ['tvente_detail_unite.id','=', $data['refDetailUnite']]
        ])      
        ->first();       
           
        if ($data_unite) 
        {
            $uniteVente = $data_unite->nom_unite;
            $uniteBase = $data_unite->uniteBase;           
            $qteBase=$data_unite->qteBase;
            $puBase=$data_unite->puBase;      
            $estunite=$data_unite->estunite;
        }
        
        $cmupVente = $cmup_data; 
 
        $qteVente = $qteBase * floatval($data['qteVente']);
        if($estunite = "OUI")
        {
           $puBase=  floatval($montants);
        }
        else
        {
           $puBase=  floatval($montants) / floatval($qteBase);
        }
        
       $montanttva=0;
       $pourtageTVA=0;
 
       $data5=DB::table('tvente_tva')     
       ->select('montant_tva')
       ->where([
         ['tvente_tva.id','=', $data['id_tva']],
         ['tvente_tva.active','=', 'OUI']
       ])      
       ->get();
        foreach ($data5 as $row) 
        {
            $pourtageTVA = $row->montant_tva;
        }         
        $montanttva = (((floatval($data['qteVente']) * floatval($montants))*floatval($pourtageTVA))/100);
    
            $data12 = tvente_detail_vente::create([
                'refEnteteVente'       =>  $idmax,
                'refProduit'    =>  $refProduit,
                'qteVente'    =>  $data['qteVente'],            
                'montantreduction'    =>  $data['montantreduction'],  
                'idStockService'    =>  $data['idStockService'],                     
                'author'       =>  $request->author,
                'refUser'    =>  $request->refUser,
    
                'active'    =>  $active,
                'uniteVente'    =>  $uniteVente,
                'compte_vente'    =>  $compte_vente,
                'compte_variationstock'    =>  $compte_variationstock,
                'compte_perte'    =>  $compte_perte,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                'puVente'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'puBase'    =>  $puBase,
                'qteBase'    =>  $qteBase,
                'uniteBase'    =>  $uniteBase,
                'cmupVente'    =>  $cmup_data,
                'montanttva'    =>  $montanttva,
            ]);

            $id_detail_max=0;
            $detail_list = DB::table('tvente_detail_vente')       
            ->selectRaw('MAX(id) as code_entete')
            ->where([
                ['refUser','=', $request->refUser],
                ['idStockService','=', $data['idStockService']]
             ]) 
            ->get();
            foreach ($detail_list as $list) {
                $id_detail_max= $list->code_entete;
            }
          
            $data99 = tvente_mouvement_stock::create([             
                'idStockService'    =>  $data['idStockService'],             
                'dateMvt'    =>   $request->dateVente,   
                'type_mouvement'    =>  'Sortie',
                'libelle_mouvement'    =>  'Vente des Produits',
                'nom_table'    =>  'tvente_detail_vente',
                'id_data'    =>  $id_detail_max, 
                'qteMvt'    =>  $data['qteVente'],
                'puMvt'    =>  $montants,                   
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'type_sortie'    =>  'Sortie',
    
                'active'    =>  $active,
                'uniteMvt'    =>  $uniteVente,
                'compte_vente'    =>  $compte_vente,
                'compte_variationstock'    =>  $compte_variationstock,
                'compte_perte'    =>  0,
                'compte_produit'    =>  $compte_produit,
                'compte_destockage'    =>  $compte_destockage,
                'compte_achat'    =>  0,
                'compte_stockage'    =>  0,
                'puVente'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'puBase'    =>  $puBase,
                'qteBase'    =>  $qteBase,
                'uniteBase'    =>  $uniteBase,
                'cmupMvt'    =>  $cmup_data
            ]); 
    
            $data2 = DB::update(
                'update tvente_stock_service set qte = qte - :qteVente where id = :idStockService',
                ['qteVente' => $qteVente,'idStockService' => $data['idStockService']]
            );
    
            $data3 = DB::update(
                'update tvente_entete_vente set montant = montant + (:pu * :qte),reduction = reduction + :reduction,totaltva = totaltva + :totaltva where id = :refEnteteVente',
                ['pu' => $montants,'qte' => $data['qteVente'],'reduction' => $data['montantreduction'],'totaltva' => $montanttva,'refEnteteVente' => $idmax]
            );

        }

        //PAIEMENT DE LA FACTURE ===================================================================


        
        $montants=0;
        $ventes = DB::table('tvente_entete_vente')
        ->selectRaw('(tvente_entete_vente.montant - tvente_entete_vente.reduction + tvente_entete_vente.totaltva) as montant')
        ->Where('id',$idmax)->get(); 
        foreach ($ventes as $vente) {
            $montants = $vente->montant;
        }


        $current = Carbon::now(); 
        $refEntetepaie=0; 
        $refService = $request->refService;
        $module_id_paie = 5;      

        $codepaie = $this->GetCodeData('tvente_param_systeme','module_id',$module_id_paie); 

        $data13 = tvente_entete_paievente::create([
            'code'       =>  $codepaie,
            'date_entete_paie'    =>  $current,
            'refService'    =>  $refService,
            'module_id'    =>  $module_id_paie,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        
        $idmax_paie=0;
        $maxid = DB::table('tvente_entete_paievente')       
        ->selectRaw('MAX(tvente_entete_paievente.id) as code_entete')
        ->where([
            ['tvente_entete_paievente.refUser','=', $request->refUser],
            ['tvente_entete_paievente.refService','=', $refService]
         ])
        ->get();
        foreach ($maxid as $list) {
            $idmax_paie= $list->code_entete;
        }

        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', $request->dateVente)
       ->take(1)
       ->orderBy('id', 'desc')         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == $request->dateVente)
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

            $data14 = tvente_paiement::create([
                'refEntetepaie'       =>  $idmax_paie,
                'refEnteteVente'       => $idmax,
                'montant_paie'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,
                'date_paie'    =>  $request->dateVente,
                'modepaie'       =>  $modepaie,
                'libellepaie'       =>  $libellepaie, 
                'refBanque'       =>  $refBanque,
                'numeroBordereau'       =>  $numeroBordereau,
                'author'       =>  $request->author,
                'refUser'       =>  $request->refUser,
                'active'       =>  $active
            ]);

            $data3 = DB::update(
                'update tvente_entete_vente set paie = paie + (:paiement) where id = :refEnteteVente',
                ['paiement' => $montants,'refEnteteVente' => $idmax]
            );       

       }

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }



    function insert_paiement_cash(Request $request, $id)
    {

        $current = Carbon::now(); 
        $refEntetepaie=0; 
        $module_id_paie = 5;
        $active = "OUI";

        $codepaie = $this->GetCodeData('tvente_param_systeme','module_id',$module_id_paie); 
        $idmax = $id; 
        $refService = 0;  

        //PAIEMENT DE LA FACTURE ===================================================================
        
        $montants=0;
        $ventes = DB::table('tvente_entete_vente')
        ->select('id','code','refClient','refService','refReservation','module_id',
        'dateVente','libelle','serveur_id','table_id','etat_facture','montant','paie','reduction',
        'totaltva','author','refUser')
        ->selectRaw('(tvente_entete_vente.montant - tvente_entete_vente.reduction + tvente_entete_vente.totaltva) as montant')
        ->Where('id',$idmax)->get(); 
        foreach ($ventes as $vente) {
            $montants = $vente->montant;
            $refService = $vente->refService;
        } 

        $data11 = tvente_entete_paievente::create([
            'code'       =>  $codepaie,
            'date_entete_paie'    =>  $current,
            'refService'    =>  $refService,
            'module_id'    =>  $module_id_paie,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        
        $idmax_paie=0;
        $maxid = DB::table('tvente_entete_paievente')       
        ->selectRaw('MAX(tvente_entete_paievente.id) as code_entete')
        ->where([
            ['tvente_entete_paievente.refUser','=', $request->refUser],
            ['tvente_entete_paievente.refService','=', $refService]
         ])
        ->get();
        foreach ($maxid as $list) {
            $idmax_paie= $list->code_entete;
        }

        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', $request->dateVente)
       ->take(1)
       ->orderBy('id', 'desc')         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == $request->dateVente)
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

            $devises = 'USD';
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

            $data12 = tvente_paiement::create([
                'refEntetepaie'       =>  $idmax_paie,
                'refEnteteVente'       => $idmax,
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

            $data3 = DB::update(
                'update tvente_entete_vente set paie = paie + (:paiement) where id = :refEnteteVente',
                ['paiement' => $montants,'refEnteteVente' => $idmax]
            );       

       }

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }


    function affecter_reservation(Request $request, $id)
    {
        $data = tvente_entete_vente::where('id', $id)->update([                        
            'refReservation' =>  $request->refReservation,
            'etat_facture'    =>  'Chambre',            
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]); 
    }
 









}
