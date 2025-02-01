<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoParametreSalairebaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_parametre_salairebase', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categorie_id')->constrained('tperso_poste')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('projet_id')->constrained('tperso_projets')->cascadeOnUpdate()->cascadeOnDelete(); 
            $table->double('salaire_base')->default(0);
            $table->double('salaire_prevu')->default(0);
            $table->string('author',100);
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
        Schema::dropIfExists('tperso_parametre_salairebase');
    }
}
