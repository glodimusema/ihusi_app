<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institution_id')->constrained('tperso_institution_stage')->cascadeOnUpdate()->cascadeOnDelete(); 
            $table->foreignId('personnel_id')->constrained('tagent')->cascadeOnUpdate()->cascadeOnDelete(); 
            $table->foreignId('option_id')->constrained('tperso_option_stage')->cascadeOnUpdate()->cascadeOnDelete(); 
            $table->foreignId('promotion_id')->constrained('tperso_promotion_stage')->cascadeOnUpdate()->cascadeOnDelete(); 
            $table->foreignId('annee_id')->constrained('tperso_annee_stage')->cascadeOnUpdate()->cascadeOnDelete(); 
            $table->foreignId('typestage_id')->constrained('tperso_type_stage')->cascadeOnUpdate()->cascadeOnDelete(); 
            $table->date('date_debut_stage');
            $table->date('date_fin_stage');
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tperso_stages');
    }
}
