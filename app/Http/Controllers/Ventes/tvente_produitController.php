<?php

namespace App\Http\Controllers\Ventes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ventes\{tvente_produit};
use App\Models\Produit;
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;


class tvente_produitController extends Controller
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

        $data = DB::table('tvente_produit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')  
        ->join('tfin_ssouscompte as compteachat','compteachat.id','=','tvente_categorie_produit.compte_achat')
        ->join('tfin_ssouscompte as comptevente','comptevente.id','=','tvente_categorie_produit.compte_vente')
        ->join('tfin_ssouscompte as comptevariation','comptevariation.id','=','tvente_categorie_produit.compte_variationstock')
        ->join('tfin_ssouscompte as compteperte','compteperte.id','=','tvente_categorie_produit.compte_perte')
        ->join('tfin_ssouscompte as compteproduit','compteproduit.id','=','tvente_categorie_produit.compte_produit')
        ->join('tfin_ssouscompte as comptedestockage','comptedestockage.id','=','tvente_categorie_produit.compte_destockage')
        ->join('tfin_ssouscompte as comptestockage','comptestockage.id','=','tvente_categorie_produit.compte_stockage')      
        ->select("tvente_produit.id","tvente_produit.designation as designation",'refCategorie','refUniteBase','uniteBase','pu','qte',
        'cmup','stock_alerte','devise','taux','Oldcode','Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie",
        'compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
        'compte_perte','compte_produit','compte_destockage','compte_stockage', 
        "tvente_produit.created_at", "tvente_produit.author","tvente_produit.refUser"
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

            $data->where('tvente_produit.designation', 'like', '%'.$query.'%')
            ->orderBy("tvente_produit.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tvente_produit_2()
    {
         $data = DB::table('tvente_produit')
         ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')  
         ->join('tfin_ssouscompte as compteachat','compteachat.id','=','tvente_categorie_produit.compte_achat')
         ->join('tfin_ssouscompte as comptevente','comptevente.id','=','tvente_categorie_produit.compte_vente')
         ->join('tfin_ssouscompte as comptevariation','comptevariation.id','=','tvente_categorie_produit.compte_variationstock')
         ->join('tfin_ssouscompte as compteperte','compteperte.id','=','tvente_categorie_produit.compte_perte')
         ->join('tfin_ssouscompte as compteproduit','compteproduit.id','=','tvente_categorie_produit.compte_produit')
         ->join('tfin_ssouscompte as comptedestockage','comptedestockage.id','=','tvente_categorie_produit.compte_destockage')
         ->join('tfin_ssouscompte as comptestockage','comptestockage.id','=','tvente_categorie_produit.compte_stockage')      
         ->select("tvente_produit.id","tvente_produit.designation as designation",'refCategorie','refUniteBase','uniteBase','pu','qte',
         'cmup','stock_alerte','devise','taux','Oldcode','Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie",
         'compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
         'compte_perte','compte_produit','compte_destockage','compte_stockage', 
         "tvente_produit.created_at", "tvente_produit.author","tvente_produit.refUser"
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

    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //'id','designation','refCategorie','refUniteBase','uniteBase','pu','qte',
    //'cmup','devise','taux','Oldcode','Newcode','tvaapplique','estvendable','author','refUser'

    public function store(Request $request)
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
            $montants = ($request->pu)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->pu;
            $devises = $request->devise;
        }


        //
        if ($request->id !='') 
        {
            $uniteBase = '';    
            $unite = '';
    
            $data4=DB::table('tvente_unite')            
            ->select('nom_unite','code_unite')
            ->where([
               ['tvente_unite.id','=', $request->refUniteBase]
           ])      
           ->get();      
           $output='';
           foreach ($data4 as $row) 
           {
               $uniteBase = $row->nom_unite;
               $unite = $row->nom_unite;
           }

            # code...
            // update stock_alerte
            $data = tvente_produit::where("id", $request->id)->update([
                'designation'       =>  $request->designation,
                'pu'    =>  $montants,                
                'devise'    =>  $devises,
                'taux'    =>  $taux,               
                'refCategorie'    =>  $request->refCategorie,
                'refUniteBase'    =>  $request->refUniteBase,
                'uniteBase'    =>  $uniteBase,
                'Oldcode'    =>  $request->Oldcode,
                'Newcode'    =>  $request->Newcode,
                'tvaapplique'    =>  $request->tvaapplique,
                'estvendable'    =>  $request->estvendable,
                'stock_alerte'    =>  $request->stock_alerte,
                'author'    =>  $request->author,
                'refUser'    =>  $request->refUser                
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            $uniteBase = '';    
            $unite = '';
    
            $data4=DB::table('tvente_unite')            
            ->select('nom_unite','code_unite')
            ->where([
               ['tvente_unite.id','=', $request->refUniteBase]
           ])      
           ->get();      
           $output='';
           foreach ($data4 as $row) 
           {
               $uniteBase = $row->nom_unite;
               $unite = $row->nom_unite;
           }


            // insertion 
            $data = tvente_produit::create([
                'designation'       =>  $request->designation,
                'qte'    =>  0,
                'pu'    =>  $montants,
                'cmup'    =>  $montants,
                'devise'    =>  $devises,
                'taux'    =>  $taux,                
                'refCategorie'    =>  $request->refCategorie,
                'refUniteBase'    =>  $request->refUniteBase,
                'uniteBase'    =>  $uniteBase,
                'Oldcode'    =>  $request->Oldcode,
                'Newcode'    =>  $request->Newcode,
                'tvaapplique'    =>  $request->tvaapplique,
                'estvendable'    =>  $request->estvendable,
                'stock_alerte'    =>  $request->stock_alerte,
                'author'    =>  $request->author,
                'refUser'    =>  $request->refUser  
            ]);

            //cmup
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
        $data = tvente_produit::where('id', $id)->get();
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
        $data = tvente_produit::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
