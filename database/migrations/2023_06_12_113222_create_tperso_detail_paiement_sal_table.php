<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoDetailPaiementSalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_detail_paiement_sal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEntetePaie')->constrained('tperso_entete_paiement')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refDetailAffectRibrique')->constrained('tperso_detail_affectation_ribrique')->restrictOnUpdate()->restrictOnDelete();
            $table->double('taux');
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
        Schema::dropIfExists('tperso_detail_paiement_sal');
    }
}
