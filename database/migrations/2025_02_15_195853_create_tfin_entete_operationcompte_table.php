<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTfinEnteteOperationcompteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tfin_entete_operationcompte', function (Blueprint $table) {
            $table->id();
            $table->string('libelleOperation',250);
            $table->date('dateOpration');
            $table->foreignId('refTresorerie')->constrained('tconf_banque')->restrictOnUpdate()->restrictOnDelete()->nullable();
            $table->string('numOpereation',20);
            $table->double('tauxdujour');
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
        Schema::dropIfExists('tfin_entete_operationcompte');
    }
}
