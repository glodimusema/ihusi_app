<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeProduitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_produit', function (Blueprint $table) {
            $table->id();
            $table->string('designation',100)->unique(); 
            $table->foreignId('refCategorie')->constrained('tvente_categorie_produit')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refUniteBase')->constrained('tvente_unite')->restrictOnUpdate()->restrictOnDelete();
            $table->string('uniteBase'); 
            $table->double('pu');
            $table->double('qte');
            $table->double('cmup');            
            $table->string('devise');
            $table->string('taux');
            $table->double('stock_alerte')->default(0); 
            $table->string('Oldcode',100)->default('0000');
            $table->string('Newcode',100)->default('0000');            
            $table->string('tvaapplique',5)->default('OUI');
            $table->string('estvendable',5)->default('OUI');
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
        Schema::dropIfExists('tvente_produit');
    }
}
