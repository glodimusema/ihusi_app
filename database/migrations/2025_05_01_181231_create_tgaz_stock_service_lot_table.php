<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTgazStockServiceLotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tgaz_stock_service_lot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refService')->constrained('tvente_services')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refLot')->constrained('tgaz_lot')->restrictOnUpdate()->restrictOnDelete();
            $table->double('pu_lot');
            $table->double('qte_lot');
            $table->double('cmup_lot');            
            $table->string('devise');
            $table->string('taux');
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
        Schema::dropIfExists('tgaz_stock_service_lot');
    }
}
