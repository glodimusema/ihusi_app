<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTconfHistoriqueInformationTable extends Migration
{
    //id,user_id,user_name,type_operation,detail_operation,date_entree,detail_information,user_created,tables,champs,valeurs
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tconf_historique_information', function (Blueprint $table) {
            $table->id();
            $table->string('author',100);  
            $table->foreignId('user_id')->constrained('users')->restrictOnUpdate()->restrictOnDelete();
            $table->string('user_name',100);
            $table->string('type_operation',100);
            $table->string('detail_operation',225);
            $table->string('date_entree',20);
            $table->string('detail_information',225);
            $table->string('user_created',50);
            $table->string('tables',50);
            $table->string('champs',50);
            $table->string('valeurs',50);            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tconf_historique_information');
    }
}
