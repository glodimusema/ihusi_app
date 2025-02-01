<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeDetailUniteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_detail_unite', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refProduit')->constrained('tvente_produit')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refUnite')->constrained('tvente_unite')->restrictOnUpdate()->restrictOnDelete();
            $table->double('puUnite');
            $table->double('qteUnite');
            $table->double('puBase');
            $table->double('qteBase');
            $table->string('estunite')->default('OUI');
            $table->string('estpivot')->default('NON');
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
        Schema::dropIfExists('tvente_detail_unite');
    }
}
