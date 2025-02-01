<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTcarDetailEntreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcar_detail_entree', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteMvt')->constrained('tcar_entete_mouvement')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refProduit')->constrained('tcar_produit')->restrictOnUpdate()->restrictOnDelete();
            $table->double('puEntree');
            $table->double('qteEntree');
            $table->string('devise');
            $table->string('taux');
            $table->string('author',100);  
            $table->foreignId('refUser')->constrained('users')->restrictOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    //id,refEnteteMvt,refProduit,puEntree,qteEntree,devise,taux,author tcar_detail_entree

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tcar_detail_entree');
    }
}
