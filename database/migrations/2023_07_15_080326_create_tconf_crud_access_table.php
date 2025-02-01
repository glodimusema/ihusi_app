<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTconfCrudAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tconf_crud_access', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refRole')->constrained('roles')->restrictOnUpdate()->restrictOnDelete();
            $table->string('insert',5)->default('OUI');  
            $table->string('update',5)->default('OUI');  
            $table->string('delete',5)->default('OUI');  
            $table->string('load',5)->default('OUI');  
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
        Schema::dropIfExists('tconf_crud_access');
    }
}
