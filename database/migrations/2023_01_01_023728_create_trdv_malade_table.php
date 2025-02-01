<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrdvMaladeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //'id','refUser','dateRDV','noms','contact','lieu','motif','statut','author'
        Schema::create('trdv_malade', function (Blueprint $table) {
            $table->id();
            $table->integer('refCarte');
            $table->integer('refUser');
            $table->string('dateRDV');
            $table->string('noms');
            $table->string('contact');
            $table->string('lieu');
            $table->string('motif');
            $table->string('statut');
            $table->string('author');
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
        Schema::dropIfExists('trdv_malade');
    }
}
