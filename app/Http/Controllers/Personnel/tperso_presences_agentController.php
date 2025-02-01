<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_presences_agent;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;

//tperso_presences_temp

class tperso_presences_agentController extends Controller
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
        $current = Carbon::now();  
        
        $heure_debut='';
        $heure_fin='';

        $data2 =  DB::table('tperso_heure_travail')       
        ->selectRaw("TIME(heure_debut) as heure_debut")
        ->selectRaw("TIME(heure_fin) as heure_fin") 
        ->get(); 
        $output='';
        foreach ($data2 as $row) 
        {  
            $heure_debut=$row->heure_debut;
            $heure_fin=$row->heure_fin;                         
        }
        $heure1 = Carbon::parse($heure_debut);
        $heure2 = Carbon::parse($heure_fin);

        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);
            $data = DB::table('tperso_presences_agent')
            ->rightJoin('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_presences_agent.affectation_id')
            ->rightJoin('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
            ->rightJoin('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
            ->rightJoin('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
            ->rightJoin('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
            ->rightJoin('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->rightJoin('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->rightJoin('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->rightJoin('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->rightJoin('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->rightJoin('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->rightJoin('communes' , 'communes.id','=','quartiers.idCommune')
            ->rightJoin('villes' , 'villes.id','=','communes.idVille')
            ->rightJoin('provinces' , 'provinces.id','=','villes.idProvince')
            ->rightJoin('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_presences_agent.id",'date_presence', 'affectation_id', 'date_entree','date_sortie','refAgent',
            'refServicePerso','refCategorieAgent','refPoste','refLieuAffectation','retard','justifications',
             'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
             'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
             'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
             'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
             "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
             "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
             "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
             "tagent.photo as photo_agent","tperso_presences_agent.author","tperso_presences_agent.created_at",
             "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
             'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
             ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as nbr_heure') 
             ->selectRaw("DATE_FORMAT(tperso_presences_agent.created_at,'%d/%M/%Y') as jour_presence")
             ->selectRaw("DATE_FORMAT(date_entree,'%H:%i:%s') as heure_entree") 
             ->selectRaw("DATE_FORMAT(date_sortie,'%H:%i:%s') as heure_sortie") 
             ->selectRaw("DAYNAME(tperso_presences_agent.created_at) as jour_name")
            //  ->selectRaw("TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as jour_test")
             ->selectRaw("CASE  
                WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) <=0 THEN 'BON'
                WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >0 AND TIMESTAMPDIFF(MINUTE, TIME('".$heure1."'), TIME(date_entree)) <=15 THEN 'ASSEZ BON'
                WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >15 THEN 'MAUVAIS'
                ELSE NULL
            END as statut_entree")
            ->selectRaw("CASE  
                WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) < 8 THEN 'JUSTIFICATION' 
                WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) >= 8 THEN 'BON'               
                ELSE NULL
            END as statut_sortie")
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['dateFin', '>=', $current],
                ['conge', '=', 'NON']
            ])               
            ->orderBy("tperso_presences_agent.id", "desc")          
            ->paginate(10);
            return response($data, 200);
        }
        else{
            $data = DB::table('tperso_presences_agent')
            ->rightJoin('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_presences_agent.affectation_id')
            ->rightJoin('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
            ->rightJoin('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
            ->rightJoin('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
            ->rightJoin('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
            ->rightJoin('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->rightJoin('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->rightJoin('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->rightJoin('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->rightJoin('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->rightJoin('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->rightJoin('communes' , 'communes.id','=','quartiers.idCommune')
            ->rightJoin('villes' , 'villes.id','=','communes.idVille')
            ->rightJoin('provinces' , 'provinces.id','=','villes.idProvince')
            ->rightJoin('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_presences_agent.id", 'affectation_id', 'date_entree','date_sortie','refAgent',
            'refServicePerso','refCategorieAgent','refPoste','refLieuAffectation','retard','justifications',
             'refMutuelle','refTypeContrat','dateAffectation','date_presence','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
             'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
             'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
             'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
             "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
             "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
             "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
             "tagent.photo as photo_agent","tperso_presences_agent.author","tperso_presences_agent.created_at",
             "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
             'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
             ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as nbr_heure') 
             ->selectRaw("DATE_FORMAT(tperso_presences_agent.created_at,'%d/%M/%Y') as jour_presence")
             ->selectRaw("DATE_FORMAT(date_entree,'%H:%i:%s') as heure_entree") 
             ->selectRaw("DATE_FORMAT(date_sortie,'%H:%i:%s') as heure_sortie") 
             ->selectRaw("DAYNAME(tperso_presences_agent.created_at) as jour_name")
            //  ->selectRaw("TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as jour_test")
             ->selectRaw("CASE  
                WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) <=0 THEN 'BON'
                WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >0 AND TIMESTAMPDIFF(MINUTE, TIME('".$heure1."'), TIME(date_entree)) <=15 THEN 'ASSEZ BON'
                WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >15 THEN 'MAUVAIS'
                ELSE NULL
            END as statut_entree")
            ->selectRaw("CASE  
                WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) < 8 THEN 'JUSTIFICATION' 
                WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) >= 8 THEN 'BON'               
                ELSE NULL
            END as statut_sortie") 
            ->where([
                ['dateFin', '>=', $current],
                ['conge', '=', 'NON']
            ]) 
            ->orderBy("tperso_presences_agent.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }

    public function all_jour(Request $request)
    { 
        $current = Carbon::now(); 
        $formattedDate = $current->format('Y-m-d');
        $heure_debut='';
        $heure_fin='';

        $data2 =  DB::table('tperso_heure_travail')       
        ->selectRaw("TIME(heure_debut) as heure_debut")
        ->selectRaw("TIME(heure_fin) as heure_fin") 
        ->get(); 
        $output='';
        foreach ($data2 as $row) 
        {  
            $heure_debut=$row->heure_debut;
            $heure_fin=$row->heure_fin;                         
        }
        $heure1 = Carbon::parse($heure_debut);
        $heure2 = Carbon::parse($heure_fin);

        if ($request->get('date1') && $request->get('date2'))  {
            // code...
            $date1 = $request->get('date1');
            $date2 = $request->get('date2');
            
            if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);
            $data = DB::table('tperso_presences_agent')
            ->rightJoin('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_presences_agent.affectation_id')
            ->rightJoin('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
            ->rightJoin('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
            ->rightJoin('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
            ->rightJoin('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
            ->rightJoin('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->rightJoin('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->rightJoin('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->rightJoin('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->rightJoin('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->rightJoin('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->rightJoin('communes' , 'communes.id','=','quartiers.idCommune')
            ->rightJoin('villes' , 'villes.id','=','communes.idVille')
            ->rightJoin('provinces' , 'provinces.id','=','villes.idProvince')
            ->rightJoin('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_presences_agent.id", 'affectation_id', 'date_entree','date_sortie','refAgent',
            'refServicePerso','refCategorieAgent','refPoste','date_presence','refLieuAffectation','retard','justifications',
             'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
             'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
             'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
             'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
             "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
             "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
             "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
             "tagent.photo as photo_agent","tperso_presences_agent.author","tperso_presences_agent.created_at",
             "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
             'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
             ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as nbr_heure') 
             ->selectRaw("DATE_FORMAT(tperso_presences_agent.created_at,'%d/%M/%Y') as jour_presence")
             ->selectRaw("DATE_FORMAT(date_entree,'%H:%i:%s') as heure_entree") 
             ->selectRaw("DATE_FORMAT(date_sortie,'%H:%i:%s') as heure_sortie") 
             ->selectRaw("DAYNAME(tperso_presences_agent.created_at) as jour_name")
            //  ->selectRaw("TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as jour_test")
             ->selectRaw("CASE  
                WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) <=0 THEN 'BON'
                WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >0 AND TIMESTAMPDIFF(MINUTE, TIME('".$heure1."'), TIME(date_entree)) <=15 THEN 'ASSEZ BON'
                WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >15 THEN 'MAUVAIS'
                ELSE NULL
            END as statut_entree")
            ->selectRaw("CASE  
                WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) < 8 THEN 'JUSTIFICATION' 
                WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) >= 8 THEN 'BON'               
                ELSE NULL
            END as statut_sortie")   
                ->where([
                    ['noms_agent', 'like', '%'.$query.'%'],
                    ['tperso_presences_agent.created_at','>=', $formattedDate],
                    ['dateFin', '>=', $current],
                    ['conge', '=', 'NON']
                ])               
                ->orderBy("tperso_presences_agent.id", "desc")          
                ->paginate(10);
                return response($data, 200);
            }
            else{
                $data = DB::table('tperso_presences_agent')
                ->rightJoin('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_presences_agent.affectation_id')
                ->rightJoin('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
                ->rightJoin('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
                ->rightJoin('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
                ->rightJoin('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
                ->rightJoin('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
                ->rightJoin('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
                ->rightJoin('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
                ->rightJoin('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
                ->rightJoin('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
                ->rightJoin('quartiers' , 'quartiers.id','=','avenues.idQuartier')
                ->rightJoin('communes' , 'communes.id','=','quartiers.idCommune')
                ->rightJoin('villes' , 'villes.id','=','communes.idVille')
                ->rightJoin('provinces' , 'provinces.id','=','villes.idProvince')
                ->rightJoin('pays' , 'pays.id','=','provinces.idPays')
                ->select("tperso_presences_agent.id", 'affectation_id', 'date_entree','date_sortie','refAgent',
                'refServicePerso','refCategorieAgent','refPoste','date_presence','refLieuAffectation','retard','justifications',
                 'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
                 'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
                 'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
                 'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
                 "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
                 "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
                 "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
                 "tagent.photo as photo_agent","tperso_presences_agent.author","tperso_presences_agent.created_at",
                 "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
                 'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
                 ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as nbr_heure') 
                 ->selectRaw("DATE_FORMAT(tperso_presences_agent.created_at,'%d/%M/%Y') as jour_presence")
                 ->selectRaw("DATE_FORMAT(date_entree,'%H:%i:%s') as heure_entree") 
                 ->selectRaw("DATE_FORMAT(date_sortie,'%H:%i:%s') as heure_sortie") 
                 ->selectRaw("DAYNAME(tperso_presences_agent.created_at) as jour_name")
                //  ->selectRaw("TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as jour_test")
                 ->selectRaw("CASE  
                    WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) <=0 THEN 'BON'
                    WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >0 AND TIMESTAMPDIFF(MINUTE, TIME('".$heure1."'), TIME(date_entree)) <=15 THEN 'ASSEZ BON'
                    WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >15 THEN 'MAUVAIS'
                    ELSE NULL
                END as statut_entree")
                ->selectRaw("CASE  
                    WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) < 8 THEN 'JUSTIFICATION' 
                    WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) >= 8 THEN 'BON'               
                    ELSE NULL
                END as statut_sortie")  
                ->where([
                    ['tperso_presences_agent.created_at','>=', $formattedDate],
                    ['dateFin', '>=', $current],
                    ['conge', '=', 'NON']
                ]) 
                ->orderBy("tperso_presences_agent.id", "desc")          
                ->paginate(10);
    
                return response($data, 200);
            }
        
        }else{}   
        //tperso_archivages id,name_archive,description_archive,fichier_archive,service_id,author


    }

    public function all_filter(Request $request)
    { 
        $current = Carbon::now();
        $heure_debut='';
        $heure_fin='';

        $data2 =  DB::table('tperso_heure_travail')       
        ->selectRaw("TIME(heure_debut) as heure_debut")
        ->selectRaw("TIME(heure_fin) as heure_fin") 
        ->get(); 
        $output='';
        foreach ($data2 as $row) 
        {  
            $heure_debut=$row->heure_debut;
            $heure_fin=$row->heure_fin;                         
        }
        $heure1 = Carbon::parse($heure_debut);
        $heure2 = Carbon::parse($heure_fin);

        if ($request->get('date1') && $request->get('date2'))  {
            // code...
            $date1 = $request->get('date1');
            $date2 = $request->get('date2');
            
            if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);
            $data = DB::table('tperso_presences_agent')
            ->rightJoin('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_presences_agent.affectation_id')
            ->rightJoin('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
            ->rightJoin('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
            ->rightJoin('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
            ->rightJoin('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
            ->rightJoin('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->rightJoin('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->rightJoin('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->rightJoin('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->rightJoin('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->rightJoin('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->rightJoin('communes' , 'communes.id','=','quartiers.idCommune')
            ->rightJoin('villes' , 'villes.id','=','communes.idVille')
            ->rightJoin('provinces' , 'provinces.id','=','villes.idProvince')
            ->rightJoin('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_presences_agent.id", 'affectation_id', 'date_entree','date_sortie','refAgent',
            'refServicePerso','refCategorieAgent','refPoste','date_presence','refLieuAffectation','retard','justifications',
             'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
             'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
             'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
             'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
             "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
             "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
             "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
             "tagent.photo as photo_agent","tperso_presences_agent.author","tperso_presences_agent.created_at",
             "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
             'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
             ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as nbr_heure') 
             ->selectRaw("DATE_FORMAT(tperso_presences_agent.created_at,'%d/%M/%Y') as jour_presence")
             ->selectRaw("DATE_FORMAT(date_entree,'%H:%i:%s') as heure_entree") 
             ->selectRaw("DATE_FORMAT(date_sortie,'%H:%i:%s') as heure_sortie") 
             ->selectRaw("DAYNAME(tperso_presences_agent.created_at) as jour_name")
            //  ->selectRaw("TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as jour_test")
             ->selectRaw("CASE  
                WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) <=0 THEN 'BON'
                WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >0 AND TIMESTAMPDIFF(MINUTE, TIME('".$heure1."'), TIME(date_entree)) <=15 THEN 'ASSEZ BON'
                WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >15 THEN 'MAUVAIS'
                ELSE NULL
            END as statut_entree")
            ->selectRaw("CASE  
                WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) < 8 THEN 'JUSTIFICATION' 
                WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) >= 8 THEN 'BON'               
                ELSE NULL
            END as statut_sortie")   
                ->where([
                    ['noms_agent', 'like', '%'.$query.'%'],
                    ['tperso_presences_agent.created_at','>=', $date1],
                    ['tperso_presences_agent.created_at','<=', $date2],
                    ['dateFin', '>=', $current],
                    ['conge', '=', 'NON']
                ])               
                ->orderBy("tperso_presences_agent.id", "desc")          
                ->paginate(10);
                return response($data, 200);
            }
            else{
                $data = DB::table('tperso_presences_agent')
                ->rightJoin('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_presences_agent.affectation_id')
                ->rightJoin('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
                ->rightJoin('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
                ->rightJoin('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
                ->rightJoin('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
                ->rightJoin('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
                ->rightJoin('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
                ->rightJoin('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
                ->rightJoin('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
                ->rightJoin('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
                ->rightJoin('quartiers' , 'quartiers.id','=','avenues.idQuartier')
                ->rightJoin('communes' , 'communes.id','=','quartiers.idCommune')
                ->rightJoin('villes' , 'villes.id','=','communes.idVille')
                ->rightJoin('provinces' , 'provinces.id','=','villes.idProvince')
                ->rightJoin('pays' , 'pays.id','=','provinces.idPays')
                ->select("tperso_presences_agent.id", 'affectation_id', 'date_entree','date_sortie','refAgent',
                'refServicePerso','refCategorieAgent','refPoste','date_presence','refLieuAffectation','retard','justifications',
                 'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
                 'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
                 'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
                 'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
                 "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
                 "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
                 "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
                 "tagent.photo as photo_agent","tperso_presences_agent.author","tperso_presences_agent.created_at",
                 "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
                 'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
                 ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as nbr_heure') 
                 ->selectRaw("DATE_FORMAT(tperso_presences_agent.created_at,'%d/%M/%Y') as jour_presence")
                 ->selectRaw("DATE_FORMAT(date_entree,'%H:%i:%s') as heure_entree") 
                 ->selectRaw("DATE_FORMAT(date_sortie,'%H:%i:%s') as heure_sortie") 
                 ->selectRaw("DAYNAME(tperso_presences_agent.created_at) as jour_name")
                //  ->selectRaw("TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as jour_test")
                 ->selectRaw("CASE  
                    WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) <=0 THEN 'BON'
                    WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >0 AND TIMESTAMPDIFF(MINUTE, TIME('".$heure1."'), TIME(date_entree)) <=15 THEN 'ASSEZ BON'
                    WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >15 THEN 'MAUVAIS'
                    ELSE NULL
                END as statut_entree")
                ->selectRaw("CASE  
                    WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) < 8 THEN 'JUSTIFICATION' 
                    WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) >= 8 THEN 'BON'               
                    ELSE NULL
                END as statut_sortie")  
                ->where([
                    ['tperso_presences_agent.created_at','>=', $date1],
                    ['tperso_presences_agent.created_at','<=', $date2],
                    ['dateFin', '>=', $current],
                    ['conge', '=', 'NON']
                ]) 
                ->orderBy("tperso_presences_agent.id", "desc")          
                ->paginate(10);
    
                return response($data, 200);
            }
        
        }else{}   
        //tperso_archivages id,name_archive,description_archive,fichier_archive,service_id,author


    }

    public function all_service_filter(Request $request)
    { 
        $current = Carbon::now();
        $heure_debut='';
        $heure_fin='';

        $data2 =  DB::table('tperso_heure_travail')       
        ->selectRaw("TIME(heure_debut) as heure_debut")
        ->selectRaw("TIME(heure_fin) as heure_fin") 
        ->get(); 
        $output='';
        foreach ($data2 as $row) 
        {  
            $heure_debut=$row->heure_debut;
            $heure_fin=$row->heure_fin;                         
        }
        $heure1 = Carbon::parse($heure_debut);
        $heure2 = Carbon::parse($heure_fin);
        
        if ($request->get('date1') && $request->get('date2') && $request->get('refServicePerso'))  {
            // code...
            $date1 = $request->get('date1');
            $date2 = $request->get('date2');
            $refServicePerso = $request->get('refServicePerso');
            
            if (!is_null($request->get('query'))) {
                # code..s.
                $query = $this->Gquery($request);
                $data = DB::table('tperso_presences_agent')
                ->rightJoin('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_presences_agent.affectation_id')
                ->rightJoin('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
                ->rightJoin('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
                ->rightJoin('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
                ->rightJoin('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
                ->rightJoin('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
                ->rightJoin('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
                ->rightJoin('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
                ->rightJoin('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
                ->rightJoin('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
                ->rightJoin('quartiers' , 'quartiers.id','=','avenues.idQuartier')
                ->rightJoin('communes' , 'communes.id','=','quartiers.idCommune')
                ->rightJoin('villes' , 'villes.id','=','communes.idVille')
                ->rightJoin('provinces' , 'provinces.id','=','villes.idProvince')
                ->rightJoin('pays' , 'pays.id','=','provinces.idPays')
                ->select("tperso_presences_agent.id", 'affectation_id', 'date_entree','date_sortie','refAgent',
                'refServicePerso','refCategorieAgent','date_presence','refPoste','refLieuAffectation','retard','justifications',
                 'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
                 'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
                 'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
                 'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
                 "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
                 "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
                 "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
                 "tagent.photo as photo_agent","tperso_presences_agent.author","tperso_presences_agent.created_at",
                 "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
                 'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
                 ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as nbr_heure') 
                 ->selectRaw("DATE_FORMAT(tperso_presences_agent.created_at,'%d/%M/%Y') as jour_presence")
                 ->selectRaw("DATE_FORMAT(date_entree,'%H:%i:%s') as heure_entree") 
                 ->selectRaw("DATE_FORMAT(date_sortie,'%H:%i:%s') as heure_sortie") 
                 ->selectRaw("DAYNAME(tperso_presences_agent.created_at) as jour_name")
                //  ->selectRaw("TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as jour_test")
                 ->selectRaw("CASE  
                    WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) <=0 THEN 'BON'
                    WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >0 AND TIMESTAMPDIFF(MINUTE, TIME('".$heure1."'), TIME(date_entree)) <=15 THEN 'ASSEZ BON'
                    WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >15 THEN 'MAUVAIS'
                    ELSE NULL
                END as statut_entree")
                ->selectRaw("CASE  
                    WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) < 8 THEN 'JUSTIFICATION' 
                    WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) >= 8 THEN 'BON'               
                    ELSE NULL
                END as statut_sortie")   
                ->where([
                    ['noms_agent', 'like', '%'.$query.'%'],
                    ['tperso_presences_agent.created_at','>=', $date1],
                    ['tperso_presences_agent.created_at','<=', $date2],
                    ['tperso_affectation_agent.refServicePerso','=', $refServicePerso],
                    ['dateFin', '>=', $current],
                    ['conge', '=', 'NON']
                ])               
                ->orderBy("tperso_presences_agent.id", "desc")          
                ->paginate(10);
                return response($data, 200);
            }
            else{
                $data = DB::table('tperso_presences_agent')
                ->rightJoin('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_presences_agent.affectation_id')
                ->rightJoin('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
                ->rightJoin('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
                ->rightJoin('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
                ->rightJoin('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
                ->rightJoin('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
                ->rightJoin('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
                ->rightJoin('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
                ->rightJoin('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
                ->rightJoin('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
                ->rightJoin('quartiers' , 'quartiers.id','=','avenues.idQuartier')
                ->rightJoin('communes' , 'communes.id','=','quartiers.idCommune')
                ->rightJoin('villes' , 'villes.id','=','communes.idVille')
                ->rightJoin('provinces' , 'provinces.id','=','villes.idProvince')
                ->rightJoin('pays' , 'pays.id','=','provinces.idPays')
                ->select("tperso_presences_agent.id", 'affectation_id', 'date_entree','date_sortie','refAgent',
                'refServicePerso','refCategorieAgent','date_presence','refPoste','refLieuAffectation','retard','justifications',
                 'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
                 'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
                 'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
                 'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
                 "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
                 "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
                 "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
                 "tagent.photo as photo_agent","tperso_presences_agent.author","tperso_presences_agent.created_at",
                 "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
                 'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
                 ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as nbr_heure') 
                 ->selectRaw("DATE_FORMAT(tperso_presences_agent.created_at,'%d/%M/%Y') as jour_presence")
                 ->selectRaw("DATE_FORMAT(date_entree,'%H:%i:%s') as heure_entree") 
                 ->selectRaw("DATE_FORMAT(date_sortie,'%H:%i:%s') as heure_sortie") 
                 ->selectRaw("DAYNAME(tperso_presences_agent.created_at) as jour_name")
                //  ->selectRaw("TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as jour_test")
                 ->selectRaw("CASE  
                    WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) <=0 THEN 'BON'
                    WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >0 AND TIMESTAMPDIFF(MINUTE, TIME('".$heure1."'), TIME(date_entree)) <=15 THEN 'ASSEZ BON'
                    WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >15 THEN 'MAUVAIS'
                    ELSE NULL
                END as statut_entree")
                ->selectRaw("CASE  
                    WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) < 8 THEN 'JUSTIFICATION' 
                    WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) >= 8 THEN 'BON'               
                    ELSE NULL
                END as statut_sortie")  
                ->where([
                    ['tperso_presences_agent.created_at','>=', $date1],
                    ['tperso_presences_agent.created_at','<=', $date2],
                    ['tperso_affectation_agent.refServicePerso','=', $refServicePerso],
                    ['dateFin', '>=', $current],
                    ['conge', '=', 'NON']
                ]) 
                ->orderBy("tperso_presences_agent.id", "desc")          
                ->paginate(10);
    
                return response($data, 200);
            }
        
        }else{}   
        //tperso_archivages id,name_archive,description_archive,fichier_archive,service_id,author


    }

    public function fetch_detail_entete(Request $request,$affectation_id)
    {
        $current = Carbon::now();
        $heure_debut='';
        $heure_fin='';

        $data2 =  DB::table('tperso_heure_travail')       
        ->selectRaw("TIME(heure_debut) as heure_debut")
        ->selectRaw("TIME(heure_fin) as heure_fin") 
        ->get(); 
        $output='';
        foreach ($data2 as $row) 
        {  
            $heure_debut=$row->heure_debut;
            $heure_fin=$row->heure_fin;                         
        }
        $heure1 = Carbon::parse($heure_debut);
        $heure2 = Carbon::parse($heure_fin);

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_presences_agent')
            ->rightJoin('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_presences_agent.affectation_id')
            ->rightJoin('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
            ->rightJoin('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
            ->rightJoin('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
            ->rightJoin('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
            ->rightJoin('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->rightJoin('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->rightJoin('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->rightJoin('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->rightJoin('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->rightJoin('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->rightJoin('communes' , 'communes.id','=','quartiers.idCommune')
            ->rightJoin('villes' , 'villes.id','=','communes.idVille')
            ->rightJoin('provinces' , 'provinces.id','=','villes.idProvince')
            ->rightJoin('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_presences_agent.id", 'affectation_id', 'date_entree','date_sortie','refAgent',
            'refServicePerso','refCategorieAgent','date_presence','refPoste','refLieuAffectation','retard','justifications',
             'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
             'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
             'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
             'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
             "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
             "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
             "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
             "tagent.photo as photo_agent","tperso_presences_agent.author","tperso_presences_agent.created_at",
             "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
             'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
             ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as nbr_heure') 
             ->selectRaw("DATE_FORMAT(tperso_presences_agent.created_at,'%d/%M/%Y') as jour_presence")
             ->selectRaw("DATE_FORMAT(date_entree,'%H:%i:%s') as heure_entree") 
             ->selectRaw("DATE_FORMAT(date_sortie,'%H:%i:%s') as heure_sortie") 
             ->selectRaw("DAYNAME(tperso_presences_agent.created_at) as jour_name")
            //  ->selectRaw("TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as jour_test")
             ->selectRaw("CASE  
                WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) <=0 THEN 'BON'
                WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >0 AND TIMESTAMPDIFF(MINUTE, TIME('".$heure1."'), TIME(date_entree)) <=15 THEN 'ASSEZ BON'
                WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >15 THEN 'MAUVAIS'
                ELSE NULL
            END as statut_entree")
            ->selectRaw("CASE  
                WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) < 8 THEN 'JUSTIFICATION' 
                WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) >= 8 THEN 'BON'               
                ELSE NULL
            END as statut_sortie")
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['affectation_id',$affectation_id],
                ['dateFin', '>=', $current],
                ['conge', '=', 'NON']
            ])                    
            ->orderBy("tperso_presences_agent.id", "desc")
            ->paginate(10);

            return response($data, 200);        

        }
        else{
      
            $data = DB::table('tperso_presences_agent')
            ->rightJoin('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_presences_agent.affectation_id')
            ->rightJoin('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
            ->rightJoin('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
            ->rightJoin('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
            ->rightJoin('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
            ->rightJoin('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->rightJoin('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->rightJoin('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->rightJoin('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->rightJoin('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->rightJoin('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->rightJoin('communes' , 'communes.id','=','quartiers.idCommune')
            ->rightJoin('villes' , 'villes.id','=','communes.idVille')
            ->rightJoin('provinces' , 'provinces.id','=','villes.idProvince')
            ->rightJoin('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_presences_agent.id", 'affectation_id', 'date_entree','date_sortie','refAgent',
            'refServicePerso','refCategorieAgent','refPoste','date_presence','refLieuAffectation','retard','justifications',
             'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
             'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
             'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
             'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
             "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
             "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
             "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
             "tagent.photo as photo_agent","tperso_presences_agent.author","tperso_presences_agent.created_at",
             "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
             'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
             ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as nbr_heure') 
             ->selectRaw("DATE_FORMAT(tperso_presences_agent.created_at,'%d/%M/%Y') as jour_presence")
             ->selectRaw("DATE_FORMAT(date_entree,'%H:%i:%s') as heure_entree") 
             ->selectRaw("DATE_FORMAT(date_sortie,'%H:%i:%s') as heure_sortie") 
             ->selectRaw("DAYNAME(tperso_presences_agent.created_at) as jour_name")
            //  ->selectRaw("TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as jour_test")
             ->selectRaw("CASE  
                WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) <=0 THEN 'BON'
                WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >0 AND TIMESTAMPDIFF(MINUTE, TIME('".$heure1."'), TIME(date_entree)) <=15 THEN 'ASSEZ BON'
                WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >15 THEN 'MAUVAIS'
                ELSE NULL
            END as statut_entree")
            ->selectRaw("CASE  
                WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) < 8 THEN 'JUSTIFICATION' 
                WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) >= 8 THEN 'BON'               
                ELSE NULL
            END as statut_sortie")                
            ->where([
                ['affectation_id',$affectation_id],
                ['dateFin', '>=', $current],
                ['conge', '=', 'NON']
            ])   
            ->orderBy("tperso_presences_agent.id", "desc")
            ->paginate(10);

            return response($data, 200);         
 
        }

    }

    function fetch_single($id)
    {
        $heure_debut='';
        $heure_fin='';

        $data2 =  DB::table('tperso_heure_travail')       
        ->selectRaw("TIME(heure_debut) as heure_debut")
        ->selectRaw("TIME(heure_fin) as heure_fin") 
        ->get(); 
        $output='';
        foreach ($data2 as $row) 
        {  
            $heure_debut=$row->heure_debut;
            $heure_fin=$row->heure_fin;                         
        }
        $heure1 = Carbon::parse($heure_debut);
        $heure2 = Carbon::parse($heure_fin);

        $data = DB::table('tperso_presences_agent')
        ->rightJoin('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_presences_agent.affectation_id')
        ->rightJoin('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
        ->rightJoin('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
        ->rightJoin('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
        ->rightJoin('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
        ->rightJoin('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
        ->rightJoin('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
        ->rightJoin('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
        ->rightJoin('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
        ->rightJoin('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->rightJoin('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->rightJoin('communes' , 'communes.id','=','quartiers.idCommune')
        ->rightJoin('villes' , 'villes.id','=','communes.idVille')
        ->rightJoin('provinces' , 'provinces.id','=','villes.idProvince')
        ->rightJoin('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_presences_agent.id", 'affectation_id', 'date_entree','date_sortie','refAgent',
        'refServicePerso','refCategorieAgent','date_presence','refPoste','refLieuAffectation','retard','justifications',
         'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
         'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
         'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
         'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
         "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
         "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
         "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
         "tagent.photo as photo_agent","tperso_presences_agent.author","tperso_presences_agent.created_at",
         "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
         'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
         ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as nbr_heure') 
         ->selectRaw("DATE_FORMAT(tperso_presences_agent.created_at,'%d/%M/%Y') as jour_presence")
         ->selectRaw("DATE_FORMAT(date_entree,'%H:%i:%s') as heure_entree") 
         ->selectRaw("DATE_FORMAT(date_sortie,'%H:%i:%s') as heure_sortie") 
         ->selectRaw("DAYNAME(tperso_presences_agent.created_at) as jour_name")
        //  ->selectRaw("TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) as jour_test")
         ->selectRaw("CASE  
            WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) <=0 THEN 'BON'
            WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >0 AND TIMESTAMPDIFF(MINUTE, TIME('".$heure1."'), TIME(date_entree)) <=15 THEN 'ASSEZ BON'
            WHEN TIMESTAMPDIFF(MINUTE, '".$heure1."', TIME(date_entree)) >15 THEN 'MAUVAIS'
            ELSE NULL
        END as statut_entree")
        ->selectRaw("CASE  
            WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) < 8 THEN 'JUSTIFICATION' 
            WHEN TIMESTAMPDIFF(HOUR, TIME(date_entree), TIME(date_sortie)) >= 8 THEN 'BON'               
            ELSE NULL
        END as statut_sortie") 
        ->where('tperso_presences_agent.id', $id)
        ->get();

        return response($data, 200);
    }

    function insert_data(Request $request)
    {
        $current = Carbon::now(); 

        $data = tperso_presences_agent::create([
            'affectation_id'    =>  $request->affectation_id,
            'date_presence'    =>  $current,
            'date_entree'    =>  $current,
            'date_sortie'    =>  $current,
            'author'       =>  'Admin',
        ]);

        return $this->msgJson('Information ajoutée avec succès');
    }

    function update_data(Request $request, $id)
    {
        $current = Carbon::now(); 
        $data = tperso_presences_agent::where('id', $id)->update([
            'affectation_id'    =>  $request->affectation_id,
            'date_sortie'    =>  $current
        ]);       
        return $this->msgJson('Information ajoutée avec succès');
    }

    //retard  justifications

    function update_data_retard(Request $request, $id)
    {
        $data = tperso_presences_agent::where('id', $id)->update([
            'retard'    =>  $request->retard,
            'justifications'    =>  $request->justifications,
            'author'       =>  $request->author,
        ]);       
        return $this->msgJson('Information ajoutée avec succès');
    }


    function delete_data($id)
    {
        $data = tperso_presences_agent::where('id',$id)->delete();
        return $this->msgJson('Information ajoutée avec succès');
        
    }
}
