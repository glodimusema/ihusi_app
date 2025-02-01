<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceEntrepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_entreps', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 250)->nullable();
            $table->string('titre', 250)->nullable();
            
            $table->text('description')->nullable();
            $table->string('photo', 250)->nullable();
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
        Schema::dropIfExists('service_entreps');
    }
}
