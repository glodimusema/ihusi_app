<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThotelReservationSalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thotel_reservation_salle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refClient')->constrained('tvente_client')->restrictOnUpdate()->restrictOnDelete(); 
            $table->foreignId('refSalle')->constrained('thotel_salle')->restrictOnUpdate()->restrictOnDelete(); 
            $table->date('date_ceremonie');
            $table->timestamp('heure_debut');
            $table->timestamp('heure_sortie');
            $table->date('date_reservation');
            $table->double('prix_unitaire');
            $table->string('devise',10);
            $table->double('taux');
            $table->double('reduction');
            $table->string('observation',200);
            $table->double('totalPaie')->default(0);
            $table->string('author',100); 
            $table->foreignId('refUser')->constrained('users')->restrictOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

//devise

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thotel_reservation_salle');
    }
}
