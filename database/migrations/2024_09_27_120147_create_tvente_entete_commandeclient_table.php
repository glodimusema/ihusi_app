<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeEnteteCommandeclientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_entete_commandeclient', function (Blueprint $table) {
            $table->id();
            $table->string('code',225);
            $table->foreignId('refClient')->constrained('tvente_client')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refService')->constrained('tvente_services')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refReservation')->constrained('thotel_reservation_chambre')->restrictOnUpdate()->restrictOnDelete()->default(0);
            $table->foreignId('module_id')->constrained('tvente_module')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('serveur_id')->constrained('tagent')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('table_id')->constrained('tvente_tables')->restrictOnUpdate()->restrictOnDelete();
            $table->string('etat_facture')->default("Crédit");
            $table->date('dateVente');
            $table->string('libelle',50);
            $table->double('montant')->default(0);
            $table->double('reduction')->default(0);
            $table->double('totaltva')->default(0);
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
        Schema::dropIfExists('tvente_entete_commandeclient');
    }
}
