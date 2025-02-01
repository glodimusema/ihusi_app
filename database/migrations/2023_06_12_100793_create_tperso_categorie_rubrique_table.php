<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoCategorieRubriqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_categorie_rubrique', function (Blueprint $table) {
            $table->id();
            $table->string('name_categorie_rubrique',100)->unique();
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tperso_categorie_rubrique')->insert([
            ['name_categorie_rubrique' => 'AVANATGE'],
            ['name_categorie_rubrique' => 'RETENUE'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tperso_categorie_rubrique');
    }
}
