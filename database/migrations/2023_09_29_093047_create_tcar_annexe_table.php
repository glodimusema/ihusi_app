<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTcarAnnexeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcar_annexe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteMvt')->constrained('tcar_entete_mouvement')->restrictOnUpdate()->restrictOnDelete();
            $table->string('pdfMouvement',100);
            $table->string('desicriptionPDF',100);
            $table->string('author',50);
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
        Schema::dropIfExists('tcar_annexe');
    }
}
