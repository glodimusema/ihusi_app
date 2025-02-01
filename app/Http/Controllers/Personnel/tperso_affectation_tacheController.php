<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_affectation_tache;
use App\Traits\{GlobalMethod,Slug};
use DB;
use Carbon\Carbon;

class tperso_affectation_tacheController extends Controller
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
    {    ////id, activite_id, affectation_id, date_affect_tache, author  
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);
            $data = DB::table('tperso_affectation_tache')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_affectation_tache.affectation_id')
            ->join('tperso_activites_projet','tperso_activites_projet.id','=','tperso_affectation_tache.activite_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_activites_projet.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            // ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
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
            ->select("tperso_affectation_tache.id", "activite_id","affectation_id", "date_affect_tache",
            "description_tache", "date_debut_tache","duree_tache","date_fin_tache", "nbr_heureJour", 
            "cout_heure","partenaire_id","nom_contrat","code_contrat","description_projet",
             "chef_projet","date_debut_projet", "date_fin_projet","tperso_affectation_tache.author",
             "tperso_affectation_tache.created_at","nom_org", "adresse_org","contact_org", "rccm_org",
             "idnat_org",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
             'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
             'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
             'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
             'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
             "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
             "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
             "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
             "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
             'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
             ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')    
            ->where([
                ['noms_agent', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_affectation_tache.id", "desc")          
            ->paginate(10);
            return response($data, 200);
        }
        else{
            $data = DB::table('tperso_affectation_tache')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_affectation_tache.affectation_id')
            ->join('tperso_activites_projet','tperso_activites_projet.id','=','tperso_affectation_tache.activite_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_activites_projet.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            // ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
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
            ->select("tperso_affectation_tache.id", "activite_id","affectation_id", "date_affect_tache",
            "description_tache", "date_debut_tache","duree_tache","date_fin_tache", "nbr_heureJour", 
            "cout_heure","partenaire_id","nom_contrat","code_contrat","description_projet",
             "chef_projet","date_debut_projet", "date_fin_projet","tperso_affectation_tache.author",
             "tperso_affectation_tache.created_at","nom_org", "adresse_org","contact_org", "rccm_org",
             "idnat_org",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
             'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
             'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
             'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
             'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
             "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
             "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
             "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
             "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
             'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
             ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->orderBy("tperso_affectation_tache.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }


    public function fetch_detail_entete(Request $request,$activite_id)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_affectation_tache')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_affectation_tache.affectation_id')
            ->join('tperso_activites_projet','tperso_activites_projet.id','=','tperso_affectation_tache.activite_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_activites_projet.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            // ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
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
            ->select("tperso_affectation_tache.id", "activite_id","affectation_id", "date_affect_tache",
            "description_tache", "date_debut_tache","duree_tache","date_fin_tache", "nbr_heureJour", 
            "cout_heure","partenaire_id","nom_contrat","code_contrat","description_projet",
             "chef_projet","date_debut_projet", "date_fin_projet","tperso_affectation_tache.author",
             "tperso_affectation_tache.created_at","nom_org", "adresse_org","contact_org", "rccm_org",
             "idnat_org",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
             'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
             'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
             'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
             'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
             "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
             "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
             "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
             "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
             'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
             ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')
            ->where([
                ['description_tache', 'like', '%'.$query.'%'],
                ['activite_id',$activite_id]
            ])                    
            ->orderBy("tperso_affectation_tache.id", "desc")
            ->paginate(10);

            return response($data, 200);        

        }
        else{
      
            $data = DB::table('tperso_affectation_tache')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_affectation_tache.affectation_id')
            ->join('tperso_activites_projet','tperso_activites_projet.id','=','tperso_affectation_tache.activite_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_activites_projet.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            // ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
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
            ->select("tperso_affectation_tache.id", "activite_id","affectation_id", "date_affect_tache",
            "description_tache", "date_debut_tache","duree_tache","date_fin_tache", "nbr_heureJour", 
            "cout_heure","partenaire_id","nom_contrat","code_contrat","description_projet",
             "chef_projet","date_debut_projet", "date_fin_projet","tperso_affectation_tache.author",
             "tperso_affectation_tache.created_at","nom_org", "adresse_org","contact_org", "rccm_org",
             "idnat_org",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
             'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
             'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
             'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
             'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
             "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
             "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
             "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
             "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
             'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
             ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')                
            ->Where('activite_id',$activite_id)    
            ->orderBy("tperso_affectation_tache.id", "desc")
            ->paginate(10);

            return response($data, 200);         
 
        }

    }    


    function fetch_single($id)
    {

        $data =DB::table('tperso_affectation_tache')
        ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_affectation_tache.affectation_id')
        ->join('tperso_activites_projet','tperso_activites_projet.id','=','tperso_affectation_tache.activite_id')
        ->join('tperso_projets','tperso_projets.id','=','tperso_activites_projet.projet_id')
        ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
        // ->join('tperso_typecontrat','tperso_typecontrat.id','=','tperso_projets.typecontrat_id')
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
        ->select("tperso_affectation_tache.id", "activite_id","affectation_id", "date_affect_tache",
        "description_tache", "date_debut_tache","duree_tache","date_fin_tache", "nbr_heureJour", 
        "cout_heure","partenaire_id","nom_contrat","code_contrat","description_projet",
         "chef_projet","date_debut_projet", "date_fin_projet","tperso_affectation_tache.author",
         "tperso_affectation_tache.created_at","nom_org", "adresse_org","contact_org", "rccm_org",
         "idnat_org",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
         'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
         'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
         'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
         'BanqueAgant','autresDetail','conge',"matricule_agent","noms_agent","sexe_agent",
         "datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
         "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
         "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
         "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
         'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle')
         ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
        ->where('tperso_affectation_tache.id', $id)
        ->get();

        return response($data, 200);
    }

//id, activite_id, affectation_id, date_affect_tache, author  

    function insert_data(Request $request)
    {
        $data = tperso_affectation_tache::create([
            'activite_id'       =>  $request->activite_id,
            'affectation_id'    =>  $request->affectation_id,
            'date_affect_tache'    =>  $request->date_affect_tache,
            'author'       =>  $request->author,
        ]);

        return $this->msgJson('Information ajoutée avec succès');
    }


    function update_data(Request $request, $id)
    {
        $data = tperso_affectation_tache::where('id', $id)->update([
            'activite_id'       =>  $request->activite_id,
            'affectation_id'    =>  $request->affectation_id,
            'date_affect_tache'    =>  $request->date_affect_tache,
            'author'       =>  $request->author,
        ]);       
        return $this->msgJson('Information ajoutée avec succès');
    }


    function delete_data($id)
    {
        $data = tperso_affectation_tache::where('id',$id)->delete();
        return $this->msgJson('Information ajoutée avec succès');
        
    }
}
