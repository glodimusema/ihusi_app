<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoServiceArchivageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_service_archivage', function (Blueprint $table) {
            $table->id();
            $table->string('name_service'); 
            $table->string('description_service'); 
            $table->foreignId('categorie_id')->constrained('tperso_categorie_archivage')->cascadeOnUpdate()->cascadeOnDelete(); 
            $table->foreignId('division_id')->constrained('tperso_division')->cascadeOnUpdate()->cascadeOnDelete(); 
            $table->string('author'); 
            $table->timestamps();
        });
    }

    //tperso_division id,name_division,description_division,author
    //tperso_categorie_archivage id,name_categorie,description_categorie,author
    //tperso_service_archivage id,name_service,description_service,categorie_id,division_id,author
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tperso_service_archivage');
    }
}
