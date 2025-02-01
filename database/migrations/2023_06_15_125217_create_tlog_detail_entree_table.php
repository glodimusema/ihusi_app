<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTlogDetailEntreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tlog_detail_entree', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('refEnteteEntree')->constrained('tlog_entete_entree')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refProduit')->constrained('tlog_produit')->restrictOnUpdate()->restrictOnDelete();                    
            $table->double('puEntree');
            $table->double('qteEntree');
            $table->string('author');
            $table->string('deleted')->default('NON');
            $table->string('author_deleted')->default('user'); 
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
        Schema::dropIfExists('tlog_detail_entree');
    }
}
