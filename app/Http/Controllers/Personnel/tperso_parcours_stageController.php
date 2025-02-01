<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_parcours_stage;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;

class tperso_parcours_stageController extends Controller
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
//
    public function all(Request $request)
    {    
        if (!is_null($request->get('query'))) {
            # code..s.
            //tperso_parcours_stage id,stage_id,service_id,date_debut_parcours,date_fin_parcours,tache_parcours,apprecition_parcours,author
            $query = $this->Gquery($request);
            $data = DB::table('tperso_parcours_stage')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_parcours_stage.service_id')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('tperso_stages','tperso_stages.id','=','tperso_parcours_stage.stage_id')
            ->join('tperso_institution_stage','tperso_institution_stage.id','=','tperso_stages.institution_id')
            ->join('tperso_option_stage','tperso_option_stage.id','=','tperso_stages.option_id')
            ->join('tperso_domaine_stage','tperso_domaine_stage.id','=','tperso_option_stage.domaine_id')
            ->join('tperso_promotion_stage','tperso_promotion_stage.id','=','tperso_stages.promotion_id')
            ->join('tperso_annee_stage','tperso_annee_stage.id','=','tperso_stages.annee_id')
            ->join('tagent','tagent.id','=','tperso_stages.personnel_id')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_parcours_stage.id","stage_id","service_id","date_debut_parcours","date_fin_parcours",
            "tache_parcours","apprecition_parcours","institution_id","personnel_id","option_id","promotion_id","annee_id",
            "date_debut_stage","date_fin_stage","name_promotion","tperso_parcours_stage.created_at",
            "tperso_parcours_stage.author","matricule_agent","name_serv_perso","name_categorie_service","refCatService",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","name_domaine","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
            "tagent.photo as photo_agent","tagent.slug as slug_agent","name_option","name_domaine","domaine_id")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->where([
                ['noms_agent', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_parcours_stage.id", "desc")          
            ->paginate(10);
            return response($data, 200);
           

        }
        else{
            $data = DB::table('tperso_parcours_stage')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_parcours_stage.service_id')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('tperso_stages','tperso_stages.id','=','tperso_parcours_stage.stage_id')
            ->join('tperso_institution_stage','tperso_institution_stage.id','=','tperso_stages.institution_id')
            ->join('tperso_option_stage','tperso_option_stage.id','=','tperso_stages.option_id')
            ->join('tperso_domaine_stage','tperso_domaine_stage.id','=','tperso_option_stage.domaine_id')
            ->join('tperso_promotion_stage','tperso_promotion_stage.id','=','tperso_stages.promotion_id')
            ->join('tperso_annee_stage','tperso_annee_stage.id','=','tperso_stages.annee_id')
            ->join('tagent','tagent.id','=','tperso_stages.personnel_id')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_parcours_stage.id","stage_id","service_id","date_debut_parcours","date_fin_parcours",
            "tache_parcours","apprecition_parcours","institution_id","personnel_id","option_id","promotion_id","annee_id",
            "date_debut_stage","date_fin_stage","name_promotion","tperso_parcours_stage.created_at",
            "tperso_parcours_stage.author","matricule_agent","name_serv_perso","name_categorie_service","refCatService",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","name_domaine","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
            "tagent.photo as photo_agent","tagent.slug as slug_agent","name_option","name_domaine","domaine_id")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->orderBy("tperso_parcours_stage.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }


    public function fetch_detail_entete(Request $request,$stage_id)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_parcours_stage')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_parcours_stage.service_id')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('tperso_stages','tperso_stages.id','=','tperso_parcours_stage.stage_id')
            ->join('tperso_institution_stage','tperso_institution_stage.id','=','tperso_stages.institution_id')
            ->join('tperso_option_stage','tperso_option_stage.id','=','tperso_stages.option_id')
            ->join('tperso_domaine_stage','tperso_domaine_stage.id','=','tperso_option_stage.domaine_id')
            ->join('tperso_promotion_stage','tperso_promotion_stage.id','=','tperso_stages.promotion_id')
            ->join('tperso_annee_stage','tperso_annee_stage.id','=','tperso_stages.annee_id')
            ->join('tagent','tagent.id','=','tperso_stages.personnel_id')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_parcours_stage.id","stage_id","service_id","date_debut_parcours","date_fin_parcours",
            "tache_parcours","apprecition_parcours","institution_id","personnel_id","option_id","promotion_id","annee_id",
            "date_debut_stage","date_fin_stage","name_promotion","tperso_parcours_stage.created_at",
            "tperso_parcours_stage.author","matricule_agent","name_serv_perso","name_categorie_service","refCatService",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","name_domaine","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
            "tagent.photo as photo_agent","tagent.slug as slug_agent","name_option","name_domaine","domaine_id")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent') 
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['stage_id',$stage_id]
            ])                    
            ->orderBy("tperso_parcours_stage.id", "desc")
            ->paginate(10);

            return response($data, 200);        

        }
        else{
      
            $data = DB::table('tperso_parcours_stage')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_parcours_stage.service_id')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('tperso_stages','tperso_stages.id','=','tperso_parcours_stage.stage_id')
            ->join('tperso_institution_stage','tperso_institution_stage.id','=','tperso_stages.institution_id')
            ->join('tperso_option_stage','tperso_option_stage.id','=','tperso_stages.option_id')
            ->join('tperso_domaine_stage','tperso_domaine_stage.id','=','tperso_option_stage.domaine_id')
            ->join('tperso_promotion_stage','tperso_promotion_stage.id','=','tperso_stages.promotion_id')
            ->join('tperso_annee_stage','tperso_annee_stage.id','=','tperso_stages.annee_id')
            ->join('tagent','tagent.id','=','tperso_stages.personnel_id')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_parcours_stage.id","stage_id","service_id","date_debut_parcours","date_fin_parcours",
            "tache_parcours","apprecition_parcours","institution_id","personnel_id","option_id","promotion_id","annee_id",
            "date_debut_stage","date_fin_stage","name_promotion","tperso_parcours_stage.created_at",
            "tperso_parcours_stage.author","matricule_agent","name_serv_perso","name_categorie_service","refCatService",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","name_domaine","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
            "tagent.photo as photo_agent","tagent.slug as slug_agent","name_option","name_domaine","domaine_id")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')              
            ->Where('stage_id',$stage_id)    
            ->orderBy("tperso_parcours_stage.id", "desc")
            ->paginate(10);

            return response($data, 200);         
 
        }

    }    

    
   

    function fetch_single($id)
    {

        $data = DB::table('tperso_parcours_stage')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_parcours_stage.service_id')
        ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
        ->join('tperso_stages','tperso_stages.id','=','tperso_parcours_stage.stage_id')
        ->join('tperso_institution_stage','tperso_institution_stage.id','=','tperso_stages.institution_id')
        ->join('tperso_option_stage','tperso_option_stage.id','=','tperso_stages.option_id')
        ->join('tperso_domaine_stage','tperso_domaine_stage.id','=','tperso_option_stage.domaine_id')
        ->join('tperso_promotion_stage','tperso_promotion_stage.id','=','tperso_stages.promotion_id')
        ->join('tperso_annee_stage','tperso_annee_stage.id','=','tperso_stages.annee_id')
        ->join('tagent','tagent.id','=','tperso_stages.personnel_id')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_parcours_stage.id","stage_id","service_id","date_debut_parcours","date_fin_parcours",
        "tache_parcours","apprecition_parcours","institution_id","personnel_id","option_id","promotion_id","annee_id",
        "date_debut_stage","date_fin_stage","name_promotion","tperso_parcours_stage.created_at",
        "tperso_parcours_stage.author","matricule_agent","name_serv_perso","name_categorie_service","refCatService",
        "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","name_domaine","provinceOrigine_agent",
        "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
        "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
        "tagent.photo as photo_agent","tagent.slug as slug_agent","name_option","name_domaine","domaine_id")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
        ->where('tperso_parcours_stage.id', $id)
        ->get();

        return response($data, 200);
    }  

   //tperso_parcours_stage id,stage_id,service_id,date_debut_parcours,date_fin_parcours,tache_parcours,apprecition_parcours,author

    function insert_data(Request $request)
    {
        $data = tperso_parcours_stage::create([
            'stage_id'       =>  $request->stage_id,
            'service_id'    =>  $request->service_id,
            'date_debut_parcours'    =>  $request->date_debut_parcours,
            'date_fin_parcours'    =>  $request->date_fin_parcours,
            'tache_parcours'    =>  $request->tache_parcours,
            'apprecition_parcours'    =>  $request->apprecition_parcours,
            'author'       =>  $request->author,
        ]);
        return $this->msgJson('Information ajoutée avec succès');
    }


    function update_data(Request $request, $id)
    {
        $data = tperso_parcours_stage::where('id', $id)->update([
            'stage_id'       =>  $request->stage_id,
            'service_id'    =>  $request->service_id,
            'date_debut_parcours'    =>  $request->date_debut_parcours,
            'date_fin_parcours'    =>  $request->date_fin_parcours,
            'tache_parcours'    =>  $request->tache_parcours,
            'apprecition_parcours'    =>  $request->apprecition_parcours,
            'author'       =>  $request->author,
        ]);
        return $this->msgJson('Information ajoutée avec succès');
    }


    function delete_data($id)
    {
        $data = tperso_parcours_stage::where('id',$id)->delete();
        return $this->msgJson('Information ajoutée avec succès');
        
    }
}
