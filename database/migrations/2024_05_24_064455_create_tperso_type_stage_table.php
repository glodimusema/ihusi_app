<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoTypeStageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_type_stage', function (Blueprint $table) {
            $table->id();
            $table->string('name_typestage');
            $table->string('author');
            $table->timestamps();
        });

        DB::table('tperso_type_stage')->insert([
            ['name_typestage' => 'ACADEMIQUE' , 'author' => 'Admin'],
            ['name_typestage' => 'PREFESSIONNEL' , 'author' => 'Admin'],
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tperso_type_stage');
    }
}
