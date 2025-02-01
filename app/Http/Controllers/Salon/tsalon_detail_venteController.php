<?php

namespace App\Http\Controllers\Salon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Salon\tsalon_detail_vente;
use App\Traits\{GlobalMethod,Slug};
use DB;
class tsalon_detail_venteController extends Controller
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

        $data = DB::table('tsalon_detail_vente')
        ->join('tsalon_produit','tsalon_produit.id','=','tsalon_detail_vente.refProduit')
        ->join('tsalon_entete_vente','tsalon_entete_vente.id','=','tsalon_detail_vente.refEnteteVente')
        ->join('tvente_client','tvente_client.id','=','tsalon_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
        ->select('tsalon_detail_vente.id','tsalon_detail_vente.refEnteteVente','refProduit','puVente','qteVente','dateVente',
        'libelle',"tsalon_produit.designation","pu","unite",
        'tsalon_detail_vente.author','tsalon_detail_vente.created_at','noms','sexe',
        'contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'tsalon_detail_vente.devise','tsalon_detail_vente.taux','tvente_categorie_client.designation as CategorieClient')
        ->selectRaw('(qteVente*puVente) as PTVente')
        ->selectRaw('((qteVente*puVente)/tsalon_detail_vente.taux) as PTVenteFC')
        ->selectRaw('((IFNULL(montant,0))/tsalon_detail_vente.taux) as totalFactureFC')
        ->selectRaw('IFNULL(montant,0) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tsalon_detail_vente.created_at", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tsalon_detail_vente.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tsalon_detail_vente')
        ->join('tsalon_produit','tsalon_produit.id','=','tsalon_detail_vente.refProduit')
        ->join('tsalon_entete_vente','tsalon_entete_vente.id','=','tsalon_detail_vente.refEnteteVente')
        ->join('tvente_client','tvente_client.id','=','tsalon_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
        ->select('tsalon_detail_vente.id','tsalon_detail_vente.refEnteteVente','refProduit','puVente','qteVente','dateVente',
        'libelle',"tsalon_produit.designation","pu","unite",
        'tsalon_detail_vente.author','tsalon_detail_vente.created_at','noms','sexe',
        'contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'tsalon_detail_vente.devise','tsalon_detail_vente.taux','tvente_categorie_client.designation as CategorieClient')
        ->selectRaw('(qteVente*puVente) as PTVente')
        ->selectRaw('((qteVente*puVente)/tsalon_detail_vente.taux) as PTVenteFC')
        ->selectRaw('((IFNULL(montant,0))/tsalon_detail_vente.taux) as totalFactureFC')
        ->selectRaw('IFNULL(montant,0) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
        ->Where('tsalon_detail_vente.refEnteteVente',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("tsalon_detail_vente.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tsalon_detail_vente.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    



    function fetch_single_data($id)
    {
        $data= DB::table('tsalon_detail_vente')
        ->join('tsalon_produit','tsalon_produit.id','=','tsalon_detail_vente.refProduit')
        ->join('tsalon_entete_vente','tsalon_entete_vente.id','=','tsalon_detail_vente.refEnteteVente')
        ->join('tvente_client','tvente_client.id','=','tsalon_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
        ->select('tsalon_detail_vente.id','tsalon_detail_vente.refEnteteVente','refProduit','puVente','qteVente','dateVente',
        'libelle',"tsalon_produit.designation","pu","unite",
        'tsalon_detail_vente.author','tsalon_detail_vente.created_at','noms','sexe',
        'contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'tsalon_detail_vente.devise','tsalon_detail_vente.taux','tvente_categorie_client.designation as CategorieClient')
        ->selectRaw('(qteVente*puVente) as PTVente')
        ->selectRaw('((qteVente*puVente)/tsalon_detail_vente.taux) as PTVenteFC')
        ->selectRaw('((IFNULL(montant,0))/tsalon_detail_vente.taux) as totalFactureFC')
        ->selectRaw('IFNULL(montant,0) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
        ->where('tsalon_detail_vente.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_detail_facture($id)
    {
        $data = DB::table('tsalon_detail_vente')
        ->join('tsalon_produit','tsalon_produit.id','=','tsalon_detail_vente.refProduit')
        ->join('tsalon_entete_vente','tsalon_entete_vente.id','=','tsalon_detail_vente.refEnteteVente')
        ->join('tvente_client','tvente_client.id','=','tsalon_entete_vente.refClient')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')
        ->select('tsalon_detail_vente.id','tsalon_detail_vente.refEnteteVente','refProduit','puVente','qteVente','dateVente',
        'libelle',"tsalon_produit.designation","pu","unite",
        'tsalon_detail_vente.author','tsalon_detail_vente.created_at','noms','sexe',
        'contact','mail','adresse','pieceidentite','numeroPiece','dateLivrePiece','lieulivraisonCarte',
        'nationnalite','datenaissance','lieunaissance','profession','occupation','nombreEnfant',
        'dateArriverGoma','arriverPar','refCategieClient','photo','slug',
        'tsalon_detail_vente.devise','tsalon_detail_vente.taux','tvente_categorie_client.designation as CategorieClient')
        ->selectRaw('(qteVente*puVente) as PTVente')
        ->selectRaw('((qteVente*puVente) * tsalon_detail_vente.taux) as PTVenteFC')
        ->selectRaw('((IFNULL(montant,0)) * tsalon_detail_vente.taux) as totalFactureFC')
        ->selectRaw('IFNULL(montant,0) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
        ->Where('tsalon_detail_vente.refEnteteVente',$id)               
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

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
            $montants = ($request->puVente)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puVente;
            $devises = $request->devise;
        }

        $qte=$request->qteVente;
        $idDetail=$request->refProduit;
        $idFacture=$request->refEnteteVente;
        $qte=$request->qteVente;
       
        $data = tsalon_detail_vente::create([
            'refEnteteVente'       =>  $request->refEnteteVente,
            'refProduit'    =>  $request->refProduit,
            'puVente'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'qteVente'    =>  $request->qteVente,
            'author'       =>  $request->author
        ]);

        $data3 = DB::update(
            'update tsalon_entete_vente set montant = montant + (:pu * :qte) where id = :refEnteteVente',
            ['pu' => $montants,'qte' => $qte,'refEnteteVente' => $idFacture]
        );

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
            $montants = ($request->puVente)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puVente;
            $devises = $request->devise;
        }


        $data = tsalon_detail_vente::where('id', $id)->update([
            'refEnteteVente'       =>  $request->refEnteteVente,
            'refProduit'    =>  $request->refProduit,
            'puVente'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'qteVente'    =>  $request->qteVente,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $qte=0;
        $idDetail=0;
        $idFacture=0;
        $montants=0;

        $deleteds = DB::table('tsalon_detail_vente')->Where('id',$id)->get();  
        foreach ($deleteds as $deleted) {
            $qte = $deleted->qteVente;
            $idDetail = $deleted->refProduit;
            $idFacture = $deleted->refEnteteVente;
            $montants = $deleted->puVente;
        }

        $data3 = DB::update(
            'update tsalon_entete_vente set montant = montant - (:pu * :qte) where id = :refEnteteVente',
            ['pu' => $montants,'qte' => $qte,'refEnteteVente' => $idFacture]
        );

        $data = tsalon_detail_vente::where('id',$id)->delete();
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
