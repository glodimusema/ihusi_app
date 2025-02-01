<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoDetailPaieSalaireTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_detail_paie_salaire', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refFichePaie')->constrained('tperso_fiche_paie')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refAffectation')->constrained('tperso_affectation_agent')->restrictOnUpdate()->restrictOnDelete();
            $table->double('salaire_base_paie')->default(0);
            $table->double('fammiliale_paie')->default(0);
            $table->double('logement_paie')->default(0);
            $table->double('transport_paie')->default(0);
            $table->double('sal_brut_paie')->default(0);
            $table->double('sal_brut_imposable_paie')->default(0);
            $table->double('inss_qpo_paie')->default(0);
            $table->double('inss_qpp_paie')->default(0);
            $table->double('cnss_paie')->default(0);
            $table->double('inpp_paie')->default(0);
            $table->double('onem_paie')->default(0);
            $table->double('ipr_paie')->default(0);

            $table->double('avance_paie')->default(0);
            $table->double('soins_paie')->default(0);
            $table->double('jourpreste_paie')->default(0);
            $table->double('salaire_horaire')->default(0);
            $table->double('heure_supp1_paie')->default(0);
            $table->double('heure_supp2_paie')->default(0);
            $table->double('heure_supp3_paie')->default(0);
            $table->double('assurances_paie')->default(0); 

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
        Schema::dropIfExists('tperso_detail_paie_salaire');
    }
}
