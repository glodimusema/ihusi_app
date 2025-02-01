<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoSortieAgentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_sortie_agent', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refAffectation')->constrained('tperso_affectation_agent')->restrictOnUpdate()->restrictOnDelete();
            $table->string('heureSortie');
            $table->string('heureRetourPrevue');
            $table->date('dateSortie');
            $table->string('motif');
            $table->string('heureRetour');
            $table->date('dateRetour');
            $table->string('annexeSortie');
            $table->string('libelleannexe');
            $table->string('viseBRH');
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
        Schema::dropIfExists('_tperso_sortie_agent');
    }
}
