<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoCategorieServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_categorie_service', function (Blueprint $table) {
            $table->id();
            $table->string('name_categorie_service',100)->unique();
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tperso_categorie_service')->insert([
            ['name_categorie_service' => 'ADMINISTRATION'],
            ['name_categorie_service' => 'SUPERVISEUR'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tperso_categorie_service');
    }
}
