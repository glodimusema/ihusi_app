<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoProjetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_projets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partenaire_id')->constrained('tperso_partenaire')->cascadeOnUpdate()->cascadeOnDelete(); 
            $table->foreignId('typecontrat_id')->constrained('tperso_typecontrat')->cascadeOnUpdate()->cascadeOnDelete(); 
            $table->text('description_projet');
            $table->string('chef_projet',100);
            $table->date('date_debut_projet');
            $table->integer('duree_projet');
            $table->date('date_fin_projet');
            $table->string('author',100);
            $table->timestamps();
        });
    }

    //duree_projet, duree_tache

    //id,nom_org, adresse_org, contact_org, rccm_org, idnat_org, author, photo  tperso_partenaire
    //id,partenaire_id, typecontrat_id, description_projet, chef_projet, date_debut_projet, date_fin_projet, author tperso_projets

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tperso_projets');
    }
}
