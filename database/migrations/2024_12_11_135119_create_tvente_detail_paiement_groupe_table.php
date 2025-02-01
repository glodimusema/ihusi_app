<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeDetailPaiementGroupeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_detail_paiement_groupe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEntetepaieGroup')->constrained('tvente_entete_paiement_groupe')->restrictOnUpdate()->restrictOnDelete()->nullable();
            $table->foreignId('refEnteteVenteGroup')->constrained('tvente_entete_facture_groupe')->restrictOnUpdate()->restrictOnDelete();
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

    // tvente_entete_paiement_groupe id,code,refFactureGroup,module_id,datePaieGroup,libelle_paie_group,author,refUser
    // tvente_detail_paiement_groupe id,refEntetepaieGroup,refEnteteVenteGroup,refBanque,montant_paie,
//devise,taux,date_paie,modepaie,libellepaie,numeroBordereau,author,refUser,active

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tvente_detail_paiement_groupe');
    }
}
