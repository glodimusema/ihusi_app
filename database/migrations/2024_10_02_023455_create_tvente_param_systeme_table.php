<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeParamSystemeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_param_systeme', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('tvente_module')->restrictOnUpdate()->restrictOnDelete();
            $table->double('maxid')->default(1);
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
        Schema::dropIfExists('tvente_param_systeme');
    }
}
