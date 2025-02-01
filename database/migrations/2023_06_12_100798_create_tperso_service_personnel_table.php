<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoServicePersonnelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_service_personnel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refCatService')->constrained('tperso_categorie_service')->restrictOnUpdate()->restrictOnDelete();
            $table->string('name_serv_perso');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tperso_service_personnel')->insert([
            ['refCatService' => 1, 'name_serv_perso' => 'COMPTABILITE'],
            ['refCatService' => 1, 'name_serv_perso' => 'TRESORERIE'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tperso_service_personnel');
    }
}
