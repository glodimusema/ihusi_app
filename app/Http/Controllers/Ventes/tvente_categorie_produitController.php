<?php

namespace App\Http\Controllers\Ventes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Ventes\{tvente_categorie_produit};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;


class tvente_categorie_produitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        $data = DB::table("tvente_categorie_produit")
        ->join('tvente_grande_categorie_produit','tvente_grande_categorie_produit.id','=','tvente_categorie_produit.id_groupe_categorie')
        ->join('tfin_ssouscompte as compteachat','compteachat.id','=','tvente_categorie_produit.compte_achat')
        ->join('tfin_ssouscompte as comptevente','comptevente.id','=','tvente_categorie_produit.compte_vente')
        ->join('tfin_ssouscompte as comptevariation','comptevariation.id','=','tvente_categorie_produit.compte_variationstock')
        ->join('tfin_ssouscompte as compteperte','compteperte.id','=','tvente_categorie_produit.compte_perte')
        ->join('tfin_ssouscompte as compteproduit','compteproduit.id','=','tvente_categorie_produit.compte_produit')
        ->join('tfin_ssouscompte as comptedestockage','comptedestockage.id','=','tvente_categorie_produit.compte_destockage')
        ->join('tfin_ssouscompte as comptestockage','comptestockage.id','=','tvente_categorie_produit.compte_stockage')
        ->select("tvente_categorie_produit.id", "tvente_categorie_produit.designation",
        'compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
        'compte_perte','compte_produit','compte_destockage','compte_stockage', 
        "tvente_categorie_produit.created_at", "tvente_categorie_produit.author", 
        "tvente_categorie_produit.refUser",'id_groupe_categorie','designation_groupe'
        ,'compteachat.refSousCompte as refSousCompteAchat','compteachat.nom_ssouscompte as nom_ssouscompteAchat',
        'compteachat.numero_ssouscompte as numero_ssouscompteAchat'
        ,'comptevente.refSousCompte as refSousCompteVente','comptevente.nom_ssouscompte as nom_ssouscompteVente',
        'comptevente.numero_ssouscompte as numero_ssouscompteVente'
        ,'comptevariation.refSousCompte as refSousCompteVariation','comptevariation.nom_ssouscompte as nom_ssouscompteVariation',
        'comptevariation.numero_ssouscompte as numero_ssouscompteVariation'
        ,'compteperte.refSousCompte as refSousComptePerte','compteperte.nom_ssouscompte as nom_ssouscomptePerte',
        'compteperte.numero_ssouscompte as numero_ssouscomptePerte'
        ,'compteproduit.refSousCompte as refSousCompteProduit','compteproduit.nom_ssouscompte as nom_ssouscompteProduit',
        'compteproduit.numero_ssouscompte as numero_ssouscompteProduit'
        ,'comptedestockage.refSousCompte as refSousCompteDestockage','comptedestockage.nom_ssouscompte as nom_ssouscompteDestockage',
        'comptedestockage.numero_ssouscompte as numero_ssouscompteDestockage'
        ,'comptestockage.refSousCompte as refSousCompteStockage','comptestockage.nom_ssouscompte as nom_ssouscompteStockage',
        'comptestockage.numero_ssouscompte as numero_ssouscompteStockage');

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tvente_categorie_produit.designation', 'like', '%'.$query.'%')
            ->orderBy("tvente_categorie_produit.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tvente_categorie_produit_2()
    {
         $data = DB::table("tvente_categorie_produit")
         ->join('tvente_grande_categorie_produit','tvente_grande_categorie_produit.id','=','tvente_categorie_produit.id_groupe_categorie')
         ->join('tfin_ssouscompte as compteachat','compteachat.id','=','tvente_categorie_produit.compte_achat')
         ->join('tfin_ssouscompte as comptevente','comptevente.id','=','tvente_categorie_produit.compte_vente')
         ->join('tfin_ssouscompte as comptevariation','comptevariation.id','=','tvente_categorie_produit.compte_variationstock')
         ->join('tfin_ssouscompte as compteperte','compteperte.id','=','tvente_categorie_produit.compte_perte')
         ->join('tfin_ssouscompte as compteproduit','compteproduit.id','=','tvente_categorie_produit.compte_produit')
         ->join('tfin_ssouscompte as comptedestockage','comptedestockage.id','=','tvente_categorie_produit.compte_destockage')
         ->join('tfin_ssouscompte as comptestockage','comptestockage.id','=','tvente_categorie_produit.compte_stockage')
         ->select("tvente_categorie_produit.id", "tvente_categorie_produit.designation",
         'compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
         'compte_perte','compte_produit','compte_destockage','compte_stockage', 
         "tvente_categorie_produit.created_at", "tvente_categorie_produit.author", 
         "tvente_categorie_produit.refUser",'id_groupe_categorie','designation_groupe'
         ,'compteachat.refSousCompte as refSousCompteAchat','compteachat.nom_ssouscompte as nom_ssouscompteAchat',
         'compteachat.numero_ssouscompte as numero_ssouscompteAchat'
         ,'comptevente.refSousCompte as refSousCompteVente','comptevente.nom_ssouscompte as nom_ssouscompteVente',
         'comptevente.numero_ssouscompte as numero_ssouscompteVente'
         ,'comptevariation.refSousCompte as refSousCompteVariation','comptevariation.nom_ssouscompte as nom_ssouscompteVariation',
         'comptevariation.numero_ssouscompte as numero_ssouscompteVariation'
         ,'compteperte.refSousCompte as refSousComptePerte','compteperte.nom_ssouscompte as nom_ssouscomptePerte',
         'compteperte.numero_ssouscompte as numero_ssouscomptePerte'
         ,'compteproduit.refSousCompte as refSousCompteProduit','compteproduit.nom_ssouscompte as nom_ssouscompteProduit',
         'compteproduit.numero_ssouscompte as numero_ssouscompteProduit'
         ,'comptedestockage.refSousCompte as refSousCompteDestockage','comptedestockage.nom_ssouscompte as nom_ssouscompteDestockage',
         'comptedestockage.numero_ssouscompte as numero_ssouscompteDestockage'
         ,'comptestockage.refSousCompte as refSousCompteStockage','comptestockage.nom_ssouscompte as nom_ssouscompteStockage',
         'comptestockage.numero_ssouscompte as numero_ssouscompteStockage')
        ->get();
        return response()->json(['data' => $data]);

       // $categories = Categorie::query()->get();
        // $categories = Categorie::query()
        // ->with('produits')
        // ->get();
        
        // return response()->json(['data' => $categories]);

    }


    function fetch_tvente_categorie_produit_22()
    {
        $data = DB::table("tvente_categorie_produit")
            ->join('tfin_ssouscompte as compteachat', 'compteachat.id', '=', 'tvente_categorie_produit.compte_achat')
            // Ajoutez les autres jointures ici...
            ->select("tvente_categorie_produit.id", "tvente_categorie_produit.designation", /* autres colonnes */)
            ->get(); // N'oubliez pas d'utiliser get() pour récupérer les résultats

        return response()->json($data); // Retournez les données en JSON
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if ($request->id !='') 
        {
            # code...
            // update  //,'id_groupe_categorie' 
            $data = tvente_categorie_produit::where("id", $request->id)->update([
                'code' =>  $request->code,
                'designation' =>  $request->designation,
                'compte_achat' =>  $request->compte_achat,
                'compte_vente' =>  $request->compte_vente,
                'compte_variationstock' =>  $request->compte_variationstock,
                'compte_perte' =>  $request->compte_perte,
                'compte_produit' =>  $request->compte_produit,
                'compte_destockage' =>  $request->compte_destockage,
                'compte_stockage' =>  $request->compte_stockage,  
                'id_groupe_categorie' =>  $request->id_groupe_categorie,              
                'author' =>  $request->author,
                'refUser' =>  $request->refUser
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tvente_categorie_produit::create([
                'code' =>  $request->code,
                'designation' =>  $request->designation,
                'compte_achat' =>  $request->compte_achat,
                'compte_vente' =>  $request->compte_vente,
                'compte_variationstock' =>  $request->compte_variationstock,
                'compte_perte' =>  $request->compte_perte,
                'compte_produit' =>  $request->compte_produit,
                'compte_destockage' =>  $request->compte_destockage,
                'compte_stockage' =>  $request->compte_stockage,  
                'id_groupe_categorie' =>  $request->id_groupe_categorie,               
                'author' =>  $request->author,
                'refUser' =>  $request->refUser
            ]);

            return $this->msgJson('Insertion avec succès!!!');
        }
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = tvente_categorie_produit::where('id', $id)->get();
        return response()->json(['data' => $data]);
    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = tvente_categorie_produit::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
