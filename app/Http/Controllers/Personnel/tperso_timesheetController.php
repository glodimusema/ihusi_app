<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_timesheet;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class tperso_timesheetController extends Controller
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
            $data = DB::table('tperso_timesheet')
            ->join('users','users.id','=','tperso_timesheet.user_id')
            ->join('roles','users.id_role','=','roles.id')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_timesheet.affectation_id')
            ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
            ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
            ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_timesheet.id",'affectation_id','user_id','annee_id','mois_id','date_tache',
            'jour_preste','perdieme','activite','heure_debut','heure_fin','temp_preste','ateste_agent',
            'ateste_projet','ateste_coordo','ateste_rh','refAgent','users.avatar','users.name','users.email',
            'users.id_role','roles.nom as role_name','users.sexe','users.telephone','users.adresse','users.active',
            'refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
             'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
             'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
             'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
             'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
             "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
             "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
             "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
             "tagent.photo as photo_agent","tperso_timesheet.author","tperso_timesheet.created_at",
             "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
             'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
             ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) as nbr_heure') 
             ->selectRaw("DATE_FORMAT(tperso_timesheet.created_at,'%d/%M/%Y') as jour_presence")
             ->selectRaw("DATE_FORMAT(heure_debut,'%H:%i:%s') as heure_entree") 
             ->selectRaw("DATE_FORMAT(heure_fin,'%H:%i:%s') as heure_sortie") 
             ->selectRaw("DAYNAME(tperso_timesheet.created_at) as jour_name")
            ->selectRaw("CASE  
                WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) < 8 THEN 'JUSTIFICATION' 
                WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) >= 8 THEN 'BON'               
                ELSE NULL
            END as statut_sortie")
            ->where([
                ['noms_agent', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_timesheet.id", "desc")          
            ->paginate(10);
            return response($data, 200);
        }
        else{
            $data = DB::table('tperso_timesheet')
            ->join('users','users.id','=','tperso_timesheet.user_id')
            ->join('roles','users.id_role','=','roles.id')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_timesheet.affectation_id')
            ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
            ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
            ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_timesheet.id",'affectation_id','user_id','annee_id','mois_id','date_tache',
            'jour_preste','perdieme','activite','heure_debut','heure_fin','temp_preste','ateste_agent',
            'ateste_projet','ateste_coordo','ateste_rh','refAgent','users.avatar','users.name','users.email',
            'users.id_role','roles.nom as role_name','users.sexe','users.telephone','users.adresse','users.active',
            'refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
             'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
             'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
             'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
             'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
             "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
             "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
             "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
             "tagent.photo as photo_agent","tperso_timesheet.author","tperso_timesheet.created_at",
             "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
             'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
             ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) as nbr_heure') 
             ->selectRaw("DATE_FORMAT(tperso_timesheet.created_at,'%d/%M/%Y') as jour_presence")
             ->selectRaw("DATE_FORMAT(heure_debut,'%H:%i:%s') as heure_entree") 
             ->selectRaw("DATE_FORMAT(heure_fin,'%H:%i:%s') as heure_sortie") 
             ->selectRaw("DAYNAME(tperso_timesheet.created_at) as jour_name")
            ->selectRaw("CASE  
                WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) < 8 THEN 'JUSTIFICATION' 
                WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) >= 8 THEN 'BON'               
                ELSE NULL
            END as statut_sortie")  
            ->orderBy("tperso_timesheet.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }

    public function all_jour(Request $request)
    {
            $current = Carbon::now(); 
            $formattedDate = $current->format('Y-m-d');
            
            if (!is_null($request->get('query'))) 
            {
            
            $query = $this->Gquery($request);
            $data = DB::table('tperso_timesheet')
            ->join('users','users.id','=','tperso_timesheet.user_id')
            ->join('roles','users.id_role','=','roles.id')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_timesheet.affectation_id')
            ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
            ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
            ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_timesheet.id",'affectation_id','user_id','annee_id','mois_id','date_tache',
            'jour_preste','perdieme','activite','heure_debut','heure_fin','temp_preste','ateste_agent',
            'ateste_projet','ateste_coordo','ateste_rh','refAgent','users.avatar','users.name','users.email',
            'users.id_role','roles.nom as role_name','users.sexe','users.telephone','users.adresse','users.active',
            'refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
             'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
             'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
             'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
             'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
             "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
             "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
             "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
             "tagent.photo as photo_agent","tperso_timesheet.author","tperso_timesheet.created_at",
             "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
             'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
             ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) as nbr_heure') 
             ->selectRaw("DATE_FORMAT(tperso_timesheet.created_at,'%d/%M/%Y') as jour_presence")
             ->selectRaw("DATE_FORMAT(heure_debut,'%H:%i:%s') as heure_entree") 
             ->selectRaw("DATE_FORMAT(heure_fin,'%H:%i:%s') as heure_sortie") 
             ->selectRaw("DAYNAME(tperso_timesheet.created_at) as jour_name")
            ->selectRaw("CASE  
                WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) < 8 THEN 'JUSTIFICATION' 
                WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) >= 8 THEN 'BON'               
                ELSE NULL
            END as statut_sortie")   
                ->where([
                    ['noms_agent', 'like', '%'.$query.'%'],
                    ['tperso_timesheet.created_at','>=', $formattedDate]
                ])               
                ->orderBy("tperso_timesheet.id", "desc")          
                ->paginate(10);
                return response($data, 200);
            }
            else{
                $data = DB::table('tperso_timesheet')
                ->join('users','users.id','=','tperso_timesheet.user_id')
                ->join('roles','users.id_role','=','roles.id')
                ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_timesheet.affectation_id')
                ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
                ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
                ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
                ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
                ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
                ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
                ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
                ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
                ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
                ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
                ->join('communes' , 'communes.id','=','quartiers.idCommune')
                ->join('villes' , 'villes.id','=','communes.idVille')
                ->join('provinces' , 'provinces.id','=','villes.idProvince')
                ->join('pays' , 'pays.id','=','provinces.idPays')
                ->select("tperso_timesheet.id",'affectation_id','user_id','annee_id','mois_id','date_tache',
                'jour_preste','perdieme','activite','heure_debut','heure_fin','temp_preste','ateste_agent',
                'ateste_projet','ateste_coordo','ateste_rh','refAgent','users.avatar','users.name','users.email',
                'users.id_role','roles.nom as role_name','users.sexe','users.telephone','users.adresse','users.active',
                'refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
                 'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
                 'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
                 'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
                 'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
                 "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
                 "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
                 "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
                 "tagent.photo as photo_agent","tperso_timesheet.author","tperso_timesheet.created_at",
                 "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
                 'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
                 ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) as nbr_heure') 
                 ->selectRaw("DATE_FORMAT(tperso_timesheet.created_at,'%d/%M/%Y') as jour_presence")
                 ->selectRaw("DATE_FORMAT(heure_debut,'%H:%i:%s') as heure_entree") 
                 ->selectRaw("DATE_FORMAT(heure_fin,'%H:%i:%s') as heure_sortie") 
                 ->selectRaw("DAYNAME(tperso_timesheet.created_at) as jour_name")
                ->selectRaw("CASE  
                    WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) < 8 THEN 'JUSTIFICATION' 
                    WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) >= 8 THEN 'BON'               
                    ELSE NULL
                END as statut_sortie")  
                ->where([
                    ['tperso_timesheet.created_at','>=', $formattedDate]
                ]) 
                ->orderBy("tperso_timesheet.id", "desc")          
                ->paginate(10);
    
                return response($data, 200);
            }
        
        

    }


    public function all_filter(Request $request)
    {

        if ($request->get('date1') && $request->get('date2'))  {
            // code...
            $date1 = $request->get('date1');
            $date2 = $request->get('date2');
            
            if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);
            $data = DB::table('tperso_timesheet')
            ->join('users','users.id','=','tperso_timesheet.user_id')
            ->join('roles','users.id_role','=','roles.id')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_timesheet.affectation_id')
            ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
            ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
            ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_timesheet.id",'affectation_id','user_id','annee_id','mois_id','date_tache',
            'jour_preste','perdieme','activite','heure_debut','heure_fin','temp_preste','ateste_agent',
            'ateste_projet','ateste_coordo','ateste_rh','refAgent','users.avatar','users.name','users.email',
            'users.id_role','roles.nom as role_name','users.sexe','users.telephone','users.adresse','users.active',
            'refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
             'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
             'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
             'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
             'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
             "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
             "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
             "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
             "tagent.photo as photo_agent","tperso_timesheet.author","tperso_timesheet.created_at",
             "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
             'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
             ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) as nbr_heure') 
             ->selectRaw("DATE_FORMAT(tperso_timesheet.created_at,'%d/%M/%Y') as jour_presence")
             ->selectRaw("DATE_FORMAT(heure_debut,'%H:%i:%s') as heure_entree") 
             ->selectRaw("DATE_FORMAT(heure_fin,'%H:%i:%s') as heure_sortie") 
             ->selectRaw("DAYNAME(tperso_timesheet.created_at) as jour_name")
            ->selectRaw("CASE  
                WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) < 8 THEN 'JUSTIFICATION' 
                WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) >= 8 THEN 'BON'               
                ELSE NULL
            END as statut_sortie")   
                ->where([
                    ['noms_agent', 'like', '%'.$query.'%'],
                    ['tperso_timesheet.created_at','>=', $date1],
                    ['tperso_timesheet.created_at','<=', $date2],
                ])               
                ->orderBy("tperso_timesheet.id", "desc")          
                ->paginate(10);
                return response($data, 200);
            }
            else{
                $data = DB::table('tperso_timesheet')
                ->join('users','users.id','=','tperso_timesheet.user_id')
                ->join('roles','users.id_role','=','roles.id')
                ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_timesheet.affectation_id')
                ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
                ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
                ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
                ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
                ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
                ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
                ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
                ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
                ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
                ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
                ->join('communes' , 'communes.id','=','quartiers.idCommune')
                ->join('villes' , 'villes.id','=','communes.idVille')
                ->join('provinces' , 'provinces.id','=','villes.idProvince')
                ->join('pays' , 'pays.id','=','provinces.idPays')
                ->select("tperso_timesheet.id",'affectation_id','user_id','annee_id','mois_id','date_tache',
                'jour_preste','perdieme','activite','heure_debut','heure_fin','temp_preste','ateste_agent',
                'ateste_projet','ateste_coordo','ateste_rh','refAgent','users.avatar','users.name','users.email',
                'users.id_role','roles.nom as role_name','users.sexe','users.telephone','users.adresse','users.active',
                'refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
                 'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
                 'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
                 'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
                 'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
                 "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
                 "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
                 "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
                 "tagent.photo as photo_agent","tperso_timesheet.author","tperso_timesheet.created_at",
                 "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
                 'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
                 ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) as nbr_heure') 
                 ->selectRaw("DATE_FORMAT(tperso_timesheet.created_at,'%d/%M/%Y') as jour_presence")
                 ->selectRaw("DATE_FORMAT(heure_debut,'%H:%i:%s') as heure_entree") 
                 ->selectRaw("DATE_FORMAT(heure_fin,'%H:%i:%s') as heure_sortie") 
                 ->selectRaw("DAYNAME(tperso_timesheet.created_at) as jour_name")
                ->selectRaw("CASE  
                    WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) < 8 THEN 'JUSTIFICATION' 
                    WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) >= 8 THEN 'BON'               
                    ELSE NULL
                END as statut_sortie")  
                ->where([
                    ['tperso_timesheet.created_at','>=', $date1],
                    ['tperso_timesheet.created_at','<=', $date2],
                ]) 
                ->orderBy("tperso_timesheet.id", "desc")          
                ->paginate(10);
    
                return response($data, 200);
            }
        
        }else{}   
        //tperso_archivages id,name_archive,description_archive,fichier_archive,service_id,author


    }


    public function all_service_filter(Request $request)
    { 
               
        if ($request->get('date1') && $request->get('date2') && $request->get('refServicePerso'))  {
            // code...
            $date1 = $request->get('date1');
            $date2 = $request->get('date2');
            $refServicePerso = $request->get('refServicePerso');
            
            if (!is_null($request->get('query'))) {
                # code..s.
                $query = $this->Gquery($request);
                $data = DB::table('tperso_timesheet')
                ->join('users','users.id','=','tperso_timesheet.user_id')
                ->join('roles','users.id_role','=','roles.id')
                ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_timesheet.affectation_id')
                ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
                ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
                ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
                ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
                ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
                ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
                ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
                ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
                ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
                ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
                ->join('communes' , 'communes.id','=','quartiers.idCommune')
                ->join('villes' , 'villes.id','=','communes.idVille')
                ->join('provinces' , 'provinces.id','=','villes.idProvince')
                ->join('pays' , 'pays.id','=','provinces.idPays')
                ->select("tperso_timesheet.id",'affectation_id','user_id','annee_id','mois_id','date_tache',
                'jour_preste','perdieme','activite','heure_debut','heure_fin','temp_preste','ateste_agent',
                'ateste_projet','ateste_coordo','ateste_rh','refAgent','users.avatar','users.name','users.email',
                'users.id_role','roles.nom as role_name','users.sexe','users.telephone','users.adresse','users.active',
                'refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
                 'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
                 'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
                 'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
                 'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
                 "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
                 "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
                 "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
                 "tagent.photo as photo_agent","tperso_timesheet.author","tperso_timesheet.created_at",
                 "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
                 'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
                 ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) as nbr_heure') 
                 ->selectRaw("DATE_FORMAT(tperso_timesheet.created_at,'%d/%M/%Y') as jour_presence")
                 ->selectRaw("DATE_FORMAT(heure_debut,'%H:%i:%s') as heure_entree") 
                 ->selectRaw("DATE_FORMAT(heure_fin,'%H:%i:%s') as heure_sortie") 
                 ->selectRaw("DAYNAME(tperso_timesheet.created_at) as jour_name")
                ->selectRaw("CASE  
                    WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) < 8 THEN 'JUSTIFICATION' 
                    WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) >= 8 THEN 'BON'               
                    ELSE NULL
                END as statut_sortie")   
                ->where([
                    ['noms_agent', 'like', '%'.$query.'%'],
                    ['tperso_timesheet.created_at','>=', $date1],
                    ['tperso_timesheet.created_at','<=', $date2],
                    ['tperso_affectation_agent.refServicePerso','=', $refServicePerso],
                ])               
                ->orderBy("tperso_timesheet.id", "desc")          
                ->paginate(10);
                return response($data, 200);
            }
            else{
                $data = DB::table('tperso_timesheet')
                ->join('users','users.id','=','tperso_timesheet.user_id')
                ->join('roles','users.id_role','=','roles.id')
                ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_timesheet.affectation_id')
                ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
                ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
                ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
                ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
                ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
                ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
                ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
                ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
                ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
                ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
                ->join('communes' , 'communes.id','=','quartiers.idCommune')
                ->join('villes' , 'villes.id','=','communes.idVille')
                ->join('provinces' , 'provinces.id','=','villes.idProvince')
                ->join('pays' , 'pays.id','=','provinces.idPays')
                ->select("tperso_timesheet.id",'affectation_id','user_id','annee_id','mois_id','date_tache',
                'jour_preste','perdieme','activite','heure_debut','heure_fin','temp_preste','ateste_agent',
                'ateste_projet','ateste_coordo','ateste_rh','refAgent','users.avatar','users.name','users.email',
                'users.id_role','roles.nom as role_name','users.sexe','users.telephone','users.adresse','users.active',
                'refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
                 'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
                 'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
                 'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
                 'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
                 "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
                 "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
                 "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
                 "tagent.photo as photo_agent","tperso_timesheet.author","tperso_timesheet.created_at",
                 "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
                 'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
                 ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) as nbr_heure') 
                 ->selectRaw("DATE_FORMAT(tperso_timesheet.created_at,'%d/%M/%Y') as jour_presence")
                 ->selectRaw("DATE_FORMAT(heure_debut,'%H:%i:%s') as heure_entree") 
                 ->selectRaw("DATE_FORMAT(heure_fin,'%H:%i:%s') as heure_sortie") 
                 ->selectRaw("DAYNAME(tperso_timesheet.created_at) as jour_name")
                ->selectRaw("CASE  
                    WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) < 8 THEN 'JUSTIFICATION' 
                    WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) >= 8 THEN 'BON'               
                    ELSE NULL
                END as statut_sortie")  
                ->where([
                    ['tperso_timesheet.created_at','>=', $date1],
                    ['tperso_timesheet.created_at','<=', $date2],
                    ['tperso_affectation_agent.refServicePerso','=', $refServicePerso],
                ]) 
                ->orderBy("tperso_timesheet.id", "desc")          
                ->paginate(10);
    
                return response($data, 200);
            }
        
        }else{}   
        //tperso_archivages id,name_archive,description_archive,fichier_archive,service_id,author


    }


    public function fetch_detail_entete(Request $request,$affectation_id)
    {

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_timesheet')
            ->join('users','users.id','=','tperso_timesheet.user_id')
            ->join('roles','users.id_role','=','roles.id')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_timesheet.affectation_id')
            ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
            ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
            ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_timesheet.id",'affectation_id','user_id','annee_id','mois_id','date_tache',
            'jour_preste','perdieme','activite','heure_debut','heure_fin','temp_preste','ateste_agent',
            'ateste_projet','ateste_coordo','ateste_rh','refAgent','users.avatar','users.name','users.email',
            'users.id_role','roles.nom as role_name','users.sexe','users.telephone','users.adresse','users.active',
            'refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
             'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
             'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
             'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
             'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
             "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
             "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
             "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
             "tagent.photo as photo_agent","tperso_timesheet.author","tperso_timesheet.created_at",
             "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
             'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
             ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) as nbr_heure') 
             ->selectRaw("DATE_FORMAT(tperso_timesheet.created_at,'%d/%M/%Y') as jour_presence")
             ->selectRaw("DATE_FORMAT(heure_debut,'%H:%i:%s') as heure_entree") 
             ->selectRaw("DATE_FORMAT(heure_fin,'%H:%i:%s') as heure_sortie") 
             ->selectRaw("DAYNAME(tperso_timesheet.created_at) as jour_name")
            ->selectRaw("CASE  
                WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) < 8 THEN 'JUSTIFICATION' 
                WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) >= 8 THEN 'BON'               
                ELSE NULL
            END as statut_sortie")
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['affectation_id',$affectation_id]
            ])                    
            ->orderBy("tperso_timesheet.id", "desc")
            ->paginate(10);

            return response($data, 200);        

        }
        else{
      
            $data = DB::table('tperso_timesheet')
            ->join('users','users.id','=','tperso_timesheet.user_id')
            ->join('roles','users.id_role','=','roles.id')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_timesheet.affectation_id')
            ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
            ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
            ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_timesheet.id",'affectation_id','user_id','annee_id','mois_id','date_tache',
            'jour_preste','perdieme','activite','heure_debut','heure_fin','temp_preste','ateste_agent',
            'ateste_projet','ateste_coordo','ateste_rh','refAgent','users.avatar','users.name','users.email',
            'users.id_role','roles.nom as role_name','users.sexe','users.telephone','users.adresse','users.active',
            'refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
             'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
             'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
             'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
             'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
             "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
             "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
             "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
             "tagent.photo as photo_agent","tperso_timesheet.author","tperso_timesheet.created_at",
             "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
             'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
             ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) as nbr_heure') 
             ->selectRaw("DATE_FORMAT(tperso_timesheet.created_at,'%d/%M/%Y') as jour_presence")
             ->selectRaw("DATE_FORMAT(heure_debut,'%H:%i:%s') as heure_entree") 
             ->selectRaw("DATE_FORMAT(heure_fin,'%H:%i:%s') as heure_sortie") 
             ->selectRaw("DAYNAME(tperso_timesheet.created_at) as jour_name")
            ->selectRaw("CASE  
                WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) < 8 THEN 'JUSTIFICATION' 
                WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) >= 8 THEN 'BON'               
                ELSE NULL
            END as statut_sortie")                
            ->Where('affectation_id',$affectation_id)    
            ->orderBy("tperso_timesheet.id", "desc")
            ->paginate(10);

            return response($data, 200);         
 
        }

    }    


    public function fetch_detail_entete_user(Request $request,$user_id)
    {

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_timesheet')
            ->join('users','users.id','=','tperso_timesheet.user_id')
            ->join('roles','users.id_role','=','roles.id')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_timesheet.affectation_id')
            ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
            ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
            ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_timesheet.id",'affectation_id','user_id','annee_id','mois_id','date_tache',
            'jour_preste','perdieme','activite','heure_debut','heure_fin','temp_preste','ateste_agent',
            'ateste_projet','ateste_coordo','ateste_rh','refAgent','users.avatar','users.name','users.email',
            'users.id_role','roles.nom as role_name','users.sexe','users.telephone','users.adresse','users.active',
            'refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
             'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
             'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
             'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
             'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
             "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
             "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
             "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
             "tagent.photo as photo_agent","tperso_timesheet.author","tperso_timesheet.created_at",
             "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
             'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
             ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) as nbr_heure') 
             ->selectRaw("DATE_FORMAT(tperso_timesheet.created_at,'%d/%M/%Y') as jour_presence")
             ->selectRaw("DATE_FORMAT(heure_debut,'%H:%i:%s') as heure_entree") 
             ->selectRaw("DATE_FORMAT(heure_fin,'%H:%i:%s') as heure_sortie") 
             ->selectRaw("DAYNAME(tperso_timesheet.created_at) as jour_name")
            ->selectRaw("CASE  
                WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) < 8 THEN 'JUSTIFICATION' 
                WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) >= 8 THEN 'BON'               
                ELSE NULL
            END as statut_sortie")
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['tperso_timesheet.user_id',$user_id]
            ])                    
            ->orderBy("tperso_timesheet.id", "desc")
            ->paginate(10);

            return response($data, 200);        

        }
        else{
      
            $data = DB::table('tperso_timesheet')
            ->join('users','users.id','=','tperso_timesheet.user_id')
            ->join('roles','users.id_role','=','roles.id')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_timesheet.affectation_id')
            ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
            ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
            ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
            ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
            ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
            ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tperso_timesheet.id",'affectation_id','user_id','annee_id','mois_id','date_tache',
            'jour_preste','perdieme','activite','heure_debut','heure_fin','temp_preste','ateste_agent',
            'ateste_projet','ateste_coordo','ateste_rh','refAgent','users.avatar','users.name','users.email',
            'users.id_role','roles.nom as role_name','users.sexe','users.telephone','users.adresse','users.active',
            'refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
             'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
             'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
             'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
             'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
             "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
             "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
             "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
             "tagent.photo as photo_agent","tperso_timesheet.author","tperso_timesheet.created_at",
             "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
             'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
             ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) as nbr_heure') 
             ->selectRaw("DATE_FORMAT(tperso_timesheet.created_at,'%d/%M/%Y') as jour_presence")
             ->selectRaw("DATE_FORMAT(heure_debut,'%H:%i:%s') as heure_entree") 
             ->selectRaw("DATE_FORMAT(heure_fin,'%H:%i:%s') as heure_sortie") 
             ->selectRaw("DAYNAME(tperso_timesheet.created_at) as jour_name")
            ->selectRaw("CASE  
                WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) < 8 THEN 'JUSTIFICATION' 
                WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) >= 8 THEN 'BON'               
                ELSE NULL
            END as statut_sortie")                
            ->Where('tperso_timesheet.user_id',$user_id)    
            ->orderBy("tperso_timesheet.id", "desc")
            ->paginate(10);

            return response($data, 200);         
 
        }

    }


    function fetch_single($id)
    {
        $data = DB::table('tperso_timesheet')
        ->join('users','users.id','=','tperso_timesheet.user_id')
        ->join('roles','users.id_role','=','roles.id')
        ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_timesheet.affectation_id')
        ->join('tperso_poste','tperso_poste.id','=','tperso_affectation_agent.refPoste')
        ->join('tperso_lieuaffectation','tperso_lieuaffectation.id','=','tperso_affectation_agent.refLieuAffectation')
        ->join('tperso_mutuelle','tperso_mutuelle.id','=','tperso_affectation_agent.refMutuelle')
        ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_affectation_agent.refTypeContrat')
        ->join('tperso_categorie_agent','tperso_categorie_agent.id','=','tperso_affectation_agent.refCategorieAgent')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tperso_affectation_agent.refServicePerso')
        ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
        ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
        ->join('avenues' , 'avenues.id','=','tagent.refAvenue_agent')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tperso_timesheet.id",'affectation_id','user_id','annee_id','mois_id','date_tache',
        'jour_preste','perdieme','activite','heure_debut','heure_fin','temp_preste','ateste_agent',
        'ateste_projet','ateste_coordo','ateste_rh','refAgent','users.avatar','users.name','users.email',
        'users.id_role','roles.nom as role_name','users.sexe','users.telephone','users.adresse','users.active',
        'refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
         'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
         'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
         'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
         'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
         "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
         "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
         "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent",
         "tagent.photo as photo_agent","tperso_timesheet.author","tperso_timesheet.created_at",
         "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
         'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
         ->selectRaw('TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) as nbr_heure') 
         ->selectRaw("DATE_FORMAT(tperso_timesheet.created_at,'%d/%M/%Y') as jour_presence")
         ->selectRaw("DATE_FORMAT(heure_debut,'%H:%i:%s') as heure_entree") 
         ->selectRaw("DATE_FORMAT(heure_fin,'%H:%i:%s') as heure_sortie") 
         ->selectRaw("DAYNAME(tperso_timesheet.created_at) as jour_name")
        ->selectRaw("CASE  
            WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) < 8 THEN 'JUSTIFICATION' 
            WHEN TIMESTAMPDIFF(HOUR, TIME(heure_debut), TIME(heure_fin)) >= 8 THEN 'BON'               
            ELSE NULL
        END as statut_sortie") 
        ->where('tperso_timesheet.id', $id)
        ->get();

        return response($data, 200);
    }


    function insert_data(Request $request)
    {
        $current = Carbon::now(); 
        $heure1=Carbon::parse(trim($request->heure_debut));
        $heure2=Carbon::parse(trim($request->heure_fin));
        $affectation_id = 0;

        try {
            $carbon1 = Carbon::createFromFormat('H:i', $heure1);
            $carbon2 = Carbon::createFromFormat('H:i', $heure2);
            $difference = $carbon1->diff($carbon2);
            $temp_preste = Carbon::createFromTime($difference->h, $difference->i);
        
        } catch (InvalidFormatException $e) {
            echo "Erreur de format : " . $e->getMessage();
        }

        

        $data3 =  DB::table('tperso_affectation_agent')
        ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
        ->select('tperso_affectation_agent.id')
        ->where([
           ['tagent.noms_agent','=', $request->author]
        ])    
        ->get(); 

        foreach ($data3 as $row) 
        {                               
            $affectation_id=$row->id;                          
        }

        $data = tperso_timesheet::create([
            'affectation_id'    =>  $affectation_id,
            'user_id'    =>  $request->user_id,
            'annee_id'    =>  $request->annee_id,
            'mois_id'    =>  $request->mois_id,
            'date_tache'    =>  $current,
            'jour_preste'    =>  1,
            'perdieme'    =>  $request->perdieme,
            'activite'    =>  $request->activite,
            'heure_debut'    =>  $heure1,
            'heure_fin'    =>  $heure2,
            'temp_preste'    =>  $heure2,
            'ateste_agent'    =>  'OUI',
            'ateste_projet'    =>  'NON',
            'ateste_coordo'    =>  'NON',
            'ateste_rh'    =>  'NON',
            'author'       =>  $request->author,
        ]);

        return $this->msgJson('Information ajoutée avec succès');
    }


    function update_data(Request $request, $id)
    {
        $current = Carbon::now(); 
        $heure1=Carbon::parse(trim($request->heure_debut));
        $heure2=Carbon::parse(trim($request->heure_fin));

        try {
            $carbon1 = Carbon::createFromFormat('H:i', $heure1);
            $carbon2 = Carbon::createFromFormat('H:i', $heure2);
            $difference = $carbon1->diff($carbon2);
            $temp_preste = Carbon::createFromTime($difference->h, $difference->i);
        
        } catch (InvalidFormatException $e) {
            echo "Erreur de format : " . $e->getMessage();
        }
        // $heures = $temp_preste->h; // Heures
        // $minutes = $temp_preste->i; // Minutes
        // $resultat = sprintf('%d:%02d', $heures, $minutes);

        $affectation_id = 0;

        $data3 =  DB::table('tperso_affectation_agent')
        ->join('tagent','tagent.id','=','tperso_affectation_agent.refAgent')
        ->select('tperso_affectation_agent.id')
        ->where([
           ['tagent.noms_agent','=', $request->author]
       ])    
        ->get(); 
        $output='';
        foreach ($data3 as $row) 
        {                               
            $affectation_id=$row->id;                          
        }
        
        $data = tperso_timesheet::where('id', $id)->update([
            'affectation_id'    =>  $affectation_id,
            'user_id'    =>  $request->user_id,
            'annee_id'    =>  $request->annee_id,
            'mois_id'    =>  $request->mois_id,
            'date_tache'    =>  $current,
            'jour_preste'    =>  1,
            'perdieme'    =>  $request->perdieme,
            'activite'    =>  $request->activite,
            'heure_debut'    =>  $heure1,
            'heure_fin'    =>  $heure2,
            'temp_preste'    =>  $heure2,
            'author'       =>  'Admin',
        ]);       
        return $this->msgJson('Information ajoutée avec succès');
    }

    function update_projet(Request $request, $id)
    {
        $data = tperso_timesheet::where('id', $id)->update([
            'ateste_projet'    =>  'OUI'
        ]);       
        return $this->msgJson('Information modifiée avec succès');
    }

    function update_coordo(Request $request, $id)
    {
        $data = tperso_timesheet::where('id', $id)->update([
            'ateste_coordo'    =>  'OUI'
        ]);       
        return $this->msgJson('Information modifiée avec succès');
    }

    function update_rh(Request $request, $id)
    {
        $data = tperso_timesheet::where('id', $id)->update([
            'ateste_rh'    =>  'OUI'
        ]);       
        return $this->msgJson('Information modifiée avec succès');
    }

    function delete_data($id)
    {
        $data = tperso_timesheet::where('id',$id)->delete();
        return $this->msgJson('Information ajoutée avec succès');
        
    }
}
