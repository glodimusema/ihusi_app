<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeEnteteCuisineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_entete_cuisine', function (Blueprint $table) {
            $table->id();
            $table->string('code',225);
            $table->foreignId('refClient')->constrained('tvente_client')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refService')->constrained('tvente_services')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refReservation')->constrained('thotel_reservation_chambre')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('module_id')->constrained('tvente_module')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('serveur_id')->constrained('tagent')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('table_id')->constrained('tvente_tables')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateVente');
            $table->string('libelle',50);
            $table->string('author',100); 
            $table->string('estServie',50)->default('OUI');
            $table->double('montant')->default(0);
            $table->double('reduction')->default(0);
            $table->double('totaltva')->default(0); 
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
        Schema::dropIfExists('tvente_entete_cuisine');
    }
}
