<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTgazDetailPaiementVenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tgaz_detail_paiement_vente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEntetepaie')->constrained('tgaz_entete_paiement_vente')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refEnteteVente')->constrained('tgaz_entete_vente')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refBanque')->constrained('tconf_banque')->restrictOnUpdate()->restrictOnDelete();
            $table->double('montant_paie');
            $table->string('devise',20);
            $table->double('taux');
            $table->date('date_paie');
            $table->string('modepaie',20);
            $table->string('libellepaie',225);            
            $table->string('numeroBordereau',20);
            $table->string('author',100);  
            $table->foreignId('refUser')->constrained('users')->restrictOnUpdate()->restrictOnDelete();           
            $table->string('active')->default('OUI');
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
        Schema::dropIfExists('tgaz_detail_paiement_vente');
    }
}
