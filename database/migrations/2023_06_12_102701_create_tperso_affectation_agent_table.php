<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoAffectationAgentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_affectation_agent', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refAgent')->constrained('tagent')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refServicePerso')->constrained('tperso_service_personnel')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refCategorieAgent')->constrained('tperso_categorie_agent')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refPoste')->constrained('tperso_poste')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refLieuAffectation')->constrained('tperso_lieuaffectation')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refMutuelle')->constrained('tperso_mutuelle')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refTypeContrat')->constrained('tperso_typecontrat')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('param_salaire_id')->constrained('tperso_parametre_salairebase')->restrictOnUpdate()->restrictOnDelete();
            $table->double('fammiliale')->default(0);
            $table->double('logement')->default(0);
            $table->double('transport')->default(0);
            $table->double('sal_brut')->default(0);
            $table->double('sal_brut_imposable')->default(0);
            $table->double('inss_qpo')->default(0);
            $table->double('inss_qpp')->default(0);
            $table->double('cnss')->default(0);
            $table->double('inpp')->default(0);
            $table->double('onem')->default(0);
            $table->double('ipr')->default(0);
            $table->string('mission')->default('NON');
            $table->date('dateAffectation');
            $table->integer('dureecontrat');
            $table->string('dureeLettre',50);
            $table->date('dateFin');
            $table->date('dateDebutEssaie');
            $table->date('dateFinEssaie');
            $table->string('JourTrail1',50);
            $table->string('JourTrail2',50);
            $table->string('heureTrail1',50);
            $table->string('heureTrail2',50);
            $table->string('TempsPause',50);
            $table->integer('nbrConge');
            $table->string('nbrCongeLettre',50);
            $table->string('nomOffice',50);
            $table->string('postnomOffice',50);
            $table->string('qualifieOffice',50);
            $table->string('codeAgent',50);
            $table->string('directeur',50);
            $table->string('numCNSS',50);
            $table->string('numImpot',50);
            $table->string('numcpteBanque',50);
            $table->string('BanqueAgant',50);
            $table->string('autresDetail',50);
            $table->string('conge')->default('OUI');
            $table->string('etat_contrat')->default('OUI');
            $table->string('author',50);
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
        Schema::dropIfExists('tperso_affectation_agent');
    }
}
