<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTconfAffectationMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tconf_affectation_menu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refRole')->constrained('roles')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refMenu')->constrained('tconf_list_menu')->restrictOnUpdate()->restrictOnDelete();   
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
        Schema::dropIfExists('tconf_affectation_menu');
    }
}
