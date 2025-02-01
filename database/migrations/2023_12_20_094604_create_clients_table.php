<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('noms',100); 
            $table->string('sexe',10);
            $table->string('contact',15); 
            $table->string('mail',100); 
            $table->string('adresse',200);  
            $table->string('pieceidentite',50);
            $table->string('numeroPiece',20);
            $table->string('dateLivrePiece',20);
            $table->string('lieulivraisonCarte',50)->nullable();
            $table->string('nationnalite',50)->nullable();
            $table->string('datenaissance',15)->nullable();
            $table->string('lieunaissance',50)->nullable();
            $table->string('profession',50)->nullable();
            $table->string('occupation',50)->nullable();
            $table->integer('nombreEnfant')->nullable();
            $table->string('dateArriverGoma',20)->nullable();
            $table->string('arriverPar',50)->nullable();
            $table->integer('refCategieClient')->nullable(); 
            $table->string('photo')->nullable(); 
            $table->string('slug')->nullable(); 
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();    
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
        Schema::dropIfExists('clients');
    }
}
