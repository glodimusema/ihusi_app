<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_stages;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;

class tperso_stagesController extends Controller
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
            //id,institution_id,personnel_id,option_id,promotion_id,annee_id,date_debut_stage,date_fin_stage,author
            $query = $this->Gquery($request);
            $data = DB::table('tperso_stages')
            ->join('tperso_institution_stage','tperso_institution_stage.id','=','tperso_stages.institution_id')
            ->join('tperso_option_stage','tperso_option_stage.id','=','tperso_stages.option_id')
            ->join('tperso_domaine_stage','tperso_domaine_stage.id','=','tperso_option_stage.domaine_id')
            ->join('tperso_promotion_stage','tperso_promotion_stage.id','=','tperso_stages.promotion_id')
            ->join('tperso_annee_stage','tperso_annee_stage.id','=','tperso_stages.annee_id')
            ->join('tperso_type_stage','tperso_type_stage.id','=','tperso_stages.typestage_id')
            ->join('tagent','tagent.id','=','tperso_stages.personnel_id')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_stages.id","institution_id","personnel_id","option_id","promotion_id","annee_id",
            "date_debut_stage","date_fin_stage","name_promotion","tperso_stages.created_at","tperso_stages.author","matricule_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","name_domaine","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
            "tagent.photo as photo_agent","tagent.slug as slug_agent","name_institution","name_option","name_annee")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->selectRaw('TIMESTAMPDIFF(DAY, CURDATE(), date_fin_stage) as dureerestante')
            ->where([
                ['noms_agent', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_stages.id", "desc")          
            ->paginate(10);
            return response($data, 200);
           

        }
        else{
            $data = DB::table('tperso_stages')
            ->join('tperso_institution_stage','tperso_institution_stage.id','=','tperso_stages.institution_id')
            ->join('tperso_option_stage','tperso_option_stage.id','=','tperso_stages.option_id')
            ->join('tperso_domaine_stage','tperso_domaine_stage.id','=','tperso_option_stage.domaine_id')
            ->join('tperso_promotion_stage','tperso_promotion_stage.id','=','tperso_stages.promotion_id')
            ->join('tperso_annee_stage','tperso_annee_stage.id','=','tperso_stages.annee_id')
            ->join('tperso_type_stage','tperso_type_stage.id','=','tperso_stages.typestage_id')
            ->join('tagent','tagent.id','=','tperso_stages.personnel_id')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_stages.id","institution_id","personnel_id","option_id","promotion_id","annee_id",
            "date_debut_stage","date_fin_stage","name_promotion","tperso_stages.created_at","tperso_stages.author","matricule_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","name_domaine","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
            "tagent.photo as photo_agent","tagent.slug as slug_agent","name_institution","name_option","name_annee")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
            ->selectRaw('TIMESTAMPDIFF(DAY, CURDATE(), date_fin_stage) as dureerestante')
            ->orderBy("tperso_stages.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }

    public function stage_encours(Request $request)
    { 
        $current = Carbon::now();

        if (!is_null($request->get('query'))) {
            # code..s.
            //id,institution_id, personnel_id,option_id,promotion_id,annee_id,date_debut_stage,date_fin_stage,author
            $query = $this->Gquery($request);
            $data = DB::table('tperso_stages')
            ->join('tperso_institution_stage','tperso_institution_stage.id','=','tperso_stages.institution_id')
            ->join('tperso_option_stage','tperso_option_stage.id','=','tperso_stages.option_id')
            ->join('tperso_domaine_stage','tperso_domaine_stage.id','=','tperso_option_stage.domaine_id')
            ->join('tperso_promotion_stage','tperso_promotion_stage.id','=','tperso_stages.promotion_id')
            ->join('tperso_annee_stage','tperso_annee_stage.id','=','tperso_stages.annee_id')
            ->join('tperso_type_stage','tperso_type_stage.id','=','tperso_stages.typestage_id')
            ->join('tagent','tagent.id','=','tperso_stages.personnel_id')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_stages.id","institution_id","personnel_id","option_id","promotion_id",
            "annee_id","name_typestage","typestage_id",
            "date_debut_stage","date_fin_stage","name_promotion","tperso_stages.created_at","tperso_stages.author","matricule_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","name_domaine","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
            "tagent.photo as photo_agent","tagent.slug as slug_agent","name_institution","name_option","name_annee")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->selectRaw('TIMESTAMPDIFF(DAY, CURDATE(), date_fin_stage) as dureerestante')
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['date_fin_stage', '>=', $current],
            ])               
            ->orderBy("tperso_stages.id", "desc")          
            ->paginate(10);
            return response($data, 200);
           

        }
        else{
            $data = DB::table('tperso_stages')
            ->join('tperso_institution_stage','tperso_institution_stage.id','=','tperso_stages.institution_id')
            ->join('tperso_option_stage','tperso_option_stage.id','=','tperso_stages.option_id')
            ->join('tperso_domaine_stage','tperso_domaine_stage.id','=','tperso_option_stage.domaine_id')
            ->join('tperso_promotion_stage','tperso_promotion_stage.id','=','tperso_stages.promotion_id')
            ->join('tperso_annee_stage','tperso_annee_stage.id','=','tperso_stages.annee_id')
            ->join('tperso_type_stage','tperso_type_stage.id','=','tperso_stages.typestage_id')
            ->join('tagent','tagent.id','=','tperso_stages.personnel_id')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_stages.id","institution_id","personnel_id","option_id","promotion_id","annee_id","name_typestage","typestage_id",
            "date_debut_stage","date_fin_stage","name_promotion","tperso_stages.created_at","tperso_stages.author","matricule_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","name_domaine","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
            "tagent.photo as photo_agent","tagent.slug as slug_agent","name_institution","name_option","name_annee")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->selectRaw('TIMESTAMPDIFF(DAY, CURDATE(), date_fin_stage) as dureerestante')
            ->where([
                ['date_fin_stage', '>=', $current],
            ])
            ->orderBy("tperso_stages.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }


    public function fetch_detail_entete(Request $request,$personnel_id)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_stages')
            ->join('tperso_institution_stage','tperso_institution_stage.id','=','tperso_stages.institution_id')
            ->join('tperso_option_stage','tperso_option_stage.id','=','tperso_stages.option_id')
            ->join('tperso_domaine_stage','tperso_domaine_stage.id','=','tperso_option_stage.domaine_id')
            ->join('tperso_promotion_stage','tperso_promotion_stage.id','=','tperso_stages.promotion_id')
            ->join('tperso_annee_stage','tperso_annee_stage.id','=','tperso_stages.annee_id')
            ->join('tperso_type_stage','tperso_type_stage.id','=','tperso_stages.typestage_id')
            ->join('tagent','tagent.id','=','tperso_stages.personnel_id')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_stages.id","institution_id","personnel_id","option_id","promotion_id","annee_id","name_typestage","typestage_id",
            "date_debut_stage","date_fin_stage","name_promotion","tperso_stages.created_at","tperso_stages.author","matricule_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","name_domaine","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
            "tagent.photo as photo_agent","tagent.slug as slug_agent","name_institution","name_option","name_annee")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->selectRaw('TIMESTAMPDIFF(DAY, CURDATE(), date_fin_stage) as dureerestante')
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['personnel_id',$personnel_id]
            ])                    
            ->orderBy("tperso_stages.id", "desc")
            ->paginate(10);

            return response($data, 200);        

        }
        else{
      
            $data = DB::table('tperso_stages')
            ->join('tperso_institution_stage','tperso_institution_stage.id','=','tperso_stages.institution_id')
            ->join('tperso_option_stage','tperso_option_stage.id','=','tperso_stages.option_id')
            ->join('tperso_domaine_stage','tperso_domaine_stage.id','=','tperso_option_stage.domaine_id')
            ->join('tperso_promotion_stage','tperso_promotion_stage.id','=','tperso_stages.promotion_id')
            ->join('tperso_annee_stage','tperso_annee_stage.id','=','tperso_stages.annee_id')
            ->join('tperso_type_stage','tperso_type_stage.id','=','tperso_stages.typestage_id')
            ->join('tagent','tagent.id','=','tperso_stages.personnel_id')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_stages.id","institution_id","personnel_id","option_id","promotion_id","annee_id","name_typestage","typestage_id",
            "date_debut_stage","date_fin_stage","name_promotion","tperso_stages.created_at","tperso_stages.author","matricule_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","name_domaine","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
            "tagent.photo as photo_agent","tagent.slug as slug_agent","name_institution","name_option","name_annee")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->selectRaw('TIMESTAMPDIFF(DAY, CURDATE(), date_fin_stage) as dureerestante')            
            ->Where('personnel_id',$personnel_id)    
            ->orderBy("tperso_stages.id", "desc")
            ->paginate(10);

            return response($data, 200);         
 
        }

    }    

    
   

    function fetch_single($id)
    {

        $data = DB::table('tperso_stages')
        ->join('tperso_institution_stage','tperso_institution_stage.id','=','tperso_stages.institution_id')
        ->join('tperso_option_stage','tperso_option_stage.id','=','tperso_stages.option_id')
        ->join('tperso_domaine_stage','tperso_domaine_stage.id','=','tperso_option_stage.domaine_id')
        ->join('tperso_promotion_stage','tperso_promotion_stage.id','=','tperso_stages.promotion_id')
        ->join('tperso_annee_stage','tperso_annee_stage.id','=','tperso_stages.annee_id')
        ->join('tperso_type_stage','tperso_type_stage.id','=','tperso_stages.typestage_id')
        ->join('tagent','tagent.id','=','tperso_stages.personnel_id')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_stages.id","institution_id","personnel_id","option_id","promotion_id","annee_id","name_typestage","typestage_id",
        "date_debut_stage","date_fin_stage","name_promotion","tperso_stages.created_at","tperso_stages.author","matricule_agent",
        "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","name_domaine","provinceOrigine_agent",
        "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
        "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
        "tagent.photo as photo_agent","tagent.slug as slug_agent","name_institution","name_option","name_annee")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
        ->selectRaw('TIMESTAMPDIFF(DAY, CURDATE(), date_fin_stage) as dureerestante') 
        ->where('tperso_stages.id', $id)
        ->get();

        return response($data, 200);
    }



  

    //id,institution_id,personnel_id,option_id,promotion_id,annee_id,date_debut_stage,date_fin_stage,author

    function insert_data(Request $request)
    {
        $data = tperso_stages::create([
            'personnel_id'       =>  $request->personnel_id,
            'institution_id'    =>  $request->institution_id,
            'option_id'    =>  $request->option_id,
            'promotion_id'    =>  $request->promotion_id,
            'annee_id'    =>  $request->annee_id,
            'typestage_id'    =>  $request->typestage_id,
            'date_debut_stage'    =>  $request->date_debut_stage,
            'date_fin_stage'    =>  $request->date_fin_stage,
            'author'       =>  $request->author,
        ]);
        return $this->msgJson('Information ajoutée avec succès');
    }


    function update_data(Request $request, $id)
    {
         $data = tperso_stages::where('id', $id)->update([
            'personnel_id'       =>  $request->personnel_id,
            'institution_id'    =>  $request->institution_id,
            'option_id'    =>  $request->option_id,
            'promotion_id'    =>  $request->promotion_id,
            'annee_id'    =>  $request->annee_id,
            'typestage_id'    =>  $request->typestage_id,
            'date_debut_stage'    =>  $request->date_debut_stage,
            'date_fin_stage'    =>  $request->date_fin_stage,
            'author'       =>  $request->author
        ]);
        return $this->msgJson('Information ajoutée avec succès');
    }


    function delete_data($id)
    {
        $data = tperso_stages::where('id',$id)->delete();
        return $this->msgJson('Information ajoutée avec succès');
        
    }
}
