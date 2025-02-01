<?php

namespace App\Http\Controllers\Logistique;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Logistique\tlog_detail_sortie;
use App\Traits\{GlobalMethod,Slug};
use DB;
class tlog_detail_sortieController extends Controller
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

        $data = DB::table('tlog_detail_sortie')
        ->join('tlog_produit','tlog_produit.id','=','tlog_detail_sortie.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
        ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
        ->select('tlog_detail_sortie.id','refEnteteSortie','refProduit','puSortie','qteSortie','nom_agent','dateSortie',
        'libelle',"tlog_produit.designation","refCategorie","pu","unite","tvente_categorie_produit.designation as Categorie",
        'tlog_detail_sortie.author','tlog_detail_sortie.created_at','name_serv_perso as Services',
        'tlog_detail_sortie.devise','tlog_detail_sortie.taux')
        ->selectRaw('(qteSortie*puSortie) as PTSortie')
        ->selectRaw('((qteSortie*puSortie)/tlog_detail_sortie.taux) as PTSortieFC');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('nom_agent', 'like', '%'.$query.'%')          
            ->orderBy("nom_agent", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tlog_detail_sortie.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tlog_detail_sortie')
        ->join('tlog_produit','tlog_produit.id','=','tlog_detail_sortie.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
        ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
        ->select('tlog_detail_sortie.id','refEnteteSortie','refProduit','puSortie','qteSortie','nom_agent','dateSortie',
        'libelle',"tlog_produit.designation","refCategorie","pu","unite","tvente_categorie_produit.designation as Categorie",
        'tlog_detail_sortie.author','tlog_detail_sortie.created_at','name_serv_perso as Services',
        'tlog_detail_sortie.devise','tlog_detail_sortie.taux')
        ->selectRaw('(qteSortie*puSortie) as PTSortie')
        ->selectRaw('((qteSortie*puSortie)/tlog_detail_sortie.taux) as PTSortieFC')
        ->Where('refEnteteSortie',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('nom_agent', 'like', '%'.$query.'%')          
            ->orderBy("tlog_detail_sortie.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tlog_detail_sortie.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    



    function fetch_single_data($id)
    {
        $data= DB::table('tlog_detail_sortie')
        ->join('tlog_produit','tlog_produit.id','=','tlog_detail_sortie.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
        ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
        ->select('tlog_detail_sortie.id','refEnteteSortie','refProduit','puSortie','qteSortie','nom_agent','dateSortie',
        'libelle',"tlog_produit.designation","refCategorie","pu","unite","tvente_categorie_produit.designation as Categorie",
        'tlog_detail_sortie.author','tlog_detail_sortie.created_at','name_serv_perso as Services',
        'tlog_detail_sortie.devise','tlog_detail_sortie.taux')
        ->selectRaw('(qteSortie*puSortie) as PTSortie')
        ->selectRaw('((qteSortie*puSortie)/tlog_detail_sortie.taux) as PTSortieFC')
        ->where('tlog_detail_sortie.id', $id)
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
            $montants = ($request->puSortie)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puSortie;
            $devises = $request->devise;
        }


        $qte=$request->qteSortie;
        $idDetail=$request->refProduit;
       
        $data = tlog_detail_sortie::create([
            'refEnteteSortie'       =>  $request->refEnteteSortie,
            'refProduit'    =>  $request->refProduit,
            'puSortie'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'qteSortie'    =>  $request->qteSortie,
            'author'       =>  $request->author
        ]);

        $data2 = DB::update(
            'update tlog_produit set qte = qte - :qteSortie where id = :refProduit',
            ['qteSortie' => $qte,'refProduit' => $idDetail]
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
            $montants = ($request->puSortie)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puSortie;
            $devises = $request->devise;
        }

        $data = tlog_detail_sortie::where('id', $id)->update([
            'refEnteteSortie'       =>  $request->refEnteteSortie,
            'refProduit'    =>  $request->refProduit,
            'puSortie'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'qteSortie'    =>  $request->qteSortie,
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
        $deleteds = DB::select('select * from tlog_detail_sortie'); 
        foreach ($deleteds as $deleted) {
            $qte = $deleted->qteSortie;
            $idDetail = $deleted->refProduit;
        }
        $data = tlog_detail_sortie::where('id',$id)->delete();

        $data2 = DB::update(
            'update tlog_produit set qte = qte + :qteSortie where id = :refProduit',
            ['qteSortie' => $qte,'refProduit' => $idDetail]
        );
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
