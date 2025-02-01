<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTlogDetailRequisitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tlog_detail_requisition', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteCmd')->constrained('tlog_entete_requisition')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refProduit')->constrained('tproduit')->restrictOnUpdate()->restrictOnDelete();
            $table->double('puCmd');
            $table->double('qteCmd');
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
        Schema::dropIfExists('tlog_detail_requisition');
    }
}
