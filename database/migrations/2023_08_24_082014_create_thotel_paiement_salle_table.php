<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThotelPaiementSalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thotel_paiement_salle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refReservation')->constrained('thotel_reservation_salle')->restrictOnUpdate()->restrictOnDelete(); 
            $table->double('montant_paie');
            $table->string('devise',5);
            $table->double('taux');
            $table->string('date_paie',20);
            $table->string('author',100);  
            $table->foreignId('refUser')->constrained('users')->restrictOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

        //id,refClient,montant_paie,devise,taux,date_paie,heure_debut,heure_fin,libelle,author  thotel_billard
       //id,designation,prix_chambre,devise,taux,author   thotel_classe_chambre
       //id,nom_chambre,numero_chambre,refClasse,author    thotel_chambre
       //id,designation,prix_salle,devise,taux,author      thotel_salle

       //id,refClient,refChmabre,date_entree,date_sortie,heure_debut,heure_sortie,libelle,
       //prix_unitaire,devise,taux,reduction,observation,type_reservation,nom_accompagner,
       //pays_provenance,author     thotel_reservation_chambre

       //id,refReservation,montant_paie,devise,taux,date_paie,author    thotel_paiement_chambre
       
       //id,refClient,refSalle,date_ceremonie,heure_debut,heure_sortie,date_reservation,prix_unitaire,
       //taux,reduction,observation,author    thotel_reservation_salle

       //id,refReservation,montant_paie,devise,taux,date_paie,author thotel_paiement_salle

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thotel_paiement_salle');
    }
}
