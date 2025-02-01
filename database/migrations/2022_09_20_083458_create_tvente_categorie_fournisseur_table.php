<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeCategorieFournisseurTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_categorie_fournisseur', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('nom_categoriefss',100)->unique();
            $table->foreignId('compte_fss_bl')->constrained('tfin_ssouscompte')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('tvente_categorie_fournisseur');
    }
}
