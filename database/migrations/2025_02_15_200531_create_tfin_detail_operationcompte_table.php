<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTfinDetailOperationcompteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //'id','refEnteteOperation','refSscompte','typeOperation','montantOpration'
        Schema::create('tfin_detail_operationcompte', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteOperation')->constrained('tfin_entete_operationcompte')->restrictOnUpdate()->restrictOnDelete()->nullable();
            $table->foreignId('refSscompte')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete()->nullable();
            $table->string('typeOperation',20);
            $table->double('montantOpration');
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
        Schema::dropIfExists('tfin_detail_operationcompte');
    }
}
