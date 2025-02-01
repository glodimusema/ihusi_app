<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoAppreciationAgentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_appreciation_agent', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refAffectation')->constrained('tperso_affectation_agent')->restrictOnUpdate()->restrictOnDelete();
            $table->string('periodeDu');
            $table->string('connaissanceTheorique');
            $table->string('appliDeontologie');
            $table->string('manipulation');
            $table->string('prendConsideration');
            $table->string('ponctualite');
            $table->string('ordre');
            $table->string('fiabilite');
            $table->string('espritEquipe');
            $table->string('courtoisie');
            $table->string('sensResponsabilite');
            $table->string('sensEcoute');
            $table->string('preparationExecution');
            $table->string('organiseTravail');
            $table->string('Propositions');
            $table->string('dateAppreciation');
            $table->string('agent');
            $table->string('suiveur');
            $table->string('hierarchie');
            $table->string('rh');
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
        Schema::dropIfExists('tperso_appreciation_agent');
    }
}
