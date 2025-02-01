<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeEntetePaiementGroupeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_entete_paiement_groupe', function (Blueprint $table) {
            $table->id();
            $table->string('code',225);
            $table->foreignId('refFactureGroup')->constrained('tvente_entete_facture_groupe')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('module_id')->constrained('tvente_module')->restrictOnUpdate()->restrictOnDelete();
            $table->date('datePaieGroup');
            $table->string('libelle_paie_group',50);
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
        Schema::dropIfExists('tvente_entete_paiement_groupe');
    }
}
