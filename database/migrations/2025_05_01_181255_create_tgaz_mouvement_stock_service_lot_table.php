<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTgazMouvementStockServiceLotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tgaz_mouvement_stock_service_lot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idStockService')->constrained('tgaz_stock_service_lot')->restrictOnUpdate()->restrictOnDelete()->default(0);                       
            $table->date('dateMvt'); 
            $table->string('type_mouvement')->default('Entree');
            $table->string('libelle_mouvement',50);
            $table->string('nom_table',50);
            $table->integer('id_data');
            $table->double('puMvt');
            $table->double('qteMvt');
            $table->string('uniteMvt');
            $table->double('cmupMvt');
            $table->string('devise',50);
            $table->double('taux');           
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
        Schema::dropIfExists('tgaz_mouvement_stock_service_lot');
    }
}
