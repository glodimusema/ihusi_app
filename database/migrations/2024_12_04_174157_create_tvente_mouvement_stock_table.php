<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeMouvementStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_mouvement_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idStockService')->constrained('tvente_stock_service')->restrictOnUpdate()->restrictOnDelete()->default(0);                       
            $table->foreignId('compte_vente')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete()->nullable();
            $table->foreignId('compte_variationstock')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete()->nullable();
            $table->foreignId('compte_perte')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete()->nullable();
            $table->foreignId('compte_produit')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete()->nullable();
            $table->foreignId('compte_destockage')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete()->nullable();
            $table->foreignId('compte_achat')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete()->nullable();            
            $table->foreignId('compte_stockage')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete()->nullable();
            $table->date('dateMvt'); 
            $table->string('type_mouvement')->default('Entree');
            $table->string('libelle_mouvement',500);
            $table->string('nom_table',50);
            $table->integer('id_data');
            $table->double('puMvt');
            $table->double('qteMvt');
            $table->string('uniteMvt');
            $table->double('puBase');
            $table->double('qteBase');
            $table->string('uniteBase');
            $table->double('cmupMvt');
            $table->string('devise',50);
            $table->double('taux');           
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
        Schema::dropIfExists('tvente_mouvement_stock');
    }
}
