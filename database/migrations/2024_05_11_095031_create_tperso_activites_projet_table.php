<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoActivitesProjetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_activites_projet', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projet_id')->constrained('tperso_projets')->cascadeOnUpdate()->cascadeOnDelete(); 
            $table->text('description_tache');
            $table->date('date_debut_tache');
            $table->integer('duree_tache');
            $table->date('date_fin_tache');
            $table->integer('nbr_heureJour');
            $table->double('cout_heure');
            $table->string('statut_tache',20)->default('Attente');
            $table->string('author',100);
            $table->timestamps();
        });
    }

    //id,nom_org, adresse_org, contact_org, rccm_org, idnat_org, author, photo  tperso_partenaire
    //id,partenaire_id, typecontrat_id, description_projet, chef_projet, date_debut_projet, date_fin_projet, author   tperso_projets
    //id, projet_id, description_tache, date_debut_tache, date_fin_tache, nbr_heureJour, cout_heure, author   tperso_activites_projet

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tperso_activites_projet');
    }
}
