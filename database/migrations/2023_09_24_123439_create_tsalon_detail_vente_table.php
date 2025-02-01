<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTsalonDetailVenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tsalon_detail_vente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteVente')->constrained('tsalon_entete_vente')->restrictOnUpdate()->restrictOnDelete();  
            $table->foreignId('refProduit')->constrained('tsalon_produit')->restrictOnUpdate()->restrictOnDelete();  
            $table->double('puVente');
            $table->double('qteVente');
            $table->string('devise',20);
            $table->double('taux');
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
        Schema::dropIfExists('tsalon_detail_vente');
    }
}
