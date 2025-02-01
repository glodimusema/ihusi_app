<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoAvanceSalaireTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //id,refAffectation,refAnne,refMois,montant_avance,author
        Schema::create('tperso_avance_salaire', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refAffectation')->constrained('tperso_affectation_agent')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refMois')->constrained('tperso_mois')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refAnne')->constrained('tperso_annee')->restrictOnUpdate()->restrictOnDelete();
            $table->double('montant_avance');
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
        Schema::dropIfExists('tperso_avance_salaire');
    }
}
