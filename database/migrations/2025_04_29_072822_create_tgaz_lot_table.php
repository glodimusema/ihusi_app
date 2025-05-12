<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTgazLotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tgaz_lot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refCategorieLot')->constrained('tgaz_categorie_lot')->restrictOnUpdate()->restrictOnDelete();
            $table->string('nom_lot',225); 
            $table->string('code_lot',225);
            $table->string('unite_lot',225);
            $table->double('stock_alerte')->default(0);            
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
        Schema::dropIfExists('tgaz_lot');
    }
}
