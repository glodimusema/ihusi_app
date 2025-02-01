<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventePaiementCommandeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_paiement_commande', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignId('refEntetepaie')->constrained('tvente_entete_paiecommande')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refCommande')->constrained('tvente_entete_requisition')->restrictOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('tvente_paiement_commande');
    }
}
