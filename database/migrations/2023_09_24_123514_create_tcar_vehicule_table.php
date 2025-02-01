<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTcarVehiculeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcar_vehicule', function (Blueprint $table) {
            $table->id();
            $table->string('nom_vehicule',100); 
            $table->string('marque',100); 
            $table->string('couleur',100); 
            $table->string('numPlaque',100); 
            $table->string('author',100);
            $table->timestamps();
        });
    }

    //id,nom_vehicule,marque,couleur,numPlaque,author

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tcar_vehicule');
    }
}
