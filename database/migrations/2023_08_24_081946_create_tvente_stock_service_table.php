<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeStockServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //,'unitePivot','qtePivot'
        Schema::create('tvente_stock_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refService')->constrained('tvente_services')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refProduit')->constrained('tvente_produit')->restrictOnUpdate()->restrictOnDelete();
            $table->double('pu');
            $table->double('qte');
            $table->string('uniteBase');
            $table->double('cmup');            
            $table->string('devise');
            $table->string('taux');
            $table->string('unitePivot');
            $table->double('qtePivot'); 
            $table->string('active')->default('OUI');
            $table->foreignId('refUser')->constrained('users')->restrictOnUpdate()->restrictOnDelete();
            $table->string('author',100);
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
        Schema::dropIfExists('tvente_stock_service');
    }
}
