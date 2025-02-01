<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTlogProduitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tlog_produit', function (Blueprint $table) {
            $table->id();
            $table->string('designation',100)->unique(); 
            $table->double('pu');
            $table->double('qte');
            $table->foreignId('refCategorie')->constrained('tvente_categorie_produit')->restrictOnUpdate()->restrictOnDelete(); 
            $table->foreignId('refEnplacement')->constrained('tlog_emplacements')->restrictOnUpdate()->restrictOnDelete(); 
            $table->string('devise');
            $table->string('taux');
            $table->string('unite'); 
            $table->string('author',100);
            $table->timestamps();
        });
    }
//qte
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tlog_produit');
    }
}
