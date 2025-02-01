<?php

namespace App\Http\Controllers\Logistique;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Logistique\tlog_detail_requisition;
use App\Traits\{GlobalMethod,Slug};
use DB;
class tlog_detail_requisitionController extends Controller
{
    use GlobalMethod, Slug;

    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
    }

    public function all(Request $request)
    { 

        $data = DB::table('tlog_detail_requisition')
        ->join('tlog_produit','tlog_produit.id','=','tlog_detail_requisition.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
        ->join('tlog_entete_requisition','tlog_entete_requisition.id','=','tlog_detail_requisition.refEnteteCmd')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tlog_entete_requisition.refFournisseur')
        ->select('tlog_detail_requisition.id','refEnteteCmd','refProduit','puCmd',
        'qteCmd','noms','contact','mail','adresse','dateCmd',
        'libelle',"tlog_produit.designation","refCategorie","pu","unite",
        "tvente_categorie_produit.designation as Categorie",'tlog_detail_requisition.author',
        'tlog_detail_requisition.created_at','tlog_detail_requisition.devise','tlog_detail_requisition.taux')
        ->selectRaw('(qteCmd*puCmd) as PTCmd')
        ->selectRaw('((qteCmd*puCmd)/tlog_detail_requisition.taux) as PTCmdFC');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("noms", "asc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tlog_detail_requisition.created_at", "desc");
        return $this->apiData($data->paginate(10));
        
    }


    public function fetch_data_entete(Request $request,$refEntete)
    { 

        $data = DB::table('tlog_detail_requisition')
        ->join('tlog_produit','tlog_produit.id','=','tlog_detail_requisition.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
        ->join('tlog_entete_requisition','tlog_entete_requisition.id','=','tlog_detail_requisition.refEnteteCmd')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tlog_entete_requisition.refFournisseur')
        ->select('tlog_detail_requisition.id','refEnteteCmd','refProduit','puCmd',
        'qteCmd','noms','contact','mail','adresse','dateCmd',
        'libelle',"tlog_produit.designation","refCategorie","pu","unite",
        "tvente_categorie_produit.designation as Categorie",'tlog_detail_requisition.author',
        'tlog_detail_requisition.created_at','tlog_detail_requisition.devise','tlog_detail_requisition.taux')
        ->selectRaw('(qteCmd*puCmd) as PTCmd')
        ->selectRaw('((qteCmd*puCmd)/tlog_detail_requisition.taux) as PTCmdFC')
        ->Where('refEnteteCmd',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms', 'like', '%'.$query.'%')          
            ->orderBy("noms", "asc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tlog_detail_requisition.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }    




    function fetch_single_data($id)
    {
        $data = DB::table('tlog_detail_requisition')
        ->join('tlog_produit','tlog_produit.id','=','tlog_detail_requisition.refProduit')
        ->join('tvente_categorie_produit','tvente_categorie_produit.id','=','tlog_produit.refCategorie')
        ->join('tlog_entete_requisition','tlog_entete_requisition.id','=','tlog_detail_requisition.refEnteteCmd')
        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tlog_entete_requisition.refFournisseur')
        ->select('tlog_detail_requisition.id','refEnteteCmd','refProduit','puCmd',
        'qteCmd','noms','contact','mail','adresse','dateCmd',
        'libelle',"tlog_produit.designation","refCategorie","pu","unite",
        "tvente_categorie_produit.designation as Categorie",'tlog_detail_requisition.author','tlog_detail_requisition.created_at')
        ->selectRaw('(qteCmd*puCmd) as PTCmd')
        ->where('tlog_detail_requisition.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
   //id,refEnteteCmd,refProduit,dateExpiration,numeroLot,puCmd,qteCmd,author
   
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
            $montants = ($request->puCmd)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puCmd;
            $devises = $request->devise;
        }

        $data = tlog_detail_requisition::create([
            'refEnteteCmd'       =>  $request->refEnteteCmd,
            'refProduit'    =>  $request->refProduit,
            'puCmd'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'qteCmd'    =>  $request->qteCmd,
            'author'       =>  $request->author
        ]);

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
            $montants = ($request->puCmd)/$taux;
            $devises='USD';
        }
        else
        {
            $montants = $request->puCmd;
            $devises = $request->devise;
        }


        $data = tlog_detail_requisition::where('id', $id)->update([
            'refEnteteCmd'       =>  $request->refEnteteCmd,
            'refProduit'    =>  $request->refProduit,
            'puCmd'    =>  $montants,
            'devise'    =>  $devises,
            'taux'    =>  $taux,
            'qteCmd'    =>  $request->qteCmd,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = tlog_detail_requisition::where('id',$id)->delete();              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);        
    }
}
