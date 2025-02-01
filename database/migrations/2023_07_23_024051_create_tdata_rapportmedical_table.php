<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdataRapportmedicalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdata_rapportmedical', function (Blueprint $table) {
            $table->id();
            $table->integer('refPatient');                               
            $table->string('plainte_med'); 
            $table->string('historique_med'); 
            $table->string('antecedent_med');           
            $table->string('examenphysique_med'); 
            $table->string('diagnostic_med'); 
            $table->string('examenparaclinique_med');
            $table->string('traitement_med');
            $table->string('evolution_med');
            $table->string('libelle_med');
            $table->string('date_med'); 
            $table->string('medecin_med'); 
            $table->string('specialite_med'); 
            $table->string('cnom_med');            
            $table->string('author');
            $table->string('Hopital');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tdata_rapportmedical');
    }
}
