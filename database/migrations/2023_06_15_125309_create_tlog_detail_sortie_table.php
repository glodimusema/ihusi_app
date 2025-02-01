<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTlogDetailSortieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tlog_detail_sortie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteSortie')->constrained('tlog_entete_sortie')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refProduit')->constrained('tproduit')->restrictOnUpdate()->restrictOnDelete();
            $table->double('puSortie');
            $table->double('qteSortie');
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
        Schema::dropIfExists('tlog_detail_sortie');
    }
}
