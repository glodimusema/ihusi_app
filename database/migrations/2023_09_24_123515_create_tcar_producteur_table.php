<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTcarProducteurTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcar_producteur', function (Blueprint $table) {
            $table->id();
            $table->string('nom_producteur',100); 
            $table->string('adresse_prod',100); 
            $table->string('contact_prod',100); 
            $table->string('mail_prod',100);
            $table->string('autres_details',100); 
            $table->string('author',100);
            $table->timestamps();
        });
    }
    //id,nom_producteur,adresse_prod,contact_prod,mail_prod,autres_details,author tcar_producteur

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tcar_producteur');
    }
}
