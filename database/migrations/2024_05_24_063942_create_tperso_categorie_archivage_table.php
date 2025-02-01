<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoCategorieArchivageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_categorie_archivage', function (Blueprint $table) {
            $table->id();
            $table->string('name_categorie'); 
            $table->string('description_categorie'); 
            $table->string('author'); 
            $table->timestamps();
        });
    }

    //tperso_division id,name_division,description_division,author
    //tperso_categorie_archivage id,name_categorie,description_categorie,author

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tperso_categorie_archivage');
    }
}
