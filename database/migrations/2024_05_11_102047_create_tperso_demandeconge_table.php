<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoDemandecongeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_demandeconge', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affectation_id')->constrained('tperso_affectation_agent')->cascadeOnUpdate()->cascadeOnDelete(); 
            $table->foreignId('typecircintance_id')->constrained('tperso_typecirconstanceconge')->cascadeOnUpdate()->cascadeOnDelete(); 
            $table->foreignId('annee_id')->constrained('tperso_annee')->restrictOnUpdate()->restrictOnDelete();
            $table->text('description_conge');
            $table->date('date_demande');
            $table->date('date_depart');
            $table->integer('nbr_joursollicite');
            $table->date('date_reprise');
            $table->string('superviseur_conge',100);
            $table->string('interimaire_conge',100);
            $table->text('resumetache_conge');
            $table->string('admin_fin_conge',100);
            $table->string('rh_conge',100);
            $table->string('coordinateur_conge',100);
            $table->string('directeur_conge',100);
            $table->string('congess')->default('NON');

            $table->date('date_debut_accord');
            $table->date('date_fin_accord');
            $table->integer('nbr_jouraccord')->default(0);

            $table->integer('cumul_conge_annee')->default(0);
            $table->integer('solde_conge_datedu')->default(0);
            $table->integer('solde_conge_reprise')->default(0);

            $table->string('author',100);
            $table->timestamps();
        });
    }

//id,affectation_id,typecircintance_id,description_conge,date_demande,date_depart,
//nbr_joursollicite,date_reprise,superviseur_conge,interimaire_conge,resumetache_conge
//rh_conge, coordinateur_conge,directeur_conge,congess,author   tperso_demandeconge

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tperso_demandeconge');
    }
}
