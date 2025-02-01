<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
class CreateTpersoMoisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_mois', function (Blueprint $table) {
            $table->id();
            $table->string('name_mois',100)->unique();
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tperso_mois')->insert([
            ['name_mois' => 'JANVIER'],
            ['name_mois' => 'FEVRIER'],
            ['name_mois' => 'MARS'],
            ['name_mois' => 'AVRIL'],
            ['name_mois' => 'MAI'],
            ['name_mois' => 'JUIN'],
            ['name_mois' => 'JUILLET'],
            ['name_mois' => 'AOUT'],
            ['name_mois' => 'SEPTEMBRE'],
            ['name_mois' => 'OCTOBRE'],
            ['name_mois' => 'NOVEMBRE'],
            ['name_mois' => 'DECMBRE']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tperso_mois');
    }
}
