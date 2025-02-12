<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtTresoDetailEtatbesoinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    //refEntete,refRubrique,Qte,PU

    public function up()
    {
        Schema::create('tt_treso_detail_etatbesoin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEntete')->constrained('ttreso_entete_angagement')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refRubrique')->constrained('tt_treso_rubrique')->restrictOnUpdate()->restrictOnDelete();
            $table->string('service_beneficiaire',100);
            $table->double('Qte');
            $table->double('PU');
            $table->double('taux');
            $table->string('devise',10);
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
        Schema::dropIfExists('tt_treso_detail_etatbesoin');
    }
}
