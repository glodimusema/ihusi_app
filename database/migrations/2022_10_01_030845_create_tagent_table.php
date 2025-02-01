<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagentTable extends Migration
{
    /**
     * Run the migrations.
     *photoslug
     * @return void
     */
    public function up()
    {
        Schema::create('tagent', function (Blueprint $table) {
            $table->id();
            $table->string('matricule_agent');
            $table->string('noms_agent');
            $table->string('sexe_agent'); 
            $table->string('datenaissance_agent'); 
            $table->string('lieunaissnce_agent');
            $table->string('provinceOrigine_agent');           
            $table->string('etatcivil_agent');
            $table->foreignId('refAvenue_agent')->constrained('avenues')->restrictOnUpdate()->restrictOnDelete();
            $table->string('nummaison_agent');
            $table->string('contact_agent'); 
            $table->string('mail_agent');
            $table->string('grade_agent');
            $table->string('fonction_agent');
            $table->string('specialite_agent');
            $table->string('Categorie_agent');
            $table->string('niveauEtude_agent');           
            $table->string('anneeFinEtude_agent');
            $table->string('Ecole_agent'); 
            $table->string('conjoint_agent');
            $table->string('nomPere_agent');
            $table->string('nomMere_agent');
            $table->string('Nationalite_agent');
            $table->string('Collectivite_agent');
            $table->string('Territoire_agent');
            $table->string('EmployeurAnt_agent');
            $table->string('PersRef_agent');            
            $table->string('photo'); 
            $table->string('slug'); 
            $table->string('cartes')->default('NON');
            $table->string('envie')->default('OUI');
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
        Schema::dropIfExists('tagent');
    }
}
