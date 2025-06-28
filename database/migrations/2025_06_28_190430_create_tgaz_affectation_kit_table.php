<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTgazAffectationKitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tgaz_affectation_kit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kit_lot')->constrained('tgaz_lot')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('id_gaz')->constrained('tgaz_lot')->restrictOnUpdate()->restrictOnDelete();
            $table->double('qte_gaz')->default(0);
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
        Schema::dropIfExists('tgaz_affectation_kit');
    }
}
