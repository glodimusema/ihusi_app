<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTgazDetailUtilisationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tgaz_detail_utilisation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteVente')->constrained('tgaz_entete_utilisation')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('idStockService')->constrained('tgaz_stock_service_lot')->restrictOnUpdate()->restrictOnDelete()->default(0);
            $table->double('puVente');
            $table->double('qteVente');
            $table->string('uniteVente');
            $table->double('cmupVente');
            $table->string('devise',50);
            $table->double('taux');
            $table->double('montanttva')->default(0);
            $table->double('montantreduction')->default(0);
            $table->string('type_sortie')->default('Casse');
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
        Schema::dropIfExists('tgaz_detail_utilisation');
    }
}
