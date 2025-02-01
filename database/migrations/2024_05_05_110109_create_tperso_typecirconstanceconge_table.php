<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoTypecirconstancecongeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_typecirconstanceconge', function (Blueprint $table) {
            $table->id();
            $table->string('nom_circontstance',100);
            $table->string('description_circons',100);
            $table->foreignId('categorie_id')->constrained('tperso_categorie_circonstance')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('nbrjour_cirscons')->default(0);
            $table->timestamps();
        });
    }

    //tperso_typecirconstanceconge  nom_circontstance,description_circons

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tperso_typecirconstanceconge');
    }
}
