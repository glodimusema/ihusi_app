<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTcarDetailCasseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcar_detail_casse', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteMvt')->constrained('tcar_entete_mouvement')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refProduit')->constrained('tcar_produit')->restrictOnUpdate()->restrictOnDelete(); 
            $table->double('puCasse');
            $table->double('qteCasse');
            $table->string('devise',20);
            $table->double('taux');
            $table->string('author',50);
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
        Schema::dropIfExists('tcar_detail_casse');
    }
}
