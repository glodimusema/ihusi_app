<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTventeGrandeCategorieProduitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('tvente_grande_categorie_produit', function (Blueprint $table) {
            $table->id();
            $table->string('designation_groupe',100)->unique();
            $table->timestamps();
        });
        
        DB::table('tvente_grande_categorie_produit')->insert([
            ['designation_groupe' => 'BOISSON'],
            ['designation_groupe' => 'PRODUIT ALIMENTAIRE'],
            ['designation_groupe' => 'CAVE'],
            ['designation_groupe' => 'CIGARETTE'],
            ['designation_groupe' => "Produit d'Entretien"],
            ['designation_groupe' => 'Autres'],
            ['designation_groupe' => 'Produit Acceuil et Habillement'],
            ['designation_groupe' => 'Matériel Cuisine et Restaurant'],
            ['designation_groupe' => 'Matériel Buanderie,Piscine et Jardin'],
            ['designation_groupe' => 'Matériel Technique'],
            ['designation_groupe' => 'Autres PE']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tvente_grande_categorie_produit');
    }
}
