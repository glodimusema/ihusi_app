<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoParcoursStageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_parcours_stage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stage_id')->constrained('tperso_stages')->cascadeOnUpdate()->cascadeOnDelete(); 
            $table->foreignId('service_id')->constrained('tperso_service_personnel')->cascadeOnUpdate()->cascadeOnDelete();             
            $table->date('date_debut_parcours');
            $table->date('date_fin_parcours');
            $table->string('tache_parcours');
            $table->string('apprecition_parcours');
            $table->string('author'); 
            $table->timestamps();
        });
    }

    //tperso_division id,name_division,description_division,author
    //tperso_categorie_archivage id,name_categorie,description_categorie,author
    //tperso_service_archivage id,name_service,description_service,categorie_id,division_id,author
    //tperso_archivages id,name_archive,description_archive,fichier_archive,service_id,author
    //tperso_promotion_stage id,name_promotion,author
    //tperso_domaine_stage id,name_domaine,author
    //tperso_option_stage id,name_option,domaine_id,author
    //tperso_annee_stage id,name_annee,author
    //tperso_institution_stage id,name_institution,adresse_institution,contact_institution,mail_institution,author
    //tperso_stages id,institution_id,personnel_id,option_id,promotion_id,annee_id,date_debut_stage,date_fin_stage,author
    //tperso_parcours_stage id,stage_id,service_id,date_debut_parcours,date_fin_parcours,tache_parcours,apprecition_parcours,author

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tperso_parcours_stage');
    }
}
