<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThotelBillardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thotel_billard', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refClient')->constrained('tvente_client')->restrictOnUpdate()->restrictOnDelete(); 
            $table->double('montant_paie');
            $table->string('devise',5);
            $table->double('taux');
            $table->date('date_paie');
            $table->dateTime('heure_debut');
            $table->dateTime('heure_fin');
            $table->string('libelle',200);
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
        Schema::dropIfExists('thotel_billard');
    }
}
