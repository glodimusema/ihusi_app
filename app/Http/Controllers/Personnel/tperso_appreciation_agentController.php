<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_appreciation_agent;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tperso_appreciation_agentController extends Controller
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
            $data = DB::table('tperso_appreciation_agent')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_appreciation_agent.refAffectation')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_appreciation_agent.id","periodeDu","connaissanceTheorique","appliDeontologie",
            "manipulation","prendConsideration","ponctualite","ordre","fiabilite","espritEquipe","courtoisie",
            "sensResponsabilite","sensEcoute","preparationExecution","organiseTravail","dateAppreciation",
            "agent","suiveur","hierarchie","rh","refAffectation",'Propositions',
            "dateAffectation","codeAgent","numCNSS","autresDetail",
            "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
            "noms_agent",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
            ->selectRaw('(connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail) as TotalPoints')
            ->selectRaw("(
                CASE 
                WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=0) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=49)) THEN 'INSUFFISANT(0-49)'
                WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=50) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=59)) THEN 'ASSEZ BON(50-59)'
                WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=60) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=69)) THEN 'BON(60-69)'
                WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=70) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=79)) THEN 'TRES BON(70-79)'
                WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=80) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=100)) THEN 'ELITE(80-100)'
            END 
            ) as Mension") 
            ->where([
                ['noms_agent', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_appreciation_agent.id", "desc")          
            ->paginate(10);

            return response($data, 200);       
        }
        else{
            $data = DB::table('tperso_appreciation_agent')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_appreciation_agent.refAffectation')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_appreciation_agent.id","periodeDu","connaissanceTheorique","appliDeontologie",
            "manipulation","prendConsideration","ponctualite","ordre","fiabilite","espritEquipe","courtoisie",
            "sensResponsabilite","sensEcoute","preparationExecution","organiseTravail","dateAppreciation",
            "agent","suiveur","hierarchie","rh","refAffectation",'Propositions',
            "dateAffectation","codeAgent","numCNSS","autresDetail",
            "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
            "noms_agent",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
            ->selectRaw('(connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail) as TotalPoints')
            ->selectRaw("(
                CASE 
                WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=0) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=49)) THEN 'INSUFFISANT(0-49)'
                WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=50) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=59)) THEN 'ASSEZ BON(50-59)'
                WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=60) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=69)) THEN 'BON(60-69)'
                WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=70) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=79)) THEN 'TRES BON(70-79)'
                WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=80) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=100)) THEN 'ELITE(80-100)'
            END 
            ) as Mension")  
            ->orderBy("tperso_appreciation_agent.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }


    public function fetch_affect_appreciation(Request $request,$refAffectation)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_appreciation_agent')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_appreciation_agent.refAffectation')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_appreciation_agent.id","periodeDu","connaissanceTheorique","appliDeontologie",
            "manipulation","prendConsideration","ponctualite","ordre","fiabilite","espritEquipe","courtoisie",
            "sensResponsabilite","sensEcoute","preparationExecution","organiseTravail","dateAppreciation",
            "agent","suiveur","hierarchie","rh","refAffectation",'Propositions',
            "dateAffectation","codeAgent","numCNSS","autresDetail",
            "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
            "noms_agent",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
            ->selectRaw('(connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail) as TotalPoints')
            ->selectRaw("(
                CASE 
                WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=0) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=49)) THEN 'INSUFFISANT(0-49)'
                WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=50) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=59)) THEN 'ASSEZ BON(50-59)'
                WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=60) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=69)) THEN 'BON(60-69)'
                WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=70) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=79)) THEN 'TRES BON(70-79)'
                WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=80) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=100)) THEN 'ELITE(80-100)'
            END 
            ) as Mension")   
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['refAffectation',$refAffectation]
            ])                    
            ->orderBy("tperso_appreciation_agent.id", "desc")
            ->paginate(10);

            return response($data, 200);         

        }
        else{
      
            $data = DB::table('tperso_appreciation_agent')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_appreciation_agent.refAffectation')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_appreciation_agent.id","periodeDu","connaissanceTheorique","appliDeontologie",
            "manipulation","prendConsideration","ponctualite","ordre","fiabilite","espritEquipe","courtoisie",
            "sensResponsabilite","sensEcoute","preparationExecution","organiseTravail","dateAppreciation",
            "agent","suiveur","hierarchie","rh","refAffectation",'Propositions',
            "dateAffectation","codeAgent","numCNSS","autresDetail",
            "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
            "noms_agent",
            "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
            "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
            "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
            ->selectRaw('(connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail) as TotalPoints')
            ->selectRaw("(
                CASE 
                WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=0) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=49)) THEN 'INSUFFISANT(0-49)'
                WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=50) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=59)) THEN 'ASSEZ BON(50-59)'
                WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=60) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=69)) THEN 'BON(60-69)'
                WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=70) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=79)) THEN 'TRES BON(70-79)'
                WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=80) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=100)) THEN 'ELITE(80-100)'
            END 
            ) as Mension")   
            ->Where('refAffectation',$refAffectation)    
            ->orderBy("tperso_appreciation_agent.id", "desc")
            ->paginate(10);

            return response($data, 200);         
 
        }

    }    
    
    function fetch_single($id)
    {

        $data = DB::table('tperso_appreciation_agent')
        ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_appreciation_agent.refAffectation')
        ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
        ->join('tperso_categorie_agent','tperso_categorie_agent.id','tperso_affectation_agent.refCategorieAgent')
        ->join('tperso_service_personnel','tperso_service_personnel.id','tperso_affectation_agent.refServicePerso')
        ->join('tperso_categorie_service','tperso_categorie_service.id','tperso_service_personnel.refCatService')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_appreciation_agent.id","periodeDu","connaissanceTheorique","appliDeontologie",
        "manipulation","prendConsideration","ponctualite","ordre","fiabilite","espritEquipe","courtoisie",
        "sensResponsabilite","sensEcoute","preparationExecution","organiseTravail","dateAppreciation",
        "agent","suiveur","hierarchie","rh","refAffectation",'Propositions',
        "dateAffectation","codeAgent","numCNSS","autresDetail",
        "refAgent","refServicePerso","refCategorieAgent","matricule_agent",
        "noms_agent",
        "lieunaissnce_agent","provinceOrigine_agent","etatcivil_agent","refAvenue_agent",
        "contact_agent","mail_agent","grade_agent","fonction_agent","specialite_agent",
        "Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
        "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
        ->selectRaw('(connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail) as TotalPoints')
        ->selectRaw("(
            CASE 
            WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=0) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=49)) THEN 'INSUFFISANT(0-49)'
            WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=50) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=59)) THEN 'ASSEZ BON(50-59)'
            WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=60) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=69)) THEN 'BON(60-69)'
            WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=70) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=79)) THEN 'TRES BON(70-79)'
            WHEN (((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)>=80) AND ((connaissanceTheorique + appliDeontologie + manipulation + prendConsideration + ponctualite + ordre + fiabilite + espritEquipe + courtoisie + sensResponsabilite + sensEcoute + preparationExecution + organiseTravail)<=100)) THEN 'ELITE(80-100)'
        END 
        ) as Mension")   
        ->where('tperso_appreciation_agent.id', $id)
        ->get();

        return response($data, 200);
    }

    //id,refAffectation,periodeDu,connaissanceTheorique,appliDeontologie,manipulation,prendConsideration,ponctualite,
    //ordre,fiabilite,espritEquipe,courtoisie,sensResponsabilite,sensEcoute,preparationExecution,organiseTravail,Propositions,
    //dateAppreciation,agent,suiveur,hierarchie,rh,author

    function insert_data(Request $request)
    {
      
        $data = tperso_appreciation_agent::create([
            'refAffectation'       =>  $request->refAffectation,
            'periodeDu'    =>  $request->periodeDu,
            'connaissanceTheorique'    =>  $request->connaissanceTheorique,
            'appliDeontologie'    =>  $request->appliDeontologie,    
            'manipulation'    =>  $request->manipulation,
            'prendConsideration'    =>  $request->prendConsideration,       
            'ponctualite'       =>  $request->ponctualite,
            'ordre'       =>  $request->ordre,
            'fiabilite'       =>  $request->fiabilite,
            'espritEquipe'    =>  $request->espritEquipe,
            'courtoisie'    =>  $request->courtoisie,
            'sensResponsabilite'    =>  $request->sensResponsabilite,    
            'sensEcoute'    =>  $request->sensEcoute,
            'preparationExecution'    =>  $request->preparationExecution,       
            'organiseTravail'       =>  $request->organiseTravail,
            'Propositions'       =>  $request->Propositions,
            'dateAppreciation'       =>  $request->dateAppreciation,
            'agent'       =>  $request->agent,
            'suiveur'       =>  $request->suiveur,
            'hierarchie'       =>  $request->hierarchie,
            'rh'       =>  $request->rh,
            'author'       =>  $request->author,
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);

    }


    function update_data(Request $request, $id)
    {
        $data = tperso_appreciation_agent::where('id', $id)->update([
            'refAffectation'       =>  $request->refAffectation,
            'periodeDu'    =>  $request->periodeDu,
            'connaissanceTheorique'    =>  $request->connaissanceTheorique,
            'appliDeontologie'    =>  $request->appliDeontologie,    
            'manipulation'    =>  $request->manipulation,
            'prendConsideration'    =>  $request->prendConsideration,       
            'ponctualite'       =>  $request->ponctualite,
            'ordre'       =>  $request->ordre,
            'fiabilite'       =>  $request->fiabilite,
            'espritEquipe'    =>  $request->espritEquipe,
            'courtoisie'    =>  $request->courtoisie,
            'sensResponsabilite'    =>  $request->sensResponsabilite,    
            'sensEcoute'    =>  $request->sensEcoute,
            'preparationExecution'    =>  $request->preparationExecution,       
            'organiseTravail'       =>  $request->organiseTravail,
            'Propositions'       =>  $request->Propositions,
            'dateAppreciation'       =>  $request->dateAppreciation,
            'agent'       =>  $request->agent,
            'suiveur'       =>  $request->suiveur,
            'hierarchie'       =>  $request->hierarchie,
            'rh'       =>  $request->rh,
            'author'       =>  $request->author,
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!"
        ]);
    }


    function delete_data($id)
    {
        $data = tperso_appreciation_agent::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès"
        ]);
        
    }
}
