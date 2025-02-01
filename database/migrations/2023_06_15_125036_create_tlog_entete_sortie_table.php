<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTlogEnteteSortieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tlog_entete_sortie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refService')->constrained('tperso_categorie_service')->restrictOnUpdate()->restrictOnDelete();
            $table->string('nom_agent',50);           
            $table->date('dateSortie');
            $table->string('libelle',50);
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
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
        Schema::dropIfExists('tlog_entete_sortie');
    }
}
