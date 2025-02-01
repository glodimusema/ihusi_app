<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoPromotionStageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_promotion_stage', function (Blueprint $table) {
            $table->id();
            $table->string('name_promotion'); 
            $table->string('author');
            $table->timestamps();
        });
    }

    //tperso_division id,name_division,description_division,author
    //tperso_categorie_archivage id,name_categorie,description_categorie,author
    //tperso_service_archivage id,name_service,description_service,categorie_id,division_id,author
    //tperso_archivages id,name_archive,description_archive,fichier_archive,service_id,author
    //tperso_promotion_stage id,name_promotion,author


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tperso_promotion_stage');
    }
}
