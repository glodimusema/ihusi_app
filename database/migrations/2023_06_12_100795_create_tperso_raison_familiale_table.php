<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoRaisonFamilialeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_raison_familiale', function (Blueprint $table) {
            $table->id();
            $table->string('name_raison_famille',100)->unique();
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
            $table->timestamps();
        });

        DB::table('tperso_raison_familiale')->insert([
            ['name_raison_famille' => 'DEUIL'],
            ['name_raison_famille' => 'ACCIDENT'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tperso_raison_familiale');
    }
}
