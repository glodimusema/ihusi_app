<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoDependantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_dependant', function (Blueprint $table) {
            $table->id();
            $table->string('noms_dependant');
            $table->foreignId('refAgent')->constrained('tagent')->restrictOnUpdate()->restrictOnDelete();
            $table->string('sexe');
            $table->string('date_naissance');
            $table->string('etat_civile');
            $table->string('degre_parente');
            $table->string('annexe');
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
        Schema::dropIfExists('tperso_dependant');
    }
}
