<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\tresorerie\tt_treso_blocController;
use App\Http\Controllers\tresorerie\tt_treso_categorie_rubriqueController;
use App\Http\Controllers\tresorerie\tt_treso_detail_angagementController;
use App\Http\Controllers\tresorerie\tt_treso_detail_etatbesoinController;
use App\Http\Controllers\tresorerie\tt_treso_entete_etatbesoinController;
use App\Http\Controllers\tresorerie\tt_treso_provenanceController;
use App\Http\Controllers\tresorerie\tt_treso_rubriqueController;
use App\Http\Controllers\tresorerie\ttreso_entete_angagementController;

use App\Http\Controllers\Finances\BonSortieCaissePdfController;
use App\Http\Controllers\Finances\BonEntreeCaissePdfController;
use App\Http\Controllers\Finances\tBanqueController;
use App\Http\Controllers\Finances\tCompteController;
use App\Http\Controllers\Finances\tClasseController;
use App\Http\Controllers\Finances\tfin_cloture_comptabiliteController;
use App\Http\Controllers\Finances\tCompteFinController;
use App\Http\Controllers\Finances\tSousCompteFinController;
use App\Http\Controllers\Finances\tSSousCompteFinController;
use App\Http\Controllers\Finances\tTypeCompteController;
use App\Http\Controllers\Finances\tTypeOperationController;
use App\Http\Controllers\Finances\tTypePositionController;
use App\Http\Controllers\Finances\Pdf_ComptabiliteController;
use App\Http\Controllers\Finances\tClotureCaisseController;
use App\Http\Controllers\Finances\tfin_entete_operationcompteController;
use App\Http\Controllers\Finances\tfin_detail_operationcompteController;
use App\Http\Controllers\Finances\tDepenseController;
use App\Http\Controllers\Finances\Pdf_BonEngagementController;
use App\Http\Controllers\Finances\ModePaieController;



//=====================PERSONNELLE===================================
use App\Http\Controllers\Personnel\tcategoriemedecinController;
use App\Http\Controllers\Personnel\tfonctionmedecinController;
use App\Http\Controllers\Personnel\tagentController;

use App\Http\Controllers\Personnel\tperso_affectation_agentController;
use App\Http\Controllers\Personnel\tperso_demandecongeController;

use App\Http\Controllers\Personnel\tperso_partenaireController;
use App\Http\Controllers\Personnel\tperso_projetsController;
use App\Http\Controllers\Personnel\tperso_activites_projetController;
use App\Http\Controllers\Personnel\tchecklistController;
use App\Http\Controllers\Personnel\tperso_livrablesController;
use App\Http\Controllers\Personnel\tperso_paie_projetController;
use App\Http\Controllers\Personnel\tperso_affectation_tacheController;
use App\Http\Controllers\Personnel\tperso_presences_agentController;
use App\Http\Controllers\Personnel\tperso_timesheetController;
use App\Http\Controllers\Personnel\tperso_correspondanceController;

use App\Http\Controllers\Personnel\categorieRubriqueController;
use App\Http\Controllers\Personnel\tperso_anneeController;
use App\Http\Controllers\Personnel\tperso_divisionController;
use App\Http\Controllers\Personnel\tperso_categorie_archivageController;
use App\Http\Controllers\Personnel\tperso_service_archivageController;
use App\Http\Controllers\Personnel\tperso_parametre_salairebaseController;
use App\Http\Controllers\Personnel\tperso_baremeController;
use App\Http\Controllers\Personnel\tperso_archivagesController;
use App\Http\Controllers\Personnel\SimpleExcelController;
use App\Http\Controllers\Personnel\tperso_promotion_stageController;
use App\Http\Controllers\Personnel\tperso_domaine_stageController;
use App\Http\Controllers\Personnel\tperso_option_stageController;
use App\Http\Controllers\Personnel\tperso_parcours_stageController;
use App\Http\Controllers\Personnel\tperso_institution_stageController;
use App\Http\Controllers\Personnel\tperso_stagesController;
use App\Http\Controllers\Personnel\tperso_appreciation_agentController;
use App\Http\Controllers\Personnel\tperso_autre_congeController;
use App\Http\Controllers\Personnel\Pdf_PersonnelController;
use App\Http\Controllers\Personnel\Pdf_ContratController;
use App\Http\Controllers\Personnel\tperso_categorie_agentController;
use App\Http\Controllers\Personnel\tperso_categorie_rubriqueController;
use App\Http\Controllers\Personnel\tperso_typecirconstancecongeController;
use App\Http\Controllers\Personnel\tperso_posteController;
use App\Http\Controllers\Personnel\tperso_lieuaffectationController;
use App\Http\Controllers\Personnel\tperso_mutuelleController;
use App\Http\Controllers\Personnel\tperso_typecontratController;
use App\Http\Controllers\Personnel\tperso_categorie_serviceController;
use App\Http\Controllers\Personnel\tperso_categorie_circonstanceController;
use App\Http\Controllers\Personnel\tperso_conge_annuelController;
use App\Http\Controllers\Personnel\tperso_conge_familialeController;
use App\Http\Controllers\Personnel\tperso_controle_congeController;
use App\Http\Controllers\Personnel\tperso_demande_soinController;
use App\Http\Controllers\Personnel\tperso_dependantConrtoller;
use App\Http\Controllers\Personnel\tperso_annexeConrtoller;
use App\Http\Controllers\Personnel\tperso_detail_affectation_ribriqueController;
use App\Http\Controllers\Personnel\tperso_detail_paiement_salController;
use App\Http\Controllers\Personnel\tperso_entete_congeController;
use App\Http\Controllers\Personnel\tperso_entete_paiementController;
use App\Http\Controllers\Personnel\tperso_detail_paie_salaireController;
use App\Http\Controllers\Personnel\tperso_fiche_paieController;
use App\Http\Controllers\Personnel\tperso_maladie_congeController;
use App\Http\Controllers\Personnel\tperso_materniteController;
use App\Http\Controllers\Personnel\tperso_moisController;
use App\Http\Controllers\Personnel\tperso_parametre_rubriqueController;
use App\Http\Controllers\Personnel\tperso_raison_familialeController;
use App\Http\Controllers\Personnel\tperso_rubriqueController;
use App\Http\Controllers\Personnel\tperso_service_personnelController;
use App\Http\Controllers\Personnel\tperso_sortie_agentController;
use App\Http\Controllers\Personnel\tperso_avance_salaireController;
use App\Http\Controllers\Personnel\tperso_enmissionController;

use App\Http\Controllers\Parametres\tconf_list_menuController;
use App\Http\Controllers\Parametres\tconf_affectation_menuController;
use App\Http\Controllers\Parametres\tconf_crud_accessController;
use App\Http\Controllers\Parametres\tconf_historique_informationController;

use App\Http\Controllers\Personnel\tperso_annee_stageController;

use App\Http\Controllers\Personnel\tperso_type_stageController;


use App\Http\Controllers\Personnel\backupsController;

//

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['namespace'   =>  "Role"], function(){
    Route::get("fetch_role", 'RoleController@index');
    Route::get("fetch_single_role/{id}", 'RoleController@edit');
    Route::get("delete_role/{id}", 'RoleController@destroy');
    Route::post("insert_role", 'RoleController@store');
    Route::get("fetch_role_2", 'RoleController@fetch_role_2');
});
//fetch_user_compte
    Route::group(['namespace'   =>  "User"], function(){
    Route::get("fetch_user", 'UserController@index');
    Route::get("fetch_user_all", 'UserController@fetch_user_all');
    Route::get("fetch_user_compte", 'UserController@fetch_user_compte');
    Route::get("fetch_user_2", 'UserController@fetch_user_2');
    //fetch_user_2
    
    Route::get("fetch_single_user/{id}", 'UserController@edit');
    Route::get("delete_user/{id}", 'UserController@destroy');
    Route::post("insert_user", 'UserController@store');
    Route::post("change_pwd_user", 'UserController@ChangePassword');
    Route::post("change_role_user", 'UserController@ChangeRole');

    Route::post("insertion_user", 'UserController@insert_user');

    // envoie de mail
    Route::post("send_mail", 'SendMailController@send_mail');
    // imprimmer sa carte 
    Route::get('print_bill','UserController@printBill');

    Route::post('edit_photo','UserController@editPhoto');

    Route::get("showUser/{id}", 'UserController@showUser');

    //modifier son mot de passe
    Route::post("ChangeMyPasswordSecure", 'UserController@ChangeMyPasswordSecure');

    Route::get("fetch_user_ceo", 'UserController@fetch_user_ceo');

    Route::get("checkEtat_compte/{id}/{etat}", 'UserController@checkEtat_Compte');

    

    
    
});

Route::group(['namespace'   =>  "Site"], function(){
    Route::get("fetch_site", 'SiteController@index');
    Route::get("fetch_single_site/{id}", 'SiteController@edit');
    Route::get("delete_site/{id}", 'SiteController@destroy');
    Route::post("insert_site", 'SiteController@store');
   
    Route::post('edit_photo_site','SiteController@editPhoto');

});

Route::group(['namespace'   =>  "Basic"], function(){
    Route::get("fetch_basic", 'BasicController@index');
    Route::get("fetch_single_basic/{id}", 'BasicController@edit');
    Route::get("delete_basic/{id}", 'BasicController@destroy');
    Route::post("insert_basic", 'BasicController@store');

});

Route::group(['namespace'   =>  "Service"], function(){
    Route::get("fetch_service", 'ServiceController@index');
    Route::get("fetch_single_service/{id}", 'ServiceController@edit');
    Route::get("delete_service/{id}", 'ServiceController@destroy');
    Route::post("insert_service", 'ServiceController@store');

});

Route::group(['namespace'   =>  "Category"], function(){
    Route::get("fetch_category_article", 'CategoryArticleController@index');
    Route::get("fetch_single_category_article/{id}", 'CategoryArticleController@edit');
    Route::get("delete_category_article/{id}", 'CategoryArticleController@destroy');
    Route::post("insert_category_article", 'CategoryArticleController@store');
    Route::get("fetchCategoryArticle", 'CategoryArticleController@fetchCategoryArticle');
    
});

Route::group(['namespace'   =>  "Blog"], function(){
    Route::get("fetch_blog", 'BlogController@index');
    Route::get("fetch_single_blog/{id}", 'BlogController@edit');
    Route::get("delete_blog/{id}", 'BlogController@destroy');

    Route::get("checkEtat_blog/{id}/{etat}", 'BlogController@checkEtat_blog');
    Route::post("insert_blog", 'BlogController@insertData');
    Route::post("update_blog", 'BlogController@updateData');

});


Route::group(['namespace'   =>  "Partenaire"], function(){
    Route::get("fetch_partenaire", 'PartenaireController@index');
    Route::get("fetch_single_partenaire/{id}", 'PartenaireController@edit');
    Route::get("delete_partenaire/{id}", 'PartenaireController@destroy');
    Route::post("insert_partenaire", 'PartenaireController@insertData');
    Route::post("update_partenaire", 'PartenaireController@updateData');

});

Route::group(['namespace'   =>  "Galery"], function(){
    Route::get("fetch_galery", 'GaleryController@index');
    Route::get("fetch_single_galery/{id}", 'GaleryController@edit');
    Route::get("delete_galery/{id}", 'GaleryController@destroy');
    Route::post("insert_galery", 'GaleryController@insertData');
    Route::post("update_galery", 'GaleryController@updateData');

});

Route::group(['namespace'   =>  "Video"], function(){
    Route::get("fetch_video", 'VideoController@index');
    Route::get("fetch_single_video/{id}", 'VideoController@edit');
    Route::get("delete_video/{id}", 'VideoController@destroy');
    Route::post("insert_video", 'VideoController@store');

});

Route::group(['namespace'   =>  "Team"], function(){
    //team 
    Route::get("fetch_team", 'TeamController@index');
    Route::get("fetch_single_team/{id}", 'TeamController@edit');
    Route::get("delete_team/{id}", 'TeamController@destroy');
    Route::post("insert_team", 'TeamController@insertData');
    Route::post("update_team", 'TeamController@updateData');
    Route::get("validationTeam/{id}/{etat}", 'TeamController@validationTeam');
    
});

Route::group(['namespace'   =>  "ContactInfo"], function(){
    Route::get("fetch_contact_onfo", 'ContactInfoController@index');
    Route::get("fetch_single_contact_onfo/{id}", 'ContactInfoController@edit');
    Route::get("delete_contact_onfo/{id}", 'ContactInfoController@destroy');
    Route::post("insert_contact_onfo", 'ContactInfoController@store');

});

Route::group(['namespace'   =>  "Carousel"], function(){
    Route::get("fetch_carousel", 'CarouselController@index');
    Route::get("fetch_single_carousel/{id}", 'CarouselController@edit');
    Route::get("delete_carousel/{id}", 'CarouselController@destroy');
    Route::post("insert_carousel", 'CarouselController@insertData');
    Route::post("update_carousel", 'CarouselController@updateData');
    
});

Route::group(['namespace'   =>  "Temoignage"], function(){
    Route::get("fetch_temoignage", 'TemoignageController@index');
    Route::get("fetch_single_temoignage/{id}", 'TemoignageController@edit');
    Route::get("delete_temoignage/{id}", 'TemoignageController@destroy');
    Route::post("insert_temoignage", 'TemoignageController@insertData');
    Route::post("update_temoignage", 'TemoignageController@updateData');

    
});

Route::group(['namespace'   =>  "Valeur"], function(){
    Route::get("fetch_valeur", 'ValeurController@index');
    Route::get("fetch_single_valeur/{id}", 'ValeurController@edit');
    Route::get("delete_valeur/{id}", 'ValeurController@destroy');
    Route::post("insert_valeur", 'ValeurController@insertData');
    Route::post("update_valeur", 'ValeurController@updateData');

    
});

Route::group(['namespace'   =>  "Choix"], function(){
    Route::get("fetch_choix", 'ChoixController@index');
    Route::get("fetch_single_choix/{id}", 'ChoixController@edit');
    Route::get("delete_choix/{id}", 'ChoixController@destroy');
    Route::post("insert_choix", 'ChoixController@insertData');
    Route::post("update_choix", 'ChoixController@updateData');
    
});

Route::group(['namespace'   =>  "Decision"], function(){
    Route::get("fetch_decision", 'DecisionController@index');
    Route::get("fetch_single_decision/{id}", 'DecisionController@edit');
    Route::get("delete_decision/{id}", 'DecisionController@destroy');
    Route::post("insert_decision", 'DecisionController@insertData');
    Route::post("update_decision", 'DecisionController@updateData');
    
});

Route::group(['namespace'   =>  "Avantage"], function(){
    Route::get("fetch_avantage", 'AvantageController@index');
    Route::get("fetch_single_avantage/{id}", 'AvantageController@edit');
    Route::get("delete_avantage/{id}", 'AvantageController@destroy');
    Route::post("insert_avantage", 'AvantageController@insertData');
    Route::post("update_avantage", 'AvantageController@updateData');
    
});

Route::group(['namespace'   =>  "ServiceEntrep"], function(){
    Route::get("fetch_valeur_service", 'ServiceEntrepController@index');
    Route::get("fetch_single_valeur_service/{id}", 'ServiceEntrepController@edit');
    Route::get("delete_valeur_service/{id}", 'ServiceEntrepController@destroy');
    Route::post("insert_valeur_service", 'ServiceEntrepController@insertData');
    Route::post("update_valeur_service", 'ServiceEntrepController@updateData');
    Route::get("fetch_ours_services", 'ServiceEntrepController@fetch_All_services');

    
});

Route::group(['namespace'   =>  "RoleService"], function(){
    Route::get("fetch_role_service", 'RoleServiceController@index');
    Route::get("fetch_single_role_service/{id}", 'RoleServiceController@edit');
    Route::get("delete_role_service/{id}", 'RoleServiceController@destroy');
    Route::post("insert_role_service", 'RoleServiceController@insertData');
    Route::post("update_role_service", 'RoleServiceController@updateData');
    
});

Route::group(['namespace'   =>  "SouServiceEntrep"], function(){
    Route::get("fetch_sous_service", 'SouServiceEntrepController@index');
    Route::get("fetch_single_sous_service/{id}", 'SouServiceEntrepController@edit');
    Route::get("delete_sous_service/{id}", 'SouServiceEntrepController@destroy');
    Route::post("insert_sous_service", 'SouServiceEntrepController@insertData');
    Route::post("update_sous_service", 'SouServiceEntrepController@updateData');
    Route::get("fetch_ours_sous_services", 'SouServiceEntrepController@fetch_All_Sous_Services');
    
});







/*
*les scripts commencent
*=====================
*pnud management project
*------------------------
*/
Route::group(['namespace'   =>  "Backend"], function(){

    //mot de la semaine
    Route::get("fetch_week", 'SwotController@indexMotSemaine');
    Route::get("fetch_single_week/{id}", 'SwotController@editMotSemaine');
    Route::get("delete_week/{id}", 'SwotController@destroyMotSemaine');
    Route::post("insert_week", 'SwotController@storeMotSemaine');
    Route::get("fetch_latest_week", 'SwotController@showLatestweek');
    Route::get("fetch_latest_users", 'SwotController@getListUsersLatest');

    //fin mot de la semaine


    Route::get("fetch_pays", 'PaysController@index');
    Route::get("fetch_single_pays/{id}", 'PaysController@edit');
    Route::get("delete_pays/{id}", 'PaysController@destroy');
    Route::post("insert_pays", 'PaysController@store');
    Route::get("fetch_pays_2", 'PaysController@fetch_pays_2');
    Route::get("destroyMessage/{id}", 'PaysController@destroyMessage');
    

    //provinces
    Route::get("fetch_province", 'ProvinceController@index');
    Route::get("fetch_single_province/{id}", 'ProvinceController@edit');
    Route::get("delete_province/{id}", 'ProvinceController@destroy');
    Route::post("insert_province", 'ProvinceController@store');
    Route::get("fetch_province_2", 'ProvinceController@fetch_province_2');
    Route::get("fetch_province_tug_pays/{idPays}", 'ProvinceController@fetch_province_tug_pays');



    //Ville
    Route::get("fetch_ville", 'VilleController@index');
    Route::get("fetch_single_ville/{id}", 'VilleController@edit');
    Route::get("delete_ville/{id}", 'VilleController@destroy');
    Route::post("insert_ville", 'VilleController@store');
    Route::get("fetch_ville_tug_pays/{idProvince}", 'VilleController@fetch_ville_tug_pays');
    

    //Commune
    Route::get("fetch_commune", 'CommuneController@index');
    Route::get("fetch_single_commune/{id}", 'CommuneController@edit');
    Route::get("delete_commune/{id}", 'CommuneController@destroy');
    Route::post("insert_commune", 'CommuneController@store');
    Route::get("fetch_commune_tug_ville/{idVille}", 'CommuneController@fetch_commune_tug_ville');

    //Quartier
    Route::get("fetch_quartier", 'QuartierController@index');
    Route::get("fetch_single_quartier/{id}", 'QuartierController@edit');
    Route::get("delete_quartier/{id}", 'QuartierController@destroy');
    Route::post("insert_quartier", 'QuartierController@store');
    Route::get("fetch_quartier_tug_commune/{idVille}", 'QuartierController@fetch_quartier_tug_commune');

    //Avenue
    Route::get("fetch_avenue", 'AvenueController@index');
    Route::get("fetch_single_avenue/{id}", 'AvenueController@edit');
    Route::get("delete_avenue/{id}", 'AvenueController@destroy');
    Route::post("insert_avenue", 'AvenueController@store');
    Route::get("getAvenueTug/{idQuartier}", 'AvenueController@getAvenueTug');
    


    

    //secteur
    Route::get("fetch_secteur", 'SecteurController@index');
    Route::get("fetch_single_secteur/{id}", 'SecteurController@edit');
    Route::get("delete_secteur/{id}", 'SecteurController@destroy');
    Route::post("insert_secteur", 'SecteurController@store');
    Route::get("fetch_secteur_2", 'SecteurController@fetch_secteur_2');

    //forme_juridiques
    Route::get("fetch_forme_juridiques", 'FormeJuridiqueController@index');
    Route::get("fetch_single_forme_juridiques/{id}", 'FormeJuridiqueController@edit');
    Route::get("delete_forme_juridiques/{id}", 'FormeJuridiqueController@destroy');
    Route::post("insert_forme_juridiques", 'FormeJuridiqueController@store');
    Route::get("fetch_forme_juridiques_2", 'FormeJuridiqueController@fetch_forme_juridiques_2');

    //entreprises
    Route::get("fetch_entreprise", 'EntrepriseController@index');
    Route::get("fetch_single_entreprise/{id}", 'EntrepriseController@edit');
    Route::get("delete_entreprise/{id}", 'EntrepriseController@destroy');
    Route::post("insert_entreprise", 'EntrepriseController@store');
    Route::get("fetch_entreprise_2", 'EntrepriseController@fetch_entreprise_2');

    Route::get("checkEtat_entreprise/{id}/{etat}", 'EntrepriseController@checkEtat_entreprise');
    Route::get('get_project_infos/{slug}','EntrepriseController@getEntrepriseDetails');
    Route::post('add_pitch','EntrepriseController@AddPich');
    Route::post('add_busness_plan','EntrepriseController@AddBusnessPlan');

    //triage filtrage
    Route::get("fetch_entreprise_tug/{id}", 'EntrepriseController@fetch_entreprise_tug');
    


    //photoentreprise
    
    Route::get("fetch_photo_entreprise/{id_entrep}", 'EntrepriseController@getPhotoEntreprise');
    Route::post('add_photo_entreprise','EntrepriseController@AddPhotoEntreprise');
    Route::get("delete_photo_entreprise/{id}", 'EntrepriseController@destroyPhotoEntreprise');

    //videoentreprise
    Route::get("fetch_video_entreprise/{id_entrep}", 'EntrepriseController@getVideoEntreprise');
    Route::post("insert_video_entreprise", 'EntrepriseController@storeVideoEntreprise');
    Route::get("fetch_single_video_entreprise/{id_entrep}", 'EntrepriseController@editVideoEntreprise');
    Route::get("delete_video_entreprise/{id_entrep}", 'EntrepriseController@destroyVideoEntreprise');
    
    //canvas model
    Route::get("fetch_canvas_entreprise/{slug}", 'EntrepriseController@getCanvasEntreprise');
    Route::get("fetch_single_canvas_entreprise/{id_entrep}", 'EntrepriseController@editCanvasEntreprise');
    Route::post("insert_canvas_entreprise", 'EntrepriseController@storeCanvasEntreprise');
    Route::get("delete_canvas_entreprise/{id_entrep}", 'EntrepriseController@destroyCanvasEntreprise');

    //pour canvas correction
    Route::get("fetch_single_canvas_correction_entreprise/{id_entrep}", 'EntrepriseController@editCanvasCorrectionEntreprise');
    Route::post("insert_canvas_correction_entreprise", 'EntrepriseController@storeCanvasCorrectionEntreprise');
    Route::get("delete_canvas_correction_entreprise/{id_entrep}", 'EntrepriseController@destroyCanvasCorrectionEntreprise');

    //swot model
    Route::get("fetch_swot_entreprise/{slug}", 'EntrepriseController@getSwotEntreprise');
    Route::get("fetch_single_swot_entreprise/{id_entrep}", 'EntrepriseController@editSwotEntreprise');
    Route::post("insert_swot_entreprise", 'EntrepriseController@storeSwotEntreprise');
    Route::get("delete_swot_entreprise/{id_entrep}", 'EntrepriseController@destroySwotEntreprise');

    //pour swot correction
    Route::get("fetch_single_swot_correction_entreprise/{id_entrep}", 'EntrepriseController@editSwotCorrectionEntreprise');
    Route::post("insert_swot_correction_entreprise", 'EntrepriseController@storeSwotCorrectionEntreprise');
    Route::get("delete_swot_correction_entreprise/{id_entrep}", 'EntrepriseController@destroySwotCorrectionEntreprise');

    Route::get("fetch_filtre_menu_entreprise", 'EntrepriseController@getMenuFiltrage');
    //show ceo entreprise and filtre
    Route::get("fetch_ceo_entreprise", 'EntrepriseController@showCeoEntreprise');
    Route::get("getEntreprisePays/{idPays}", 'EntrepriseController@getEntreprisePays');
    Route::get("getEntreprisePprovince/{idPays}", 'EntrepriseController@getEntreprisePprovince');
    Route::get("getEntrepriseSecteur/{idsecteur}", 'EntrepriseController@getEntrepriseSecteur');
    Route::get("getEntrepriseForme/{idforme}", 'EntrepriseController@getEntrepriseForme');
    Route::get("getEntrepriseEdition/{idforme}", 'EntrepriseController@getEntrepriseEdition');
    //document
    Route::get('get_project_infos_document/{slug}','EntrepriseController@getEntrepriseDetailsDocument');

    // impression de la liste
    Route::get('pdf_entreprise_morale','SwotController@makepdfEntrepriseMorale');
    Route::get('pdf_liste_entreprise_morale','SwotController@makepdfListeEntrepriseMorale');

    //statistique users
    Route::get('stat_users','SwotController@stat_users');
    Route::get('stat_users_sexe_ceo','SwotController@stat_users_sexe_ceo');
    Route::get('pnudShowLineChartAssuranceAuto','SwotController@pnudShowLineChartAssuranceAuto');
    Route::get('stat_blogs','SwotController@stat_blogs');
    
    Route::get('statEntreprise','SwotController@statEntreprise');
    Route::get('statEntrepriseSecteur','SwotController@statEntrepriseSecteur');
    
    Route::get("showCountDashbord", 'SwotController@showCountDashbord');
    Route::get('statEntreprisePrint','SwotController@statEntreprisePrint');

    //debit
    Route::get("showCountDashbord_tug/{id}", 'SwotController@showCountDashbord_tug');
    Route::get('fetchMessagesTug/{user_id}', 'SwotController@fetchMessagesTug');
    
    Route::get('/get_all_users', 'SwotController@users');


    //territoire
    Route::get("fetch_territoire", 'TerritoireController@index');
    Route::get("fetch_single_territoire/{id}", 'TerritoireController@edit');
    Route::get("delete_territoire/{id}", 'TerritoireController@destroy');
    Route::post("insert_territoire", 'TerritoireController@store');
    Route::get("fetch_territoire_2", 'TerritoireController@fetch_territoire_2');

    //texto sms
    Route::get("fetch_texto", 'TextoController@index');
    Route::get("fetch_single_texto/{id}", 'TextoController@edit');
    Route::get("delete_texto/{id}", 'TextoController@destroy');
    Route::post("insert_texto", 'TextoController@store');
    
    Route::get("checkEtat_texto/{id}/{phone}/{etat}", 'TextoController@checkEtat_texto');
    


    
});

Route::group(['namespace'   =>  "Patients"], function(){
    Route::get("fetch_rdv_malade", 'RvdMaladeController@index');
    Route::get("showRDV_Carte/{numeroCarte}", 'RvdMaladeController@showRDV_Carte');
    Route::get("fetch_single_rdv_malade/{id}", 'RvdMaladeController@edit');    
    Route::post("insert_rdv_malade", 'RvdMaladeController@insertData');
    Route::post("update_rdv_malade", 'RvdMaladeController@updateData');
    Route::get("delete_rdv_malade/{id}", 'RvdMaladeController@destroy');    
    
    Route::get("fetch_carte_malade", 'CarteController@index');
    Route::get("searchMaladeTeste", 'CarteController@searchMaladeTeste');
    Route::get("showCarte_Compte/{mail_profil}", 'CarteController@showCarte_Compte');
    Route::get("fetch_single_carte_malade/{id}", 'CarteController@edit');   
    Route::get("carte_by_user/{refUser}", 'CarteController@carte_by_user');  
    Route::post("insert_carte_malade", 'CarteController@insertData');
    Route::post("update_carte_malade", 'CarteController@updateData');
    Route::post("update_carte_profil", 'CarteController@updateData2');
    Route::get("delete_carte_malade/{id}", 'CarteController@destroy'); 

    Route::get("fetch_rapportmedical_malade", 'tdata_rapportmedicalController@all');
    Route::get("fetch_rapportmedical_cons/{refPatient}", 'tdata_rapportmedicalController@fetch_rapportmedical_cons');
    Route::get("fetch_single_rapportmedical/{id}", 'tdata_rapportmedicalController@fetch_single_rapportmedical');    
    Route::post("insert_rapportmedical", 'tdata_rapportmedicalController@insert_rapportmedical');
    Route::post("update_rapportmedical", 'tdata_rapportmedicalController@update_rapportmedical');
    Route::get("delete_rapportmedical/{id}", 'tdata_rapportmedicalController@delete_rapportmedical');

    Route::get("pdf_rapportmedical_data", 'Pdf_AttestationsController@pdf_rapportmedical_data');
    Route::get("pdf_carte_medicale", 'CartePdfController@pdf_carte_medicale'); 

    //CartePdfController
    
});

Route::group(['namespace'	=>	"Connexion"], function(){
	Route::post("checkLogin", 'ConnexionController@checkLogin');
	Route::post("register_count", 'ConnexionController@createCount');
	Route::get("logout", 'ConnexionController@logout');
    Route::get("fetch_login_patient", 'ConnexionController@fetch_login_patient');
	Route::get("fetch_all_user", 'ConnexionController@fetch_all_user');
	
});


//========================================================================================================
//===========================================================================================================


Route::group(['namespace'   =>  "Logistique"], function(){

    Route::get("fetch_log_produit", 'tlog_produitController@index');
    Route::get("fetch_log_single_produit/{id}", 'tlog_produitController@edit');
    Route::get("delete_log_produit/{id}", 'tlog_produitController@destroy');
    Route::post("insert_log_produit", 'tlog_produitController@store');
    Route::get("fetch_tlog_produit_2", 'tlog_produitController@fetch_tlog_produit_2');
    Route::get("fetch_list_produit_depo/{refEmplacement}", 'tlog_produitController@fetch_list_produit_depo');

    Route::get("fetch_log_service", 'tlog_serviceController@index');
    Route::get("fetch_single_log_service/{id}", 'tlog_serviceController@edit');
    Route::get("delete_log_service/{id}", 'tlog_serviceController@destroy');
    Route::post("insert_log_service", 'tlog_serviceController@store');
    Route::get("fetch_tlog_service_2", 'tlog_serviceController@fetch_tlog_service_2');

    Route::get("fetch_log_emplacement", 'tlog_emplacementsController@index');
    Route::get("fetch_single_log_emplacement/{id}", 'tlog_emplacementsController@edit');
    Route::get("delete_log_emplacement/{id}", 'tlog_emplacementsController@destroy');
    Route::post("insert_log_emplacement", 'tlog_emplacementsController@store');
    Route::get("fetch_tlog_emplacement_2", 'tlog_emplacementsController@fetch_tlog_emplacements_2');

    Route::get("fetch_entete_log_entree", 'tlog_entete_entreeController@all');
    Route::get("fetch_entete_log_entree_fournisseur/{refEntete}", 'tlog_entete_entreeController@fetch_data_entete');
    Route::get("fetch_single_entete_log_entree/{id}", 'tlog_entete_entreeController@fetch_single_data');    
    Route::post("insert_entete_log_entree", 'tlog_entete_entreeController@insert_data');
    Route::post("update_entete_log_entree/{id}", 'tlog_entete_entreeController@update_data');
    Route::get("delete_entete_log_entree/{id}", 'tlog_entete_entreeController@delete_data');

    Route::get("fetch_entete_log_requisition", 'tlog_entete_requisitionController@all');
    Route::get("fetch_entete_log_requisition_fournisseur/{refEntete}", 'tlog_entete_requisitionController@fetch_data_entete');
    Route::get("fetch_single_entete_log_requisition/{id}", 'tlog_entete_requisitionController@fetch_single_data');    
    Route::post("insert_entete_log_requisition", 'tlog_entete_requisitionController@insert_data');
    Route::post("update_entete_log_requisition/{id}", 'tlog_entete_requisitionController@update_data');
    Route::get("delete_entete_log_requisition/{id}", 'tlog_entete_requisitionController@delete_data');
  

    Route::get("fetch_entete_log_sortie", 'tlog_entete_sortieController@all');
    Route::get("fetch_entete_log_sortie_service/{refEntete}", 'tlog_entete_sortieController@fetch_data_entete');
    Route::get("fetch_single_entete_log_sortie/{id}", 'tlog_entete_sortieController@fetch_single_data');    
    Route::post("insert_entete_log_sortie", 'tlog_entete_sortieController@insert_data');
    Route::post("update_entete_log_sortie/{id}", 'tlog_entete_sortieController@update_data');
    Route::get("delete_entete_log_sortie/{id}", 'tlog_entete_sortieController@delete_data');


    Route::get("fetch_detail_log_entree", 'tlog_detail_entreeController@all');
    Route::get("fetch_detail_entete_log_entree/{refEntete}", 'tlog_detail_entreeController@fetch_data_entete');
    Route::get("fetch_single_detail_log_entree/{id}", 'tlog_detail_entreeController@fetch_single_data');    
    Route::post("insert_detail_log_entree", 'tlog_detail_entreeController@insert_data');
    Route::post("update_detail_log_entree/{id}", 'tlog_detail_entreeController@update_data');
    Route::get("delete_detail_log_entree/{id}", 'tlog_detail_entreeController@delete_data');

    Route::get("fetch_detail_log_requisition", 'tlog_detail_requisitionController@all');
    Route::get("fetch_detail_entete_log_requisition/{refEntete}", 'tlog_detail_requisitionController@fetch_data_entete');
    Route::get("fetch_single_detail_log_requisition/{id}", 'tlog_detail_requisitionController@fetch_single_data');    
    Route::post("insert_detail_log_requisition", 'tlog_detail_requisitionController@insert_data');
    Route::post("update_detail_log_requisition/{id}", 'tlog_detail_requisitionController@update_data');
    Route::get("delete_detail_log_requisition/{id}", 'tlog_detail_requisitionController@delete_data');

    Route::get("fetch_detail_log_sortie", 'tlog_detail_sortieController@all');
    Route::get("fetch_detail_entete_log_sortie/{refEntete}", 'tlog_detail_sortieController@fetch_data_entete');
    Route::get("fetch_single_detail_log_sortie/{id}", 'tlog_detail_sortieController@fetch_single_data');    
    Route::post("insert_detail_log_sortie", 'tlog_detail_sortieController@insert_data');
    Route::post("update_detail_log_sortie/{id}", 'tlog_detail_sortieController@update_data');
    Route::get("delete_detail_log_sortie/{id}", 'tlog_detail_sortieController@delete_data');


    Route::get("fetch_pdf_rapport_detail_log_sortie_date", 'PdfLogistiqueController@fetch_rapport_detailvente_date'); 
    Route::get("fetch_pdf_rapport_detail_log_sortie_date_service", 'PdfLogistiqueController@fetch_rapport_detailvente_date_service'); 
    Route::get("fetch_pdf_rapport_detail_log_sortie_date_produit", 'PdfLogistiqueController@fetch_rapport_detailvente_date_produit'); 
    Route::get("fetch_pdf_rapport_detail_log_entree_date", 'PdfLogistiqueController@fetch_rapport_detailentree_date'); 
    Route::get("fetch_pdf_rapport_detail_log_cmd_date", 'PdfLogistiqueController@fetch_rapport_detailcmd_date'); 
    Route::get("pdf_fiche_stock_logistique", 'PdfLogistiqueController@pdf_fiche_stock_logistique'); 
    Route::get("pdf_fiche_stock_logistique_cayegorie", 'PdfLogistiqueController@pdf_fiche_stock_logistique_cayegorie'); 
    Route::get("pdf_fiche_stock_logistique_emplacement", 'PdfLogistiqueController@pdf_fiche_stock_logistique_emplacement');  

    //pdf_fiche_stock_logistique_emplacement
       
});

Route::group(['namespace'   =>  "Gaz"], function(){

    Route::get("fetch_gaz_entete_inventaire", 'tgaz_entete_inventaireController@all');
    Route::get("fetch_gaz_entete_inventaire/{refEntete}", 'tgaz_entete_inventaireController@fetch_data_entete');
    Route::get("fetch_single_gaz_entete_inventaire/{id}", 'tgaz_entete_inventaireController@fetch_single_data');    
    Route::post("insert_gaz_entete_inventaire", 'tgaz_entete_inventaireController@insert_data');
    Route::post("update_gaz_entete_inventaire/{id}", 'tgaz_entete_inventaireController@update_data');
    Route::get("delete_gaz_entete_inventaire/{id}", 'tgaz_entete_inventaireController@delete_data');

    Route::get("fetch_gaz_detail_inventaire", 'tgaz_detail_inventaireController@all');
    Route::get("fetch_gaz_details_inventaire/{refEntete}", 'tgaz_detail_inventaireController@fetch_data_entete');
    Route::get("fetch_single_gaz_detail_inventaire/{id}", 'tgaz_detail_inventaireController@fetch_single_data');    
    Route::post("insert_gaz_detail_inventaire", 'tgaz_detail_inventaireController@insert_data');
    Route::post("insert_gaz_globale_inventaire", 'tgaz_detail_inventaireController@insert_dataGlobal');
    Route::post("insert_gaz_globale_inventaire_innitial", 'tgaz_detail_inventaireController@insert_dataGlobalInnitialise');
    Route::get('/fetch_gaz_detail_inventaire/{id}', 'tgaz_detail_inventaireController@fetch_detail_facture');
    Route::post("update_gaz_detail_inventaire/{id}", 'tgaz_detail_inventaireController@update_data');
    Route::get("delete_gaz_detail_inventaire/{id}", 'tgaz_detail_inventaireController@delete_data');


    Route::get("fetch_gaz_entete_utilisations", 'tgaz_entete_utilisationController@all');
    Route::get("fetch_gaz_entete_utilisation/{refEntete}", 'tgaz_entete_utilisationController@fetch_data_entete');
    Route::get("fetch_single_gaz_entete_utilisation/{id}", 'tgaz_entete_utilisationController@fetch_single_data');    
    Route::post("insert_gaz_entete_utilisation", 'tgaz_entete_utilisationController@insert_data');
    Route::post("update_gaz_entete_utilisation/{id}", 'tgaz_entete_utilisationController@update_data');
    Route::get("delete_gaz_entete_utilisation/{id}", 'tgaz_entete_utilisationController@delete_data');

    Route::get("fetch_gaz_detail_utilisation", 'tgaz_detail_utilisationController@all');
    Route::get("fetch_gaz_detail_utilisation/{refEntete}", 'tgaz_detail_utilisationController@fetch_data_entete');
    Route::get("fetch_single_gaz_detail_utilisation/{id}", 'tgaz_detail_utilisationController@fetch_single_data');    
    Route::post("insert_gaz_detail_utilisation", 'tgaz_detail_utilisationController@insert_data');
    Route::post("insert_gaz_globale_utilisation", 'tgaz_detail_utilisationController@insert_dataGlobal');
    Route::get('fetch_gaz_detail_utilisation/{id}', 'tgaz_detail_utilisationController@fetch_detail_facture');
    Route::post("update_gaz_detail_utilisation/{id}", 'tgaz_detail_utilisationController@update_data');
    Route::get("delete_gaz_detail_utilisation/{id}", 'tgaz_detail_utilisationController@delete_data');


    Route::get("fetch_gaz_paiement", 'tgaz_detail_paiement_venteController@all');
    Route::get("fetch_gaz_paiement_byentete/{refEntete}", 'tgaz_detail_paiement_venteController@fetch_data_entete');
    Route::get("fetch_gaz_paiement_byentetepaie/{refEntete}", 'tgaz_detail_paiement_venteController@fetch_data_entete_paie');
    Route::get("fetch_single_gaz_paiement/{id}", 'tgaz_detail_paiement_venteController@fetch_single_data');    
    Route::post("insert_gaz_paiement", 'tgaz_detail_paiement_venteController@insert_data');
    Route::post("insert_gaz_paiement2", 'tgaz_detail_paiement_venteController@insert_data2');
    Route::post("update_gaz_paiement/{id}", 'tgaz_detail_paiement_venteController@update_data');
    Route::get("delete_gaz_paiement/{id}", 'tgaz_detail_paiement_venteController@delete_data');

    Route::get("fetch_gaz_entete_paiement", 'tgaz_entete_paiement_venteController@all');
    Route::get("fetch_gaz_entete_paiement_entete/{refEntete}", 'tgaz_entete_paiement_venteController@fetch_data_entete');
    Route::get("fetch_single_gaz_entete_paiement/{id}", 'tgaz_entete_paiement_venteController@fetch_single_data');    
    Route::post("insert_gaz_entete_paiement", 'tgaz_entete_paiement_venteController@insert_data');
    Route::post("update_gaz_entete_paiement/{id}", 'tgaz_entete_paiement_venteController@update_data');
    Route::get("delete_gaz_entete_paiement/{id}", 'tgaz_entete_paiement_venteController@delete_data');


    Route::get("fetch_gaz_entete_transferts", 'tgaz_entete_transfertController@all');
    Route::get("fetch_gaz_entete_transfert/{refEntete}", 'tgaz_entete_transfertController@fetch_data_entete');
    Route::get("fetch_single_gaz_entete_transfert/{id}", 'tgaz_entete_transfertController@fetch_single_data');    
    Route::post("insert_gaz_entete_transfert", 'tgaz_entete_transfertController@insert_data');
    Route::post("update_gaz_entete_transfert/{id}", 'tgaz_entete_transfertController@update_data');
    Route::get("delete_gaz_entete_transfert/{id}", 'tgaz_entete_transfertController@delete_data');

    Route::get("fetch_gaz_detail_transfert", 'tgaz_detail_transfertController@all');
    Route::get("fetch_gaz_detail_transfert/{refEntete}", 'tgaz_detail_transfertController@fetch_data_entete');
    Route::get("fetch_single_gaz_detail_transfert/{id}", 'tgaz_detail_transfertController@fetch_single_data');    
    Route::post("insert_gaz_detail_transfert", 'tgaz_detail_transfertController@insert_data');
    Route::post("insert_gaz_global_transfert", 'tgaz_detail_transfertController@insert_dataGlobal');
    Route::post("insert_gaz_data_transfert", 'tgaz_detail_transfertController@insert_dataTransfert');
    Route::post("update_gaz_detail_transfert/{id}", 'tgaz_detail_transfertController@update_data');
    Route::get("delete_gaz_detail_transfert/{id}", 'tgaz_detail_transfertController@delete_data');


    Route::get("fetch_gaz_entete_production", 'tgaz_entete_productionController@all');
    Route::get("fetch_gaz_entete_production/{refEntete}", 'tgaz_entete_productionController@fetch_data_entete');
    Route::get("fetch_single_gaz_entete_production/{id}", 'tgaz_entete_productionController@fetch_single_data');    
    Route::post("insert_gaz_entete_production", 'tgaz_entete_productionController@insert_data');
    Route::post("update_gaz_entete_production/{id}", 'tgaz_entete_productionController@update_data');
    Route::get("delete_gaz_entete_production/{id}", 'tgaz_entete_productionController@delete_data');

    Route::get("fetch_gaz_detail_production", 'tgaz_detail_productionController@all');
    Route::get("fetch_gaz_detail_production/{refEntete}", 'tgaz_detail_productionController@fetch_data_entete');
    Route::get("fetch_single_gaz_detail_production/{id}", 'tgaz_detail_productionController@fetch_single_data');    
    Route::post("insert_gaz_detail_production", 'tgaz_detail_productionController@insert_data');
    Route::post("insert_gaz_globale_production", 'tgaz_detail_productionController@insert_dataGlobal');
    Route::get('/fetch_detail_production/{id}', 'tgaz_detail_productionController@fetch_detail_facture');
    Route::post("update_gaz_detail_production/{id}", 'tgaz_detail_productionController@update_data');
    Route::get("delete_gaz_detail_production/{id}", 'tgaz_detail_productionController@delete_data');


    Route::get("fetch_gaz_entete_vente", 'tgaz_entete_venteController@all');
    Route::get("fetch_gaz_entete_vente_encours", 'tgaz_entete_venteController@fetch_data_encours');
    Route::get("fetch_data_gaz_entete_vente_search", 'tgaz_entete_venteController@fetch_data_entete_vente_search');
    Route::get("fetch_gaz_entete_vente/{refEntete}", 'tgaz_entete_venteController@fetch_data_entete');
    Route::get("fetch_single_gaz_entete_vente/{id}", 'tgaz_entete_venteController@fetch_single_data');    
    Route::post("insert_gaz_entete_vente", 'tgaz_entete_venteController@insert_data');
    Route::post("update_gaz_entete_vente/{id}", 'tgaz_entete_venteController@update_data');
    Route::post("update_gaz_vente_nombre_print/{id}", 'tgaz_entete_venteController@update_nombre_print');
    Route::get("delete_gaz_entete_vente/{id}", 'tgaz_entete_venteController@delete_data')
    
    ;
    Route::get("fetch_gaz_detail_vente", 'tgaz_detail_venteController@all');
    Route::get("fetch_gaz_detail_vente/{refEntete}", 'tgaz_detail_venteController@fetch_data_entete');
    Route::get("fetch_single_gaz_detail_vente/{id}", 'tgaz_detail_venteController@fetch_single_data');    
    Route::post("insert_gaz_detail_vente", 'tgaz_detail_venteController@insert_data');
    Route::post("insert_gaz_globale_vente", 'tgaz_detail_venteController@insert_dataGlobal');
    Route::post("insert_gaz_cash_vente/{id}", 'tgaz_detail_venteController@insert_paiement_cash');
    Route::post("insert_gaz_globale_vente_cash", 'tgaz_detail_venteController@insert_dataGlobalCash');
    Route::get('/fetch_gaz_detail_facture/{id}', 'tgaz_detail_venteController@fetch_detail_facture');
    Route::get('/fetch_gaz_detail_facture_chambre/{id}', 'tgaz_detail_venteController@fetch_detail_facture_chambre');
    Route::post("update_gaz_detail_vente/{id}", 'tgaz_detail_venteController@update_data');
    Route::get("delete_gaz_detail_vente/{id}", 'tgaz_detail_venteController@delete_data');

    Route::get("fetch_gaz_lot", 'tgaz_lotController@index');
    Route::get("fetch_single_gaz_lot/{id}", 'tgaz_lotController@edit');
    Route::get("delete_gaz_lot/{id}", 'tgaz_lotController@destroy');
    Route::post("insert_gaz_lot", 'tgaz_lotController@store');
    Route::get("fetch_gaz_lot_2", 'tgaz_lotController@fetch_tgaz_lot_2');

    Route::get("fetch_gaz_categorie_lot", 'tgaz_categorie_lotController@index');
    Route::get("fetch_single_gaz_categorie_lot/{id}", 'tgaz_categorie_lotController@edit');
    Route::get("delete_gaz_categorie_lot/{id}", 'tgaz_categorie_lotController@destroy');
    Route::post("insert_gaz_categorie_lot", 'tgaz_categorie_lotController@store');
    Route::get("fetch_gaz_categorie_lot_2", 'tgaz_categorie_lotController@fetch_tgaz_categorie_lot_2');

    Route::get("fetch_gaz_parametre_lots", 'tgaz_parametre_lotController@all');
    Route::get("fetch_gaz_parametre_lot/{refEntete}", 'tgaz_parametre_lotController@fetch_data_entete');
    Route::get("fetch_single_gaz_parametre_lot/{id}", 'tgaz_parametre_lotController@fetch_single_data');
    Route::get("fetch_data_gaz_parametre_byLot/{refLot}", 'tgaz_parametre_lotController@fetch_parametre_lot');    
    Route::get("fetch_data_gaz_parametre_byLotStockService/{idStockService}", 'tgaz_parametre_lotController@fetch_parametre_lot_stock_service');     
    Route::post("insert_gaz_parametre_lot", 'tgaz_parametre_lotController@insert_data');
    Route::post("update_gaz_parametre_lot/{id}", 'tgaz_parametre_lotController@update_data');
    Route::get("delete_gaz_parametre_lot/{id}", 'tgaz_parametre_lotController@delete_data');

    //fetch_stock_data_gaz_byserviceAndCategorie
    Route::get("fetch_gaz_service_stock", 'tgaz_stock_service_lotController@all');
    Route::get("fetch_stock_data_gaz_byserviceAndCategorie", 'tgaz_stock_service_lotController@fetch_stock_data_gaz_byserviceAndCategorie');
    Route::get("fetch_gaz_stock_fiche_byservice/{refService}", 'tgaz_stock_service_lotController@getStockFinal');
    Route::get("fetch_gaz_stock_data_byservice/{refService}", 'tgaz_stock_service_lotController@fetch_stock_data_byservice');
    Route::get("fetch_gaz_data_stock_service_filter", 'tgaz_stock_service_lotController@fetch_data_stock_service_filter');
    Route::get("fetch_gaz_service_stock_byservice/{refEntete}", 'tgaz_stock_service_lotController@fetch_data_entete_service');
    Route::get("fetch_gaz_service_stock_byproduct/{refEntete}", 'tgaz_stock_service_lotController@fetch_data_entete_produit');
    Route::get("fetch_single_gaz_service_stock/{id}", 'tgaz_stock_service_lotController@fetch_single_data');    
    Route::post("insert_gaz_service_stock", 'tgaz_stock_service_lotController@insert_data');
    Route::post("update_gaz_service_stock/{id}", 'tgaz_stock_service_lotController@update_data');
    Route::get("delete_gaz_service_stock/{id}", 'tgaz_stock_service_lotController@delete_data');

    Route::get("fetch_gaz_mouvement_stocks", 'tgaz_mouvement_stock_service_lotController@all');
    Route::get("fetch_gaz_mouvement_stock/{refEntete}", 'tgaz_mouvement_stock_service_lotController@fetch_data_entete');
    Route::get("fetch_single_gaz_mouvement_stock/{id}", 'tgaz_mouvement_stock_service_lotController@fetch_single_data');    
    Route::post("insert_gaz_mouvement_stock", 'tgaz_mouvement_stock_service_lotController@insert_data');
    Route::post("update_gaz_mouvement_stock/{id}", 'tgaz_mouvement_stock_service_lotController@update_data');
    Route::get("delete_gaz_mouvement_stock/{id}", 'tgaz_mouvement_stock_service_lotController@delete_data');


    Route::get("fetch_pdf_gaz_rapport_detailtransfert_date_service_destination", 'PdfGazController@fetch_rapport_detailtransfert_date_service_destination'); 
    Route::get("fetch_pdf_gaz_rapport_detailtransfert_date_service_source", 'PdfGazController@fetch_rapport_detailtransfert_date_service_source'); 
    Route::get("pdf_gaz_fiche_mouvement_produit", 'PdfGazController@pdf_fiche_mouvement_produit'); 
    Route::get("fetch_pdf_gaz_rapport_paiementfacture_date_banque", 'PdfGazController@fetch_rapport_paiementfacture_date_banque'); 
    Route::get("fetch_pdf_gaz_rapport_paiementfacture_date", 'PdfGazController@fetch_rapport_paiementfacture_date'); 
    Route::get("fetch_pdf_gaz_rapport_gaz_detailvente_dette_date", 'PdfGazController@fetch_rapport_gaz_detailvente_dette_date'); 
    Route::get("fetch_pdf_gaz_rapport_detailvente_dette_date_service", 'PdfGazController@fetch_rapport_detailvente_dette_date_service'); 
    Route::get("pdf_gaz_fiche_stock_vente_service", 'PdfGazController@pdf_fiche_stock_vente_service'); 
    Route::get("fetch_pdf_gaz_rapport_detail_production_date_service_byproduit", 'PdfGazController@fetch_rapport_detail_production_date_service_byproduit'); 
    Route::get("fetch_pdf_gaz_rapport_detail_production_date_produit", 'PdfGazController@fetch_rapport_detail_production_date_produit'); 
    Route::get("fetch_pdf_gaz_rapport_detail_production_date", 'PdfGazController@fetch_rapport_detail_production_date'); 
    Route::get("fetch_pdf_gaz_rapport_detailvente_date_service_byproduit", 'PdfGazController@fetch_rapport_detailvente_date_service_byproduit'); 
    Route::get("fetch_pdf_gaz_rapport_detailvente_date_produit", 'PdfGazController@fetch_rapport_detailvente_date_produit'); 
    Route::get("fetch_pdf_gaz_rapport_detailvente_date_etat_facture_service", 'PdfGazController@fetch_rapport_detailvente_date_etat_facture_service'); 
    Route::get("fetch_pdf_gaz_rapport_detailvente_date_service", 'PdfGazController@fetch_rapport_detailvente_date_service'); 
    Route::get("fetch_pdf_gaz_rapport_gaz_detailvente_date", 'PdfGazController@fetch_rapport_gaz_detailvente_date'); 
    Route::get("pdf_gaz_fiche_stock_vente_service_bycategorie_excel", 'PdfGazController@pdf_fiche_gaz_stock_vente_service_bycategorie_excel'); 
    Route::get("pdf_pdf_detail_vente_service_excel", 'PdfGazController@pdf_detail_vente_service_excel'); 
    Route::get("pdf_gaz_fiche_stock_vente_service_excel", 'PdfGazController@pdf_fiche_stock_vente_service_excel'); 



});


Route::group(['namespace'   =>  "Ventes"], function(){


    Route::get("fetch_vente_categorie_client", 'tvente_categorie_clientController@index');
    Route::get("fetch_single_vente_categorie_client/{id}", 'tvente_categorie_clientController@edit');
    Route::get("delete_vente_categorie_client/{id}", 'tvente_categorie_clientController@destroy');
    Route::post("insert_vente_categorie_client", 'tvente_categorie_clientController@store');
    Route::get("fetch_tvente_categorie_client_2", 'tvente_categorie_clientController@fetch_tvente_categorie_client_2');

    Route::get("fetch_vente_client", 'tvente_clientController@index');
    Route::get("fetch_tvente_client_2", 'tvente_clientController@fetch_tvente_client_2');
    Route::get("fetch_single_vente_client/{id}", 'tvente_clientController@edit');   
    Route::post("insert_vente_client", 'tvente_clientController@insertData');
    Route::post("update_vente_client", 'tvente_clientController@updateData');
    Route::get("delete_vente_client/{id}", 'tvente_clientController@destroy'); 

    Route::get("fetch_annexe_commande", 'tvente_annexe_commandeConrtoller@all');
    Route::get("fetch_annexe_bycommande/{refCommande}", 'tvente_annexe_commandeConrtoller@fetch_annexe_commande');
    Route::get("fetch_single_annexe_commande/{id}", 'tvente_annexe_commandeConrtoller@fetch_single');    
    Route::post("insert_annexe_commande", 'tvente_annexe_commandeConrtoller@insert_data');
    Route::post("update_annexe_commande/{id}", 'tvente_annexe_commandeConrtoller@update_data');
    Route::get("delete_annexe_commande/{id}", 'tvente_annexe_commandeConrtoller@delete_data');

    Route::get("fetch_categorie_produit", 'tvente_categorie_produitController@index');
    Route::get("fetch_single_categorie_produit/{id}", 'tvente_categorie_produitController@edit');
    Route::get("delete_categorie_produit/{id}", 'tvente_categorie_produitController@destroy');
    Route::post("insert_categorie_produit", 'tvente_categorie_produitController@store');
    Route::get("fetch_categorie_produit_2", 'tvente_categorie_produitController@fetch_tvente_categorie_produit_2');
    Route::get("fetch_categorie_produit_22", 'tvente_categorie_produitController@fetch_tvente_categorie_produit_22');

    Route::get("fetch_fournisseur", 'tvente_fournisseurController@index');
    Route::get("fetch_single_fournisseur/{id}", 'tvente_fournisseurController@edit');
    Route::get("delete_fournisseur/{id}", 'tvente_fournisseurController@destroy');
    Route::post("insert_fournisseur", 'tvente_fournisseurController@store');
    Route::get("fetch_list_fournisseur", 'tvente_fournisseurController@fetch_list_fournisseur');

    Route::get("fetch_produit", 'tvente_produitController@index');
    Route::get("fetch_single_produit/{id}", 'tvente_produitController@edit');
    Route::get("delete_produit/{id}", 'tvente_produitController@destroy');
    Route::post("insert_produit", 'tvente_produitController@store');
    Route::get("fetch_produit_2", 'tvente_produitController@fetch_tvente_produit_2');

    Route::get("fetch_vente_taux", 'tvente_tauxController@index');
    Route::get("fetch_single_vente_taux/{id}", 'tvente_tauxController@edit');
    Route::get("delete_vente_taux/{id}", 'tvente_tauxController@destroy');
    Route::post("insert_vente_taux", 'tvente_tauxController@store');
    Route::get("fetch_tvente_taux_2", 'tvente_tauxController@fetch_tvente_taux_2');

    Route::get("fetch_vente_entete_entree", 'tvente_entete_entreeController@all');
    Route::get("fetch_vente_entete_entree/{refEntete}", 'tvente_entete_entreeController@fetch_data_entete');
    Route::get("fetch_single_vente_entete_entree/{id}", 'tvente_entete_entreeController@fetch_single_data');    
    Route::post("insert_vente_entete_entree", 'tvente_entete_entreeController@insert_data');
    Route::post("update_vente_entete_entree/{id}", 'tvente_entete_entreeController@update_data');
    Route::get("delete_vente_entete_entree/{id}", 'tvente_entete_entreeController@delete_data');

    //all_filter  all_fournisseur_filter 
    Route::get("fetch_vente_entete_requisition", 'tvente_entete_requisitionController@all');
    Route::get("fetch_vente_entete_requisition_filter", 'tvente_entete_requisitionController@all_filter');
    Route::get("fetch_vente_entete_requisition_filter_fss", 'tvente_entete_requisitionController@all_fournisseur_filter');
    Route::get("fetch_vente_entete_requisition_encours", 'tvente_entete_requisitionController@fetch_data_encours');
    Route::get("fetch_liste_commande_search", 'tvente_entete_requisitionController@fetch_liste_commande');
    Route::get("fetch_vente_entete_requisition/{refEntete}", 'tvente_entete_requisitionController@fetch_data_entete');
    Route::get("fetch_commande_data_by_fournisseur/{refFournisseur}", 'tvente_entete_requisitionController@fetch_commande_data_by_fournisseur');
    Route::get("fetch_single_vente_entete_requisition/{id}", 'tvente_entete_requisitionController@fetch_single_data');    
    Route::post("insert_vente_entete_requisition", 'tvente_entete_requisitionController@insert_data');
    Route::post("update_vente_entete_requisition/{id}", 'tvente_entete_requisitionController@update_data');
    Route::get("delete_vente_entete_requisition/{id}", 'tvente_entete_requisitionController@delete_data');

    //all_dette
    Route::get("fetch_vente_entete_vente", 'tvente_entete_venteController@all');
    Route::get("fetch_vente_entete_vente_dette", 'tvente_entete_venteController@all_dette');
    Route::get("fetch_vente_entete_vente_encours", 'tvente_entete_venteController@fetch_data_encours');
    Route::get("fetch_data_entete_vente_search", 'tvente_entete_venteController@fetch_data_entete_vente_search');
    Route::get("fetch_vente_entete_vente/{refEntete}", 'tvente_entete_venteController@fetch_data_entete');
    Route::get("fetch_single_vente_entete_vente/{id}", 'tvente_entete_venteController@fetch_single_data');    
    Route::post("insert_vente_entete_vente", 'tvente_entete_venteController@insert_data');
    Route::post("update_vente_entete_vente/{id}", 'tvente_entete_venteController@update_data');
    Route::post("update_nombre_print/{id}", 'tvente_entete_venteController@update_nombre_print');
    Route::get("delete_vente_entete_vente/{id}", 'tvente_entete_venteController@delete_data');


    Route::get("fetch_vente_entete_inventaire", 'tvente_entete_inventaireController@all');
    Route::get("fetch_vente_entete_inventaire/{refEntete}", 'tvente_entete_inventaireController@fetch_data_entete');
    Route::get("fetch_single_vente_entete_inventaire/{id}", 'tvente_entete_inventaireController@fetch_single_data');    
    Route::post("insert_vente_entete_inventaire", 'tvente_entete_inventaireController@insert_data');
    Route::post("update_vente_entete_inventaire/{id}", 'tvente_entete_inventaireController@update_data');
    Route::get("delete_vente_entete_inventaire/{id}", 'tvente_entete_inventaireController@delete_data');

    Route::get("fetch_vente_detail_inventaire", 'tvente_detail_inventaireController@all');
    Route::get("fetch_vente_detail_inventaire/{refEntete}", 'tvente_detail_inventaireController@fetch_data_entete');
    Route::get("fetch_single_vente_detail_inventaire/{id}", 'tvente_detail_inventaireController@fetch_single_data');    
    Route::post("insert_vente_detail_inventaire", 'tvente_detail_inventaireController@insert_data');
    Route::post("insert_vente_globale_inventaire", 'tvente_detail_inventaireController@insert_dataGlobal');
    Route::post("insert_vente_globale_inventaire_innitial", 'tvente_detail_inventaireController@insert_dataGlobalInnitialise');
    Route::get('/fetch_detail_inventaire/{id}', 'tvente_detail_inventaireController@fetch_detail_facture');
    Route::post("update_vente_detail_inventaire/{id}", 'tvente_detail_inventaireController@update_data');
    Route::get("delete_vente_detail_inventaire/{id}", 'tvente_detail_inventaireController@delete_data');

    //Data insert_dataGlobalQuickCommande
    Route::get("fetch_vente_detail_entree", 'tvente_detail_entreeController@all');
    Route::get("fetch_vente_detail_entree_byentete/{refEntete}", 'tvente_detail_entreeController@fetch_data_entete');
    Route::get("fetch_single_vente_detail_entree/{id}", 'tvente_detail_entreeController@fetch_single_data');
    Route::get("fetch_detail_entree_vente/{id}", 'tvente_detail_entreeController@fetch_detail_entree_vente');    
    Route::post("insert_vente_detail_entree", 'tvente_detail_entreeController@insert_data');
    Route::post("insert_vente_global_entree", 'tvente_detail_entreeController@insert_dataGlobal');
    Route::post("insert_vente_global_entree_quick_commande", 'tvente_detail_entreeController@insert_dataGlobalQuickCommande');
    Route::post("update_vente_detail_entree/{id}", 'tvente_detail_entreeController@update_data');
    Route::get("delete_vente_detail_entree/{id}", 'tvente_detail_entreeController@delete_data');

    //insert_dataValidate
    Route::get("fetch_vente_detail_requisition", 'tvente_detail_requisitionController@all');
    Route::get("fetch_vente_detail_requisition_byentete/{refEntete}", 'tvente_detail_requisitionController@fetch_data_entete');
    Route::get("fetch_single_vente_detail_requisition/{id}", 'tvente_detail_requisitionController@fetch_single_data');
    Route::get("fetch_data_commande/{refEnteteCmd}", 'tvente_detail_requisitionController@fetch_data_commande');      
    Route::post("insert_vente_detail_requisition", 'tvente_detail_requisitionController@insert_data');
    Route::post("insert_vente_global_requisition", 'tvente_detail_requisitionController@insert_dataGlobal');
    Route::post("insert_vente_global_valider_commande", 'tvente_detail_requisitionController@insert_dataValidate');
    Route::post("update_vente_detail_requisition/{id}", 'tvente_detail_requisitionController@update_data');
    Route::get("delete_vente_detail_requisition/{id}", 'tvente_detail_requisitionController@delete_data');
    Route::get("fetch_detail_requisition_vente/{id}", 'tvente_detail_requisitionController@fetch_detail_requisition_vente');

    //insert_dataGlobalGros
//insert_dataGlobalGrosCash

    Route::get("fetch_vente_detail_vente", 'tvente_detail_venteController@all');
    Route::get("fetch_vente_detail_parmois", 'tvente_detail_venteController@ventesParMois');
    Route::get("fetch_vente_detail_vente/{refEntete}", 'tvente_detail_venteController@fetch_data_entete');
    Route::get("fetch_single_vente_detail_vente/{id}", 'tvente_detail_venteController@fetch_single_data');    
    Route::post("insert_vente_detail_vente", 'tvente_detail_venteController@insert_data');
    Route::post("insert_vente_globale_vente", 'tvente_detail_venteController@insert_dataGlobal');
    Route::post("insert_vente_globale_gros_vente", 'tvente_detail_venteController@insert_dataGlobalGros');
    Route::post("insert_vente_globale_gros_vente_cash", 'tvente_detail_venteController@insert_dataGlobalGrosCash');
    Route::post("insert_vente_cash_vente/{id}", 'tvente_detail_venteController@insert_paiement_cash');
    Route::post("insert_vente_globale_vente_cash", 'tvente_detail_venteController@insert_dataGlobalCash');
    Route::get('/fetch_detail_facture/{id}', 'tvente_detail_venteController@fetch_detail_facture');
    Route::get('/fetch_detail_facture_chambre/{id}', 'tvente_detail_venteController@fetch_detail_facture_chambre');
    Route::post("update_vente_detail_vente/{id}", 'tvente_detail_venteController@update_data');
    Route::post("update_affecter_reservation/{id}", 'tvente_detail_venteController@affecter_reservation');
    Route::get("delete_vente_detail_vente/{id}", 'tvente_detail_venteController@delete_data');

    Route::get("fetch_vente_paiement", 'tvente_paiementController@all');
    Route::get("fetch_vente_paiement_byentete/{refEntete}", 'tvente_paiementController@fetch_data_entete');
    Route::get("fetch_vente_paiement_byentetepaie/{refEntete}", 'tvente_paiementController@fetch_data_entete_paie');
    Route::get("fetch_single_vente_paiement/{id}", 'tvente_paiementController@fetch_single_data');    
    Route::post("insert_vente_paiement", 'tvente_paiementController@insert_data');
    Route::post("insert_vente_paiement2", 'tvente_paiementController@insert_data2');
    Route::post("update_vente_paiement/{id}", 'tvente_paiementController@update_data');
    Route::get("delete_vente_paiement/{id}", 'tvente_paiementController@delete_data');


    Route::get("fetch_vente_entete_utilisation", 'tvente_entete_utilisationController@all');
    Route::get("fetch_vente_entete_utilisation/{refEntete}", 'tvente_entete_utilisationController@fetch_data_entete');
    Route::get("fetch_single_vente_entete_utilisation/{id}", 'tvente_entete_utilisationController@fetch_single_data');    
    Route::post("insert_vente_entete_utilisation", 'tvente_entete_utilisationController@insert_data');
    Route::post("update_vente_entete_utilisation/{id}", 'tvente_entete_utilisationController@update_data');
    Route::get("delete_vente_entete_utilisation/{id}", 'tvente_entete_utilisationController@delete_data');

    Route::get("fetch_vente_detail_utilisation", 'tvente_detail_utilisationController@all');
    Route::get("fetch_vente_detail_utilisation/{refEntete}", 'tvente_detail_utilisationController@fetch_data_entete');
    Route::get("fetch_single_vente_detail_utilisation/{id}", 'tvente_detail_utilisationController@fetch_single_data');    
    Route::post("insert_vente_detail_utilisation", 'tvente_detail_utilisationController@insert_data');
    Route::post("insert_vente_globale_utilisation", 'tvente_detail_utilisationController@insert_dataGlobal');
    Route::get('/fetch_detail_utilisation/{id}', 'tvente_detail_utilisationController@fetch_detail_facture');
    Route::post("update_vente_detail_utilisation/{id}", 'tvente_detail_utilisationController@update_data');
    Route::get("delete_vente_detail_utilisation/{id}", 'tvente_detail_utilisationController@delete_data');

    Route::get("fetch_vente_mouvement_stocks", 'tvente_mouvement_stockController@all');
    Route::get("fetch_vente_mouvement_stock/{refEntete}", 'tvente_mouvement_stockController@fetch_data_entete');
    Route::get("fetch_single_vente_mouvement_stock/{id}", 'tvente_mouvement_stockController@fetch_single_data');    
    Route::post("insert_vente_mouvement_stock", 'tvente_mouvement_stockController@insert_data');
    Route::post("update_vente_mouvement_stock/{id}", 'tvente_mouvement_stockController@update_data');
    Route::get("delete_vente_mouvement_stock/{id}", 'tvente_mouvement_stockController@delete_data');


    //
    Route::get("pdf_fiche_stock_vente_service_by_vendable_cmup", 'PdfVenteController@pdf_fiche_stock_vente_service_by_vendable_cmup');
    Route::get("pdf_fiche_stock_vente_service_by_vendable", 'PdfVenteController@pdf_fiche_stock_vente_service_by_vendable');
    Route::get("pdf_fiche_stock_vente_service_by_sans_prix", 'PdfVenteController@pdf_fiche_stock_vente_service_by_sans_prix');

    Route::get("fetch_rapport_solde_facture_date_fournisseur", 'PdfVenteController@fetch_rapport_solde_facture_date_fournisseur');

    Route::get("fetch_rapport_entete_facture_cmd_date", 'PdfVenteController@fetch_rapport_entete_facture_cmd_date');
    Route::get("fetch_rapport_entete_facture_date_fournisseur", 'PdfVenteController@fetch_rapport_entete_facture_date_fournisseur');

    Route::get("pdf_fiche_mouvement_comptes", 'PdfVenteController@pdf_fiche_mouvement_comptes');
    Route::get("pdf_fiche_mouvement_comptes_entree", 'PdfVenteController@pdf_fiche_mouvement_comptes_entree');

    Route::get("pdf_fiche_stock_vente_service_bycategorie_unite_excel", 'PdfVenteController@pdf_fiche_stock_vente_service_bycategorie_unite_excel');
    Route::get("pdf_fiche_stock_vente_service_unite_excel", 'PdfVenteController@pdf_fiche_stock_vente_service_unite_excel');

    //pdf_fiche_stock_vente_service_sans_prix_excel
    Route::get("pdf_fiche_stock_vente_service_bycategorie_excel", 'PdfVenteController@pdf_fiche_stock_vente_service_bycategorie_excel');
    Route::get("pdf_fiche_stock_vente_service_excel", 'PdfVenteController@pdf_fiche_stock_vente_service_excel');
    Route::get("pdf_fiche_stock_vente_service_sans_prix_excel", 'PdfVenteController@pdf_fiche_stock_vente_service_sans_prix_excel');
    Route::get("pdf_fiche_mouvement_produit", 'PdfVenteController@pdf_fiche_mouvement_produit');
    Route::get("pdf_fiche_stock_cout_vente_service", 'PdfVenteController@pdf_fiche_stock_cout_vente_service');
    Route::get("fetch_rapport_detailentree_date_fss_produit", 'PdfVenteController@fetch_rapport_detailentree_date_fss_produit'); 
    Route::get("fetch_rapport_detailcmd_date_fss_produit", 'PdfVenteController@fetch_rapport_detailcmd_date_fss_produit'); 
    Route::get("fetch_rapport_detailvente_date_etat_facture_service", 'PdfVenteController@fetch_rapport_detailvente_date_etat_facture_service'); 
    Route::get("fetch_rapport_paiementfacture_date", 'PdfVenteController@fetch_rapport_paiementfacture_date'); 
    Route::get("fetch_rapport_paiementfacture_date_banque", 'PdfVenteController@fetch_rapport_paiementfacture_date_banque'); 
    Route::get("fetch_rapport_paiementfacture_date_etat_facture", 'PdfVenteController@fetch_rapport_paiementfacture_date_etat_facture'); 
    Route::get("fetch_rapport_detailentree_date_fss", 'PdfVenteController@fetch_rapport_detailentree_date_fss'); 
    Route::get("fetch_rapport_detailcmd_date_fss", 'PdfVenteController@fetch_rapport_detailcmd_date_fss'); 
    Route::get("fetch_pdf_rapport_detail_vente_date_service", 'PdfVenteController@fetch_rapport_detailvente_date_service');
    Route::get("fetch_pdf_rapport_detail_vente_date_service_byproduit", 'PdfVenteController@fetch_rapport_detailvente_date_service_byproduit'); 
    Route::get("pdf_detail_vente_service_excel", 'PdfVenteController@pdf_detail_vente_service_excel'); 
    Route::get("fetch_rapport_detailusage_date_service_byproduit", 'PdfVenteController@fetch_rapport_detailusage_date_service_byproduit'); 
    Route::get("fetch_rapport_detailusage_date_service_bycategorie", 'PdfVenteController@fetch_rapport_detailusage_date_service_bycategorie'); 
 

    Route::get("fetch_rapport_liste_client", 'PdfVenteController@fetch_rapport_liste_client'); 
    Route::get("fetch_rapport_entete_facture_dette_client_date_agent", 'PdfVenteController@fetch_rapport_entete_facture_dette_client_date_agent'); 
    Route::get("fetch_rapport_entete_facture_dette_client_date", 'PdfVenteController@fetch_rapport_entete_facture_dette_client_date'); 
    Route::get("fetch_rapport_entete_facture_client_date_etat_facture_agent", 'PdfVenteController@fetch_rapport_entete_facture_client_date_etat_facture_agent'); 
    Route::get("fetch_rapport_entete_facture_client_date_etat_facture", 'PdfVenteController@fetch_rapport_entete_facture_client_date_etat_facture'); 

    Route::get("fetch_rapport_paiementfacture_commande_date", 'PdfVenteController@fetch_rapport_paiementfacture_commande_date'); 
    Route::get("fetch_rapport_paiementfacture_commande_date_banque", 'PdfVenteController@fetch_rapport_paiementfacture_commande_date_banque'); 
    Route::get("fetch_rapport_paiementfacture_commande_date_fournisseur", 'PdfVenteController@fetch_rapport_paiementfacture_commande_date_fournisseur'); 
   
    Route::get("pdf_fiche_inventaire_service", 'PdfVenteController@pdf_fiche_inventaire_service'); 
    Route::get("pdf_fiche_inventaire_service_bycategorie", 'PdfVenteController@pdf_fiche_inventaire_service_bycategorie'); 
    Route::get("pdf_fiche_inventaire_service_bycategorie_unite", 'PdfVenteController@pdf_fiche_inventaire_service_bycategorie_unite'); 
    Route::get("pdf_inventaire_vente_service_unite", 'PdfVenteController@pdf_fiche_inventaire_service_unite'); 

    Route::get("fetch_pdf_fiche_stock_vente_service_bycategorie_unite", 'PdfVenteController@pdf_fiche_stock_vente_service_bycategorie_unite');
    Route::get("fetch_pdf_fiche_stock_vente_service_unite", 'PdfVenteController@pdf_fiche_stock_vente_service_unite');
    Route::get("fetch_rapport_detailvente_date_etat_facture", 'PdfVenteController@fetch_rapport_detailvente_date_etat_facture');
    Route::get("fetch_rapport_detailusage_date_service_type", 'PdfVenteController@fetch_rapport_detailusage_date_service_type');
    Route::get("fetch_pdf_rapport_detail_vente_date", 'PdfVenteController@fetch_rapport_detailvente_date'); 
    Route::get("fetch_pdf_rapport_detail_vente_date_categorie", 'PdfVenteController@fetch_rapport_detailvente_date_categorie');
    Route::get("fetch_pdf_rapport_detail_vente_date_service", 'PdfVenteController@fetch_rapport_detailvente_date_service');  
    Route::get("fetch_pdf_rapport_detail_vente_date_produit", 'PdfVenteController@fetch_rapport_detailvente_date_produit'); 
    Route::get("fetch_pdf_rapport_detail_vente_entree_date", 'PdfVenteController@fetch_rapport_detailentree_date'); 
    Route::get("fetch_pdf_rapport_detail_vente_cmd_date", 'PdfVenteController@fetch_rapport_detailcmd_date'); 
    Route::get("pdf_fiche_stock_vente", 'PdfVenteController@pdf_fiche_stock_vente');  
    Route::get("fetch_rapport_detail_cuisine_date_service", 'PdfVenteController@fetch_rapport_detail_cuisine_date_service');   
    Route::get("pdf_fiche_stock_vente_categorie", 'PdfVenteController@pdf_fiche_stock_vente_categorie');

    Route::get("pdf_fiche_stock_vente_service_bycategorie", 'PdfVenteController@pdf_fiche_stock_vente_service_bycategorie');
    Route::get("pdf_fiche_stock_vente_service", 'PdfVenteController@pdf_fiche_stock_vente_service');
    Route::get("fetch_rapport_detailvente_date_service_bycategorie", 'PdfVenteController@fetch_rapport_detailvente_date_service_bycategorie');

    Route::get("pdf_fiche_stock_vente_unite", 'PdfVenteController@pdf_fiche_stock_vente_unite'); 
    Route::get("pdf_fiche_stock_vente_categorie_unite", 'PdfVenteController@pdf_fiche_stock_vente_categorie_unite'); 
    

    Route::get("fetch_rapport_detailtransfert_date_service", 'PdfVenteController@fetch_rapport_detailtransfert_date_service');
    Route::get("fetch_rapport_detailusage_date_service", 'PdfVenteController@fetch_rapport_detailusage_date_service');
 
    Route::get("fetch_rapport_detailtransfert_date_service_source", 'PdfVenteController@fetch_rapport_detailtransfert_date_service_source');
    Route::get("fetch_rapport_detailtransfert_date_service_destination", 'PdfVenteController@fetch_rapport_detailtransfert_date_service_destination');

    Route::get("pdf_detail_commande_fournisseur_excel", 'PdfVenteController@pdf_detail_commande_fournisseur_excel');
    Route::get("pdf_entete_commande_fournisseur_excel", 'PdfVenteController@pdf_entete_commande_fournisseur_excel');


    


    Route::get("fetch_vente_entete_cuisine", 'tvente_entete_cuisineController@all');
    Route::get("fetch_data_encours_cuisine", 'tvente_entete_cuisineController@fetch_data_encours');
    Route::get("fetch_vente_entete_cuisine/{refEntete}", 'tvente_entete_cuisineController@fetch_data_entete');
    Route::get("fetch_single_vente_entete_cuisine/{id}", 'tvente_entete_cuisineController@fetch_single_data');    
    Route::post("insert_vente_entete_cuisine", 'tvente_entete_cuisineController@insert_data');
    Route::post("update_vente_entete_cuisine/{id}", 'tvente_entete_cuisineController@update_data');
    Route::get("delete_vente_entete_cuisine/{id}", 'tvente_entete_cuisineController@delete_data');

    Route::get("fetch_vente_detail_cuisine", 'tvente_detail_cuisineController@all');
    Route::get("fetch_vente_detail_cuisine/{refEntete}", 'tvente_detail_cuisineController@fetch_data_entete');
    Route::get("fetch_single_vente_detail_cuisine/{id}", 'tvente_detail_cuisineController@fetch_single_data');  
    Route::get("fetch_detail_facture_cuisine/{id}", 'tvente_detail_cuisineController@fetch_detail_facture');    
    Route::post("insert_vente_detail_cuisine", 'tvente_detail_cuisineController@insert_data');
    Route::post("insert_vente_global_cuisine", 'tvente_detail_cuisineController@insert_dataGlobal');
    Route::get('pdf_detail_sortie_cuisine/{id}', 'tvente_detail_cuisineController@fetch_detail_facture');
    Route::post("update_vente_detail_cuisine/{id}", 'tvente_detail_cuisineController@update_data');
    Route::post("affecter_reservation_cuisine/{id}", 'tvente_detail_cuisineController@affecter_reservation');
    Route::get("delete_vente_detail_cuisine/{id}", 'tvente_detail_cuisineController@delete_data');

    Route::get("fetch_vente_entete_paiement", 'tvente_entete_paieventeController@all');
    Route::get("fetch_vente_entete_paiement_entete/{refEntete}", 'tvente_entete_paieventeController@fetch_data_entete');
    Route::get("fetch_single_vente_entete_paiement/{id}", 'tvente_entete_paieventeController@fetch_single_data');    
    Route::post("insert_vente_entete_paiement", 'tvente_entete_paieventeController@insert_data');
    Route::post("update_vente_entete_paiement/{id}", 'tvente_entete_paieventeController@update_data');
    Route::get("delete_vente_entete_paiement/{id}", 'tvente_entete_paieventeController@delete_data');

    Route::get("fetch_vente_entete_paiecommande", 'tvente_entete_paiecommandeController@all');
    Route::get("fetch_vente_entete_paiecommande/{refEntete}", 'tvente_entete_paiecommandeController@fetch_data_entete');
    Route::get("fetch_single_vente_entete_paiecommande/{id}", 'tvente_entete_paiecommandeController@fetch_single_data');    
    Route::post("insert_vente_entete_paiecommande", 'tvente_entete_paiecommandeController@insert_data');
    Route::post("update_vente_entete_paiecommande/{id}", 'tvente_entete_paiecommandeController@update_data');
    Route::get("delete_vente_entete_paiecommande/{id}", 'tvente_entete_paiecommandeController@delete_data');

    Route::get("fetch_vente_paiecommande", 'tvente_paiement_commandeController@all');
    Route::get("fetch_vente_paiecommandeEntete/{refEntete}", 'tvente_paiement_commandeController@fetch_data_entete');
    Route::get("fetch_vente_paieOnecommandeEntete/{refEntete}", 'tvente_paiement_commandeController@fetch_data_entete_cmd');
    Route::get("fetch_single_vente_paiecommande/{id}", 'tvente_paiement_commandeController@fetch_single_data');    
    Route::post("insert_vente_paiecommande", 'tvente_paiement_commandeController@insert_data');
    Route::post("insert_vente_paieonecommande", 'tvente_paiement_commandeController@insert_data_one');
    Route::post("update_vente_paiecommande/{id}", 'tvente_paiement_commandeController@update_data');
    Route::get("delete_vente_paiecommande/{id}", 'tvente_paiement_commandeController@delete_data');

    //insert_data_one

    Route::get("fetch_vente_autorisation", 'tvente_autorisationController@index');
    Route::get("fetch_single_vente_autorisation/{id}", 'tvente_autorisationController@edit');
    Route::get("delete_vente_autorisation/{id}", 'tvente_autorisationController@destroy');
    Route::post("insert_vente_autorisation", 'tvente_autorisationController@store');
    Route::get("fetch_tvente_autorisation_2", 'tvente_autorisationController@fetch_tvente_autorisation_2');

    Route::get("fetch_vente_user_service", 'tvente_user_serviceController@index');
    Route::get("fetch_service_user_by_user/{refUser}", 'tvente_user_serviceController@fetch_service_user_by_user');
    Route::get("fetch_service_pointvente_user_by_user/{refUser}", 'tvente_user_serviceController@fetch_service_pointvente_user_by_user');
    Route::get("fetch_service_magasin_user_by_user/{refUser}", 'tvente_user_serviceController@fetch_service_magasin_user_by_user');
    Route::get("fetch_service_stockmasison_user_by_user/{refUser}", 'tvente_user_serviceController@fetch_service_stockmasison_user_by_user');
    Route::get("fetch_single_vente_user_service/{id}", 'tvente_user_serviceController@edit');
    Route::get("delete_vente_user_service/{id}", 'tvente_user_serviceController@destroy');
    Route::post("insert_vente_user_service", 'tvente_user_serviceController@store');
    Route::get("fetch_tvente_user_service_2", 'tvente_user_serviceController@fetch_tvente_user_service_2');

    Route::get("fetch_vente_devise", 'tvente_deviseController@index');
    Route::get("fetch_single_vente_devise/{id}", 'tvente_deviseController@edit');
    Route::get("delete_vente_devise/{id}", 'tvente_deviseController@destroy');
    Route::post("insert_vente_devise", 'tvente_deviseController@store');
    Route::get("fetch_tvente_devise_2", 'tvente_deviseController@fetch_tvente_devise_2');

    Route::get("fetch_grande_categorie_produit", 'tvente_grande_categorie_produitController@index');
    Route::get("fetch_single_grande_categorie_produit/{id}", 'tvente_grande_categorie_produitController@edit');
    Route::get("delete_grande_categorie_produit/{id}", 'tvente_grande_categorie_produitController@destroy');
    Route::post("insert_grande_categorie_produit", 'tvente_grande_categorie_produitController@store');
    Route::get("fetch_tvente_grande_categorie_produit_2", 'tvente_grande_categorie_produitController@fetch_tvente_grande_categorie_produit_2');

    Route::get("fetch_vente_service_stock", 'tvente_stock_serviceController@all');
    Route::get("fetch_stock_fiche_byservice/{refService}", 'tvente_stock_serviceController@getStockFinal');
    Route::get("fetch_stock_data_byservice/{refService}", 'tvente_stock_serviceController@fetch_stock_data_byservice');
    Route::get("fetch_stock_data_byserviceAndCategorie", 'tvente_stock_serviceController@fetch_stock_data_byserviceAndCategorie');
    Route::get("fetch_data_stock_service_filter", 'tvente_stock_serviceController@fetch_data_stock_service_filter');
    Route::get("fetch_vente_service_stock_byservice/{refEntete}", 'tvente_stock_serviceController@fetch_data_entete_service');
    Route::get("fetch_vente_service_stock_byproduct/{refEntete}", 'tvente_stock_serviceController@fetch_data_entete_produit');
    Route::get("fetch_single_vente_service_stock/{id}", 'tvente_stock_serviceController@fetch_single_data');    
    Route::post("insert_vente_service_stock", 'tvente_stock_serviceController@insert_data');
    Route::post("update_vente_service_stock/{id}", 'tvente_stock_serviceController@update_data');
    Route::get("delete_vente_service_stock/{id}", 'tvente_stock_serviceController@delete_data');
    //getStockFinal($idService) 

    Route::get("fetch_vente_validation", 'tvente_validationsController@all');
    Route::get("fetch_vente_validationEntete/{refEntete}", 'tvente_validationsController@fetch_data_entete');
    Route::get("fetch_single_vente_validation/{id}", 'tvente_validationsController@fetch_single_data');    
    Route::post("insert_vente_validation", 'tvente_validationsController@insert_data');
    Route::post("update_vente_validation/{id}", 'tvente_validationsController@update_data');
    Route::get("delete_vente_validation/{id}", 'tvente_validationsController@delete_data');

    //tvente_validationsController

    Route::get("fetch_vente_categoriefss", 'tvente_categorie_fournisseurController@index');
    Route::get("fetch_single_vente_categoriefss/{id}", 'tvente_categorie_fournisseurController@edit');
    Route::get("delete_vente_categoriefss/{id}", 'tvente_categorie_fournisseurController@destroy');
    Route::post("insert_vente_categoriefss", 'tvente_categorie_fournisseurController@store');
    Route::get("fetch_tvente_categoriefss_2", 'tvente_categorie_fournisseurController@fetch_tvente_categorie_fournisseur_2');

    Route::get("fetch_vente_unite", 'tvente_uniteController@index');
    Route::get("fetch_single_vente_unite/{id}", 'tvente_uniteController@edit');
    Route::get("delete_vente_unite/{id}", 'tvente_uniteController@destroy');
    Route::post("insert_vente_unite", 'tvente_uniteController@store');
    Route::get("fetch_tvente_unite_2", 'tvente_uniteController@fetch_tvente_unite_2');

    Route::get("fetch_vente_tables", 'tvente_tablesController@index');
    Route::get("fetch_single_vente_tables/{id}", 'tvente_tablesController@edit');
    Route::get("delete_vente_tables/{id}", 'tvente_tablesController@destroy');
    Route::post("insert_vente_tables", 'tvente_tablesController@store');
    Route::get("fetch_tvente_tables_2", 'tvente_tablesController@fetch_tvente_tables_2');

    //tvente_tablesController

    Route::get("fetch_vente_tva", 'tvente_tvaController@index');
    Route::get("fetch_single_vente_tva/{id}", 'tvente_tvaController@edit');
    Route::get("delete_vente_tva/{id}", 'tvente_tvaController@destroy');
    Route::post("insert_vente_tva", 'tvente_tvaController@store');
    Route::get("fetch_tvente_tva_2", 'tvente_tvaController@fetch_tvente_tva_2');

    Route::get("fetch_vente_module", 'tvente_moduleController@index');
    Route::get("fetch_single_vente_module/{id}", 'tvente_moduleController@edit');
    Route::get("delete_vente_module/{id}", 'tvente_moduleController@destroy');
    Route::post("insert_vente_module", 'tvente_moduleController@store');
    Route::get("fetch_tvente_module_2", 'tvente_moduleController@fetch_tvente_module_2');

    Route::get("fetch_vente_services", 'tvente_servicesController@index');
    Route::get("fetch_single_vente_services/{id}", 'tvente_servicesController@edit');
    Route::get("delete_vente_services/{id}", 'tvente_servicesController@destroy');
    Route::post("insert_vente_services", 'tvente_servicesController@store');
    Route::get("fetch_vente_services_2", 'tvente_servicesController@fetch_tvente_services_2');
    Route::get("fetch_tvente_services_pointvente", 'tvente_servicesController@fetch_tvente_services_pointvente');
    Route::get("fetch_tvente_services_magasin", 'tvente_servicesController@fetch_tvente_services_magasin');
    Route::get("fetch_tvente_services_stockmasison", 'tvente_servicesController@fetch_tvente_services_stockmasison');

    Route::get("fetch_vente_entete_inventaire", 'tvente_entete_inventaireController@all');
    Route::get("fetch_vente_entete_inventaire/{refEntete}", 'tvente_entete_inventaireController@fetch_data_entete');
    Route::get("fetch_single_vente_entete_inventaire/{id}", 'tvente_entete_inventaireController@fetch_single_data');    
    Route::post("insert_vente_entete_inventaire", 'tvente_entete_inventaireController@insert_data');
    Route::post("update_vente_entete_inventaire/{id}", 'tvente_entete_inventaireController@update_data');
    Route::get("delete_vente_entete_inventaire/{id}", 'tvente_entete_inventaireController@delete_data');

    Route::get("fetch_vente_detail_inventaire", 'tvente_detail_inventaireController@all');
    Route::get("fetch_vente_detail_inventaire/{refEntete}", 'tvente_detail_inventaireController@fetch_data_entete');
    Route::get("fetch_single_vente_detail_inventaire/{id}", 'tvente_detail_inventaireController@fetch_single_data');    
    Route::post("insert_vente_detail_inventaire", 'tvente_detail_inventaireController@insert_data');
    Route::post("update_vente_detail_inventaire/{id}", 'tvente_detail_inventaireController@update_data');
    Route::get("delete_vente_detail_inventaire/{id}", 'tvente_detail_inventaireController@delete_data');

    Route::get("fetch_vente_entete_transfert", 'tvente_entete_transfertController@all');
    Route::get("fetch_vente_entete_transfert/{refEntete}", 'tvente_entete_transfertController@fetch_data_entete');
    Route::get("fetch_single_vente_entete_transfert/{id}", 'tvente_entete_transfertController@fetch_single_data');    
    Route::post("insert_vente_entete_transfert", 'tvente_entete_transfertController@insert_data');
    Route::post("update_vente_entete_transfert/{id}", 'tvente_entete_transfertController@update_data');
    Route::get("delete_vente_entete_transfert/{id}", 'tvente_entete_transfertController@delete_data');

    Route::get("fetch_vente_detail_transfert", 'tvente_detail_transfertController@all');
    Route::get("fetch_vente_detail_transfert/{refEntete}", 'tvente_detail_transfertController@fetch_data_entete');
    Route::get("fetch_single_vente_detail_transfert/{id}", 'tvente_detail_transfertController@fetch_single_data');    
    Route::post("insert_vente_detail_transfert", 'tvente_detail_transfertController@insert_data');
    Route::post("insert_vente_global_transfert", 'tvente_detail_transfertController@insert_dataGlobal');
    Route::post("insert_vente_global_transfert_usage", 'tvente_detail_transfertController@insert_dataGlobalUsage');
    Route::post("insert_vente_data_transfert", 'tvente_detail_transfertController@insert_dataTransfert');
    Route::post("update_vente_detail_transfert/{id}", 'tvente_detail_transfertController@update_data');
    Route::get("delete_vente_detail_transfert/{id}", 'tvente_detail_transfertController@delete_data');

    //insert_dataGlobalUsage

    Route::get("fetch_vente_detail_unite", 'tvente_detail_uniteController@all');
    Route::get("fetch_data_detail_unite_vente", 'tvente_detail_uniteController@fetch_data_detail_unite_vente');
    Route::get("fetch_detailunite_stockdispo_service", 'tvente_detail_uniteController@fetch_detailunite_stockdispo_service');
    Route::get("fetch_vente_detail_uniteByProd/{refEntete}", 'tvente_detail_uniteController@fetch_data_entete');
    Route::get("fetch_detailunite_prod/{refProduit}", 'tvente_detail_uniteController@fetch_detailunite_prod');
    Route::get("fetch_detailunite_prod2/{refProduit}", 'tvente_detail_uniteController@fetch_detailunite_prod2');
    Route::get("fetch_detailunite_prod_stock_service/{refProduit}", 'tvente_detail_uniteController@fetch_detailunite_prod_stock_service');
    Route::get("fetch_single_vente_detail_unite/{id}", 'tvente_detail_uniteController@fetch_single_data');    
    Route::post("insert_vente_detail_unite", 'tvente_detail_uniteController@insert_data');
    Route::post("update_vente_detail_unite/{id}", 'tvente_detail_uniteController@update_data');
    Route::get("delete_vente_detail_unite/{id}", 'tvente_detail_uniteController@delete_data');
    //fetch_detailunite_stockdispo_service

    Route::get("fetch_vente_param_systeme", 'tvente_param_systemeController@all');
    Route::get("fetch_vente_param_systeme/{refEntete}", 'tvente_param_systemeController@fetch_data_entete');
    Route::get("fetch_single_vente_param_systeme/{id}", 'tvente_param_systemeController@fetch_single_data');    
    Route::post("insert_vente_param_systeme", 'tvente_param_systemeController@insert_data');
    Route::post("update_vente_param_systeme/{id}", 'tvente_param_systemeController@update_data');
    Route::get("delete_vente_param_systeme/{id}", 'tvente_param_systemeController@delete_data');




    //=============== FACTURE GROUPEE ===============================================================================

    Route::get("fetch_vente_entete_facture_group", 'tvente_entete_facture_groupeController@all');
    Route::get("fetch_vente_entete_facture_group_encours", 'tvente_entete_facture_groupeController@fetch_data_encours');
    Route::get("fetch_data_entete_facture_group_search", 'tvente_entete_facture_groupeController@fetch_data_entete_vente_search');
    Route::get("fetch_vente_entete_facture_group/{refEntete}", 'tvente_entete_facture_groupeController@fetch_data_entete');
    Route::get("fetch_single_vente_entete_facture_group/{id}", 'tvente_entete_facture_groupeController@fetch_single_data');    
    Route::post("insert_vente_entete_facture_group", 'tvente_entete_facture_groupeController@insert_data');
    Route::post("update_vente_entete_facture_group/{id}", 'tvente_entete_facture_groupeController@update_data');
    Route::post("update_nombre_print_facture_group/{id}", 'tvente_entete_facture_groupeController@update_nombre_print');
    Route::get("delete_vente_entete_facture_group/{id}", 'tvente_entete_facture_groupeController@delete_data');

    Route::get("fetch_vente_detail_facture_groupes", 'tvente_detail_facture_groupeController@all');
    Route::get("fetch_vente_detail_facture_groupe/{refEntete}", 'tvente_detail_facture_groupeController@fetch_data_entete');
    Route::get("fetch_single_vente_detail_facture_groupe/{id}", 'tvente_detail_facture_groupeController@fetch_single_data');    
    Route::post("insert_vente_detail_facture_groupe", 'tvente_detail_facture_groupeController@insert_data');
    Route::post("update_vente_detail_facture_groupe/{id}", 'tvente_detail_facture_groupeController@update_data');
    Route::get("delete_vente_detail_facture_groupe/{id}", 'tvente_detail_facture_groupeController@delete_data');
    Route::post("insert_vente_globale_facture_groupe_vente", 'tvente_detail_facture_groupeController@insert_dataGlobalVente');
    Route::post("insert_vente_cash_facture_groupe_vente/{id}", 'tvente_detail_facture_groupeController@insert_paiement_vente_cash');
    Route::post("insert_vente_globale_facture_groupe_vente_cash", 'tvente_detail_facture_groupeController@insert_dataGlobalVenteCash');
    Route::post("insert_vente_globale_facture_groupe_hotel", 'tvente_detail_facture_groupeController@insert_dataGlobalHotel');
    Route::post("insert_vente_cash_facture_groupe_hotel/{id}", 'tvente_detail_facture_groupeController@insert_paiement_hotel_cash');
    Route::post("insert_vente_globale_facture_groupe_hotel_cash", 'tvente_detail_facture_groupeController@insert_dataGlobalHotelCash');
    Route::get('/fetch_detail_facture_group/{id}', 'tvente_detail_facture_groupeController@fetch_detail_facture');

    Route::get("fetch_entete_paiement_groupe", 'tvente_entete_paiement_groupeController@all');
    Route::get("fetch_entete_paiement_groupe_entete/{refEntete}", 'tvente_entete_paiement_groupeController@fetch_data_entete');
    Route::get("fetch_single_entete_paiement_groupe/{id}", 'tvente_entete_paiement_groupeController@fetch_single_data');    
    Route::post("insert_entete_paiement_groupe", 'tvente_entete_paiement_groupeController@insert_data');
    Route::post("update_entete_paiement_groupe/{id}", 'tvente_entete_paiement_groupeController@update_data');
    Route::get("delete_entete_paiement_groupe/{id}", 'tvente_entete_paiement_groupeController@delete_data');

    Route::get("fetch_detail_paiement_groupe", 'tvente_detail_paiement_groupeController@all');
    Route::get("fetch_detail_paiement_groupe_byentete/{refEntete}", 'tvente_detail_paiement_groupeController@fetch_data_entete');
    Route::get("fetch_detail_paiement_groupe_byentetepaie/{refEntete}", 'tvente_detail_paiement_groupeController@fetch_data_entete_paie');
    Route::get("fetch_single_detail_paiement_groupe/{id}", 'tvente_detail_paiement_groupeController@fetch_single_data');    
    Route::post("insert_detail_paiement_groupe", 'tvente_detail_paiement_groupeController@insert_data');
    Route::post("update_detail_paiement_groupe/{id}", 'tvente_detail_paiement_groupeController@update_data');
    Route::get("delete_detail_paiement_groupe/{id}", 'tvente_detail_paiement_groupeController@delete_data');
    
});





Route::group(['namespace'   =>  "Salon"], function(){

    Route::get("fetch_produit_salon", 'tsalon_produitController@index');
    Route::get("fetch_single_produit_salon/{id}", 'tsalon_produitController@edit');
    Route::get("delete_produit_salon/{id}", 'tsalon_produitController@destroy');
    Route::post("insert_produit_salon", 'tsalon_produitController@store');
    Route::get("fetch_produit_2_salon", 'tsalon_produitController@fetch_tsalon_produit_2');

    Route::get("fetch_vente_entete_vente_salon", 'tsalon_entete_venteController@all');
    Route::get("fetch_vente_entete_vente_salon/{refEntete}", 'tsalon_entete_venteController@fetch_data_entete');
    Route::get("fetch_single_vente_entete_vente_salon/{id}", 'tsalon_entete_venteController@fetch_single_data');    
    Route::post("insert_vente_entete_vente_salon", 'tsalon_entete_venteController@insert_data');
    Route::post("update_vente_entete_vente_salon/{id}", 'tsalon_entete_venteController@update_data');
    Route::get("delete_vente_entete_vente_salon/{id}", 'tsalon_entete_venteController@delete_data');

    Route::get("fetch_vente_detail_vente_salon", 'tsalon_detail_venteController@all');
    Route::get("fetch_vente_detail_vente_salon/{refEntete}", 'tsalon_detail_venteController@fetch_data_entete');
    Route::get("fetch_single_vente_detail_vente_salon/{id}", 'tsalon_detail_venteController@fetch_single_data');    
    Route::post("insert_vente_detail_vente_salon", 'tsalon_detail_venteController@insert_data');
    Route::get('/fetch_detail_facture_salon/{id}', 'tsalon_detail_venteController@fetch_detail_facture');
    Route::post("update_vente_detail_vente_salon/{id}", 'tsalon_detail_venteController@update_data');
    Route::get("delete_vente_detail_vente_salon/{id}", 'tsalon_detail_venteController@delete_data');

    Route::get("fetch_vente_paiement_salon", 'tsalon_paiementController@all');
    Route::get("fetch_vente_paiement_salon/{refEntete}", 'tsalon_paiementController@fetch_data_entete');
    Route::get("fetch_single_vente_paiement_salon/{id}", 'tsalon_paiementController@fetch_single_data');    
    Route::post("insert_vente_paiement_salon", 'tsalon_paiementController@insert_data');
    Route::post("update_vente_paiement_salon/{id}", 'tsalon_paiementController@update_data');
    Route::get("delete_vente_paiement_salon/{id}", 'tsalon_paiementController@delete_data');

    Route::get("fetch_pdf_rapport_detail_vente_salon_date", 'PdfVenteSalonController@fetch_rapport_detailvente_date'); 
    Route::get("fetch_pdf_rapport_detail_vente_salon_date_produit", 'PdfVenteSalonController@fetch_rapport_detailvente_date_produit'); 
   
    

    
});





Route::group(['namespace'   =>  "Vehicule"], function(){

    Route::get("fetch_producteur", 'tcar_producteurController@index');
    Route::get("fetch_single_producteur/{id}", 'tcar_producteurController@edit');
    Route::get("delete_producteur/{id}", 'tcar_producteurController@destroy');
    Route::post("insert_producteur", 'tcar_producteurController@store');
    Route::get("fetch_tcar_producteur_2", 'tcar_producteurController@fetch_tcar_producteur_2');

    Route::get("fetch_car_produit", 'tcar_produitController@index');
    Route::get("fetch_single_car_produit/{id}", 'tcar_produitController@edit');
    Route::get("delete_car_produit/{id}", 'tcar_produitController@destroy');
    Route::post("insert_car_produit", 'tcar_produitController@store');
    Route::get("fetch_tcar_produit_2", 'tcar_produitController@fetch_tcar_produit_2');

    Route::get("fetch_vehicule", 'tcar_vehiculeController@index');
    Route::get("fetch_single_vehicule/{id}", 'tcar_vehiculeController@edit');
    Route::get("delete_vehicule/{id}", 'tcar_vehiculeController@destroy');
    Route::post("insert_vehicule", 'tcar_vehiculeController@store');
    Route::get("fetch_tcar_vehicule_2", 'tcar_vehiculeController@fetch_tcar_vehicule_2');

    Route::get("fetch_car_entete_mouvement", 'tcar_entete_mouvementController@all');
    Route::get("fetch_car_entete_mouvement_vehicule/{refEntete}", 'tcar_entete_mouvementController@fetch_data_entete');
    Route::get("fetch_single_car_entete_mouvement/{id}", 'tcar_entete_mouvementController@fetch_single_data');    
    Route::post("insert_car_entete_mouvement", 'tcar_entete_mouvementController@insert_data');
    Route::post("update_car_entete_mouvement/{id}", 'tcar_entete_mouvementController@update_data');
    Route::get("delete_car_entete_mouvement/{id}", 'tcar_entete_mouvementController@delete_data');

    //tcar_detail_casseController

    Route::get("fetch_car_detail_casse", 'tcar_detail_casseController@all');
    Route::get("fetch_car_detail_casse_Movement/{refEntete}", 'tcar_detail_casseController@fetch_data_entete');
    Route::get("fetch_single_car_detail_casse/{id}", 'tcar_detail_casseController@fetch_single_data');    
    Route::post("insert_car_detail_casse", 'tcar_detail_casseController@insert_data');
    Route::post("update_car_detail_casse/{id}", 'tcar_detail_casseController@update_data');
    Route::get("delete_car_detail_casse/{id}", 'tcar_detail_casseController@delete_data');

    Route::get("fetch_car_detail_entree", 'tcar_detail_entreeController@all');
    Route::get("fetch_car_detail_entree_Movement/{refEntete}", 'tcar_detail_entreeController@fetch_data_entete');
    Route::get("fetch_single_car_detail_entree/{id}", 'tcar_detail_entreeController@fetch_single_data');    
    Route::post("insert_car_detail_entree", 'tcar_detail_entreeController@insert_data');
    Route::post("update_car_detail_entree/{id}", 'tcar_detail_entreeController@update_data');
    Route::get("delete_car_detail_entree/{id}", 'tcar_detail_entreeController@delete_data');

    Route::get("fetch_car_detail_solde", 'tcar_detail_soldeController@all');
    Route::get("fetch_car_detail_solde_Movement/{refEntete}", 'tcar_detail_soldeController@fetch_data_entete');
    Route::get("fetch_single_car_detail_solde/{id}", 'tcar_detail_soldeController@fetch_single_data');    
    Route::post("insert_car_detail_solde", 'tcar_detail_soldeController@insert_data');
    Route::post("update_car_detail_solde/{id}", 'tcar_detail_soldeController@update_data');
    Route::get("delete_car_detail_solde/{id}", 'tcar_detail_soldeController@delete_data');

    Route::get("fetch_car_emballage", 'tcar_emballageController@all');
    Route::get("fetch_car_emballage_Movement/{refEntete}", 'tcar_emballageController@fetch_data_entete');
    Route::get("fetch_single_car_emballage/{id}", 'tcar_emballageController@fetch_single_data');    
    Route::post("insert_car_emballage", 'tcar_emballageController@insert_data');
    Route::post("update_car_emballage/{id}", 'tcar_emballageController@update_data');
    Route::get("delete_car_emballage/{id}", 'tcar_emballageController@delete_data');
    
    Route::get("fetch_car_paiement", 'tcar_paiementController@all');
    Route::get("fetch_car_paiement_Movement/{refEntete}", 'tcar_paiementController@fetch_data_entete');
    Route::get("fetch_single_car_paiement/{id}", 'tcar_paiementController@fetch_single_data');    
    Route::post("insert_car_paiement", 'tcar_paiementController@insert_data');
    Route::post("update_car_paiement/{id}", 'tcar_paiementController@update_data');
    Route::get("delete_car_paiement/{id}", 'tcar_paiementController@delete_data');

    Route::get("fetch_all_annexe_mouvement", 'tcar_annexeController@all');
    Route::get("fetch_single_annexe_mouvement/{id}",'tcar_annexeController@fetch_single_annexe_mouvement');
    Route::get("downloadfile_mouvement/{filenamess}",'tcar_annexeController@downloadfile');
    Route::get("fetch_annexe_mouvement/{refmouvement}",'tcar_annexeController@fetch_annexe_mouvement');
    Route::post('insert_annexe_mouvement', 'tcar_annexeController@insertData');
    Route::post('update_annexe_mouvement', 'tcar_annexeController@updateData');
    Route::get("delete_annexe_mouvement/{id}", 'tcar_annexeController@delete_annexe');

    Route::get("pdf_fiche_stock_vehicule", 'PdfVehiculeController@pdf_fiche_stock_vehicule'); 
    Route::get("pdf_fiche_stock_vehicule_entete", 'PdfVehiculeController@pdf_fiche_stock_vehicule_entete'); 
    Route::get("fetch_rapport_paiement_mouvement_date_vehicule", 'PdfVehiculeController@fetch_rapport_paiement_mouvement_date_vehicule'); 
    //fetch_rapport_paiement_mouvement_date_vehicule
    
    
});



//pdf_fiche_stock_vente_categorie

Route::group(['namespace'   =>  "Hotel"], function(){


    Route::get("fetch_hotel_salle", 'thotel_salleController@index');
    Route::get("fetch_single_hotel_salle/{id}", 'thotel_salleController@edit');
    Route::get("delete_hotel_salle/{id}", 'thotel_salleController@destroy');
    Route::post("insert_hotel_salle", 'thotel_salleController@store');
    Route::get("fetch_thotel_salle_2", 'thotel_salleController@fetch_thotel_salle_2');

    Route::get("fetch_hotel_chambre", 'thotel_chambreController@index');
    Route::get("fetch_single_hotel_chambre/{id}", 'thotel_chambreController@edit');
    Route::get("delete_hotel_chambre/{id}", 'thotel_chambreController@destroy');
    Route::get("chambre_by_categorie/{refClasse}", 'thotel_chambreController@chambre_by_categorie');
    //chambre_by_categorie 
    Route::post("insert_hotel_chambre", 'thotel_chambreController@store');
    Route::get("fetch_thotel_chambre_2", 'thotel_chambreController@fetch_thotel_chambre_2');
    Route::get("fetch_thotel_chambre_libre", 'thotel_chambreController@fetch_thotel_chambre_libre');

    Route::get("fetch_hotel_classe_chambre", 'thotel_classe_chambreController@index');
    Route::get("fetch_single_hotel_classe_chambre/{id}", 'thotel_classe_chambreController@edit');
    Route::get("delete_hotel_classe_chambre/{id}", 'thotel_classe_chambreController@destroy');
    Route::post("insert_hotel_classe_chambre", 'thotel_classe_chambreController@store');
    Route::get("fetch_thotel_classe_chambre_2", 'thotel_classe_chambreController@fetch_thotel_classe_chambre_2');

    Route::get("fetch_hotel_billard", 'thotel_billardController@all');
    Route::get("fetch_hotel_billard/{refEntete}", 'thotel_billardController@fetch_data_entete');
    Route::get("fetch_single_hotel_billard/{id}", 'thotel_billardController@fetch_single_data');    
    Route::post("insert_hotel_billard", 'thotel_billardController@insert_data');
    Route::post("update_hotel_billard/{id}", 'thotel_billardController@update_data');
    Route::get("delete_hotel_billard/{id}", 'thotel_billardController@delete_data');

    Route::get("fetch_hotel_incident_reservation_salle", 'thotel_incident_reservation_salleController@all');
    Route::get("fetch_hotel_incident_reservation_salle/{refEntete}", 'thotel_incident_reservation_salleController@fetch_data_entete');
    Route::get("fetch_single_hotel_incident_reservation_salle/{id}", 'thotel_incident_reservation_salleController@fetch_single_data');    
    Route::post("insert_hotel_incident_reservation_salle", 'thotel_incident_reservation_salleController@insert_data');
    Route::post("update_hotel_incident_reservation_salle/{id}", 'thotel_incident_reservation_salleController@update_data');
    Route::get("delete_hotel_incident_reservation_salle/{id}", 'thotel_incident_reservation_salleController@delete_data');

    Route::get("fetch_hotel_paiement_chambres", 'thotel_paiement_chambreController@all');
    Route::get("fetch_hotel_paiement_chambre/{refEntete}", 'thotel_paiement_chambreController@fetch_data_entete');
    Route::get("fetch_single_hotel_paiement_chambre/{id}", 'thotel_paiement_chambreController@fetch_single_data');    
    Route::post("insert_hotel_paiement_chambre", 'thotel_paiement_chambreController@insert_data');
    Route::post("update_hotel_paiement_chambre/{id}", 'thotel_paiement_chambreController@update_data');
    Route::get("delete_hotel_paiement_chambre/{id}", 'thotel_paiement_chambreController@delete_data');

    Route::get("fetch_hotel_paiement_salle", 'thotel_paiement_salleController@all');
    Route::get("fetch_hotel_paiement_salle/{refEntete}", 'thotel_paiement_salleController@fetch_data_entete');
    Route::get("fetch_single_hotel_paiement_salle/{id}", 'thotel_paiement_salleController@fetch_single_data');    
    Route::post("insert_hotel_paiement_salle", 'thotel_paiement_salleController@insert_data');
    Route::post("update_hotel_paiement_salle/{id}", 'thotel_paiement_salleController@update_data');
    Route::get("delete_hotel_paiement_salle/{id}", 'thotel_paiement_salleController@delete_data');

    //thotel_reservation_appartementController
    Route::get("fetch_hotel_reservation_chambre", 'thotel_reservation_chambreController@all');
    Route::get("fetch_hotel_reservation_search", 'thotel_reservation_chambreController@fetch_reservation_search');
    Route::get("fetch_hotel_reservation_chambre/{refEntete}", 'thotel_reservation_chambreController@fetch_data_entete');
    Route::get("fetch_single_hotel_reservation_chambre/{id}", 'thotel_reservation_chambreController@fetch_single_data');    
    Route::post("insert_hotel_reservation_chambre", 'thotel_reservation_chambreController@insert_data');
    Route::post("update_hotel_reservation_chambre/{id}", 'thotel_reservation_chambreController@update_data');
    Route::get("delete_hotel_reservation_chambre/{id}", 'thotel_reservation_chambreController@delete_data');


    Route::get("fetch_hotel_reservation_appartement", 'thotel_reservation_appartementController@all');
    Route::get("fetch_hotel_reservation_search_appartement", 'thotel_reservation_appartementController@fetch_reservation_search');
    Route::get("fetch_hotel_reservation_appartement/{refEntete}", 'thotel_reservation_appartementController@fetch_data_entete');
    Route::get("fetch_single_hotel_reservation_appartement/{id}", 'thotel_reservation_appartementController@fetch_single_data');    
    Route::post("insert_hotel_reservation_appartement", 'thotel_reservation_appartementController@insert_data');
    Route::post("update_hotel_reservation_appartement/{id}", 'thotel_reservation_appartementController@update_data');
    Route::get("delete_hotel_reservation_appartement/{id}", 'thotel_reservation_appartementController@delete_data');

    Route::get("fetch_hotel_reservation_salle", 'thotel_reservation_salleController@all');
    Route::get("fetch_hotel_reservation_salle/{refEntete}", 'thotel_reservation_salleController@fetch_data_entete');
    Route::get("fetch_single_hotel_reservation_salle/{id}", 'thotel_reservation_salleController@fetch_single_data');    
    Route::post("insert_hotel_reservation_salle", 'thotel_reservation_salleController@insert_data');
    Route::post("update_hotel_reservation_salle/{id}", 'thotel_reservation_salleController@update_data');
    Route::get("delete_hotel_reservation_salle/{id}", 'thotel_reservation_salleController@delete_data');

    Route::get("fetch_rapport_salle_date", 'PdfReservationController@fetch_rapport_salle_date');
    Route::get("fetch_rapport_hotel_date", 'PdfReservationController@fetch_rapport_hotel_date');
    Route::get("pdf_fiche_hotel", 'PdfReservationController@pdf_fiche_hotel');
    Route::get("pdf_facture_hotel", 'PdfReservationController@pdf_facture_hotel'); 
    Route::get("pdf_facture_salle", 'PdfReservationController@pdf_facture_salle');  

    Route::get("pdf_facture_appartement", 'PdfReservationController@pdf_facture_appartement'); 
    Route::get("fetch_rapport_appartement_date", 'PdfReservationController@fetch_rapport_appartement_date'); 
    Route::get("fetch_rapport_appartement_client_date", 'PdfReservationController@fetch_rapport_appartement_client_date'); 
    Route::get("fetch_rapport_appartement_by_location_date", 'PdfReservationController@fetch_rapport_appartement_by_location_date'); 

    //  
    Route::get("fetch_facture_hebergement_consommation", 'PdfReservationController@fetch_facture_hebergement_consommation');
    Route::get("fetch_rapport_facture_hebergement_date_organisation", 'PdfReservationController@fetch_rapport_facture_hebergement_date_organisation');
    Route::get("fetch_rapport_facture_hebergement_date", 'PdfReservationController@fetch_rapport_facture_hebergement_date');
    Route::get("fetch_rapport_facture_hebergement_by_numero", 'PdfReservationController@fetch_rapport_facture_hebergement_by_numero');
});

//fetch_rapport_facture_hebergement_date_organisation
//fetch_rapport_facture_hebergement_date
//fetch_rapport_facture_hebergement_by_numero
//pdf_facture_salle
//======== PARTIE TRESORERIE ========================================================================

//=========EnteteBON D'ANGAGEMENT===============
Route::get("fetch_all_bonAngagement", [ttreso_entete_angagementController::class, 'index']);
Route::get("fetch_single_bonAngagement/{id}",[ttreso_entete_angagementController::class,'edit']);
Route::post('insert_bonAngagement', [ttreso_entete_angagementController::class, 'store']);
Route::post('update_bonAngagement/{id}', [ttreso_entete_angagementController::class, 'store']);

Route::post('valider_divison/{id}', [ttreso_entete_angagementController::class, 'valider_divison']);
Route::post('attester_divison/{id}', [ttreso_entete_angagementController::class, 'attester_divison']);

Route::post('valider_tresorerie/{id}', [ttreso_entete_angagementController::class, 'valider_tresorerie']);
Route::post('attester_tresorerie/{id}', [ttreso_entete_angagementController::class, 'attester_tresorerie']);

Route::post('valider_administration/{id}', [ttreso_entete_angagementController::class, 'valider_administration']);
Route::post('attester_administration/{id}', [ttreso_entete_angagementController::class, 'attester_administration']);

Route::post('valider_direction/{id}', [ttreso_entete_angagementController::class, 'valider_direction']);
Route::post('attester_direction/{id}', [ttreso_entete_angagementController::class, 'attester_direction']);

Route::post('valider_gerant/{id}', [ttreso_entete_angagementController::class, 'valider_gerant']);
Route::post('attester_gerant/{id}', [ttreso_entete_angagementController::class, 'attester_gerant']);

Route::get("delete_bonAngagement/{id}", [ttreso_entete_angagementController::class, 'destroy']);

//=========DetailBON D'ANGAGEMENT=======================
Route::get("fetch_all_DbonAngagement", [tt_treso_detail_angagementController::class, 'index']);
Route::get('/fetch_detail_enteteengagement/{refEntete}', [tt_treso_detail_angagementController::class, 'fetch_detail_for_entete']);
Route::get("fetch_single_DbonAngagement/{id}",[tt_treso_detail_angagementController::class,'edit']);
Route::post('insert_DbonAngagement', [tt_treso_detail_angagementController::class, 'store']);
Route::post('update_DbonAngagement/{id}', [tt_treso_detail_angagementController::class, 'store']);
Route::get("delete_DbonAngagement/{id}", [tt_treso_detail_angagementController::class, 'destroy']);
//==========PROVENANCE==============***********
Route::get("fetch_all_provenance", [tt_treso_provenanceController::class, 'index']);
Route::get("fetch_provenance2", [tt_treso_provenanceController::class, 'fetch_provenance2']);
Route::get("fetch_single_provenance/{id}",[tt_treso_provenanceController::class,'edit']);
Route::post('insert_provenance', [tt_treso_provenanceController::class, 'store']);
Route::post('update_provenance/{id}', [tt_treso_provenanceController::class, 'store']);
Route::get("delete_provenance/{id}", [tt_treso_provenanceController::class, 'destroy']);
//fetch_provenance2
//=========RUBRIQUEDEPENSE===============
Route::get("fetch_all_rubrique", [tt_treso_rubriqueController::class, 'index']);
Route::get("fetch_rubrique2", [tt_treso_rubriqueController::class, 'fetch_rubrique2']);
Route::get("fetch_single_rubrique/{id}",[tt_treso_rubriqueController::class,'edit']);
Route::post('insert_rubrique', [tt_treso_rubriqueController::class, 'store']);
Route::post('update_rubrique/{id}', [tt_treso_rubriqueController::class, 'store']);
Route::get("delete_rubrique/{id}", [tt_treso_rubriqueController::class, 'destroy']);
//=========CATEGORIERUBRIQUE=====================================================
//fetch_categorie_rubrique2
Route::get("fetch_all_catRubrique", [tt_treso_categorie_rubriqueController::class, 'index']);
Route::get("fetch_categorie_rubrique2", [tt_treso_categorie_rubriqueController::class, 'fetch_categorie_rubrique2']);
Route::get("fetch_single_catRubrique/{id}",[tt_treso_categorie_rubriqueController::class,'edit']);
Route::post('insert_catRubrique', [tt_treso_categorie_rubriqueController::class, 'store']);
Route::post('update_catRubrique/{id}', [tt_treso_categorie_rubriqueController::class, 'store']);
Route::get("delete_catRubrique/{id}", [tt_treso_categorie_rubriqueController::class, 'destroy']);
//=========ENTETE_ETATDEBESOIN===============
Route::get("fetch_all_etatBesoin", [tt_treso_entete_etatbesoinController::class, 'index']);
Route::get("fetch_single_etatBesoin/{id}",[tt_treso_entete_etatbesoinController::class,'edit']);
Route::post('insert_etatBesoin', [tt_treso_entete_etatbesoinController::class, 'store']);
Route::post('update_etatBesoin/{id}', [tt_treso_entete_etatbesoinController::class, 'store']);
Route::post('aquitter_etatbesoin/{id}', [tt_treso_entete_etatbesoinController::class, 'aquitter_etatbesoin']);
Route::post('approuver_etatbesoin/{id}', [tt_treso_entete_etatbesoinController::class, 'approuver_etatbesoin']);
Route::get("delete_etatBesoin/{id}", [tt_treso_entete_etatbesoinController::class, 'destroy']);
//=========DETAIL_ETATDEBESOIN===============
Route::get("fetch_all_DetatBesoin", [tt_treso_detail_etatbesoinController::class, 'index']);
Route::get('/fetch_detail_enteteetatbesoin/{refEntete}', [tt_treso_detail_etatbesoinController::class, 'fetch_detail_for_entete']);
Route::get("fetch_single_DetatBesoin/{id}",[tt_treso_detail_etatbesoinController::class,'edit']);
Route::post('insert_DetatBesoin', [tt_treso_detail_etatbesoinController::class, 'store']);
Route::post('update_DetatBesoin/{id}', [tt_treso_detail_etatbesoinController::class, 'store']);
Route::get("delete_DetatBesoin/{id}", [tt_treso_detail_etatbesoinController::class, 'destroy']);
//=========BLOCS===============
Route::get("fetch_all_bloc", [tt_treso_blocController::class, 'index']);
Route::get("fetch_bloc2", [tt_treso_blocController::class, 'fetch_bloc2']);
Route::get("fetch_single_bloc/{id}",[tt_treso_blocController::class,'edit']);
Route::post('insert_bloc', [tt_treso_blocController::class, 'store']);
Route::post('update_bloc/{id}', [tt_treso_blocController::class, 'store']);
Route::get("delete_bloc/{id}", [tt_treso_blocController::class, 'destroy']);

// PARTIE FINANCE=============================================================

Route::get("fetch_modepaie", [ModePaieController::class, 'index']);
Route::get("fetch_single_modepaie/{id}",[ModePaieController::class,'edit']);
Route::get("delete_modepaie/{id}", [ModePaieController::class,'destroy']);
Route::post("insert_modepaie", [ModePaieController::class,'store']);
Route::get("fetch_tconf_modepaie_2", [ModePaieController::class, 'fetch_tconf_modepaiement_2']);
Route::get("destroyMessage/{id}", [ModePaieController::class, 'destroyMessage']);

Route::get("fetch_classecompte", [tClasseController::class, 'index']);
Route::get("fetch_single_classecompte/{id}",[tClasseController::class,'edit']);
Route::get("delete_classecompte/{id}", [tClasseController::class,'destroy']);
Route::post("insert_classecompte", [tClasseController::class,'store']);
Route::get("fetch_fin_classe_2", [tClasseController::class, 'fetch_tfin_classe_2']);

Route::get("fetch_typecompte", [tTypeCompteController::class, 'index']);
Route::get("fetch_single_typecompte/{id}",[tTypeCompteController::class,'edit']);
Route::get("delete_typecompte/{id}", [tTypeCompteController::class,'destroy']);
Route::post("insert_typecompte", [tTypeCompteController::class,'store']);
Route::get("fetch_fin_typecompte_2", [tTypeCompteController::class, 'fetch_tfin_typecompte_2']);

Route::get("fetch_typeposition", [tTypePositionController::class, 'index']);
Route::get("fetch_single_typeposition/{id}",[tTypePositionController::class,'edit']);
Route::get("delete_typeposition/{id}", [tTypePositionController::class,'destroy']);
Route::post("insert_typeposition", [tTypePositionController::class,'store']);
Route::get("fetch_fin_typeposition_2", [tTypePositionController::class, 'fetch_tfin_typeposition_2']);

Route::get("fetch_typeoperation", [tTypeOperationController::class, 'index']);
Route::get("fetch_single_typeoperation/{id}",[tTypeOperationController::class,'edit']);
Route::get("delete_typeoperation/{id}", [tTypeOperationController::class,'destroy']);
Route::post("insert_typeoperation", [tTypeOperationController::class,'store']);
Route::get("fetch_fin_typeoperation_2", [tTypeOperationController::class, 'fetch_tfin_typeoperation_2']);

//fetch_unite2
Route::get('/fetch_comptefin', [tCompteFinController::class, 'all']);
Route::get('/fetch_single_compte/{id}', [tCompteFinController::class, 'fetch_single_compte']);
Route::get('/fetch_compte_classe/{refClasse}', [tCompteFinController::class, 'fetch_compte_classe']);   
Route::get('/fetch_compte_classe2/{refClasse}', [tCompteFinController::class, 'fetch_compte_classe2']); 
Route::get('/fetch_compte2', [tCompteFinController::class, 'fetch_compte2']);         
Route::post('/insert_comptefin', [tCompteFinController::class, 'insert_compte']);
Route::post('/update_comptefin/{id}', [tCompteFinController::class, 'update_compte']);
Route::get('/delete_comptefin/{id}', [tCompteFinController::class, 'delete_compte']);

Route::get('/fetch_souscomptefin', [tSousCompteFinController::class, 'all']);
Route::get('/fetch_single_souscompte/{id}', [tSousCompteFinController::class, 'fetch_single_souscompte']);
Route::get('/fetch_souscompte_compte/{refCompte}', [tSousCompteFinController::class, 'fetch_souscompte_compte']);   
Route::get('/fetch_souscompte_compte2/{refCompte}', [tSousCompteFinController::class, 'fetch_souscompte_compte2']);         
Route::post('/insert_souscomptefin', [tSousCompteFinController::class, 'insert_souscompte']);
Route::post('/update_souscomptefin/{id}', [tSousCompteFinController::class, 'update_souscompte']);
Route::get('/delete_souscomptefin/{id}', [tSousCompteFinController::class, 'delete_souscompte']);

//fetch_single_ssouscompte

Route::get('/fetch_ssouscomptefin', [tSSousCompteFinController::class, 'all']);
Route::get('/fetch_ssouscompte2', [tSSousCompteFinController::class, 'fetch_ssouscompte2']);
Route::get('/fetch_single_ssouscompte/{id}', [tSSousCompteFinController::class, 'fetch_single_ssouscompte']);
Route::get('/fetch_ssouscompte_sous/{refSousCompte}', [tSSousCompteFinController::class, 'fetch_ssouscompte_sous']);   
Route::get('/fetch_ssouscompte_sous2/{refSousCompte}', [tSSousCompteFinController::class, 'fetch_ssouscompte_sous2']);         
Route::post('/insert_ssouscomptefin', [tSSousCompteFinController::class, 'insert_ssouscompte']);
Route::post('/update_ssouscomptefin/{id}', [tSSousCompteFinController::class, 'update_ssouscompte']);
Route::get('/delete_ssouscomptefin/{id}', [tSSousCompteFinController::class, 'delete_ssouscompte']);

Route::get("fetch_all_enteteoperationcomptable",[tfin_entete_operationcompteController::class, 'all']);
Route::get("fetch_single_enteteoperationcomptable/{id}",[tfin_entete_operationcompteController::class,'fetch_single']);
Route::post('insert_enteteoperationcomptable',[tfin_entete_operationcompteController::class, 'insert_data']);
Route::post('update_enteteoperationcomptable/{id}', [tfin_entete_operationcompteController::class, 'updateData']);
Route::get("delete_enteteoperationcomptable/{id}", [tfin_entete_operationcompteController::class, 'destroy']);

Route::get('/fetch_detail_operationcomptable', [tfin_detail_operationcompteController::class, 'all']);
Route::get('/fetch_single_detail_operationcomptable/{id}', [tfin_detail_operationcompteController::class, 'fetch_single_detail']);
Route::get('/fetch_detail_enteteoperationcomptable/{refEnteteOperation}', [tfin_detail_operationcompteController::class, 'fetch_detail_entete']);
Route::post('/insert_detailoperationcomptable', [tfin_detail_operationcompteController::class, 'insert_detail']);
Route::post('/update_detailoperationcomptable/{id}', [tfin_detail_operationcompteController::class, 'update_detail']);
Route::get('/delete_detailoperationcomptable/{id}', [tfin_detail_operationcompteController::class, 'delete_detail']);

Route::get("fetch_cloture_comptabilite", [tfin_cloture_comptabiliteController::class, 'index']);
Route::get("fetch_single_cloture_comptabilite/{id}",[tfin_cloture_comptabiliteController::class,'edit']);
Route::get("delete_cloture_comptabilite/{id}", [tfin_cloture_comptabiliteController::class,'destroy']);
Route::post("insert_cloture_comptabilite", [tfin_cloture_comptabiliteController::class,'store']);
Route::get("fetch_tfin_cloture_comptabilite_2", [tfin_cloture_comptabiliteController::class, 'fetch_tfin_cloture_comptabilite_2']);

Route::get('fetch_depense', [tDepenseController::class, 'all']);
Route::get('fetch_single_depense/{id}', [tDepenseController::class, 'fetch_single_depense']);
Route::get('fetch_mouvement_depense', [tDepenseController::class, 'fetch_mouvement_depense']);
Route::get('fetch_mouvement_entree', [tDepenseController::class, 'fetch_mouvement_entree']);        
Route::post('insert_depense', [tDepenseController::class, 'insert_depense']);
Route::post('update_depense/{id}', [tDepenseController::class, 'update_depense']);
Route::get('delete_depense/{id}', [tDepenseController::class, 'delete_depense']);
Route::get('fetch_compte_entree', [tDepenseController::class, 'fetch_compte_entree']);
Route::get('fetch_compte_sortie', [tDepenseController::class, 'fetch_compte_sortie']);
Route::post('aquitter_depense/{id}', [tDepenseController::class, 'aquitter_depense']);
Route::post('approuver_depense/{id}', [tDepenseController::class, 'approuver_depense']);
Route::post('cloturer_Comptabilite', [tDepenseController::class, 'cloturer_Comptabilite']);
Route::post('cloturer_Caisse_vente', [tDepenseController::class, 'cloturer_Caisse_vente']);
Route::post('cloturer_Caisse_hotel', [tDepenseController::class, 'cloturer_Caisse_hotel']);
Route::post('cloturer_Caisse_salle', [tDepenseController::class, 'cloturer_Caisse_salle']);
Route::post('cloturer_Caisse_billard', [tDepenseController::class, 'cloturer_Caisse_billard']);
Route::post('cloturer_Caisse', [tDepenseController::class, 'cloturer_Caisse']);
Route::post('cloturer_Caisse_ok', [tDepenseController::class, 'cloturer_Caisse_ok']);
//cloturer_Caisse_vente   cloturer_Caisse_hotel  cloturer_Caisse_salle cloturer_Caisse_billard
//cloturer_Caisse



Route::get("pdf_livre_caisse_par_banque_caisse", [Pdf_ComptabiliteController::class, 'pdf_livre_caisse_par_banque_caisse']);
Route::get("fetch_rapport_detailfacture_date_compte_cash", [Pdf_ComptabiliteController::class, 'fetch_rapport_detailfacture_date_compte_cash']);
Route::get("fetch_rapport_detailfacture_date_compte_credit", [Pdf_ComptabiliteController::class, 'fetch_rapport_detailfacture_date_compte_credit']);
Route::get("fetch_rapport_journal_caisse", [Pdf_ComptabiliteController::class, 'fetch_rapport_journal_caisse']);
Route::get("fetch_rapport_bilan", [Pdf_ComptabiliteController::class, 'fetch_rapport_bilan']);
Route::get("pdf_livre_caisse", [Pdf_ComptabiliteController::class, 'pdf_livre_caisse']);
Route::get("pdf_livre_banque", [Pdf_ComptabiliteController::class, 'pdf_livre_banque']);

Route::get("fetch_cloture_caisse", [tClotureCaisseController::class, 'index']);
Route::get("fetch_single_cloture_caisse/{id}",[tClotureCaisseController::class,'edit']);
Route::get("delete_cloture_caisse/{id}", [tClotureCaisseController::class,'destroy']);
Route::post("insert_cloture_caisse", [tClotureCaisseController::class,'store']);


Route::get("pdf_bon_engagement", [Pdf_BonEngagementController::class, 'pdf_bon_engagement']);
Route::get("pdf_bon_etatdebesoin", [Pdf_BonEngagementController::class, 'pdf_bon_etatdebesoin']);



Route::get("fetch_banque", [tBanqueController::class, 'index']);
Route::get("fetch_list_mode", [tBanqueController::class, 'fetch_list_mode']);
Route::get("fetch_tconf_banque_2", [tBanqueController::class, 'fetch_tconf_banque_2']);
Route::get('/fetch_list_banque/{nom_mode}', [tBanqueController::class, 'fetch_list_banque']);
Route::get("fetch_single_banque/{id}",[tBanqueController::class,'edit']);
Route::get("delete_banque/{id}", [tBanqueController::class,'destroy']);
Route::post("insert_banque", [tBanqueController::class,'store']);


Route::get("fetch_modepaie", [ModePaieController::class, 'index']);
Route::get("fetch_single_modepaie/{id}",[ModePaieController::class,'edit']);
Route::get("delete_modepaie/{id}", [ModePaieController::class,'destroy']);
Route::post("insert_modepaie", [ModePaieController::class,'store']);
Route::get("fetch_tconf_modepaie_2", [ModePaieController::class, 'fetch_tconf_modepaiement_2']);
Route::get("destroyMessage/{id}", [ModePaieController::class, 'destroyMessage']);

Route::get('fetch_libelle', [tCompteController::class, 'all']);
Route::get('fetch_single_libelle/{id}', [tCompteController::class, 'fetch_single_compte']);
Route::post('insert_libelle', [tCompteController::class, 'insert_compte']);
Route::post('update_libelle/{id}', [tCompteController::class, 'update_compte']);
Route::get('delete_libelle/{id}', [tCompteController::class, 'delete_compte']);
Route::get('fetch_typemouvement', [tCompteController::class, 'fetch_typemouvement']);




 
//=====================GESTION PERSONNELLE===================================

//=====================AffectationAgent===================================
Route::get("fetch_all_AffectationAgent",[tperso_affectation_agentController::class, 'all']);
Route::get("contrat_encours",[tperso_affectation_agentController::class, 'contrat_encours']);
Route::get("contrat_encours_actif",[tperso_affectation_agentController::class, 'contrat_encours_actif']);
Route::get("contrat_encours_conge",[tperso_affectation_agentController::class, 'contrat_encours_conge']);
Route::get("contrat_fini",[tperso_affectation_agentController::class, 'contrat_fini']);
Route::get("fetch_affectation_agent",[tperso_affectation_agentController::class, 'fetch_affectation_agent']);
Route::get("fetch_AffectationAgent/{refAgent}",[tperso_affectation_agentController::class, 'fetch_affect_agent']);
Route::get("fetch_single_AffectationAgent/{id}",[tperso_affectation_agentController::class,'fetch_single']);
Route::post('insert_AffectationAgent',[tperso_affectation_agentController::class, 'insert_data']);
Route::post('update_AffectationAgent/{id}', [tperso_affectation_agentController::class, 'update_data']);
Route::get("delete_AffectationAgent/{id}", [tperso_affectation_agentController::class, 'delete_data']);


Route::get("fetch_all_demandeconge",[tperso_demandecongeController::class, 'all']);
Route::get("fetch_demandeconge/{affectation_id}",[tperso_demandecongeController::class, 'fetch_detail_entete']);
Route::get("fetch_single_demandeconge/{id}",[tperso_demandecongeController::class,'fetch_single']);
Route::post('insert_demandeconge',[tperso_demandecongeController::class, 'insert_data']);
Route::post('update_demandeconge/{id}', [tperso_demandecongeController::class, 'update_data']);
Route::post("delete_demandeconge/{id}", [tperso_demandecongeController::class, 'delete_data']);

Route::get("fetch_all_perso_projtes",[tperso_projetsController::class, 'all']);
Route::get("fetch_perso_projets2",[tperso_projetsController::class, 'fetch_dropdown']);
Route::get("fetch_perso_projtes/{partenaire_id}",[tperso_projetsController::class, 'fetch_detail_entete']);
Route::get("fetch_single_perso_projtes/{id}",[tperso_projetsController::class,'fetch_single']);
Route::post('insert_perso_projtes',[tperso_projetsController::class, 'insert_data']);
Route::post('update_perso_projtes/{id}', [tperso_projetsController::class, 'update_data']);
Route::get("delete_perso_projtes/{id}", [tperso_projetsController::class, 'delete_data']);
//fetch_dropdown

Route::get("fetch_all_activites_projet",[tperso_activites_projetController::class, 'all']);
Route::get("fetch_activites_projet/{projet_id}",[tperso_activites_projetController::class, 'fetch_detail_entete']);
Route::get("fetch_single_activites_projet/{id}",[tperso_activites_projetController::class,'fetch_single']);
Route::post('insert_activites_projet',[tperso_activites_projetController::class, 'insert_data']);
Route::post('update_activites_projet/{id}', [tperso_activites_projetController::class, 'update_data']);
Route::get("delete_activites_projet/{id}", [tperso_activites_projetController::class, 'delete_data']);

Route::get("fetch_all_checklist",[tchecklistController::class, 'all']);
Route::get("fetch_checklist/{refAgent}",[tchecklistController::class, 'fetch_detail_entete']);
Route::get("fetch_single_checklist/{id}",[tchecklistController::class,'fetch_single']);
Route::post('insert_checklist',[tchecklistController::class, 'insert_data']);
Route::post('update_checklist/{id}', [tchecklistController::class, 'update_data']);
Route::get("delete_checklist/{id}", [tchecklistController::class, 'delete_data']);

//tchecklistController

Route::get("fetch_all_perso_livrables",[tperso_livrablesController::class, 'all']);
Route::get("fetch_perso_livrables/{activite_id}",[tperso_livrablesController::class, 'fetch_detail_entete']);
Route::get("fetch_single_perso_livrables/{id}",[tperso_livrablesController::class,'fetch_single']);
Route::post('insert_perso_livrables',[tperso_livrablesController::class, 'insert_data']);
Route::post('update_perso_livrables/{id}', [tperso_livrablesController::class, 'update_data']);
Route::get("delete_perso_livrables/{id}", [tperso_livrablesController::class, 'delete_data']);
Route::get("downloadfile/{filenamess}",[tperso_livrablesController::class,'downloadfile']);

Route::get("fetch_all_perso_paie_projet",[tperso_paie_projetController::class, 'all']);
Route::get("fetch_perso_paie_projet/{activite_id}",[tperso_paie_projetController::class, 'fetch_detail_entete']);
Route::get("fetch_single_perso_paie_projet/{id}",[tperso_paie_projetController::class,'fetch_single']);
Route::post('insert_perso_paie_projet',[tperso_paie_projetController::class, 'insert_data']);
Route::post('update_perso_paie_projet/{id}', [tperso_paie_projetController::class, 'update_data']);
Route::get("delete_perso_paie_projet/{id}", [tperso_paie_projetController::class, 'delete_data']);

Route::get("fetch_all_perso_affectation_tache",[tperso_affectation_tacheController::class, 'all']);
Route::get("fetch_perso_affectation_tache/{activite_id}",[tperso_affectation_tacheController::class, 'fetch_detail_entete']);
Route::get("fetch_single_perso_affectation_tache/{id}",[tperso_affectation_tacheController::class,'fetch_single']);
Route::post('insert_perso_affectation_tache',[tperso_affectation_tacheController::class, 'insert_data']);
Route::post('update_perso_affectation_tache/{id}', [tperso_affectation_tacheController::class, 'update_data']);
Route::get("delete_perso_affectation_tache/{id}", [tperso_affectation_tacheController::class, 'delete_data']);

Route::get("fetch_all_perso_presences_agent",[tperso_presences_agentController::class, 'all']);
Route::get("fetch_all_jour_perso_presences_agent",[tperso_presences_agentController::class, 'all_jour']);
Route::get("fetch_all_filter_perso_presences_agent",[tperso_presences_agentController::class, 'all_filter']);
Route::get("fetch_all_service_filter_perso_presences_agent",[tperso_presences_agentController::class, 'all_service_filter']);
Route::get("fetch_perso_presences_agent/{affectation_id}",[tperso_presences_agentController::class, 'fetch_detail_entete']);
Route::get("fetch_single_perso_presences_agent/{id}",[tperso_presences_agentController::class,'fetch_single']);
Route::post('insert_perso_presences_agent',[tperso_presences_agentController::class, 'insert_data']);
Route::post('update_perso_presences_agent/{id}', [tperso_presences_agentController::class, 'update_data']);
Route::post('update_perso_retard_agent/{id}', [tperso_presences_agentController::class, 'update_data_retard']);
Route::get("delete_perso_presences_agent/{id}", [tperso_presences_agentController::class, 'delete_data']);

Route::get("fetch_all_perso_correspondance_agent",[tperso_correspondanceController::class, 'all']);
Route::get("fetch_jour_perso_correspondance_agent",[tperso_correspondanceController::class, 'all_jour']);
Route::get("fetch_perso_correspondance_agent/{user_id}",[tperso_correspondanceController::class, 'fetch_detail_entete']);
Route::get("fetch_single_perso_correspondance_agent/{id}",[tperso_correspondanceController::class,'fetch_single']);
Route::post('insert_perso_correspondance_agent',[tperso_correspondanceController::class, 'insert_data']);
Route::post('update_perso_correspondance_agent/{id}', [tperso_correspondanceController::class, 'update_data']);
Route::get("delete_perso_correspondance_agent/{id}", [tperso_correspondanceController::class, 'delete_data']);

//all_jour

Route::get("fetch_all_perso_timesheet",[tperso_timesheetController::class, 'all']);
Route::get("fetch_all_jour_perso_timesheet",[tperso_timesheetController::class, 'all_jour']);
Route::get("fetch_all_filter_perso_timesheet",[tperso_timesheetController::class, 'all_filter']);
Route::get("fetch_all_service_filter_perso_timesheet",[tperso_timesheetController::class, 'all_service_filter']);
Route::get("fetch_perso_timesheet/{affectation_id}",[tperso_timesheetController::class, 'fetch_detail_entete']);
Route::get("fetch_perso_timesheet_user/{user_id}",[tperso_timesheetController::class, 'fetch_detail_entete_user']);
Route::get("fetch_single_perso_timesheet/{id}",[tperso_timesheetController::class,'fetch_single']);
Route::post('insert_perso_timesheet',[tperso_timesheetController::class, 'insert_data']);
Route::post('update_perso_timesheet/{id}', [tperso_timesheetController::class, 'update_data']);
Route::post('update_perso_chef_projet/{id}', [tperso_timesheetController::class, 'update_projet']);
Route::post('update_perso_coordo_projet/{id}', [tperso_timesheetController::class, 'update_coordo']);
Route::post('update_perso_rh_projet/{id}', [tperso_timesheetController::class, 'update_rh']);
Route::get("delete_perso_timesheet/{id}", [tperso_timesheetController::class, 'delete_data']);

Route::get("fetch_perso_partenaire", [tperso_partenaireController::class, 'index']);
Route::get("fetch_list_perso_partenaire", [tperso_partenaireController::class, 'fetch_data']);
Route::get("fetch_single_perso_partenaire/{id}", [tperso_partenaireController::class, 'edit']);
Route::get("delete_perso_partenaire/{id}", [tperso_partenaireController::class, 'destroy']);
Route::post("insert_perso_partenaire", [tperso_partenaireController::class, 'insertData']);
Route::post("update_perso_partenaire", [tperso_partenaireController::class, 'updateData']);



//=====================annee===================================
Route::get("fetch_all_annee",[tperso_anneeController::class, 'index']);
Route::get("fetch_annee2",[tperso_anneeController::class,'fetch_dropdown_2']);
Route::get("fetch_single_annee/{id}",[tperso_anneeController::class,'edit']);
Route::post('insert_annee',[tperso_anneeController::class, 'store']);
Route::post('update_annee/{id}', [tperso_anneeController::class, 'store']);
Route::get("delete_annee/{id}", [tperso_anneeController::class, 'destroy']);

Route::get("fetch_all_perso_division",[tperso_divisionController::class, 'index']);
Route::get("fetch_perso_division2",[tperso_divisionController::class,'fetch_dropdown_2']);
Route::get("fetch_single_perso_division/{id}",[tperso_divisionController::class,'edit']);
Route::post('insert_perso_division',[tperso_divisionController::class, 'store']);
Route::post('update_perso_division/{id}', [tperso_divisionController::class, 'store']);
Route::get("delete_perso_division/{id}", [tperso_divisionController::class, 'destroy']);

Route::get("fetch_all_categorie_archivage",[tperso_categorie_archivageController::class, 'index']);
Route::get("fetch_categorie_archivage2",[tperso_categorie_archivageController::class,'fetch_dropdown_2']);
Route::get("fetch_single_categorie_archivage/{id}",[tperso_categorie_archivageController::class,'edit']);
Route::post('insert_categorie_archivage',[tperso_categorie_archivageController::class, 'store']);
Route::post('update_categorie_archivage/{id}', [tperso_categorie_archivageController::class, 'store']);
Route::get("delete_categorie_archivage/{id}", [tperso_categorie_archivageController::class, 'destroy']);

Route::get("fetch_all_promotion_stage",[tperso_promotion_stageController::class, 'index']);
Route::get("fetch_promotion_stage2",[tperso_promotion_stageController::class,'fetch_dropdown_2']);
Route::get("fetch_single_promotion_stage/{id}",[tperso_promotion_stageController::class,'edit']);
Route::post('insert_promotion_stage',[tperso_promotion_stageController::class, 'store']);
Route::post('update_promotion_stage/{id}', [tperso_promotion_stageController::class, 'store']);
Route::get("delete_promotion_stage/{id}", [tperso_promotion_stageController::class, 'destroy']);

Route::get("fetch_all_domaine_stage",[tperso_domaine_stageController::class, 'index']);
Route::get("fetch_domaine_stage2",[tperso_domaine_stageController::class,'fetch_dropdown_2']);
Route::get("fetch_single_domaine_stage/{id}",[tperso_domaine_stageController::class,'edit']);
Route::post('insert_domaine_stage',[tperso_domaine_stageController::class, 'store']);
Route::post('update_domaine_stage/{id}', [tperso_domaine_stageController::class, 'store']);
Route::get("delete_domaine_stage/{id}", [tperso_domaine_stageController::class, 'destroy']);

Route::get("fetch_all_option_stage",[tperso_option_stageController::class, 'all']);
Route::get("fetch_option_stage2",[tperso_option_stageController::class,'fetch_service_personnel2']);
Route::get("fetch_single_option_stage/{id}",[tperso_option_stageController::class,'fetch_single']);
Route::post('insert_option_stage',[tperso_option_stageController::class, 'insert_data']);
Route::post('update_option_stage/{id}', [tperso_option_stageController::class, 'update_data']);
Route::get("delete_option_stage/{id}", [tperso_option_stageController::class, 'destroy']);

Route::get("fetch_all_annee_stage",[tperso_annee_stageController::class, 'index']);
Route::get("fetch_annee_stage2",[tperso_annee_stageController::class,'fetch_dropdown_2']);
Route::get("fetch_single_annee_stage/{id}",[tperso_annee_stageController::class,'edit']);
Route::post('insert_annee_stage',[tperso_annee_stageController::class, 'store']);
Route::post('update_annee_stage/{id}', [tperso_annee_stageController::class, 'store']);
Route::get("delete_annee_stage/{id}", [tperso_annee_stageController::class, 'destroy']);

Route::get("fetch_all_type_stage",[tperso_type_stageController::class, 'index']);
Route::get("fetch_type_stage2",[tperso_type_stageController::class,'fetch_dropdown_2']);
Route::get("fetch_single_type_stage/{id}",[tperso_type_stageController::class,'edit']);
Route::post('insert_type_stage',[tperso_type_stageController::class, 'store']);
Route::post('update_type_stage/{id}', [tperso_type_stageController::class, 'store']);
Route::get("delete_type_stage/{id}", [tperso_type_stageController::class, 'destroy']);

//tperso_type_stageController 

Route::get("fetch_all_service_archivage",[tperso_service_archivageController::class, 'all']);
Route::get("fetch_service_archivage2",[tperso_service_archivageController::class, 'fetch_dropdown_2']);
Route::get("fetch_service_archivage/{division_id}",[tperso_service_archivageController::class, 'fetch_detail_entete']);
Route::get("fetch_single_service_archivage/{id}",[tperso_service_archivageController::class,'fetch_single']);
Route::post('insert_service_archivage',[tperso_service_archivageController::class, 'insert_data']);
Route::post('update_service_archivage/{id}', [tperso_service_archivageController::class, 'update_data']);
Route::get("delete_service_archivage/{id}", [tperso_service_archivageController::class, 'delete_data']);

Route::get("fetch_all_parametre_salairebase",[tperso_parametre_salairebaseController::class, 'all']);
Route::get("fetch_parametre_salairebase2",[tperso_parametre_salairebaseController::class, 'fetch_dropdown_2']);
Route::get("fetch_data_salairebase/{categorie_id}",[tperso_parametre_salairebaseController::class, 'fetch_data_projet']);
Route::get("fetch_parametre_salairebase/{projet_id}",[tperso_parametre_salairebaseController::class, 'fetch_detail_entete']);
Route::get("fetch_single_parametre_salairebase/{id}",[tperso_parametre_salairebaseController::class,'fetch_single']);
Route::post('insert_parametre_salairebase',[tperso_parametre_salairebaseController::class, 'insert_data']);
Route::post('update_parametre_salairebase/{id}', [tperso_parametre_salairebaseController::class, 'update_data']);
Route::get("delete_parametre_salairebase/{id}", [tperso_parametre_salairebaseController::class, 'delete_data']);

//SimpleExcelController 
Route::post('import_presence_excel',[SimpleExcelController::class, 'import']);

Route::get("fetch_all_archivages",[tperso_archivagesController::class, 'all']);
Route::get("fetch_all_filter_archivages",[tperso_archivagesController::class, 'all_filter']);
Route::get("fetch_all_service_filter_archivages",[tperso_archivagesController::class, 'all_service_filter']);
Route::get("fetch_all_categorie_filter_archivages",[tperso_archivagesController::class, 'all_categorie_filter']);
Route::get("fetch_all_categorie_service_filter_archivages",[tperso_archivagesController::class, 'all_categorie_service_filter']);
Route::get("fetch_archivages/{activite_id}",[tperso_archivagesController::class, 'fetch_detail_entete']);
Route::get("fetch_single_archivages/{id}",[tperso_archivagesController::class,'fetch_single']);
Route::post('insert_archivages',[tperso_archivagesController::class, 'insert_data']);
Route::post('update_archivages/{id}', [tperso_archivagesController::class, 'update_data']);
Route::get("delete_archivages/{id}", [tperso_archivagesController::class, 'delete_data']);

Route::get("fetch_all_institution_stage",[tperso_institution_stageController::class, 'index']);
Route::get("fetch_institution_stage2",[tperso_institution_stageController::class,'fetch_dropdown_2']);
Route::get("fetch_single_institution_stage/{id}",[tperso_institution_stageController::class,'edit']);
Route::post('insert_institution_stage',[tperso_institution_stageController::class, 'store']);
Route::post('update_institution_stage/{id}', [tperso_institution_stageController::class, 'store']);
Route::get("delete_institution_stage/{id}", [tperso_institution_stageController::class, 'destroy']);


//stage_encours
Route::get("fetch_all_perso_stages",[tperso_stagesController::class, 'all']);
Route::get("stage_encours",[tperso_stagesController::class, 'stage_encours']);
Route::get("fetch_stages_agent/{personnel_id}",[tperso_stagesController::class, 'fetch_detail_entete']);
Route::get("fetch_single_perso_stages/{id}",[tperso_stagesController::class,'fetch_single']);
Route::post('insert_perso_stages',[tperso_stagesController::class, 'insert_data']);
Route::post('update_perso_stages/{id}', [tperso_stagesController::class, 'update_data']);
Route::get("delete_perso_stages/{id}", [tperso_stagesController::class, 'delete_data']);

Route::get("fetch_all_parcours_stage",[tperso_parcours_stageController::class, 'all']);
Route::get("fetch_parcours_stage/{stage_id}",[tperso_parcours_stageController::class, 'fetch_detail_entete']); 
Route::get("fetch_single_parcours_stage/{id}",[tperso_parcours_stageController::class,'fetch_single']);
Route::post('insert_parcours_stage',[tperso_parcours_stageController::class, 'insert_data']);
Route::post('update_parcours_stage/{id}', [tperso_parcours_stageController::class, 'update_data']);
Route::get("delete_parcours_stage/{id}", [tperso_parcours_stageController::class, 'delete_data']);





//=====================appreciationAgent===================================
Route::get("fetch_all_appreciation_agent",[tperso_appreciation_agentController::class, 'all']);
Route::get("fetch_appreciation_agent/{refAffectation}",[tperso_appreciation_agentController::class, 'fetch_affect_appreciation']);
Route::get("fetch_single_appreciation_agent/{id}",[tperso_appreciation_agentController::class,'fetch_single']);
Route::post('insert_appreciation_agentt',[tperso_appreciation_agentController::class, 'insert_data']);
Route::post('update_appreciation_agent/{id}', [tperso_appreciation_agentController::class, 'update_data']);
Route::get("delete_appreciation_agent/{id}", [tperso_appreciation_agentController::class, 'delete_data']);
//=====================RAPPORT PERSONNELS===================================  
//fetch_rapport_paiement_date_mois_poste
 
Route::get("fetch_rapport_paiement_date_mois_poste",[Pdf_PersonnelController::class, 'fetch_rapport_paiement_date_mois_poste']);
Route::get("fetch_rapport_paiement_date_mois_projet",[Pdf_PersonnelController::class, 'fetch_rapport_paiement_date_mois_projet']);
Route::get("pdf_bon_soin",[Pdf_PersonnelController::class, 'pdf_bon_soin']);
Route::get("pdf_bon_sortie_agent",[Pdf_PersonnelController::class, 'pdf_bon_sortie_agent']);
Route::get("pdf_fiche_appreciation_agent",[Pdf_PersonnelController::class, 'pdf_fiche_appreciation_agent']);
Route::get("pdf_conge_annuel",[Pdf_PersonnelController::class, 'pdf_conge_annuel']);
Route::get("pdf_autres_conges",[Pdf_PersonnelController::class, 'pdf_autres_conges']);
Route::get("pdf_conge_maladie",[Pdf_PersonnelController::class, 'pdf_conge_maladie']);
Route::get("pdf_conge_famillial",[Pdf_PersonnelController::class, 'pdf_conge_famillial']);
Route::get("pdf_conge_maternite",[Pdf_PersonnelController::class, 'pdf_conge_maternite']);
Route::get("fetch_rapport_paiement_date_mois",[Pdf_PersonnelController::class, 'fetch_rapport_paiement_date_mois']);
Route::get("pdf_bulletin_paie",[Pdf_PersonnelController::class, 'pdf_bulletin_paie']);
Route::get("fetch_rapport_paiement_date_mois_rubrique",[Pdf_PersonnelController::class, 'fetch_rapport_paiement_date_mois_rubrique']);
Route::get("fetch_rapport_paiement_date",[Pdf_PersonnelController::class, 'fetch_rapport_paiement_date']);
Route::get("fetch_rapport_paiement_date_service",[Pdf_PersonnelController::class, 'fetch_rapport_paiement_date_service']);




Route::get("fetch_rapport_contrat_date",[Pdf_ContratController::class, 'fetch_rapport_contrat_date']);
Route::get("fetch_rapport_fincontrat_date",[Pdf_ContratController::class, 'fetch_rapport_fincontrat_date']);
Route::get("fetch_rapport_contrat_date_typecontrat",[Pdf_ContratController::class, 'fetch_rapport_contrat_date_typecontrat']);
Route::get("fetch_rapport_contrat_date_poste",[Pdf_ContratController::class, 'fetch_rapport_contrat_date_poste']);
Route::get("fetch_rapport_contrat_date_LieuAffectation",[Pdf_ContratController::class, 'fetch_rapport_contrat_date_LieuAffectation']);
Route::get("fetch_rapport_contrat_date_mutuelle",[Pdf_ContratController::class, 'fetch_rapport_contrat_date_mutuelle']);
Route::get("fetch_rapport_contrat_date_conge",[Pdf_ContratController::class, 'fetch_rapport_contrat_date_conge']);
Route::get("fetch_rapport_conge_encours_date",[Pdf_ContratController::class, 'fetch_rapport_conge_encours_date']);
Route::get("fetch_rapport_stagiaires_date",[Pdf_ContratController::class, 'fetch_rapport_stagiaires_date']);
Route::get("fetch_rapport_stagiaires_date_institution",[Pdf_ContratController::class, 'fetch_rapport_stagiaires_date_institution']);
Route::get("fetch_rapport_stagiaires_date_typestage",[Pdf_ContratController::class, 'fetch_rapport_stagiaires_date_typestage']);
Route::get("pdf_fiche_agent",[Pdf_ContratController::class, 'pdf_fiche_agent']);
Route::get("pdf_contrat_prestation_agent",[Pdf_ContratController::class, 'pdf_contrat_prestation_agent']);
Route::get("pdf_contrat_travail_agent",[Pdf_ContratController::class, 'pdf_contrat_travail_agent']);
Route::get("pdf_fiche_conge_agent",[Pdf_ContratController::class, 'pdf_fiche_conge_agent']);

Route::get("fetch_rapport_presence_date",[Pdf_ContratController::class, 'fetch_rapport_presence_date']);
Route::get("fetch_rapport_presence_service_date",[Pdf_ContratController::class, 'fetch_rapport_presence_service_date']);
Route::get("fetch_rapport_presence_lieu_date",[Pdf_ContratController::class, 'fetch_rapport_presence_lieu_date']);
Route::get("fetch_rapport_contrat_date_projet",[Pdf_ContratController::class, 'fetch_rapport_contrat_date_projet']);
Route::get("fetch_rapport_contrat_date_sexe",[Pdf_ContratController::class, 'fetch_rapport_contrat_date_sexe']);
Route::get("pdf_bulletin_paie_salire_agent",[Pdf_ContratController::class, 'pdf_bulletin_paie_salire_agent']);

Route::get("pdf_notificationfin_contrat_agent",[Pdf_ContratController::class, 'pdf_notificationfin_contrat_agent']);
Route::get("pdf_checklist_agent",[Pdf_ContratController::class, 'pdf_checklist_agent']);
Route::get("fetch_rapport_time_sheet_date",[Pdf_ContratController::class, 'fetch_rapport_time_sheet_date']);

// fetch_rapport_time_sheet_date


//pdf_bulletin_paie_salire_agent
//fetch_rapport_contrat_date_projet
//fetch_rapport_contrat_date_sexe
// fetch_rapport_contrat_date
// fetch_rapport_fincontrat_date
// fetch_rapport_contrat_date_typecontrat
// fetch_rapport_contrat_date_poste
// fetch_rapport_contrat_date_LieuAffectation
// fetch_rapport_contrat_date_mutuelle
// fetch_rapport_contrat_date_conge
// fetch_rapport_conge_encours_date
// fetch_rapport_stagiaires_date
// fetch_rapport_stagiaires_date_institution
// fetch_rapport_stagiaires_date_typestage
// pdf_fiche_agent
// pdf_contrat_prestation_agent
// pdf_contrat_travail_agent
// pdf_fiche_conge_agent









//fetch_rapport_paiement_date_mois_rubrique
//=====================autreConge===================================
Route::get("fetch_all_autreConge",[tperso_autre_congeController::class, 'all']);
Route::get("fetch_autreConge/{refEnteteConge}",[tperso_autre_congeController::class, 'fetch_affect_autreConge']);
Route::get("fetch_single_autreConge/{id}",[tperso_autre_congeController::class,'fetch_single']);
Route::post('insert_autreConge',[tperso_autre_congeController::class, 'insert_data']);
Route::post('update_autreConge/{id}', [tperso_autre_congeController::class, 'update_data']);
Route::get("delete_autreConge/{id}", [tperso_autre_congeController::class, 'delete_data']);
//=====================categorieAgent===================================
Route::get("fetch_all_categorie_agent",[tperso_categorie_agentController::class, 'index']);
Route::get("fetch_dopdown_categorie_agent",[tperso_categorie_agentController::class,'fetch_dropdown_2']);
Route::get("fetch_single_categorie_agent/{id}",[tperso_categorie_agentController::class,'edit']);
Route::post('insert_categorie_agent',[tperso_categorie_agentController::class, 'store']);
Route::post('update_categorie_agent/{id}', [tperso_categorie_agentController::class, 'store']);
Route::get("delete_categorie_agent/{id}", [tperso_categorie_agentController::class, 'destroy']);
//=====================categorieRubrique===================================

Route::get("fetch_all_bareme",[tperso_baremeController::class, 'index']);
Route::get("fetch_dopdown_bareme",[tperso_baremeController::class,'fetch_dropdown_2']);
Route::get("fetch_single_bareme/{id}",[tperso_baremeController::class,'edit']);
Route::post('insert_bareme',[tperso_baremeController::class, 'store']);
Route::post('update_bareme/{id}', [tperso_baremeController::class, 'store']);
Route::get("delete_bareme/{id}", [tperso_baremeController::class, 'destroy']);

//backupsController 

Route::get("downloadBackup",[backupsController::class, 'downloadBackup']);

Route::get("fetch_all_categorie_rubrique_pers",[tperso_categorie_rubriqueController::class, 'index']);
Route::get("fetch_dopdown_categorie_rubrique_pers",[tperso_categorie_rubriqueController::class,'fetch_dropdown_2']);
Route::get("fetch_single_categorie_rubrique_pers/{id}",[tperso_categorie_rubriqueController::class,'edit']);
Route::post('insert_categorie_rubrique_pers',[tperso_categorie_rubriqueController::class, 'store']);
Route::post('update_categorie_rubrique_pers/{id}', [tperso_categorie_rubriqueController::class, 'store']);
Route::get("delete_categorie_rubrique_pers/{id}", [tperso_categorie_rubriqueController::class, 'destroy']);

Route::get("fetch_all_typecirconstance_pers",[tperso_typecirconstancecongeController::class, 'index']);
Route::get("fetch_dopdown_typecirconstance_pers",[tperso_typecirconstancecongeController::class,'fetch_dropdown_2']);
Route::get("fetch_single_typecirconstance_pers/{id}",[tperso_typecirconstancecongeController::class,'edit']);
Route::get("fetch_single_circonstance_categorie/{categorie_id}",[tperso_typecirconstancecongeController::class,'fetch_dropdown_categorie']);
Route::post('insert_typecirconstance_pers',[tperso_typecirconstancecongeController::class, 'store']);
Route::post('update_typecirconstance_pers/{id}', [tperso_typecirconstancecongeController::class, 'store']);
Route::get("delete_typecirconstance_pers/{id}", [tperso_typecirconstancecongeController::class, 'destroy']);

//fetch_dropdown_categorie

Route::get("fetch_all_poste_pers",[tperso_posteController::class, 'index']);
Route::get("fetch_dopdown_poste_pers",[tperso_posteController::class,'fetch_dropdown_2']);
Route::get("fetch_single_poste_pers/{id}",[tperso_posteController::class,'edit']);
Route::post('insert_poste_pers',[tperso_posteController::class, 'store']);
Route::post('update_poste_pers/{id}', [tperso_posteController::class, 'store']);
Route::get("delete_poste_pers/{id}", [tperso_posteController::class, 'destroy']);

Route::get("fetch_all_lieuaffectation_pers",[tperso_lieuaffectationController::class, 'index']);
Route::get("fetch_dopdown_lieuaffectation_pers",[tperso_lieuaffectationController::class,'fetch_dropdown_2']);
Route::get("fetch_single_lieuaffectation_pers/{id}",[tperso_lieuaffectationController::class,'edit']);
Route::post('insert_lieuaffectation_pers',[tperso_lieuaffectationController::class, 'store']);
Route::post('update_lieuaffectation_pers/{id}', [tperso_lieuaffectationController::class, 'store']);
Route::get("delete_lieuaffectation_pers/{id}", [tperso_lieuaffectationController::class, 'destroy']);

Route::get("fetch_all_mutuelle_pers",[tperso_mutuelleController::class, 'index']);
Route::get("fetch_dopdown_mutuelle_pers",[tperso_mutuelleController::class,'fetch_dropdown_2']);
Route::get("fetch_single_mutuelle_pers/{id}",[tperso_mutuelleController::class,'edit']);
Route::post('insert_mutuelle_pers',[tperso_mutuelleController::class, 'store']);
Route::post('update_mutuelle_pers/{id}', [tperso_mutuelleController::class, 'store']);
Route::get("delete_mutuelle_pers/{id}", [tperso_mutuelleController::class, 'destroy']);

Route::get("fetch_all_typecontrat_pers",[tperso_typecontratController::class, 'index']);
Route::get("fetch_dopdown_typecontrat_pers",[tperso_typecontratController::class,'fetch_dropdown_2']);
Route::get("fetch_single_typecontrat_pers/{id}",[tperso_typecontratController::class,'edit']);
Route::post('insert_typecontrat_pers',[tperso_typecontratController::class, 'store']);
Route::post('update_typecontrat_pers/{id}', [tperso_typecontratController::class, 'store']);
Route::get("delete_typecontrat_pers/{id}", [tperso_typecontratController::class, 'destroy']);

//=====================categorieService===================================
Route::get("fetch_all_categorie_service_pers",[tperso_categorie_serviceController::class, 'index']);
Route::get("fetch_categorie_service_personnel_2",[tperso_categorie_serviceController::class,'fetch_categorie_service_2']);
Route::get("fetch_single_categorie_service_pers/{id}",[tperso_categorie_serviceController::class,'edit']);
Route::post('insert_categorie_service_pers',[tperso_categorie_serviceController::class, 'store']);
Route::post('update_categorie_service_pers/{id}', [tperso_categorie_serviceController::class, 'store']);
Route::get("delete_categorie_service_pers/{id}", [tperso_categorie_serviceController::class, 'destroy']);

Route::get("fetch_all_categorie_circonstance",[tperso_categorie_circonstanceController::class, 'index']);
Route::get("fetch_categorie_circonstance2",[tperso_categorie_circonstanceController::class,'fetch_dropdown_2']);
Route::get("fetch_single_categorie_circonstance/{id}",[tperso_categorie_circonstanceController::class,'edit']);
Route::post('insert_categorie_circonstance',[tperso_categorie_circonstanceController::class, 'store']);
Route::post('update_categorie_circonstance/{id}', [tperso_categorie_circonstanceController::class, 'store']);
Route::get("delete_categorie_circonstance/{id}", [tperso_categorie_circonstanceController::class, 'destroy']);

//tperso_categorie_circonstanceController
//=====================conge annuel===================================
Route::get("fetch_all_congeAnnuel",[tperso_conge_annuelController::class, 'all']);
Route::get("fetch_congeAnnuel/{refEnteteConge}",[tperso_conge_annuelController::class, 'fetch_entete_congeAnnuel']);
Route::get("fetch_single_congeAnnuel/{id}",[tperso_conge_annuelController::class,'fetch_single']);
Route::post('insert_congeAnnuel',[tperso_conge_annuelController::class, 'insert_data']);
Route::post('update_congeAnnuel/{id}', [tperso_conge_annuelController::class, 'update_data']);
Route::get("delete_congeAnnuel/{id}", [tperso_conge_annuelController::class, 'delete_data']);
//=====================conge famililiale===================================
Route::get("fetch_all_conge_familiale",[tperso_conge_familialeController::class, 'all']);
Route::get("fetch_conge_familiale/{refEnteteConge}",[tperso_conge_familialeController::class, 'fetch_entete_congeFamiliale']);
Route::get("fetch_single_conge_familiale/{id}",[tperso_conge_familialeController::class,'fetch_single']);
Route::post('insert_conge_familiale',[tperso_conge_familialeController::class, 'insert_data']);
Route::post('update_conge_familiale/{id}', [tperso_conge_familialeController::class, 'update_data']);
Route::get("delete_conge_familiale/{id}", [tperso_conge_familialeController::class, 'delete_data']);

 
Route::get("fetch_all_avance_salaire",[tperso_avance_salaireController::class, 'all']);
Route::get("fetch_avance_salaire/{refAffectation}",[tperso_avance_salaireController::class, 'fetch_affect_controle']);
Route::get("fetch_single_avance_salaire/{id}",[tperso_avance_salaireController::class,'fetch_single']);
Route::post('insert_avance_salaire',[tperso_avance_salaireController::class, 'insert_data']);
Route::post('update_avance_salaire/{id}', [tperso_avance_salaireController::class, 'update_data']);
Route::get("delete_avance_salaire/{id}", [tperso_avance_salaireController::class, 'delete_data']);

Route::get("fetch_all_mission_service",[tperso_enmissionController::class, 'all']);
Route::get("fetch_mission_service/{refAffectation}",[tperso_enmissionController::class, 'fetch_affect_controle']);
Route::get("fetch_single_mission_service/{id}",[tperso_enmissionController::class,'fetch_single']);
Route::post('insert_mission_service',[tperso_enmissionController::class, 'insert_data']);
Route::post('update_mission_service/{id}', [tperso_enmissionController::class, 'update_data']);
Route::get("delete_mission_service/{id}", [tperso_enmissionController::class, 'delete_data']);
//tperso_enmissionController
//=====================controleConge===================================
Route::get("fetch_all_controleConge",[tperso_controle_congeController::class, 'all']);
Route::get("fetch_controleConge/{refAffectation}",[tperso_controle_congeController::class, 'fetch_affect_controle']);
Route::get("fetch_single_controleConge/{id}",[tperso_controle_congeController::class,'fetch_single']);
Route::post('insert_controleConge',[tperso_controle_congeController::class, 'insert_data']);
Route::post('update_controleConge/{id}', [tperso_controle_congeController::class, 'update_data']);
Route::get("delete_controleConge/{id}", [tperso_controle_congeController::class, 'delete_data']);
//=====================demande soin===================================
Route::get("fetch_all_demandeSoin",[tperso_demande_soinController::class, 'all']);
Route::get("fetch_demandeSoin_agent/{refAffectation}",[tperso_demande_soinController::class, 'fetch_affect_dmdSoin']);
Route::get("fetch_single_demandeSoin/{id}",[tperso_demande_soinController::class,'fetch_single']);
Route::post('insert_demandeSoin',[tperso_demande_soinController::class, 'insert_data']);
Route::post('update_demandeSoin/{id}', [tperso_demande_soinController::class, 'update_data']);
Route::get("delete_demandeSoin/{id}", [tperso_demande_soinController::class, 'delete_data']);
//=======================perso_dependant============================================== tperso_annexeConrtoller

Route::get("fetch_all_perso_annexe",[tperso_annexeConrtoller::class, 'all']);
Route::get("fetch_perso_annexe_agent/{refAgent}",[tperso_annexeConrtoller::class, 'fetch_annexe_agent']);
Route::get("fetch_single_perso_annexe/{id}",[tperso_annexeConrtoller::class,'fetch_single']);
Route::post('insert_perso_annexe',[tperso_annexeConrtoller::class, 'insert_data']);
Route::post('update_perso_annexe/{id}', [tperso_annexeConrtoller::class, 'update_data']);
Route::get("delete_perso_annexe/{id}", [tperso_annexeConrtoller::class, 'delete_data']);

Route::get("fetch_all_perso_dependant",[tperso_dependantConrtoller::class, 'all']);
Route::get("fetch_perso_dependant_agent/{refAgent}",[tperso_dependantConrtoller::class, 'fetch_depend_agent']);
Route::get("fetch_single_perso_dependant/{id}",[tperso_dependantConrtoller::class,'fetch_single']);
Route::post('insert_perso_dependant',[tperso_dependantConrtoller::class, 'insert_data']);
Route::post('update_perso_dependant/{id}', [tperso_dependantConrtoller::class, 'update_data']);
Route::get("delete_perso_dependant/{id}", [tperso_dependantConrtoller::class, 'delete_data']);
//==================== DetailAffectationRubrique==============================================
Route::get("fetch_detail_affectation_affect_agent/{refAffectation}",[tperso_detail_affectation_ribriqueController::class, 'fetch_detail_affectation_affect_agent']);
Route::get("fetch_all_DetailAffectationRubrique",[tperso_detail_affectation_ribriqueController::class, 'all']);
Route::get("fetch_DetailAffectationRubrique/{refAffectation}",[tperso_detail_affectation_ribriqueController::class,'fetch_affect_detail']);
Route::get("fetch_single_DetailAffectationRubrique/{id}",[tperso_detail_affectation_ribriqueController::class,'fetch_single']);
Route::post('insert_DetailAffectationRubriquet',[tperso_detail_affectation_ribriqueController::class, 'insert_data']);
Route::post('update_DetailAffectationRubrique{id}', [tperso_detail_affectation_ribriqueController::class, 'update_data']);
Route::get("delete_DetailAffectationRubrique/{id}", [tperso_detail_affectation_ribriqueController::class, 'delete_data']);

//fetch_detail_affectation_affect_agent
//==================== DetailPaiement==============================================
Route::get("fetch_all_DetailPaiement",[tperso_detail_paiement_salController::class, 'all']);
Route::get("fetch_DetailPaiement/{refEntetePaie}",[tperso_detail_paiement_salController::class,'fetch_entete_Detail']);
Route::get("fetch_single_DetailPaiement/{id}",[tperso_detail_paiement_salController::class,'fetch_single']);
Route::post('insert_DetailPaiement',[tperso_detail_paiement_salController::class, 'insert_data']);
Route::post('update_DetailPaiement{id}', [tperso_detail_paiement_salController::class, 'update_data']);
Route::get("delete_DetailPaiement/{id}", [tperso_detail_paiement_salController::class, 'delete_data']);
//====================EnteteConge==============================================
Route::get("fetch_all_EnteteConge",[tperso_entete_congeController::class, 'all']);
Route::get("fetch_EnteteConge/{refAffectation}",[tperso_entete_congeController::class,'fetch_affect_enteteConge']);
Route::get("fetch_single_EnteteConge/{id}",[tperso_entete_congeController::class,'fetch_single']);
Route::post('insert_EnteteConge',[tperso_entete_congeController::class, 'insert_data']);
Route::post('update_EnteteConge/{id}', [tperso_entete_congeController::class, 'update_data']);
Route::get("delete_EnteteConge/{id}", [tperso_entete_congeController::class, 'delete_data']);

//====================Entetepaiement==============================================
Route::get("fetch_all_Entetepaiement",[tperso_entete_paiementController::class, 'all']);
Route::get("fetch_entete_paiement_fiche/{refFichePaie}",[tperso_entete_paiementController::class,'fetch_entete_paiement_fiche']);
Route::get("fetch_single_Entetepaiement/{id}",[tperso_entete_paiementController::class,'fetch_single']);
Route::post('insert_Entetepaiement',[tperso_entete_paiementController::class, 'insert_data']);
Route::post('update_Entetepaiement{id}', [tperso_entete_paiementController::class, 'update_data']);
Route::get("delete_Entetepaiement/{id}", [tperso_entete_paiementController::class, 'delete_data']);

Route::get("fetch_all_paie_salaire",[tperso_detail_paie_salaireController::class, 'all']);
Route::get("fetch_paiement_salaire_fiche/{refFichePaie}",[tperso_detail_paie_salaireController::class,'fetch_entete_paiement_fiche']);
Route::get("fetch_single_paie_salaire/{id}",[tperso_detail_paie_salaireController::class,'fetch_single']);
Route::post('insert_paie_salaire',[tperso_detail_paie_salaireController::class, 'insert_data']);
Route::post('update_paie_salaire', [tperso_detail_paie_salaireController::class, 'update_data']);
Route::post('insert_Global_Paie_Salaire',[tperso_detail_paie_salaireController::class, 'insert_global_data']);
Route::get("delete_paie_salaire/{id}", [tperso_detail_paie_salaireController::class, 'delete_data']); 

//tperso_detail_paie_salaireController
//=====================FichePaie=================================== insert_gobal_data
Route::get("fetch_all_FichePaie",[tperso_fiche_paieController::class, 'all']);
Route::get("fetch_single_FichePaie/{id}",[tperso_fiche_paieController::class,'fetch_single']);
Route::post('insert_FichePaie',[tperso_fiche_paieController::class, 'insert_data']);
Route::post('insert_Global_FichePaie',[tperso_fiche_paieController::class, 'insert_global_data']);
Route::post('update_FichePaie/{id}', [tperso_fiche_paieController::class, 'updateData']);
Route::get("delete_FichePaie/{id}", [tperso_fiche_paieController::class, 'destroy']);

//====================maladieConge==============================================
Route::get("fetch_all_maladieConge",[tperso_maladie_congeController::class, 'all']);
Route::get("fetch_maladieConge/{refEnteteConge}",[tperso_maladie_congeController::class,'fetch_entete_maladieConge']);
Route::get("fetch_single_maladieConge/{id}",[tperso_maladie_congeController::class,'fetch_single']);
Route::post('insert_maladieConge',[tperso_maladie_congeController::class, 'insert_data']);
Route::post('update_maladieConge/{id}', [tperso_maladie_congeController::class, 'update_data']);
Route::get("delete_maladieConge/{id}", [tperso_maladie_congeController::class, 'delete_data']);
//====================maternite==============================================
Route::get("fetch_all_maternite",[tperso_materniteController::class, 'all']);
Route::get("fetch_maternite/{refEnteteConge}",[tperso_materniteController::class,'fetch_entete_maternite']);
Route::get("fetch_single_maternite/{id}",[tperso_materniteController::class,'fetch_single']);
Route::post('insert_maternite',[tperso_materniteController::class, 'insert_data']);
Route::post('update_maternite/{id}', [tperso_materniteController::class, 'update_data']);
Route::get("delete_maternite/{id}", [tperso_materniteController::class, 'delete_data']);

//=====================mois===================================
Route::get("fetch_all_mois",[tperso_moisController::class, 'index']);
Route::get("fetch_dopdown_mois",[tperso_moisController::class,'fetch_dropdown_2']);
Route::get("fetch_single_mois/{id}",[tperso_moisController::class,'edit']);
Route::post('insert_mois',[tperso_moisController::class, 'store']);
Route::post('update_mois/{id}', [tperso_moisController::class, 'store']);
Route::get("delete_mois/{id}", [tperso_moisController::class, 'destroy']);

//====================parametreRubrique==============================================
//fetch_parametre_categorie_agent($refCategorieAgent)
Route::get("fetch_all_parametre_rubrique",[tperso_parametre_rubriqueController::class, 'all']);
Route::get("fetch_parametre_categorie_agent/{refCategorieAgent}",[tperso_parametre_rubriqueController::class, 'fetch_parametre_categorie_agent']);
Route::get("fetch_single_parametre_rubrique/{id}",[tperso_parametre_rubriqueController::class,'fetch_single']);
Route::post('insert_parametre_rubrique',[tperso_parametre_rubriqueController::class, 'insert_data']);
Route::post('update_parametre_rubrique/{id}', [tperso_parametre_rubriqueController::class, 'update_data']);
Route::get("delete_parametre_rubrique/{id}", [tperso_parametre_rubriqueController::class, 'delete_data']);
//=====================raisonFamiliale===================================
Route::get("fetch_all_raisonFamiliale",[tperso_raison_familialeController::class, 'index']);
Route::get("fetch_dopdown_raisonFamiliale",[tperso_raison_familialeController::class,'fetch_dropdown_2']);
Route::get("fetch_single_raisonFamiliale/{id}",[tperso_raison_familialeController::class,'edit']);
Route::post('insert_raisonFamiliale',[tperso_raison_familialeController::class, 'store']);
Route::post('update_raisonFamiliale/{id}', [tperso_raison_familialeController::class, 'store']);
Route::get("delete_raisonFamiliale/{id}", [tperso_raison_familialeController::class, 'destroy']);

//=====================Rubrique===================================
Route::get("fetch_all_Rubrique",[tperso_rubriqueController::class, 'all']);
Route::get("fetch_dopdown_Rubrique",[tperso_rubriqueController::class,'fetch_dropdown_2']);
Route::get("fetch_single_Rubrique/{id}",[tperso_rubriqueController::class,'fetch_single']);
Route::post('insert_Rubrique',[tperso_rubriqueController::class, 'insert_data']);
Route::post('update_Rubrique/{id}', [tperso_rubriqueController::class, 'update_data']);
Route::get("delete_Rubrique/{id}", [tperso_rubriqueController::class, 'destroy']);
//=====================Service Personnel===================================
//fetch_service_personnel_categorie
Route::get("fetch_all_servicePerso",[tperso_service_personnelController::class, 'all']);
Route::get("fetch_service_personnel2",[tperso_service_personnelController::class,'fetch_service_personnel2']);
Route::get("fetch_service_personnel_categorie/{refCatService}",[tperso_service_personnelController::class,'fetch_service_personnel_categorie']);
Route::get("fetch_single_servicePerso/{id}",[tperso_service_personnelController::class,'fetch_single']);
Route::post('insert_servicePerso',[tperso_service_personnelController::class, 'insert_data']);
Route::post('update_servicePerso/{id}', [tperso_service_personnelController::class, 'update_data']);
Route::get("delete_servicePerso/{id}", [tperso_service_personnelController::class, 'destroy']);
//====================sortie_agent==============================================
Route::get("fetch_all_sortieAgent",[tperso_sortie_agentController::class, 'all']);
Route::get("fetch_sortieAgent/{refAffectation}",[tperso_sortie_agentController::class,'fetch_sortieAgent_affect']);
Route::get("fetch_single_sortieAgent/{id}",[tperso_sortie_agentController::class,'fetch_single']);
Route::post('insert_sortieAgent',[tperso_sortie_agentController::class, 'insert_data']);
Route::post('update_sortieAgent/{id}', [tperso_sortie_agentController::class, 'update_data']);
Route::get("delete_sortieAgent/{id}", [tperso_sortie_agentController::class, 'delete_data']);

// PARTIE MEDECIN ==================================================================

Route::get("fetch_fonctionmedecin", [tfonctionmedecinController::class, 'index']);
Route::get("fetch_single_fonctionmedecin/{id}",[tfonctionmedecinController::class,'edit']);
Route::get("delete_fonctionmedecin/{id}", [tfonctionmedecinController::class,'destroy']);
Route::post("insert_fonctionmedecin", [tfonctionmedecinController::class,'store']);
Route::get("destroyMessage/{id}", [tfonctionmedecinController::class, 'destroyMessage']);

Route::get("fetch_categoriemedecin", [tcategoriemedecinController::class, 'index']);
Route::get("fetch_single_categoriemedecin/{id}",[tcategoriemedecinController::class,'edit']);
Route::get("delete_categoriemedecin/{id}", [tcategoriemedecinController::class,'destroy']);
Route::post("insert_categoriemedecin", [tcategoriemedecinController::class,'store']);
Route::get("destroyMessage/{id}", [tcategoriemedecinController::class, 'destroyMessage']);

Route::get("fetch_agent", [tagentController::class, 'index']);
Route::get("fetch_list_agent", [tagentController::class, 'fetch_list_agent']);
Route::get("fetch_list_categoriemedecin", [tagentController::class, 'fetch_list_categorie']);
Route::get("fetch_list_fonctionmedecin", [tagentController::class, 'fetch_list_fonction']);
Route::get("fetch_single_agent/{id}", [tagentController::class, 'edit']);
Route::get("delete_agent/{id}", [tagentController::class, 'destroy']);
Route::post("insert_agent", [tagentController::class, 'insertData']);
Route::post("update_agent", [tagentController::class, 'updateData']);
Route::get("Profiletagent/{id}", [tagentController::class, 'ProfiletClient']);


Route::get("pdf_bonsortie_data", [BonSortieCaissePdfController::class, 'pdf_bon_data']);
Route::get("pdf_bonentree_data", [BonEntreeCaissePdfController::class, 'pdf_bon_data']); 
Route::get("fetch_rapport_sortie_banque_date", [BonSortieCaissePdfController::class, 'fetch_rapport_sortie_banque_date']);
Route::get("fetch_rapport_sortie_compte_date", [BonSortieCaissePdfController::class, 'fetch_rapport_sortie_compte_date']);
Route::get("fetch_rapport_entree_compte_date", [BonEntreeCaissePdfController::class, 'fetch_rapport_entree_compte_date']);
Route::get("fetch_rapport_entree_banque_date", [BonEntreeCaissePdfController::class, 'fetch_rapport_entree_banque_date']);

//fetch_rapport_entree_banque_date
//fetch_rapport_sortie_banque_date


//========================================================================================================

Route::get('/fetch_affectationrole', [tconf_affectation_menuController::class, 'all']);
Route::get('/fetch_single_affectationrole/{id}', [tconf_affectation_menuController::class, 'fetch_single_detail']);
Route::get('/fetch_affaction_role/{refRole}', [tconf_affectation_menuController::class, 'fetch_affaction_role']);   
Route::get('/fetch_menu_roles/{refRole}', [tconf_affectation_menuController::class, 'fetch_menu_roles']);        
Route::post('/insert_affectationrole', [tconf_affectation_menuController::class, 'insert_detail']);
Route::post('/update_affectationrole/{id}', [tconf_affectation_menuController::class, 'update_detail']);
Route::get('/delete_affectationrole/{id}', [tconf_affectation_menuController::class, 'delete_detail']);

Route::get('/fetch_crud_access', [tconf_crud_accessController::class, 'all']);
Route::get('/fetch_single_crud_access/{id}', [tconf_crud_accessController::class, 'fetch_single_detail']);
Route::get('/fetch_crud_access_role/{refRole}', [tconf_crud_accessController::class, 'fetch_affaction_role']);   
Route::get('/fetch_crud_access_roles_one/{refRole}', [tconf_crud_accessController::class, 'fetch_menu_roles']);        
Route::post('/insert_crud_access', [tconf_crud_accessController::class, 'insert_detail']);
Route::post('/update_crud_access/{id}', [tconf_crud_accessController::class, 'update_detail']);
Route::get('/delete_crud_access/{id}', [tconf_crud_accessController::class, 'delete_detail']);

Route::get("fetch_liste_menu", [tconf_list_menuController::class, 'index']);
Route::get("fetch_tconf_list_menu_2", [tconf_list_menuController::class, 'fetch_tconf_list_menu_2']);
Route::get("fetch_single_liste_menu/{id}",[tconf_list_menuController::class,'edit']);
Route::get("delete_liste_menu/{id}", [tconf_list_menuController::class,'destroy']);
Route::post("insert_liste_menu", [tconf_list_menuController::class,'store']);

Route::get("fetch_historique_information", [tconf_historique_informationController::class, 'index']);
Route::get("fetch_tconf_historique_information_2", [tconf_historique_informationController::class, 'fetch_tconf_historique_information_2']);
Route::get("desactiver_data", [tconf_historique_informationController::class, 'desactiver_data']);
Route::get("activer_data", [tconf_historique_informationController::class, 'activer_data']);
Route::get("fetch_historique_information_deleted", [tconf_historique_informationController::class, 'fetch_historique_information_deleted']);
Route::get("fetch_single_historique_information/{id}",[tconf_historique_informationController::class,'edit']);
Route::get("delete_historique_information/{id}", [tconf_historique_informationController::class,'destroy']);
Route::post("insert_historique_information", [tconf_historique_informationController::class,'store']);
Route::get("restore_historique_information/{id}", [tconf_historique_informationController::class,'restore']);
Route::get("restoreAll_historique_information/{id}", [tconf_historique_informationController::class,'restoreAll']);

//fetch_list_agent

//pdf_fiche_stock_vente


//fetch_all_user
/*
*les scripts commencent
*=====================
*pnud management project
*------------------------
*/



