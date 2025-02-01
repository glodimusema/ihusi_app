<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoControleCongeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_controle_conge', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refAffectation')->constrained('tperso_affectation_agent')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refAnne')->constrained('tperso_annee')->restrictOnUpdate()->restrictOnDelete();
            $table->integer('nbrJour');
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
        Schema::dropIfExists('tperso_controle_conge');
    }
}
