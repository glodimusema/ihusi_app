<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoDemandeSoinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {//
        Schema::create('tperso_demande_soin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refAffectation')->constrained('tperso_affectation_agent')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refMois')->constrained('tperso_mois')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refAnnee')->constrained('tperso_annee')->restrictOnUpdate()->restrictOnDelete();
            $table->string('malade');
            $table->string('sexe');
            $table->date('datenaissance');
            $table->string('degreparente');
            $table->string('medecinConsultant');
            $table->string('divRH');
            $table->string('AG');
            $table->date('dateDemande');
            $table->double('factures')->default(0);
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
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
        Schema::dropIfExists('tperso_demande_soin');
    }
}
