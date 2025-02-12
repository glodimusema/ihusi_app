<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTtypemouvementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ttypemouvement', function (Blueprint $table) {
            $table->id();
            $table->string('designation',20);
            $table->timestamps();
        });
        DB::table('ttypemouvement')->insert([
            ['designation' => 'PRODUIT'],
            ['designation' => 'CHARGE'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ttypemouvement');
    }
}
