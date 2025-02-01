<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoTimesheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_timesheet', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affectation_id')->constrained('tperso_affectation_agent')->cascadeOnUpdate()->cascadeOnDelete(); 
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete(); 
            $table->foreignId('annee_id')->constrained('tperso_annee')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('mois_id')->constrained('tperso_mois')->restrictOnUpdate()->restrictOnDelete();
            $table->date('date_tache');
            $table->integer('jour_preste')->default(1);
            $table->string('perdieme',10);
            $table->text('activite');
            $table->timestamp('heure_debut');
            $table->timestamp('heure_fin');
            $table->timestamp('temp_preste');
            
            $table->string('ateste_agent',100)->default('OUI');
            $table->string('ateste_projet',100)->default('NON');
            $table->string('ateste_coordo',100)->default('NON');
            $table->string('ateste_rh',100)->default('NON');

            $table->string('author',100);
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
        Schema::dropIfExists('tperso_timesheet');
    }
}
