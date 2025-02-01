<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeCategorieProduitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_categorie_produit', function (Blueprint $table) {
            $table->id();
            $table->string('code',100);
            $table->string('designation',100)->unique();
            $table->foreignId('compte_achat')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('compte_vente')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('compte_variationstock')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('compte_perte')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('compte_produit')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('compte_destockage')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('compte_stockage')->constrained('tfin_ssouscompte')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('id_groupe_categorie')->constrained('tvente_grande_categorie_produit')->restrictOnUpdate()->restrictOnDelete()->default(1);
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
        Schema::dropIfExists('tvente_categorie_produit');
    }
}
