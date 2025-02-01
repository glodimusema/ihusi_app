<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeAnnexeCommandeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tvente_annexe_commande', function (Blueprint $table) {
            $table->id();
            $table->string('noms_annexe');
            $table->foreignId('refCommande')->constrained('tvente_entete_requisition')->restrictOnUpdate()->restrictOnDelete();
            $table->string('annexe');
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
        Schema::dropIfExists('tvente_annexe_commande');
    }
}
