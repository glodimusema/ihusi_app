<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntreprisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->integer('ceo');
            $table->string('nomEntreprise', 250);
            
            $table->text('descriptionEntreprise');
            $table->string('emailEntreprise', 250);
            $table->string('adresseEntreprise', 250);
            $table->string('telephoneEntreprise', 250);
            $table->text('solutionEntreprise');
            $table->string('rccm', 250);
            $table->integer('etat')->default(0);

            $table->integer('idsecteur');
            $table->integer('idforme');
            $table->integer('idPays');
            $table->integer('idProvince');

            $table->string('edition', 250);
            $table->string('facebook', 250);
            $table->string('linkedin', 250);
            $table->string('twitter', 250);
            $table->string('siteweb', 250);
            $table->string('invPersonnel', 250);
            $table->string('invHub', 250);
            $table->string('invRecherche', 250);
            $table->string('chiffreAffaire', 250);
            $table->string('nbremploye', 250);
            $table->string('logo', 250);
            $table->string('slug', 250);

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
        Schema::dropIfExists('entreprises');
    }
}
