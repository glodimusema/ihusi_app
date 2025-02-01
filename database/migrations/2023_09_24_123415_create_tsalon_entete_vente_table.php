<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTsalonEnteteVenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tsalon_entete_vente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refClient')->constrained('tvente_client')->restrictOnUpdate()->restrictOnDelete();          
            $table->date('dateVente');
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
        Schema::dropIfExists('tsalon_entete_vente');
    }
}
