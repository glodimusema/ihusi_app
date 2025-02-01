<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTlogEnteteRequisitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tlog_entete_requisition', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refFournisseur')->constrained('tvente_fournisseur')->restrictOnUpdate()->restrictOnDelete();
            $table->date('dateCmd');
            $table->string('libelle');
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
        Schema::dropIfExists('tlog_entete_requisition');
    }
}
