<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeParametreTvaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_parametre_tva', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tva_id')->constrained('tvente_tva')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('module_id')->constrained('tvente_module')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('tvente_parametre_tva');
    }
}
