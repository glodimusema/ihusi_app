<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTgazDetailTransfertTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //refProduit
        Schema::create('tgaz_detail_transfert', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteTransfert')->constrained('tgaz_entete_transfert')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('refDestination')->constrained('tvente_services')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('idStockService')->constrained('tgaz_stock_service_lot')->restrictOnUpdate()->restrictOnDelete()->default(0);
            $table->foreignId('refLot')->constrained('tgaz_lot')->restrictOnUpdate()->restrictOnDelete()->default(0);
            $table->double('puTransfert');
            $table->double('qteTransfert');
            $table->string('uniteTransfert'); 
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
        Schema::dropIfExists('tgaz_detail_transfert');
    }
}
