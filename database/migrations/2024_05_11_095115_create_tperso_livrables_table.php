<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoLivrablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_livrables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activite_id')->constrained('tperso_activites_projet')->cascadeOnUpdate()->cascadeOnDelete(); 
            $table->text('designation_livrable');
            $table->text('description_livrable');
            $table->string('fichiers',100);
            $table->string('statut_livrable',10)->default('NON');
            $table->string('author',100);
            $table->timestamps();
        });
    }

    //id,nom_org, adresse_org, contact_org, rccm_org, idnat_org, author, photo  tperso_partenaire
    //id,partenaire_id, typecontrat_id, description_projet, chef_projet, date_debut_projet, date_fin_projet, author   tperso_projets
    //id, projet_id, description_tache, date_debut_tache, date_fin_tache, nbr_heureJour, cout_heure, author   tperso_activites_projet
    //id, activite_id, designation_livrable, description_livrable, fichiers, statut_livrable, author   tperso_livrables

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tperso_livrables');
    }
}
