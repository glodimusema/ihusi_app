<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTcarPaiementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tcar_paiement', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteMvt')->constrained('tcar_entete_mouvement')->restrictOnUpdate()->restrictOnDelete();
            $table->double('montant_paie');
            $table->date('date_paie');
            $table->string('modepaie',20);
            $table->string('devise',20);
            $table->double('taux');
            $table->string('libellepaie',225);
            $table->foreignId('refBanque')->constrained('tconf_banque')->restrictOnUpdate()->restrictOnDelete();
            $table->string('numeroBordereau',20);
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
        Schema::dropIfExists('tcar_paiement');
    }
}
