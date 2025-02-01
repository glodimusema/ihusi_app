<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeDetailCommandeclientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_detail_commandeclient', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refEnteteVente')->constrained('tvente_entete_vente')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refProduit')->constrained('tvente_produit')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('compte_vente')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('compte_variationstock')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('compte_perte')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('compte_produit')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('compte_destockage')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('idStockService')->constrained('tvente_stock_service')->restrictOnUpdate()->restrictOnDelete()->default(0);
            $table->double('puVente');
            $table->double('qteVente');
            $table->string('uniteVente');
            $table->double('puBase');
            $table->double('qteBase');
            $table->string('uniteBase');
            $table->double('cmupVente');
            $table->string('devise',50);
            $table->double('taux');
            $table->double('montanttva')->default(0);
            $table->double('montantreduction')->default(0);
            $table->string('priseencharge')->default('NON');
            $table->string('active')->default('OUI');
            $table->string('author',100);  
            $table->foreignId('refUser')->constrained('users')->restrictOnUpdate()->restrictOnDelete();
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
        Schema::dropIfExists('tvente_detail_commandeclient');
    }
}
