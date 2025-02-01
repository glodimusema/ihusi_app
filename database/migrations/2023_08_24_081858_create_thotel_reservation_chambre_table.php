<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThotelReservationChambreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 'id','refClient','refChmabre','date_entree','date_sortie','heure_debut',
        // 'heure_sortie','libelle','prix_unitaire','devise','taux','reduction',
        // 'observation','type_reservation','nom_accompagner','pays_provenance','totalPaie','author'
        Schema::create('thotel_reservation_chambre', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refClient')->constrained('tvente_client')->restrictOnUpdate()->restrictOnDelete(); 
            $table->foreignId('refChmabre')->constrained('thotel_chambre')->restrictOnUpdate()->restrictOnDelete(); 
            $table->foreignId('id_prise_charge')->constrained('tvente_client')->restrictOnUpdate()->restrictOnDelete(); 
            $table->date('date_entree');
            $table->date('date_sortie');
            $table->timestamp('heure_debut');
            $table->timestamp('heure_sortie');
            $table->string('libelle',200);
            $table->double('prix_unitaire');
            $table->string('devise',5);
            $table->double('taux');
            $table->double('reduction');
            $table->string('observation',200);
            $table->string('type_reservation',50);
            $table->string('nom_accompagner',100);
            $table->string('pays_provenance',100);
            $table->double('totalPaie')->default(0);
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
        Schema::dropIfExists('thotel_reservation_chambre');
    }
}
