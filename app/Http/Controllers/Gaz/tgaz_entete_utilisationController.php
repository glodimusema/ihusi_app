<?php

namespace App\Http\Controllers\Gaz;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gaz\tgaz_entete_utilisation;
use App\Models\Gaz\tgaz_detail_utilisation;
use App\Models\Facture;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tgaz_entete_utilisationController extends Controller
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

        $data = DB::table('tgaz_entete_utilisation')
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_utilisation.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_utilisation.refService')
        ->join('tagent','tagent.id','=','tgaz_entete_utilisation.agent_id')        
        ->select('tgaz_entete_utilisation.id','tgaz_entete_utilisation.code','refService','module_id',
        'dateUse','libelle','tgaz_entete_utilisation.author','tgaz_entete_utilisation.refUser',
        'agent_id','tgaz_entete_utilisation.created_at'
        
        ,'nom_service', "tvente_module.nom_module"

        ,'matricule_agent','noms_agent','sexe_agent','datenaissance_agent',
        'lieunaissnce_agent','provinceOrigine_agent','etatcivil_agent','refAvenue_agent','nummaison_agent',
        'contact_agent','mail_agent','grade_agent','fonction_agent','specialite_agent',
        'Categorie_agent','niveauEtude_agent','anneeFinEtude_agent','Ecole_agent','conjoint_agent', 
        'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
        'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent','photo','slug','cartes','envie')
        ->selectRaw('CONCAT("F",YEAR(dateUse),"",MONTH(dateUse),"00",tgaz_entete_utilisation.id) as codeFacture');
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms_agent', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_entete_utilisation.created_at", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        $data->orderBy("tgaz_entete_utilisation.created_at", "desc");
        return $this->apiData($data->paginate(10));
       
    }


    public function fetch_data_entete(Request $request,$refEntete)
    {
        $data = DB::table('tgaz_entete_utilisation')
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_utilisation.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_utilisation.refService')
        ->join('tagent','tagent.id','=','tgaz_entete_utilisation.agent_id')        
        ->select('tgaz_entete_utilisation.id','tgaz_entete_utilisation.code','refService','module_id',
        'dateUse','libelle','tgaz_entete_utilisation.author','tgaz_entete_utilisation.refUser',
        'agent_id','tgaz_entete_utilisation.created_at'
        
        ,'nom_service', "tvente_module.nom_module"

        ,'matricule_agent','noms_agent','sexe_agent','datenaissance_agent',
        'lieunaissnce_agent','provinceOrigine_agent','etatcivil_agent','refAvenue_agent','nummaison_agent',
        'contact_agent','mail_agent','grade_agent','fonction_agent','specialite_agent',
        'Categorie_agent','niveauEtude_agent','anneeFinEtude_agent','Ecole_agent','conjoint_agent', 
        'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
        'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent','photo','slug','cartes','envie')
        ->selectRaw('CONCAT("F",YEAR(dateUse),"",MONTH(dateUse),"00",tgaz_entete_utilisation.id) as codeFacture')
        ->Where('refClient',$refEntete);
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data ->where('noms_agent', 'like', '%'.$query.'%')          
            ->orderBy("tgaz_entete_utilisation.created_at", "desc");
            return $this->apiData($data->paginate(10));         

        }       
        $data->orderBy("tgaz_entete_utilisation.created_at", "desc");
        return $this->apiData($data->paginate(10));
    }     
    

    function fetch_single_data($id)
    {

        $data = DB::table('tgaz_entete_utilisation')
        ->join('tvente_module','tvente_module.id','=','tgaz_entete_utilisation.module_id')
        ->join('tvente_services','tvente_services.id','=','tgaz_entete_utilisation.refService')
        ->join('tagent','tagent.id','=','tgaz_entete_utilisation.agent_id')        
        ->select('tgaz_entete_utilisation.id','tgaz_entete_utilisation.code','refService','module_id',
        'dateUse','libelle','tgaz_entete_utilisation.author','tgaz_entete_utilisation.refUser',
        'agent_id','tgaz_entete_utilisation.created_at'
        
        ,'nom_service', "tvente_module.nom_module"

        ,'matricule_agent','noms_agent','sexe_agent','datenaissance_agent',
        'lieunaissnce_agent','provinceOrigine_agent','etatcivil_agent','refAvenue_agent','nummaison_agent',
        'contact_agent','mail_agent','grade_agent','fonction_agent','specialite_agent',
        'Categorie_agent','niveauEtude_agent','anneeFinEtude_agent','Ecole_agent','conjoint_agent', 
        'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent', 
        'Territoire_agent', 'EmployeurAnt_agent', 'PersRef_agent','photo','slug','cartes','envie')
        ->selectRaw('CONCAT("F",YEAR(dateUse),"",MONTH(dateUse),"00",tgaz_entete_utilisation.id) as codeFacture')
        ->where('tgaz_entete_utilisation.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }


    function insert_data(Request $request)
    {
        //'id','code','refService','module_id','agent_id','dateUse','libelle','author','refUser'
        $module_id = 7;
        $code = $this->GetCodeData('tvente_param_systeme','module_id',$request->module_id);
        $data = tgaz_entete_utilisation::create([
            'code'       =>  $code,
            'refService'       =>  $request->refService, 
            'module_id'       =>  $module_id,
            'agent_id'    =>  $request->agent_id,
            'dateUse'    =>  $request->dateUse,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_data(Request $request, $id)
    {
        $data = tgaz_entete_utilisation::where('id', $id)->update([            
            'refService'       =>  $request->refService, 
            'agent_id'    =>  $request->agent_id,
            'dateUse'    =>  $request->dateUse,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author,
            'refUser'       =>  $request->refUser
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        
        $qte=0;
        $pu=0;
        $montantreduction=0;
        $montanttva=0;
        $idStockService=0;
        $idDetail=0;

        $deleteds = DB::table('tgaz_detail_utilisation')->Where('refEnteteVente',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $idDetail = $deleted->id;
            $qte = $deleted->qteVente;            
            $pu = $deleted->puVente;
            $idStockService = $deleted->idStockService;
   
            $data2 = DB::update(
                'update tgaz_stock_service_lot set qte_lot = qte_lot + :qteVente where tgaz_stock_service_lot.id = :id',
                ['qteVente' => $qte,'id' => $idStockService]
            ); 

            $nom_table = 'tgaz_detail_utilisation';

            $data4 = DB::update(
                'delete from tvente_mouvement_stock where tvente_mouvement_stock.id_data = :id and nom_table=:nom_table',
                ['id' => $idDetail, 'nom_table' => $nom_table]
            );
    
            $data1 = tgaz_detail_utilisation::where('id',$idDetail)->delete();

        }

        $data1 = tgaz_detail_utilisation::where('refEnteteVente',$id)->delete();
        $data = tgaz_entete_utilisation::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
