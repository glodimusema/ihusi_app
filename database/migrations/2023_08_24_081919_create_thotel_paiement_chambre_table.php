<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThotelPaiementChambreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thotel_paiement_chambre', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refReservation')->constrained('thotel_reservation_chambre')->restrictOnUpdate()->restrictOnDelete(); 
            $table->double('montant_paie');
            $table->string('devise',5);
            $table->double('taux');
            $table->date('date_paie');
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
        Schema::dropIfExists('thotel_paiement_chambre');
    }
}
