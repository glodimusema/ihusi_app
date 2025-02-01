<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThotelIncidentReservationSalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thotel_incident_reservation_salle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refReservation')->constrained('thotel_reservation_salle')->restrictOnUpdate()->restrictOnDelete(); 
            $table->double('montant_incident');
            $table->string('devise',5);
            $table->double('taux');
            $table->string('autres_details',300);
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
        Schema::dropIfExists('thotel_incident_reservation_salle');
    }
}
