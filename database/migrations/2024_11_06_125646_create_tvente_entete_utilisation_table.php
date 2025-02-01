<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeEnteteUtilisationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_entete_utilisation', function (Blueprint $table) {
            $table->id();
            $table->string('code',225);
            $table->foreignId('refService')->constrained('tvente_services')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('module_id')->constrained('tvente_module')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('agent_id')->constrained('tagent')->restrictOnUpdate()->restrictOnDelete();            
            $table->date('dateUse');
            $table->string('libelle',50);
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
        Schema::dropIfExists('tvente_entete_utilisation');
    }
}
