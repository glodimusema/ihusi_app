<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtresoEnteteAngagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    

    public function up()
    {
        Schema::create('ttreso_entete_angagement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refProvenance')->constrained('tt_treso_provenance')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refBloc')->constrained('tt_treso_bloc')->restrictOnUpdate()->restrictOnDelete();
            $table->string('motif',100);
            $table->datetime('dateEngagement');

            $table->datetime('dateValiderDemandeur')->nullable();
            $table->string('StatutValiderDemandeur',5)->nullable();
            $table->string('ValiderDemandeur',50)->nullable();            

            $table->datetime('dateValidertDivision')->nullable();
            $table->string('StatutValiderDivision',5)->nullable();
            $table->string('ValiderDivision',50)->nullable();   
            
            $table->datetime('dateAtesterDivision')->nullable();
            $table->string('StatutAtesterDivision',5)->nullable();
            $table->string('Atesterterdivision',50)->nullable();   

            $table->datetime('dateValiderTresorerie')->nullable();
            $table->string('ValiderStatuttresorerie',5)->nullable();
            $table->string('ValiderTresorerie',50)->nullable();    

            $table->datetime('dateAtesterTresorerie')->nullable();
            $table->string('StatutAtesterTresorerie',5)->nullable();
            $table->string('AtesterterTresorier',50)->nullable();
            
            $table->datetime('dateValiderAdministration')->nullable();
            $table->string('ValiderStatutAdministration',5)->nullable();
            $table->string('ValiderAdministrateur',50)->nullable(); 

            $table->datetime('dateAtesterAdministration')->nullable();
            $table->string('StatutAtesterAdministration',5)->nullable();
            $table->string('AtesterterAdministrateur',50)->nullable();

            $table->datetime('dateValiderDirection')->nullable();
            $table->string('ValiderStatutDirection',5)->nullable();
            $table->string('ValiderDirecteur',50)->nullable();

            $table->datetime('dateAtesterDirection')->nullable();
            $table->string('StatutAtesterDirection',5)->nullable();
            $table->string('AtesterterDirecteur',50)->nullable();

            $table->datetime('dateValidertGerant')->nullable();
            $table->string('ValiderStatutGerant',5)->nullable();
            $table->string('ValiderGerant',50)->nullable();

            $table->datetime('dateAtesterGerant')->nullable();
            $table->string('StatutAtesterGerant',5)->nullable();
            $table->string('AtesterterGerant',50)->nullable();
           
            $table->string('refEtatbesoin',100)->nullable();
            $table->string('author',100);  
            $table->foreignId('refUser')->constrained('users')->restrictOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    //refProvenance,refBloc,motif,dateEngagement,refEtatbesoin,author

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ttreso_entete_angagement');
    }
}
