<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeEnteteEntreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_entete_entree', function (Blueprint $table) {
            $table->id();
            $table->string('code',225);
            $table->foreignId('refFournisseur')->constrained('tvente_fournisseur')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refRecquisition')->constrained('tvente_entete_requisition')->restrictOnUpdate()->restrictOnDelete()->nullable();
            $table->foreignId('module_id')->constrained('tvente_module')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('refService')->constrained('tvente_services')->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('dateEntree');
            $table->string('libelle',225);
            $table->string('transporteur',225);
            $table->integer('niveau1')->default(0);
            $table->integer('niveaumax')->default(0);
            $table->string('active')->default('OUI');
            $table->string('author',100);  
            $table->foreignId('refUser')->constrained('users')->restrictOnUpdate()->restrictOnDelete();
            $table->double('montant')->default(0);
            $table->timestamps();
        });
    }
//tvente_entete_entree
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tvente_entete_entree');
    }
}
