<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tchecklist;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;

class tchecklistController extends Controller
{
    use GlobalMethod, Slug  ;

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
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);
            $data = DB::table('tchecklist')
            ->join('tagent','tagent.id','=','tchecklist.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tchecklist.id",'refAgent','checklist','motivation','cv','diplome','carteidentite','actenaissance',
            'actenaissanceenfant','aptitudephysique','viemoeurs','servicerendu','ficheidentite','contrattravail',
            'jobdescription','actemariage','briefingmission','datebriefingmission','organigramme','dateorganigramme',
            'briefingposte','datebriefingposte','planstrategique','dateplanstrategique','briefinggestion',
            'datebriefinggestion','mannuel','datemannuel','evaluationstaff','datestaff1','datestaff2','datestaff3',
            'periodeconge','dateconge1','dateconge2','dateconge3',
            'briefingsecurite','datebriefingsecurite','notification','notefinance','datenotefinance','attesteservice',
            'dateattesteservice','tchecklist.author',"tchecklist.created_at","matricule_agent","noms_agent",
            "sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent",
            "refAvenue_agent","nummaison_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",'conjoint_agent', 
            'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent','Territoire_agent', 
            'EmployeurAnt_agent', 'PersRef_agent',"photo","slug","avenues.nomAvenue", "quartiers.idCommune",
            "quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille","communes.nomCommune",
            "villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince","pays.nomPays",
            "tagent.updated_at","cartes","envie")   
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')
            ->where([
                ['noms_agent', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tchecklist.id", "desc")          
            ->paginate(10);
            return response($data, 200);
        }
        else{
            $data = DB::table('tchecklist')
            ->join('tagent','tagent.id','=','tchecklist.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tchecklist.id",'refAgent','checklist','motivation','cv','diplome','carteidentite','actenaissance',
            'actenaissanceenfant','aptitudephysique','viemoeurs','servicerendu','ficheidentite','contrattravail',
            'jobdescription','actemariage','briefingmission','datebriefingmission','organigramme','dateorganigramme',
            'briefingposte','datebriefingposte','planstrategique','dateplanstrategique','briefinggestion',
            'datebriefinggestion','mannuel','datemannuel','evaluationstaff','datestaff1','datestaff2','datestaff3',
            'briefingsecurite','datebriefingsecurite','notification','notefinance','datenotefinance','attesteservice',
            'dateattesteservice','tchecklist.author',"tchecklist.created_at","matricule_agent","noms_agent",
            "sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent",
            "refAvenue_agent","nummaison_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",'conjoint_agent', 
            'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent','Territoire_agent', 
            'EmployeurAnt_agent', 'PersRef_agent',"photo","slug","avenues.nomAvenue", "quartiers.idCommune",
            "quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille","communes.nomCommune",
            "villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince","pays.nomPays",
            "tagent.updated_at","cartes","envie",'periodeconge','dateconge1','dateconge2','dateconge3')   
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')
            ->orderBy("tchecklist.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }


    public function fetch_detail_entete(Request $request,$refAgent)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tchecklist')
            ->join('tagent','tagent.id','=','tchecklist.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tchecklist.id",'refAgent','checklist','motivation','cv','diplome','carteidentite','actenaissance',
            'actenaissanceenfant','aptitudephysique','viemoeurs','servicerendu','ficheidentite','contrattravail',
            'jobdescription','actemariage','briefingmission','datebriefingmission','organigramme','dateorganigramme',
            'briefingposte','datebriefingposte','planstrategique','dateplanstrategique','briefinggestion',
            'datebriefinggestion','mannuel','datemannuel','evaluationstaff','datestaff1','datestaff2','datestaff3',
            'briefingsecurite','datebriefingsecurite','notification','notefinance','datenotefinance','attesteservice',
            'dateattesteservice','tchecklist.author',"tchecklist.created_at","matricule_agent","noms_agent",
            "sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent",
            "refAvenue_agent","nummaison_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",'conjoint_agent', 
            'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent','Territoire_agent', 
            'EmployeurAnt_agent', 'PersRef_agent',"photo","slug","avenues.nomAvenue", "quartiers.idCommune",
            "quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille","communes.nomCommune",
            "villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince","pays.nomPays",
            "tagent.updated_at","cartes","envie",'periodeconge','dateconge1','dateconge2','dateconge3')   
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')
            ->where([
                ['description_tache', 'like', '%'.$query.'%'],
                ['refAgent',$refAgent]
            ])                    
            ->orderBy("tchecklist.id", "desc")
            ->paginate(10);

            return response($data, 200);        

        }
        else{
      
            $data = DB::table('tchecklist')
            ->join('tagent','tagent.id','=','tchecklist.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tchecklist.id",'refAgent','checklist','motivation','cv','diplome','carteidentite','actenaissance',
            'actenaissanceenfant','aptitudephysique','viemoeurs','servicerendu','ficheidentite','contrattravail',
            'jobdescription','actemariage','briefingmission','datebriefingmission','organigramme','dateorganigramme',
            'briefingposte','datebriefingposte','planstrategique','dateplanstrategique','briefinggestion',
            'datebriefinggestion','mannuel','datemannuel','evaluationstaff','datestaff1','datestaff2','datestaff3',
            'briefingsecurite','datebriefingsecurite','notification','notefinance','datenotefinance','attesteservice',
            'dateattesteservice','tchecklist.author',"tchecklist.created_at","matricule_agent","noms_agent",
            "sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent",
            "refAvenue_agent","nummaison_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",'conjoint_agent', 
            'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent','Territoire_agent', 
            'EmployeurAnt_agent', 'PersRef_agent',"photo","slug","avenues.nomAvenue", "quartiers.idCommune",
            "quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille","communes.nomCommune",
            "villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince","pays.nomPays",
            "tagent.updated_at","cartes","envie",'periodeconge','dateconge1','dateconge2','dateconge3')   
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')           
            ->Where('refAgent',$refAgent)    
            ->orderBy("tchecklist.id", "desc")
            ->paginate(10);

            return response($data, 200);         
 
        }

    }    


    function fetch_single($id)
    {

        $data = DB::table('tchecklist')
        ->join('tagent','tagent.id','=','tchecklist.refAgent')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tchecklist.id",'refAgent','checklist','motivation','cv','diplome','carteidentite','actenaissance',
        'actenaissanceenfant','aptitudephysique','viemoeurs','servicerendu','ficheidentite','contrattravail',
        'jobdescription','actemariage','briefingmission','datebriefingmission','organigramme','dateorganigramme',
        'briefingposte','datebriefingposte','planstrategique','dateplanstrategique','briefinggestion',
        'datebriefinggestion','mannuel','datemannuel','evaluationstaff','datestaff1','datestaff2','datestaff3',
        'briefingsecurite','datebriefingsecurite','notification','notefinance','datenotefinance','attesteservice',
        'dateattesteservice','tchecklist.author',"tchecklist.created_at","matricule_agent","noms_agent",
        "sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent",
        "refAvenue_agent","nummaison_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
        "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",'conjoint_agent', 
        'nomPere_agent', 'nomMere_agent', 'Nationalite_agent', 'Collectivite_agent','Territoire_agent', 
        'EmployeurAnt_agent', 'PersRef_agent',"photo","slug","avenues.nomAvenue", "quartiers.idCommune",
        "quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille","communes.nomCommune",
        "villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince","pays.nomPays",
        "tagent.updated_at","cartes","envie",'periodeconge','dateconge1','dateconge2','dateconge3')   
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')
        ->where('tchecklist.id', $id)
        ->get();

        return response($data, 200);
    }

//'id','refAgent','checklist','motivation','cv','diplome','carteidentite','actenaissance',
// 'actenaissanceenfant','aptitudephysique','viemoeurs','servicerendu','ficheidentite','contrattravail',
// 'jobdescription','actemariage','briefingmission','datebriefingmission','organigramme','dateorganigramme',
// 'briefingposte','datebriefingposte','planstrategique','dateplanstrategique','briefinggestion',
// 'datebriefinggestion','mannuel','datemannuel','evaluationstaff','datestaff1','datestaff2','datestaff3',
// 'briefingsecurite','datebriefingsecurite','notification','notefinance','datenotefinance','attesteservice',
// 'dateattesteservice','author'   

    function insert_data(Request $request)
    {
        $data = tchecklist::create([
            'refAgent'       =>  $request->refAgent,
            'checklist' =>  $request->checklist,
            'motivation' =>  $request->motivation,
            'cv' =>  $request->cv,
            'diplome' =>  $request->diplome,
            'carteidentite' =>  $request->carteidentite,
            'actenaissance' =>  $request->actenaissance,
            'actenaissanceenfant' =>  $request->actenaissanceenfant,
            'aptitudephysique' =>  $request->aptitudephysique,
            'viemoeurs' =>  $request->viemoeurs,
            'servicerendu' =>  $request->servicerendu,
            'ficheidentite' =>  $request->ficheidentite,
            'contrattravail' =>  $request->contrattravail,
            'jobdescription' =>  $request->jobdescription,
            'actemariage' =>  $request->actemariage,
            'briefingmission' =>  $request->briefingmission,
            'datebriefingmission' =>  $request->datebriefingmission,
            'organigramme' =>  $request->organigramme,
            'dateorganigramme' =>  $request->dateorganigramme,
            'briefingposte' =>  $request->briefingposte,
            'datebriefingposte' =>  $request->datebriefingposte,
            'planstrategique' =>  $request->planstrategique,
            'dateplanstrategique' =>  $request->dateplanstrategique,
            'briefinggestion' =>  $request->briefinggestion,
            'datebriefinggestion' =>  $request->datebriefinggestion,
            'mannuel' =>  $request->mannuel,
            'datemannuel' =>  $request->datemannuel,
            'evaluationstaff' =>  $request->evaluationstaff,
            'datestaff1' =>  $request->datestaff1,
            'datestaff2' =>  $request->datestaff2,
            'datestaff3' =>  $request->datestaff3,
            'periodeconge' =>  $request->periodeconge,
            'dateconge1' =>  $request->dateconge1,
            'dateconge2' =>  $request->dateconge2,
            'dateconge3' =>  $request->dateconge3,
            'briefingsecurite' =>  $request->briefingsecurite,
            'datebriefingsecurite' =>  $request->datebriefingsecurite,
            'notification' =>  $request->notification,
            'notefinance' =>  $request->notefinance,
            'datenotefinance' =>  $request->datenotefinance,
            'attesteservice' =>  $request->attesteservice,
            'dateattesteservice' =>  $request->dateattesteservice,
            'author'       =>  $request->author
        ]);

        return $this->msgJson('Information ajoutée avec succès');
    }


    function update_data(Request $request, $id)
    {
         $data = tchecklist::where('id', $id)->update([
            'refAgent'       =>  $request->refAgent,
            'checklist' =>  $request->checklist,
            'motivation' =>  $request->motivation,
            'cv' =>  $request->cv,
            'diplome' =>  $request->diplome,
            'carteidentite' =>  $request->carteidentite,
            'actenaissance' =>  $request->actenaissance,
            'actenaissanceenfant' =>  $request->actenaissanceenfant,
            'aptitudephysique' =>  $request->aptitudephysique,
            'viemoeurs' =>  $request->viemoeurs,
            'servicerendu' =>  $request->servicerendu,
            'ficheidentite' =>  $request->ficheidentite,
            'contrattravail' =>  $request->contrattravail,
            'jobdescription' =>  $request->jobdescription,
            'actemariage' =>  $request->actemariage,
            'briefingmission' =>  $request->briefingmission,
            'datebriefingmission' =>  $request->datebriefingmission,
            'organigramme' =>  $request->organigramme,
            'dateorganigramme' =>  $request->dateorganigramme,
            'briefingposte' =>  $request->briefingposte,
            'datebriefingposte' =>  $request->datebriefingposte,
            'planstrategique' =>  $request->planstrategique,
            'dateplanstrategique' =>  $request->dateplanstrategique,
            'briefinggestion' =>  $request->briefinggestion,
            'datebriefinggestion' =>  $request->datebriefinggestion,
            'mannuel' =>  $request->mannuel,
            'datemannuel' =>  $request->datemannuel,
            'evaluationstaff' =>  $request->evaluationstaff,
            'datestaff1' =>  $request->datestaff1,
            'datestaff2' =>  $request->datestaff2,
            'datestaff3' =>  $request->datestaff3,
            'periodeconge' =>  $request->periodeconge,
            'dateconge1' =>  $request->dateconge1,
            'dateconge2' =>  $request->dateconge2,
            'dateconge3' =>  $request->dateconge3,
            'briefingsecurite' =>  $request->briefingsecurite,
            'datebriefingsecurite' =>  $request->datebriefingsecurite,
            'notification' =>  $request->notification,
            'notefinance' =>  $request->notefinance,
            'datenotefinance' =>  $request->datenotefinance,
            'attesteservice' =>  $request->attesteservice,
            'dateattesteservice' =>  $request->dateattesteservice,
            'author'       =>  $request->author,
        ]);       
        return $this->msgJson('Information ajoutée avec succès');
    }


    function delete_data($id)
    {
        $data = tchecklist::where('id',$id)->delete();
        return $this->msgJson('Information ajoutée avec succès');
        
    }
}
