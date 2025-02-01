<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoBaremeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_bareme', function (Blueprint $table) {
            $table->id();
            $table->double('taux_bareme');
            $table->double('usd_bareme');
            $table->double('tranche1_bareme');
            $table->double('tranche2_bareme');
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
        Schema::dropIfExists('tperso_bareme');
    }
}
