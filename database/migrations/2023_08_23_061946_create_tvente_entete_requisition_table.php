<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeEnteteRequisitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void //paie
     */
    public function up()
    {
        Schema::create('tvente_entete_requisition', function (Blueprint $table) {
            $table->id();
            $table->string('code',225);
            $table->foreignId('refFournisseur')->constrained('tvente_fournisseur')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('module_id')->constrained('tvente_module')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refService')->constrained('tvente_services')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateCmd');
            $table->string('libelle',225);
            $table->integer('niveau1')->default(0);
            $table->integer('niveaumax')->default(0);
            $table->string('cloture')->default('NON');
            $table->string('active')->default('OUI');
            $table->double('montant')->default(0);
            $table->double('paie')->default(0);
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
        Schema::dropIfExists('tvente_entete_requisition');
    }
}
