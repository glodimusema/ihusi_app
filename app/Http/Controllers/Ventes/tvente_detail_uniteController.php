<?php

namespace App\Http\Controllers\Ventes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ventes\tvente_detail_unite;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tvente_detail_uniteController extends Controller
{

    use GlobalMethod, Slug;

// 'id','refProduit','refUnite','puUnite','qteUnite','puBase','qteBase','estunite','active','author','refUser'
//tvente_detail_unite
//'id','nom_unite','code_unite','active'
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

        $data = DB::table('tvente_detail_unite')
        ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_unite.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')  
        ->join('tfin_ssouscompte as compteachat','compteachat.id','=','tvente_categorie_produit.compte_achat')
        ->join('tfin_ssouscompte as comptevente','comptevente.id','=','tvente_categorie_produit.compte_vente')
        ->join('tfin_ssouscompte as comptevariation','comptevariation.id','=','tvente_categorie_produit.compte_variationstock')
        ->join('tfin_ssouscompte as compteperte','compteperte.id','=','tvente_categorie_produit.compte_perte')
        ->join('tfin_ssouscompte as compteproduit','compteproduit.id','=','tvente_categorie_produit.compte_produit')
        ->join('tfin_ssouscompte as comptedestockage','comptedestockage.id','=','tvente_categorie_produit.compte_destockage')
        ->join('tfin_ssouscompte as comptestockage','comptestockage.id','=','tvente_categorie_produit.compte_stockage')
        ->select('tvente_detail_unite.id','refProduit','refUnite','puUnite','qteUnite','puBase','qteBase','estunite','estpivot',
        'tvente_detail_unite.active','tvente_detail_unite.author','tvente_detail_unite.refUser','nom_unite','code_unite'
        ,"tvente_produit.designation as designation",'refCategorie','refUniteBase','uniteBase','pu','qte',
        'cmup','devise','taux','Oldcode','Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie",
        'compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
        'compte_perte','compte_produit','compte_destockage','compte_stockage',"tvente_detail_unite.created_at"
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

            $data->where('nom_unite', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_unite.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tvente_detail_unite.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 
        $data = DB::table('tvente_detail_unite')
        ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_unite.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')  
        ->join('tfin_ssouscompte as compteachat','compteachat.id','=','tvente_categorie_produit.compte_achat')
        ->join('tfin_ssouscompte as comptevente','comptevente.id','=','tvente_categorie_produit.compte_vente')
        ->join('tfin_ssouscompte as comptevariation','comptevariation.id','=','tvente_categorie_produit.compte_variationstock')
        ->join('tfin_ssouscompte as compteperte','compteperte.id','=','tvente_categorie_produit.compte_perte')
        ->join('tfin_ssouscompte as compteproduit','compteproduit.id','=','tvente_categorie_produit.compte_produit')
        ->join('tfin_ssouscompte as comptedestockage','comptedestockage.id','=','tvente_categorie_produit.compte_destockage')
        ->join('tfin_ssouscompte as comptestockage','comptestockage.id','=','tvente_categorie_produit.compte_stockage')
        ->select('tvente_detail_unite.id','refProduit','refUnite','puUnite','qteUnite','puBase','qteBase','estunite','estpivot',
        'tvente_detail_unite.active','tvente_detail_unite.author','tvente_detail_unite.refUser','nom_unite','code_unite'
        ,"tvente_produit.designation as designation",'refCategorie','refUniteBase','uniteBase','pu','qte',
        'cmup','devise','taux','Oldcode','Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie",
        'compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
        'compte_perte','compte_produit','compte_destockage','compte_stockage',"tvente_detail_unite.created_at"
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
        ->Where('refProduit',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('nom_unite', 'like', '%'.$query.'%')          
            ->orderBy("tvente_detail_unite.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tvente_detail_unite.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    

     

    function fetch_single_data($id)
    {
        $data = DB::table('tvente_detail_unite')
        ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_unite.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')         
        ->select('tvente_detail_unite.id','refProduit','refUnite','puUnite','qteUnite','puBase',
        'qteBase','estunite','estpivot','tvente_detail_unite.active','tvente_detail_unite.author',
        'tvente_detail_unite.refUser','nom_unite','code_unite'
        ,"tvente_produit.designation as designation",'refCategorie','refUniteBase','uniteBase','pu',
        'cmup','devise','taux','Oldcode','Newcode','tvaapplique','estvendable',
        "tvente_categorie_produit.designation as Categorie",
        )
        ->selectRaw('ROUND((qte/qteBase),1) as qte')
        ->where('tvente_detail_unite.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }


    function fetch_detailunite_prod($refProduit)
    {

        $data = DB::table('tvente_detail_unite')
        ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_unite.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')  
        ->join('tfin_ssouscompte as compteachat','compteachat.id','=','tvente_categorie_produit.compte_achat')
        ->join('tfin_ssouscompte as comptevente','comptevente.id','=','tvente_categorie_produit.compte_vente')
        ->join('tfin_ssouscompte as comptevariation','comptevariation.id','=','tvente_categorie_produit.compte_variationstock')
        ->join('tfin_ssouscompte as compteperte','compteperte.id','=','tvente_categorie_produit.compte_perte')
        ->join('tfin_ssouscompte as compteproduit','compteproduit.id','=','tvente_categorie_produit.compte_produit')
        ->join('tfin_ssouscompte as comptedestockage','comptedestockage.id','=','tvente_categorie_produit.compte_destockage')
        ->join('tfin_ssouscompte as comptestockage','comptestockage.id','=','tvente_categorie_produit.compte_stockage')
        ->select('tvente_detail_unite.id','refProduit','refUnite','puUnite','qteUnite','puBase','qteBase','estunite','estpivot',
        'tvente_detail_unite.active','tvente_detail_unite.author','tvente_detail_unite.refUser','nom_unite','code_unite'
        ,"tvente_produit.designation as designation",'refCategorie','refUniteBase','uniteBase','pu','qte',
        'cmup','devise','taux','Oldcode','Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie",
        'compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
        'compte_perte','compte_produit','compte_destockage','compte_stockage',"tvente_detail_unite.created_at"
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
        ->Where('refProduit',$refProduit)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }

    function fetch_detailunite_prod2($refProduit)
    {

        $data = DB::table('tvente_detail_unite')
        ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_unite.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')  
        ->join('tfin_ssouscompte as compteachat','compteachat.id','=','tvente_categorie_produit.compte_achat')
        ->join('tfin_ssouscompte as comptevente','comptevente.id','=','tvente_categorie_produit.compte_vente')
        ->join('tfin_ssouscompte as comptevariation','comptevariation.id','=','tvente_categorie_produit.compte_variationstock')
        ->join('tfin_ssouscompte as compteperte','compteperte.id','=','tvente_categorie_produit.compte_perte')
        ->join('tfin_ssouscompte as compteproduit','compteproduit.id','=','tvente_categorie_produit.compte_produit')
        ->join('tfin_ssouscompte as comptedestockage','comptedestockage.id','=','tvente_categorie_produit.compte_destockage')
        ->join('tfin_ssouscompte as comptestockage','comptestockage.id','=','tvente_categorie_produit.compte_stockage')
        ->select('tvente_detail_unite.id','refProduit','refUnite','puUnite','qteUnite','puBase','qteBase','estunite','estpivot',
        'tvente_detail_unite.active','tvente_detail_unite.author','tvente_detail_unite.refUser','nom_unite','code_unite'
        ,"tvente_produit.designation as designation",'refCategorie','refUniteBase','uniteBase','pu','qte',
        'cmup','devise','taux','Oldcode','Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie",
        'compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
        'compte_perte','compte_produit','compte_destockage','compte_stockage',"tvente_detail_unite.created_at"
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
        ->where([               
            ['refProduit','=', $refProduit],
            ['estunite','=', 'OUI']
        ]) 
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }

    function fetch_detailunite_prod_stock_service($idStockService)
    {
        $refProduit = 0;
        $data3=DB::table('tvente_stock_service')
         ->select('id','refService','refProduit','pu','qte','uniteBase','cmup',
         'devise','taux','active','refUser','author')
         ->where([
            ['tvente_stock_service.id','=', $idStockService]
        ])      
        ->get(); 
        foreach ($data3 as $row) 
        {
            $refProduit =  $row->refProduit;                 
        }

        $data = DB::table('tvente_detail_unite')
        ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
        ->join('tvente_produit','tvente_produit.id','=','tvente_detail_unite.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')  
       
        ->select('tvente_detail_unite.id','refProduit','refUnite','puUnite','qteUnite','puBase','qteBase','estunite','estpivot',
        'tvente_detail_unite.active','tvente_detail_unite.author','tvente_detail_unite.refUser','nom_unite','code_unite'
        ,"tvente_produit.designation as designation",'refCategorie','refUniteBase','uniteBase','pu','qte',
        'cmup','devise','taux','Oldcode','Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie",
        )                     
        ->Where('refProduit',$refProduit)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }

    function fetch_detailunite_stockdispo_service(Request $request)
    {
        if (($request->get('refDetailUnite')) && ($request->get('idStockService'))) 
        {
            $qteBase = 0;
            $data3=DB::table('tvente_detail_unite')
             ->select('id','refProduit','refUnite','puUnite','qteUnite','puBase',
                        'qteBase','estunite','estpivot','active','author','refUser')
             ->where([
                ['tvente_detail_unite.id','=', $request->refDetailUnite]
            ])      
            ->get(); 
            foreach ($data3 as $row) 
            {
                $qteBase =  $row->qteBase;                     
            }
            // 'id','refService','refProduit','pu','qte','uniteBase','cmup','devise','taux','active','refUser','author'
            // tvente_stock_service

            $data = DB::select(
                'select ROUND((qte / :qteBase),3) as Qtedispo,refProduit,ROUND((cmup * :qteBases),3) as cmupData from tvente_stock_service  
                 where tvente_stock_service.id = :idPro',
                 ['qteBase' => $qteBase,'qteBases' => $qteBase,'idPro' => $request->idStockService]
            );   
    
            return response()->json([
                'data'  => $data
            ]);
    
        }
    }

    function fetch_data_detail_unite_vente(Request $request)
    {
        if (($request->get('refProduit')) && ($request->get('refUnite'))) 
        {
          
            $data = DB::table('tvente_detail_unite')
            ->join('tvente_unite','tvente_unite.id','=','tvente_detail_unite.refUnite')
            ->join('tvente_produit','tvente_produit.id','=','tvente_detail_unite.refProduit')
            ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tvente_produit.refCategorie')
            ->select('tvente_detail_unite.id','refProduit','refUnite','puUnite','qteUnite','puBase','qteBase','estunite','estpivot',
            'tvente_detail_unite.active','tvente_detail_unite.author','tvente_detail_unite.refUser','nom_unite','code_unite'
            ,"tvente_produit.designation as designation",'refCategorie','refUniteBase','uniteBase','pu',
            'cmup','devise','taux','Oldcode','Newcode','tvaapplique','estvendable',"tvente_categorie_produit.designation as Categorie",
            'compte_achat','compte_vente','compte_variationstock','tvente_categorie_produit.code',
            'compte_perte','compte_produit','compte_destockage','compte_stockage',"tvente_detail_unite.created_at"
           )
           ->selectRaw('(qte/qteBase) as qte')
            ->where([               
                ['refProduit','=', $request->refProduit],
                ['refUnite','=', $request->refUnite]
            ])     
            ->get();               
        
            return response()->json([
                'data'  => $data,
            ]);
                       
        }
        else{

        }       
    }


   //'id','refProduit','refUnite','puUnite','qteUnite','puBase','qteBase','estunite','estpivot','active','author','refUser'
    function insert_data(Request $request)
    {       
        $data = tvente_detail_unite::create([
            'refProduit'       =>  $request->refProduit,
            'refUnite'    =>  $request->refUnite,
            'puUnite'    =>  $request->puUnite,
            'qteUnite'    =>  $request->qteUnite,
            'puBase'    =>  $request->puBase,
            'qteBase'    =>  $request->qteBase,
            'estunite'    =>  $request->estunite,
            'estpivot'    =>  $request->estpivot,
            'active'    =>  $request->active,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {
        $data = tvente_detail_unite::where('id', $id)->update([
            'refProduit'       =>  $request->refProduit,
            'refUnite'    =>  $request->refUnite,
            'puUnite'    =>  $request->puUnite,
            'qteUnite'    =>  $request->qteUnite,
            'puBase'    =>  $request->puBase,
            'qteBase'    =>  $request->qteBase,
            'estunite'    =>  $request->estunite,
            'estpivot'    =>  $request->estpivot,
            'active'    =>  $request->active,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = tvente_detail_unite::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
