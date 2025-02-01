<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoParametreRubriqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_parametre_rubrique', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refRubrique')->constrained('tperso_rubrique')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refCategorieAgent')->constrained('tperso_categorie_agent')->restrictOnUpdate()->restrictOnDelete();
            $table->double('montant');
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
        Schema::dropIfExists('tperso_parametre_rubrique');
    }
}
