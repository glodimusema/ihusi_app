<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tperso_detail_paie_salaire;
use App\Models\Personnel\tperso_fiche_paie;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tperso_detail_paie_salaireController extends Controller
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

    // 'id','refFichePaie','refAffectation','salaire_base','fammiliale','logement',
    // 'transport','sal_brut','sal_brut_imposable','inss_qpo','inss_qpp','cnss','inpp','onem','ipr','author'

    public function all(Request $request)
    {    
        if (!is_null($request->get('query'))) {           
            # code..s.
            $query = $this->Gquery($request);
            $data = DB::table('tperso_detail_paie_salaire')            
            ->join('tperso_fiche_paie','tperso_fiche_paie.id','=','tperso_detail_paie_salaire.refFichePaie')
            ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_fiche_paie.refMois')
            ->join('tperso_annee','tperso_annee.id','=', 'tperso_fiche_paie.refAnne')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_detail_paie_salaire.refAffectation')
            ->join('tperso_parametre_salairebase','tperso_parametre_salairebase.id','=','tperso_affectation_agent.param_salaire_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
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
            ->select("tperso_detail_paie_salaire.id","refAffectation",'salaire_base_paie','fammiliale_paie','logement_paie',
            'transport_paie','sal_brut_paie','sal_brut_imposable_paie','inss_qpo_paie','inss_qpp_paie','cnss_paie','inpp_paie','onem_paie','ipr_paie',
            "name_mois","name_annee","dateFiche","refAnne","refMois","dateAffectation","codeAgent","numCNSS","numcpteBanque",
            "numImpot","BanqueAgant","autresDetail",'refFichePaie','refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
            'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
            'nom_contrat','code_contrat','param_salaire_id','fammiliale','logement','tperso_affectation_agent.transport',
            'sal_brut','sal_brut_imposable','inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission',"categorie_id","projet_id","salaire_base",
            "partenaire_id","description_projet","chef_projet","date_debut_projet","date_fin_projet","nom_org",
            "adresse_org","contact_org","rccm_org", "idnat_org",'refBanque',
            "tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",'avance_paie',
            'soins_paie','jourpreste_paie','salaire_horaire','heure_supp1_paie','heure_supp2_paie','heure_supp3_paie','assurances_paie',
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','salaire_prevu')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')
            ->selectRaw('((salaire_base_paie +fammiliale_paie + logement_paie + transport_paie) - inss_qpo_paie - ipr_paie) as netPaie') 
            ->selectRaw('(((salaire_base_paie +fammiliale_paie + logement_paie + transport_paie) - inss_qpo_paie - ipr_paie)-(avance_paie)-(soins_paie)) as netPaieCash')  
            ->where([
                ['noms_agent', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tperso_detail_paie_salaire.id", "desc")          
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tperso_detail_paie_salaire')            
            ->join('tperso_fiche_paie','tperso_fiche_paie.id','=','tperso_detail_paie_salaire.refFichePaie')
            ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_fiche_paie.refMois')
            ->join('tperso_annee','tperso_annee.id','=', 'tperso_fiche_paie.refAnne')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_detail_paie_salaire.refAffectation')
            ->join('tperso_parametre_salairebase','tperso_parametre_salairebase.id','=','tperso_affectation_agent.param_salaire_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
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
            ->select("tperso_detail_paie_salaire.id","refAffectation",'salaire_base_paie','fammiliale_paie','logement_paie',
            'transport_paie','sal_brut_paie','sal_brut_imposable_paie','inss_qpo_paie','inss_qpp_paie','cnss_paie','inpp_paie','onem_paie','ipr_paie',
            "name_mois","name_annee","dateFiche","refAnne","refMois","dateAffectation","codeAgent","numCNSS","numcpteBanque",
            "numImpot","BanqueAgant","autresDetail",'refFichePaie','refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
            'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
            'nom_contrat','code_contrat','param_salaire_id','fammiliale','logement','tperso_affectation_agent.transport',
            'sal_brut','sal_brut_imposable','inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission',"categorie_id","projet_id","salaire_base",
            "partenaire_id","description_projet","chef_projet","date_debut_projet","date_fin_projet","nom_org",
            "adresse_org","contact_org","rccm_org", "idnat_org",'refBanque',
            "tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','salaire_prevu','avance_paie',
            'soins_paie','jourpreste_paie','salaire_horaire','heure_supp1_paie','heure_supp2_paie','heure_supp3_paie','assurances_paie')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')    
            ->selectRaw('((salaire_base_paie +fammiliale_paie + logement_paie + transport_paie) - inss_qpo_paie - ipr_paie) as netPaie') 
            ->selectRaw('(((salaire_base_paie +fammiliale_paie + logement_paie + transport_paie) - inss_qpo_paie - ipr_paie)-(avance_paie)-(soins_paie)) as netPaieCash')    
            ->orderBy("tperso_detail_paie_salaire.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }


    public function fetch_entete_paiement_fiche(Request $request,$refFichePaie)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_detail_paie_salaire')            
            ->join('tperso_fiche_paie','tperso_fiche_paie.id','=','tperso_detail_paie_salaire.refFichePaie')
            ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_fiche_paie.refMois')
            ->join('tperso_annee','tperso_annee.id','=', 'tperso_fiche_paie.refAnne')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_detail_paie_salaire.refAffectation')
            ->join('tperso_parametre_salairebase','tperso_parametre_salairebase.id','=','tperso_affectation_agent.param_salaire_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
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
            ->select("tperso_detail_paie_salaire.id","refAffectation",'salaire_base_paie','fammiliale_paie','logement_paie',
            'transport_paie','sal_brut_paie','sal_brut_imposable_paie','inss_qpo_paie','inss_qpp_paie','cnss_paie','inpp_paie','onem_paie','ipr_paie',
            "name_mois","name_annee","dateFiche","refAnne","refMois","dateAffectation","codeAgent","numCNSS","numcpteBanque",
            "numImpot","BanqueAgant","autresDetail",'refFichePaie','refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
            'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
            'nom_contrat','code_contrat','param_salaire_id','fammiliale','logement','tperso_affectation_agent.transport',
            'sal_brut','sal_brut_imposable','inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission',"categorie_id","projet_id","salaire_base",
            "partenaire_id","description_projet","chef_projet","date_debut_projet","date_fin_projet","nom_org",
            "adresse_org","contact_org","rccm_org", "idnat_org",'refBanque',
            "tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','salaire_prevu','avance_paie',
            'soins_paie','jourpreste_paie','salaire_horaire','heure_supp1_paie','heure_supp2_paie','heure_supp3_paie','assurances_paie')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->selectRaw('((salaire_base_paie +fammiliale_paie + logement_paie + transport_paie) - inss_qpo_paie - ipr_paie) as netPaie')  
            ->selectRaw('(((salaire_base_paie +fammiliale_paie + logement_paie + transport_paie) - inss_qpo_paie - ipr_paie)-(avance_paie)-(soins_paie)) as netPaieCash')
            ->where([
                ['noms_agent', 'like', '%'.$query.'%'],
                ['refFichePaie',$refFichePaie]
            ])                    
            ->orderBy("tperso_detail_paie_salaire.id", "desc")
            ->paginate(10);

            return response($data, 200);          

        }
        else{
      
            $data = DB::table('tperso_detail_paie_salaire')            
            ->join('tperso_fiche_paie','tperso_fiche_paie.id','=','tperso_detail_paie_salaire.refFichePaie')
            ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tperso_mois','tperso_mois.id','=', 'tperso_fiche_paie.refMois')
            ->join('tperso_annee','tperso_annee.id','=', 'tperso_fiche_paie.refAnne')
            ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_detail_paie_salaire.refAffectation')
            ->join('tperso_parametre_salairebase','tperso_parametre_salairebase.id','=','tperso_affectation_agent.param_salaire_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
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
            ->select("tperso_detail_paie_salaire.id","refAffectation",'salaire_base_paie','fammiliale_paie','logement_paie',
            'transport_paie','sal_brut_paie','sal_brut_imposable_paie','inss_qpo_paie','inss_qpp_paie','cnss_paie','inpp_paie','onem_paie','ipr_paie',
            "name_mois","name_annee","dateFiche","refAnne","refMois","dateAffectation","codeAgent","numCNSS","numcpteBanque",
            "numImpot","BanqueAgant","autresDetail",'refFichePaie','refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
            "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
            "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
            "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
            "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
            'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
            'nom_contrat','code_contrat','param_salaire_id','fammiliale','logement','tperso_affectation_agent.transport',
            'sal_brut','sal_brut_imposable','inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission',"categorie_id","projet_id","salaire_base",
            "partenaire_id","description_projet","chef_projet","date_debut_projet","date_fin_projet","nom_org",
            "adresse_org","contact_org","rccm_org", "idnat_org",'refBanque',
            "tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','salaire_prevu','avance_paie',
            'soins_paie','jourpreste_paie','salaire_horaire','heure_supp1_paie','heure_supp2_paie','heure_supp3_paie','assurances_paie')
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')   
            ->selectRaw('((salaire_base_paie +fammiliale_paie + logement_paie + transport_paie) - inss_qpo_paie - ipr_paie) as netPaie')
            ->selectRaw('(((salaire_base_paie +fammiliale_paie + logement_paie + transport_paie) - inss_qpo_paie - ipr_paie)-(avance_paie)-(soins_paie)) as netPaieCash')
            ->Where('refFichePaie',$refFichePaie)    
            ->orderBy("tperso_detail_paie_salaire.id", "desc")
            ->paginate(10);

            return response($data, 200);          
 
        }

    }    
    

    function fetch_single($id)
    {

        $data = DB::table('tperso_detail_paie_salaire')            
        ->join('tperso_fiche_paie','tperso_fiche_paie.id','=','tperso_detail_paie_salaire.refFichePaie')
        ->join('tconf_banque' , 'tconf_banque.id','=','tperso_fiche_paie.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tperso_mois','tperso_mois.id','=', 'tperso_fiche_paie.refMois')
        ->join('tperso_annee','tperso_annee.id','=', 'tperso_fiche_paie.refAnne')
        ->join('tperso_affectation_agent','tperso_affectation_agent.id','=','tperso_detail_paie_salaire.refAffectation')
        ->join('tperso_parametre_salairebase','tperso_parametre_salairebase.id','=','tperso_affectation_agent.param_salaire_id')
        ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
        ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
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
        ->select("tperso_detail_paie_salaire.id","refAffectation",'salaire_base_paie','fammiliale_paie','logement_paie',
        'transport_paie','sal_brut_paie','sal_brut_imposable_paie','inss_qpo_paie','inss_qpp_paie','cnss_paie','inpp_paie','onem_paie','ipr_paie',
        "name_mois","name_annee","dateFiche","refAnne","refMois","dateAffectation","codeAgent","numCNSS","numcpteBanque",
        "numImpot","BanqueAgant","autresDetail",'refFichePaie','refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
        'refMutuelle','refTypeContrat','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
        'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
        'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
        'BanqueAgant','autresDetail','conge',"tperso_affectation_agent.author","matricule_agent","nummaison_agent",
        "noms_agent","sexe_agent","datenaissance_agent","lieunaissnce_agent","provinceOrigine_agent",
        "etatcivil_agent","refAvenue_agent","contact_agent","mail_agent","grade_agent","fonction_agent",
        "specialite_agent","Categorie_agent","niveauEtude_agent","anneeFinEtude_agent","Ecole_agent","tagent.photo as photo_agent",
        "tagent.slug as slug_agent","name_serv_perso","name_categorie_service","name_categorie_agent",
        'nom_poste','description_poste','nom_lieu','description_lieu','nom_mutuelle','description_mutuelle',
        'nom_contrat','code_contrat','param_salaire_id','fammiliale','logement','tperso_affectation_agent.transport',
        'sal_brut','sal_brut_imposable','inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission',"categorie_id","projet_id","salaire_base",
        "partenaire_id","description_projet","chef_projet","date_debut_projet","date_fin_projet","nom_org",
        "adresse_org","contact_org","rccm_org", "idnat_org",'refBanque',
        "tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','salaire_prevu','avance_paie',
        'soins_paie','jourpreste_paie','salaire_horaire','heure_supp1_paie','heure_supp2_paie','heure_supp3_paie','assurances_paie')
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_agent, CURDATE()) as age_agent')  
        ->selectRaw('((salaire_base_paie +fammiliale_paie + logement_paie + transport_paie) - inss_qpo_paie - ipr_paie) as netPaie') 
        ->selectRaw('(((salaire_base_paie +fammiliale_paie + logement_paie + transport_paie) - inss_qpo_paie - ipr_paie)-(avance_paie)-(soins_paie)) as netPaieCash')
        ->where('tperso_detail_paie_salaire.id', $id)
        ->get();

        return response($data, 200);
    }

    //'id','refFichePaie','refAffectation','salaire_base_paie','fammiliale_paie','logement_paie',
    //'transport_paie','sal_brut_paie','sal_brut_imposable_paie','inss_qpo_paie','inss_qpp_paie','cnss_paie','inpp_paie','onem_paie','ipr_paie','author'

    function insert_data(Request $request)
    { 

        $param_salaire_id=0;
        $categorie_id=0;
        $agent_id=0;
        $poste_id=0;

        $salaire_base=0;
        $nombre_enfant=0;
        $fammiliale=0;
        $logement=0;
        $transport=0;
        $sal_brut=0;
        $sal_brut_imposable=0;
        $inss_qpo=0;
        $inss_qpp=0;
        $cnss=0;
        $inpp=0;
        $onem=0;
        $ipr=0;


        $mois_id=0;
        $annee_id=0;
        $avance_paie=0;
        $soins_paie=0;
        $jourpreste_paie=0;
        $salaire_horaire=0;
        $heure_supp1_paie=0;
        $heure_supp2_paie=0;
        $heure_supp3_paie=0;
        $assurances_paie=0;

        $data9 =  DB::table('tperso_fiche_paie')       
        ->select("tperso_fiche_paie.id","tperso_fiche_paie.refMois","refAnne")
        ->where('tperso_fiche_paie.id', '=', $request->refFichePaie) 
        ->get(); 
        $output='';
        foreach ($data9 as $row) 
        {  
            $mois_id=$row->refMois;   
            $annee_id=  $row->refAnne;
        }

        $data8 = DB::table('tperso_demande_soin')            
        ->selectRaw('ROUND(SUM(IFNULL(tperso_demande_soin.factures,0)),0) as total')
        ->where([               
           ['tperso_demande_soin.refAffectation','=', $request->refAffectation],
           ['tperso_demande_soin.refMois','=', $mois_id],
           ['tperso_demande_soin.refAnnee','=', $annee_id]
        ])
        ->get(); 
        $output='';
        foreach ($data8 as $row) 
        { 
            if(((int)$row->total) > 0 )
            {
                $soins_paie=$row->total;
            }
            else
            {
                $soins_paie=0;
            }                               
            
        }

        $data10 = DB::table('tperso_avance_salaire')            
        ->selectRaw('ROUND(SUM(IFNULL(tperso_avance_salaire.montant_avance,0)),0) as total')
        ->where([               
           ['tperso_avance_salaire.refAffectation','=', $request->refAffectation],
           ['tperso_avance_salaire.refMois','=', $mois_id],
           ['tperso_avance_salaire.refAnne','=', $annee_id]
        ])
        ->get(); 
        $output='';
        foreach ($data10 as $row) 
        {  
            if(((int)$row->total) > 0 )
            {
                $avance_paie=$row->total;
            }
            else
            {
                $avance_paie=0;
            } 
        }




        $data7 =  DB::table('tperso_affectation_agent')       
        ->select("tperso_affectation_agent.id","tperso_affectation_agent.param_salaire_id",
        "refCategorieAgent","refAgent","refPoste")
        ->where('tperso_affectation_agent.id', '=', $request->refAffectation) 
        ->get(); 
        $output='';
        foreach ($data7 as $row) 
        {  
            $param_salaire_id=$row->param_salaire_id;   
            $categorie_id=  $row->refCategorieAgent;
            $agent_id=  $row->refAgent;
            $poste_id=  $row->refPoste; 
        }

        $salaire_base=$request->salaire_base_paie; 

        $data3 = DB::table('tperso_dependant')            
        ->selectRaw('ROUND(COUNT(IFNULL(tperso_dependant.id,0)),0) as nbrEnfant')
        ->where([               
           ['refAgent','=', $agent_id]
        ])    
        ->get(); 
        $output='';
        foreach ($data3 as $row) 
        {                                
           $nombre_enfant=$row->nbrEnfant;
        }


        $data4 =  DB::table('tperso_poste')       
        ->select("tperso_poste.id","tperso_poste.transport")
        ->where('tperso_poste.id', '=', $poste_id) 
        ->get(); 
        $output='';
        foreach ($data4 as $row) 
        {  
            $transport=$row->transport;                  
        }

        $assurances_paie=((floatval($salaire_base)*1.5)/100);
        $fammiliale = (int)$nombre_enfant * 5;
        $logement=((floatval($salaire_base)*30)/100);
        // $transport=0;
        $sal_brut=(($salaire_base)+($fammiliale)+($logement)+($transport));        
        $inss_qpo=((floatval($salaire_base)*5)/100);
        $inss_qpp=((floatval($salaire_base)*13)/100);
        $cnss=((floatval($salaire_base)*18)/100);
        $inpp=((floatval($salaire_base)*2)/100);
        $onem=((floatval($salaire_base)*0.2)/100);
        $sal_brut_imposable=((floatval($salaire_base))+(floatval($fammiliale))-(floatval($inss_qpo)));

        if($sal_brut_imposable >= 0 && $sal_brut_imposable<=96)
        {
            $ipr = (((floatval($sal_brut_imposable))*3)/100);
        }
        else if($sal_brut_imposable >= 96.1 && $sal_brut_imposable<=1067)
        {
            $ipr = (((((floatval($sal_brut_imposable) - 96))*15)/100)+2.88);
        }
        else if($sal_brut_imposable >= 1067.1 && $sal_brut_imposable<=2133)
        {
            $ipr = (((((floatval($sal_brut_imposable) - 1163))*30)/100)+148.49);
        }
        else if($sal_brut_imposable >= 2133.1 && $sal_brut_imposable<=3600000)
        {
            $ipr = (((((floatval($sal_brut_imposable) - 3296))*40)/100)+468.51);
        }
        else if($sal_brut_imposable > 3600000)
        {            
        }


        $data = tperso_detail_paie_salaire::create([
            'refAffectation'       =>  $request->refAffectation,
            'refFichePaie'    =>  $request->refFichePaie,
            'salaire_base_paie'    =>  $salaire_base,
            'fammiliale_paie'    =>  $fammiliale,
            'logement_paie'    =>  $logement,
            'transport_paie'    =>  $transport,
            'sal_brut_paie'    =>  $sal_brut,
            'sal_brut_imposable_paie'    =>  $sal_brut_imposable,
            'inss_qpo_paie'    =>  $inss_qpo,
            'inss_qpp_paie'    =>  $inss_qpp,
            'cnss_paie'    =>  $cnss,
            'inpp_paie'    =>  $inpp,
            'onem_paie'    =>  $onem,
            'ipr_paie'    =>  $ipr,

            'avance_paie'=> $avance_paie,
            'soins_paie'=> $soins_paie,
            'jourpreste_paie'=> 0,
            'salaire_horaire'=> 0,
            'heure_supp1_paie'=> 0,
            'heure_supp2_paie'=> 0,
            'heure_supp3_paie'=> 0,
            'assurances_paie'=> $assurances_paie,

            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_data(Request $request)
    {
        $param_salaire_id=0;
        $categorie_id=0;
        $agent_id=0;
        $poste_id=0;

        $salaire_base=0;
        $nombre_enfant=0;
        $fammiliale=0;
        $logement=0;
        $transport=0;
        $sal_brut=0;
        $sal_brut_imposable=0;
        $inss_qpo=0;
        $inss_qpp=0;
        $cnss=0;
        $inpp=0;
        $onem=0;
        $ipr=0;

        $mois_id=0;
        $annee_id=0;
        $avance_paie=0;
        $soins_paie=0;
        $jourpreste_paie=0;
        $salaire_horaire=0;
        $heure_supp1_paie=0;
        $heure_supp2_paie=0;
        $heure_supp3_paie=0;
        $assurances_paie=0;

        $data9 =  DB::table('tperso_fiche_paie')       
        ->select("tperso_fiche_paie.id","tperso_fiche_paie.refMois","refAnne")
        ->where('tperso_fiche_paie.id', '=', $request->refFichePaie) 
        ->get(); 
        $output='';
        foreach ($data9 as $row) 
        {  
            $mois_id=$row->refMois;   
            $annee_id=  $row->refAnne;
        }

        $data8 = DB::table('tperso_demande_soin')            
        ->selectRaw('ROUND(SUM(IFNULL(tperso_demande_soin.factures,0)),0) as total')
        ->where([               
           ['tperso_demande_soin.refAffectation','=', $request->refAffectation],
           ['tperso_demande_soin.refMois','=', $mois_id],
           ['tperso_demande_soin.refAnnee','=', $annee_id]
        ])
        ->get(); 
        $output='';
        foreach ($data8 as $row) 
        {    
            if(((int)$row->total) > 0 )
            {
                $soins_paie=$row->total;
            }
            else
            {
                $soins_paie=0;
            }                            
            
        }

        $data10 = DB::table('tperso_avance_salaire')            
        ->selectRaw('ROUND(SUM(IFNULL(tperso_avance_salaire.montant_avance,0)),0) as total')
        ->where([               
           ['tperso_avance_salaire.refAffectation','=', $request->refAffectation],
           ['tperso_avance_salaire.refMois','=', $mois_id],
           ['tperso_avance_salaire.refAnne','=', $annee_id]
        ])
        ->get(); 
        $output='';
        foreach ($data10 as $row) 
        {  
            if(((int)$row->total) > 0 )
            {
                $avance_paie=$row->total;
            }
            else
            {
                $avance_paie=0;
            } 
        }


        $data7 =  DB::table('tperso_affectation_agent')       
        ->select("tperso_affectation_agent.id","tperso_affectation_agent.param_salaire_id",
        "refCategorieAgent","refAgent","refPoste")
        ->where('tperso_affectation_agent.id', '=', $request->refAffectation) 
        ->get(); 
        $output='';
        foreach ($data7 as $row) 
        {  
            $param_salaire_id=$row->param_salaire_id;   
            $categorie_id=  $row->refCategorieAgent;
            $agent_id=  $row->refAgent;
            $poste_id=  $row->refPoste; 
        }

        $salaire_base=$request->salaire_base_paie; 

        $data3 = DB::table('tperso_dependant')            
        ->selectRaw('ROUND(COUNT(IFNULL(tperso_dependant.id,0)),0) as nbrEnfant')
        ->where([               
           ['refAgent','=', $agent_id]
        ])    
        ->get(); 
        $output='';
        foreach ($data3 as $row) 
        {                                
           $nombre_enfant=$row->nbrEnfant;
        }


        $data4 =  DB::table('tperso_poste')       
        ->select("tperso_poste.id","tperso_poste.transport")
        ->where('tperso_poste.id', '=', $poste_id) 
        ->get(); 
        $output='';
        foreach ($data4 as $row) 
        {  
            $transport=$row->transport;                  
        }

        $assurances_paie=((floatval($salaire_base)*1.5)/100);
        $fammiliale = (int)$nombre_enfant * 5;
        $logement=((floatval($salaire_base)*30)/100);
        // $transport=0;
        $sal_brut=(($salaire_base)+($fammiliale)+($logement)+($transport));        
        $inss_qpo=((floatval($salaire_base)*5)/100);
        $inss_qpp=((floatval($salaire_base)*13)/100);
        $cnss=((floatval($salaire_base)*18)/100);
        $inpp=((floatval($salaire_base)*2)/100);
        $onem=((floatval($salaire_base)*0.2)/100);
        $sal_brut_imposable=((floatval($salaire_base))+(floatval($fammiliale))-(floatval($inss_qpo)));

        if($sal_brut_imposable >= 0 && $sal_brut_imposable<=96)
        {
            $ipr = (((floatval($sal_brut_imposable))*3)/100);
        }
        else if($sal_brut_imposable >= 96.1 && $sal_brut_imposable<=1067)
        {
            $ipr = (((((floatval($sal_brut_imposable) - 96))*15)/100)+2.88);
        }
        else if($sal_brut_imposable >= 1067.1 && $sal_brut_imposable<=2133)
        {
            $ipr = (((((floatval($sal_brut_imposable) - 1163))*30)/100)+148.49);
        }
        else if($sal_brut_imposable >= 2133.1 && $sal_brut_imposable<=3600000)
        {
            $ipr = (((((floatval($sal_brut_imposable) - 3296))*40)/100)+468.51);
        }
        else if($sal_brut_imposable > 3600000)
        {            
        }


        $data = tperso_detail_paie_salaire::where('id', $request->id)->update([
            'refAffectation'       =>  $request->refAffectation,
            'refFichePaie'    =>  $request->refFichePaie,
            'salaire_base_paie'    =>  $salaire_base,
            'fammiliale_paie'    =>  $fammiliale,
            'logement_paie'    =>  $logement,
            'transport_paie'    =>  $transport,
            'sal_brut_paie'    =>  $sal_brut,
            'sal_brut_imposable_paie'    =>  $sal_brut_imposable,
            'inss_qpo_paie'    =>  $inss_qpo,
            'inss_qpp_paie'    =>  $inss_qpp,
            'cnss_paie'    =>  $cnss,
            'inpp_paie'    =>  $inpp,
            'onem_paie'    =>  $onem,
            'ipr_paie'    =>  $ipr,

            'avance_paie'=> $avance_paie,
            'soins_paie'=> $soins_paie,
            'jourpreste_paie'=> 0,
            'salaire_horaire'=> 0,
            'heure_supp1_paie'=> 0,
            'heure_supp2_paie'=> 0,
            'heure_supp3_paie'=> 0,
            'assurances_paie'=> $assurances_paie,

            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!"
        ]);
    }


    function delete_data($id)
    {
        $data = tperso_detail_paie_salaire::where('id',$id)->delete();        
        return response()->json([
            'data'  =>  "suppression avec succès"
        ]);        
    }



    function insert_global_data(Request $request)
    {
        $check=$request->check;  
        $mois_id=$request->refMois;
        $annee_id=$request->refAnne;     

        $taux=0;
        $tauxList = DB::table('tvente_taux')
        ->select("tvente_taux.id","tvente_taux.taux","tvente_taux.created_at")
        ->get();
        foreach ($tauxList as $listTaux) {
            $taux= $listTaux->taux;
        }

        //,'modepaie','refBanque'

        $data = tperso_fiche_paie::create([
            'dateFiche'       =>  date('Y-m-d'),
            'refMois'       =>  $request->refMois,
            'refAnne'    =>  $request->refAnne,
            'modepaie'    =>  $request->modepaie,
            'refBanque'    =>  $request->refBanque,
            'author'    =>  $request->author  
        ]);

        $idmax=0;
        $maxid = DB::table('tperso_fiche_paie')
        ->join('tperso_mois','tperso_mois.id','=', 'tperso_fiche_paie.refMois')
        ->join('tperso_annee','tperso_annee.id','=', 'tperso_fiche_paie.refAnne')        
        ->selectRaw('MAX(tperso_fiche_paie.id) as code_fiche')
        ->where([
            ['tperso_fiche_paie.refAnne',$request->refAnne],
            ['tperso_fiche_paie.refMois',$request->refMois]
        ])
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_fiche;
        }       

        if($check == 'TOUS')
        {
            $refAffectation=0;
            $salaire_base=0;
            $fammiliale= 0;
            $logement= 0;
            $transport= 0;
            $sal_brut= 0;
            $sal_brut_imposable= 0;
            $inss_qpo= 0;
            $inss_qpp= 0;
            $cnss= 0;
            $inpp= 0;
            $onem= 0;
            $ipr= 0;

            $data2 = DB::table('tperso_affectation_agent')
            ->join('tperso_parametre_salairebase','tperso_parametre_salairebase.id','=','tperso_affectation_agent.param_salaire_id')
            ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
            ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
            ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
            'refMutuelle','refTypeContrat','param_salaire_id','fammiliale','logement','transport','sal_brut','sal_brut_imposable',
            'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
            'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
            'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
            'BanqueAgant','autresDetail','conge','salaire_base','tperso_affectation_agent.author')               
            ->orderBy("tperso_affectation_agent.id", "asc")          
            ->get();
            foreach ($data2 as $list) {

                    $refAffectation= $list->id;
                    $salaire_base=$list->salaire_base;
                    $fammiliale= $list->fammiliale;
                    $logement= $list->logement;
                    $transport= $list->transport;
                    $sal_brut= $list->sal_brut;
                    $sal_brut_imposable= $list->sal_brut_imposable;
                    $inss_qpo= $list->inss_qpo;
                    $inss_qpp= $list->inss_qpp;
                    $cnss= $list->cnss;
                    $inpp= $list->inpp;
                    $onem= $list->onem;
                    $ipr= $list->ipr;
                    
                    $avance_paie=0;
                    $soins_paie=0;
                    $jourpreste_paie=0;
                    $salaire_horaire=0;
                    $heure_supp1_paie=0;
                    $heure_supp2_paie=0;
                    $heure_supp3_paie=0;
                    $assurances_paie=0;            
           
                    $data8 = DB::table('tperso_demande_soin')            
                    ->selectRaw('ROUND(SUM(IFNULL(tperso_demande_soin.factures,0)),0) as total')
                    ->where([               
                       ['tperso_demande_soin.refAffectation','=', $refAffectation],
                       ['tperso_demande_soin.refMois','=', $mois_id],
                       ['tperso_demande_soin.refAnnee','=', $annee_id]
                    ])
                    ->get(); 
                    
                    foreach ($data8 as $row) 
                    {  
                        if(((int)$row->total) > 0 )
                        {
                            $soins_paie=$row->total;
                        }
                        else
                        {
                            $soins_paie=0;
                        }                           
                        
                    }
            
                    $data10 = DB::table('tperso_avance_salaire')            
                    ->selectRaw('ROUND(SUM(IFNULL(tperso_avance_salaire.montant_avance,0)),0) as total')
                    ->where([               
                       ['tperso_avance_salaire.refAffectation','=', $refAffectation],
                       ['tperso_avance_salaire.refMois','=', $mois_id],
                       ['tperso_avance_salaire.refAnne','=', $annee_id]
                    ])
                    ->get(); 
                    
                    foreach ($data10 as $row) 
                    {  
                        if(((int)$row->total) > 0 )
                        {
                            $avance_paie=$row->total;
                        }
                        else
                        {
                            $avance_paie=0;
                        }                              
                        
                    }  
                    $assurances_paie=((floatval($salaire_base)*1.5)/100);     


                    $data = tperso_detail_paie_salaire::create([
                        'refAffectation'       =>  $refAffectation,
                        'refFichePaie'    =>  $idmax,
                        'salaire_base_paie'    =>  $salaire_base,
                        'fammiliale_paie'    =>  $fammiliale,
                        'logement_paie'    =>  $logement,
                        'transport_paie'    =>  $transport,
                        'sal_brut_paie'    =>  $sal_brut,
                        'sal_brut_imposable_paie'    =>  $sal_brut_imposable,
                        'inss_qpo_paie'    =>  $inss_qpo,
                        'inss_qpp_paie'    =>  $inss_qpp,
                        'cnss_paie'    =>  $cnss,
                        'inpp_paie'    =>  $inpp,
                        'onem_paie'    =>  $onem,
                        'ipr_paie'    =>  $ipr,

                        'avance_paie'=> $avance_paie,
                        'soins_paie'=> $soins_paie,
                        'jourpreste_paie'=> 0,
                        'salaire_horaire'=> 0,
                        'heure_supp1_paie'=> 0,
                        'heure_supp2_paie'=> 0,
                        'heure_supp3_paie'=> 0,
                        'assurances_paie'=> $assurances_paie,

                        'author'    =>  $request->author
                    ]);
            }

        }
        else if($check == 'PAR SERVICE')
        {
            $refServicePerso=$request->refServicePerso;
            $refAffectation=0;

            $data2 = DB::table('tperso_affectation_agent')
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
            ->select("tperso_affectation_agent.id")               
            ->where([
                ['tperso_affectation_agent.refServicePerso',$refServicePerso]
            ])         
            ->get();
            foreach ($data2 as $list) {
                $refAffectation=0;
                $salaire_base=0;
                $fammiliale= 0;
                $logement= 0;
                $transport= 0;
                $sal_brut= 0;
                $sal_brut_imposable= 0;
                $inss_qpo= 0;
                $inss_qpp= 0;
                $cnss= 0;
                $inpp= 0;
                $onem= 0;
                $ipr= 0;
    
                $data2 = DB::table('tperso_affectation_agent')
                ->join('tperso_parametre_salairebase','tperso_parametre_salairebase.id','=','tperso_affectation_agent.param_salaire_id')
                ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
                ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
                ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
                'refMutuelle','refTypeContrat','param_salaire_id','fammiliale','logement','transport','sal_brut','sal_brut_imposable',
                'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
                'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
                'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
                'BanqueAgant','autresDetail','conge','salaire_base','tperso_affectation_agent.author')               
                ->orderBy("tperso_affectation_agent.id", "asc")          
                ->get();
                foreach ($data2 as $list) {
    
                        $refAffectation= $list->id;
                        $salaire_base=$list->salaire_base;
                        $fammiliale= $list->fammiliale;
                        $logement= $list->logement;
                        $transport= $list->transport;
                        $sal_brut= $list->sal_brut;
                        $sal_brut_imposable= $list->sal_brut_imposable;
                        $inss_qpo= $list->inss_qpo;
                        $inss_qpp= $list->inss_qpp;
                        $cnss= $list->cnss;
                        $inpp= $list->inpp;
                        $onem= $list->onem;
                        $ipr= $list->ipr;

                        $avance_paie=0;
                        $soins_paie=0;
                        $jourpreste_paie=0;
                        $salaire_horaire=0;
                        $heure_supp1_paie=0;
                        $heure_supp2_paie=0;
                        $heure_supp3_paie=0;
                        $assurances_paie=0;            
               
                        $data8 = DB::table('tperso_demande_soin')            
                        ->selectRaw('ROUND(SUM(IFNULL(tperso_demande_soin.factures,0)),0) as total')
                        ->where([               
                           ['tperso_demande_soin.refAffectation','=', $refAffectation],
                           ['tperso_demande_soin.refMois','=', $mois_id],
                           ['tperso_demande_soin.refAnnee','=', $annee_id]
                        ])
                        ->get(); 
                        $output='';
                        foreach ($data8 as $row) 
                        { 
                            if(((int)$row->total) > 0 )
                            {
                                $soins_paie=$row->total;
                            }
                            else
                            {
                                $soins_paie=0;
                            } 
                        } 
                
                        $data10 = DB::table('tperso_avance_salaire')            
                        ->selectRaw('ROUND(SUM(IFNULL(tperso_avance_salaire.montant_avance,0)),0) as total')
                        ->where([               
                           ['tperso_avance_salaire.refAffectation','=', $refAffectation],
                           ['tperso_avance_salaire.refMois','=', $mois_id],
                           ['tperso_avance_salaire.refAnne','=', $annee_id]
                        ])
                        ->get(); 
                        $output='';
                        foreach ($data10 as $row) 
                        {  
                            if(((int)$row->total) > 0 )
                            {
                                $avance_paie=$row->total;
                            }
                            else
                            {
                                $avance_paie=0;
                            }                              
                            
                        } 
                        $assurances_paie=((floatval($salaire_base)*1.5)/100);     
    
    
    
                        $data = tperso_detail_paie_salaire::create([
                            'refAffectation'       =>  $refAffectation,
                            'refFichePaie'    =>  $idmax,
                            'salaire_base_paie'    =>  $salaire_base,
                            'fammiliale_paie'    =>  $fammiliale,
                            'logement_paie'    =>  $logement,
                            'transport_paie'    =>  $transport,
                            'sal_brut_paie'    =>  $sal_brut,
                            'sal_brut_imposable_paie'    =>  $sal_brut_imposable,
                            'inss_qpo_paie'    =>  $inss_qpo,
                            'inss_qpp_paie'    =>  $inss_qpp,
                            'cnss_paie'    =>  $cnss,
                            'inpp_paie'    =>  $inpp,
                            'onem_paie'    =>  $onem,
                            'ipr_paie'    =>  $ipr,

                            'avance_paie'=> $avance_paie,
                            'soins_paie'=> $soins_paie,
                            'jourpreste_paie'=> 0,
                            'salaire_horaire'=> 0,
                            'heure_supp1_paie'=> 0,
                            'heure_supp2_paie'=> 0,
                            'heure_supp3_paie'=> 0,
                            'assurances_paie'=> $assurances_paie,

                            'author'    =>  $request->author
                        ]);
                }
    
            }

        }
        else if($check == 'PAR COORDINATION')
        {
            $refCatService=$request->refCatService;
            $refAffectation=0;

            $data2 = DB::table('tperso_affectation_agent')
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
            ->select("tperso_affectation_agent.id")               
            ->where([
                ['tperso_service_personnel.refCatService',$refCatService]
            ])         
            ->get();
            foreach ($data2 as $list) {
                $refAffectation=0;
                $salaire_base=0;
                $fammiliale= 0;
                $logement= 0;
                $transport= 0;
                $sal_brut= 0;
                $sal_brut_imposable= 0;
                $inss_qpo= 0;
                $inss_qpp= 0;
                $cnss= 0;
                $inpp= 0;
                $onem= 0;
                $ipr= 0;
    
                $data2 = DB::table('tperso_affectation_agent')
                ->join('tperso_parametre_salairebase','tperso_parametre_salairebase.id','=','tperso_affectation_agent.param_salaire_id')
                ->join('tperso_projets','tperso_projets.id','=','tperso_parametre_salairebase.projet_id')
                ->join('tperso_partenaire','tperso_partenaire.id','=','tperso_projets.partenaire_id')
                ->select("tperso_affectation_agent.id",'refAgent','refServicePerso','refCategorieAgent','refPoste','refLieuAffectation',
                'refMutuelle','refTypeContrat','param_salaire_id','fammiliale','logement','transport','sal_brut','sal_brut_imposable',
                'inss_qpo','inss_qpp','cnss','inpp','onem','ipr','mission','dateAffectation','dureecontrat','dureeLettre','dateFin','dateDebutEssaie',
                'dateFinEssaie','JourTrail1','JourTrail2','heureTrail1','heureTrail2','TempsPause','nbrConge','nbrCongeLettre',
                'nomOffice','postnomOffice','qualifieOffice','codeAgent','directeur','numCNSS','numImpot','numcpteBanque',
                'BanqueAgant','autresDetail','conge','salaire_base','tperso_affectation_agent.author')               
                ->orderBy("tperso_affectation_agent.id", "asc")          
                ->get();
                foreach ($data2 as $list) {
    
                        $refAffectation= $list->id;
                        $salaire_base=$list->salaire_base;
                        $fammiliale= $list->fammiliale;
                        $logement= $list->logement;
                        $transport= $list->transport;
                        $sal_brut= $list->sal_brut;
                        $sal_brut_imposable= $list->sal_brut_imposable;
                        $inss_qpo= $list->inss_qpo;
                        $inss_qpp= $list->inss_qpp;
                        $cnss= $list->cnss;
                        $inpp= $list->inpp;
                        $onem= $list->onem;
                        $ipr= $list->ipr;

                        $avance_paie=0;
                        $soins_paie=0;
                        $jourpreste_paie=0;
                        $salaire_horaire=0;
                        $heure_supp1_paie=0;
                        $heure_supp2_paie=0;
                        $heure_supp3_paie=0;
                        $assurances_paie=0;            
               
                        $data8 = DB::table('tperso_demande_soin')            
                        ->selectRaw('ROUND(SUM(IFNULL(tperso_demande_soin.factures,0)),0) as total')
                        ->where([               
                           ['tperso_demande_soin.refAffectation','=', $refAffectation],
                           ['tperso_demande_soin.refMois','=', $mois_id],
                           ['tperso_demande_soin.refAnnee','=', $annee_id]
                        ])
                        ->get(); 
                        $output='';
                        foreach ($data8 as $row) 
                        { 
                            if(((int)$row->total) > 0 )
                            {
                                $soins_paie=$row->total;
                            }
                            else
                            {
                                $soins_paie=0;
                            }                                                        
                           
                        }
                
                        $data10 = DB::table('tperso_avance_salaire')            
                        ->selectRaw('ROUND(SUM(IFNULL(tperso_avance_salaire.montant_avance,0)),0) as total')
                        ->where([               
                           ['tperso_avance_salaire.refAffectation','=', $refAffectation],
                           ['tperso_avance_salaire.refMois','=', $mois_id],
                           ['tperso_avance_salaire.refAnne','=', $annee_id]
                        ])
                        ->get(); 
                        $output='';
                        foreach ($data10 as $row) 
                        {                                
                            if(((int)$row->total) > 0 )
                            {
                                $avance_paie=$row->total;
                            }
                            else
                            {
                                $avance_paie=0;
                            }
                        }  
                        $assurances_paie=((floatval($salaire_base)*1.5)/100);     

    
    
                        $data = tperso_detail_paie_salaire::create([
                            'refAffectation'       =>  $refAffectation,
                            'refFichePaie'    =>  $idmax,
                            'salaire_base_paie'    =>  $salaire_base,
                            'fammiliale_paie'    =>  $fammiliale,
                            'logement_paie'    =>  $logement,
                            'transport_paie'    =>  $transport,
                            'sal_brut_paie'    =>  $sal_brut,
                            'sal_brut_imposable_paie'    =>  $sal_brut_imposable,
                            'inss_qpo_paie'    =>  $inss_qpo,
                            'inss_qpp_paie'    =>  $inss_qpp,
                            'cnss_paie'    =>  $cnss,
                            'inpp_paie'    =>  $inpp,
                            'onem_paie'    =>  $onem,
                            'ipr_paie'    =>  $ipr,

                            'avance_paie'=> $avance_paie,
                            'soins_paie'=> $soins_paie,
                            'jourpreste_paie'=> 0,
                            'salaire_horaire'=> 0,
                            'heure_supp1_paie'=> 0,
                            'heure_supp2_paie'=> 0,
                            'heure_supp3_paie'=> 0,
                            'assurances_paie'=> $assurances_paie,

                            'author'    =>  $request->author
                        ]);
                }
    
            }

        }
        
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }
}
