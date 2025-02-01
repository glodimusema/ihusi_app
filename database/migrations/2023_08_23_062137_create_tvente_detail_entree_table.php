<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeDetailEntreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_detail_entree', function (Blueprint $table) {
            $table->id();           
            $table->foreignId('refEnteteEntree')->constrained('tvente_entete_entree')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refProduit')->constrained('tvente_produit')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('compte_achat')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('compte_variationstock')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('compte_produit')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('compte_stockage')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('idStockService')->constrained('tvente_stock_service')->restrictOnUpdate()->restrictOnDelete()->default(0);
            $table->double('puEntree');
            $table->double('qteEntree');
            $table->string('uniteEntree');
            $table->double('puBase');
            $table->double('qteBase');
            $table->string('uniteBase');
            $table->string('devise',50);
            $table->double('taux');
            $table->double('montanttva')->default(0);
            $table->double('montantreduction')->default(0);
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
        Schema::dropIfExists('tvente_detail_entree');
    }
}
