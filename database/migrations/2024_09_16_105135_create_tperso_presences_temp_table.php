<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoPresencesTempTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_presences_temp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affectation_id')->constrained('tperso_affectation_agent')->cascadeOnUpdate()->cascadeOnDelete(); 
            $table->string('date_presence');
            $table->string('date_entree');
            $table->string('date_sortie');
            $table->string('retard')->default('NON');
            $table->string('justifications')->default('Encours');
            $table->string('author',100)->default('User');
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
        Schema::dropIfExists('tperso_presences_temp');
    }
}
