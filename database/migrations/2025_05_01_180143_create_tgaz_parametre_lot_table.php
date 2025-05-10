<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTgazParametreLotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tgaz_parametre_lot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refProduit')->constrained('tvente_produit')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refLot')->constrained('tgaz_lot')->restrictOnUpdate()->restrictOnDelete();
            $table->double('pu_param',8,2);
            $table->double('qte_param',8,2);
            $table->string('autre_detail',100);
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
        Schema::dropIfExists('tgaz_parametre_lot');
    }
}
