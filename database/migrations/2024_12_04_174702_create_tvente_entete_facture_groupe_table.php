<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeEnteteFactureGroupeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_entete_facture_groupe', function (Blueprint $table) {
            $table->id();
            $table->string('code',225);
            $table->foreignId('refOrganisation')->constrained('tvente_client')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('module_id')->constrained('tvente_module')->restrictOnUpdate()->restrictOnDelete();
            $table->string('etat_facture_group')->default("Crédit");
            $table->date('dateGroup');
            $table->string('libelle_group',50);
            $table->double('montant_group')->default(0);
            $table->double('reduction_group')->default(0);
            $table->double('totaltva_group')->default(0);
            $table->double('paie_group')->default(0);
            $table->date('date_paie_current_group')->nullable();
            $table->double('nombre_print_group')->default(0);
            $table->string('author',100);  
            $table->foreignId('refUser')->constrained('users')->restrictOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('tvente_entete_facture_groupe');
    }
}
