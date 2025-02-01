<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeEnteteTransfertTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_entete_transfert', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refService')->constrained('tvente_services')->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('date_transfert');
            $table->foreignId('module_id')->constrained('tvente_module')->restrictOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('tvente_entete_transfert');
    }
}
