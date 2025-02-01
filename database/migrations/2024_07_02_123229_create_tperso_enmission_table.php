<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoEnmissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_enmission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affectation_id')->constrained('tperso_affectation_agent')->cascadeOnUpdate()->cascadeOnDelete(); 
            $table->date('date_depart');
            $table->date('date_retour');
            $table->string('objets');
            $table->string('lieu');
            $table->string('autres_details');
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
        Schema::dropIfExists('tperso_enmission');
    }
}
