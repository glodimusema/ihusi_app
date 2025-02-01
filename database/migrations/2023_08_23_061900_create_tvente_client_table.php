<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_client', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refCategieClient')->constrained('tvente_categorie_client')->restrictOnUpdate()->restrictOnDelete();
            $table->string('noms',100)->unique(); 
            $table->string('sexe',10);
            $table->string('contact',15); 
            $table->string('mail',100); 
            $table->string('adresse',200);  
            $table->string('pieceidentite',50);
            $table->string('numeroPiece',20);
            $table->string('dateLivrePiece',20);
            $table->string('lieulivraisonCarte',50);
            $table->string('nationnalite',50);
            $table->string('datenaissance',15);
            $table->string('lieunaissance',50);
            $table->string('profession',50);
            $table->string('occupation',50);
            $table->integer('nombreEnfant');
            $table->string('dateArriverGoma',20);
            $table->string('arriverPar',50);            
            $table->string('photo'); 
            $table->string('slug'); 
            $table->boolean('tvaapplique')->default(true);
            $table->string('author',100);  
            $table->foreignId('refUser')->constrained('users')->restrictOnUpdate()->restrictOnDelete();  
            $table->timestamps();
        });
    }

    //id,noms,sexe,contact,mail,adresse,pieceidentite,numeroPiece,dateLivrePiece,lieulivraisonCarte,nationnalite,
    //datenaissance,lieunaissance,profession,occupation,nombreEnfant,dateArriverGoma,arriverPar,refCategieClient,
    //photo,slug,author
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tvente_client');
    }
}
