<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTcarEnteteMouvementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcar_entete_mouvement', function (Blueprint $table) {
            $table->id();
            $table->integer('refVehicule');  
            $table->integer('refProvenance');        
            $table->date('dateMvt');
            $table->string('numBS',50);
            $table->string('numCD',50);
            $table->string('numSR',50);
            $table->string('Chauffeur',50);
            $table->string('author',50);
            $table->timestamps();
        });
    }

    //id,refVehicule,refProvenance,dateMvt,numBS,numCD,numSR,Chauffeur,author tcar_entete_mouvement

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tcar_entete_mouvement');
    }
}
