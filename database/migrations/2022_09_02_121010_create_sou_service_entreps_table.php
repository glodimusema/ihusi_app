<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSouServiceEntrepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sou_service_entreps', function (Blueprint $table) {
            $table->id();
            $table->integer('id_service');
            $table->string('nom', 450)->nullable();
            $table->string('titre', 250)->nullable();
            
            $table->text('description')->nullable();
            $table->string('photo', 250)->nullable();
            $table->string('prix', 450)->nullable();
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
        Schema::dropIfExists('sou_service_entreps');
    }
}
