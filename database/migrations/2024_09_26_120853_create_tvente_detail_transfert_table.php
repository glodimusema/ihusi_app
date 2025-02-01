<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeDetailTransfertTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_detail_transfert', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteTransfert')->constrained('tvente_entete_transfert')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('refProduit')->constrained('tvente_produit')->cascadeOnUpdate()->cascadeOnDelete(); 
            $table->foreignId('refDestination')->constrained('tvente_services')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('idStockService')->constrained('tvente_stock_service')->restrictOnUpdate()->restrictOnDelete()->default(0);
            $table->double('puTransfert');
            $table->double('qteTransfert');
            $table->string('uniteTransfert'); 

            $table->double('puBase');
            $table->double('qteBase');
            $table->string('uniteBase');

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
        Schema::dropIfExists('tvente_detail_transfert');
    }
}
