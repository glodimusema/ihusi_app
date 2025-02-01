<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeDetailFactureGroupeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_detail_facture_groupe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteGroup')->constrained('tvente_entete_facture_groupe')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('id_vente')->constrained('tvente_entete_vente')->restrictOnUpdate()->restrictOnDelete()->nullable();
            $table->foreignId('id_reservation')->constrained('thotel_reservation_chambre')->restrictOnUpdate()->restrictOnDelete()->nullable();
            $table->string('active')->default('OUI');
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
        Schema::dropIfExists('tvente_detail_facture_groupe');
    }
}
