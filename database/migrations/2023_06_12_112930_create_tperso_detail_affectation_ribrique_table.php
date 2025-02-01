<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoDetailAffectationRibriqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_detail_affectation_ribrique', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refAffectation')->constrained('tperso_affectation_agent')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refParametre')->constrained('tperso_parametre_rubrique')->restrictOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('tperso_detail_affectation_ribrique');
    }
}
