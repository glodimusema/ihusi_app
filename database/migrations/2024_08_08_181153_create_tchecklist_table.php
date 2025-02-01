<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTchecklistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tchecklist', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refAgent')->constrained('tagent')->restrictOnUpdate()->restrictOnDelete();
            $table->string('checklist',5)->nullable()->default('NON');
            $table->string('motivation',5)->nullable()->default('NON');
            $table->string('cv',5)->nullable()->default('NON');
            $table->string('diplome',5)->nullable()->default('NON');
            $table->string('carteidentite',5)->nullable()->default('NON');
            $table->string('actenaissance',5)->nullable()->default('NON');
            $table->string('actenaissanceenfant',5)->nullable()->default('NON');
            $table->string('aptitudephysique',5)->nullable()->default('NON');
            $table->string('viemoeurs',5)->nullable()->default('NON');
            $table->string('servicerendu',5)->nullable()->default('NON');
            $table->string('ficheidentite',5)->nullable()->default('NON');
            $table->string('contrattravail',5)->nullable()->default('NON');
            $table->string('jobdescription',5)->nullable()->default('NON');
            $table->string('actemariage',5)->nullable()->default('NON');
            $table->string('briefingmission',5)->nullable()->default('NON');
            $table->date('datebriefingmission')->nullable();
            $table->string('organigramme',5)->nullable()->default('NON');
            $table->date('dateorganigramme')->nullable();
            $table->string('briefingposte',5)->nullable()->default('NON');
            $table->date('datebriefingposte')->nullable();
            $table->string('planstrategique',5)->nullable()->default('NON');
            $table->date('dateplanstrategique')->nullable();
            $table->string('briefinggestion',5)->nullable()->default('NON');
            $table->date('datebriefinggestion')->nullable();
            $table->string('mannuel',5)->nullable()->default('NON');
            $table->date('datemannuel')->nullable();
            $table->string('evaluationstaff',5)->nullable()->default('NON');
            $table->date('datestaff1')->nullable();
            $table->date('datestaff2')->nullable();
            $table->date('datestaff3')->nullable();

            $table->string('periodeconge',5)->nullable()->default('NON');
            $table->date('dateconge1')->nullable();
            $table->date('dateconge2')->nullable();
            $table->date('dateconge3')->nullable();

            $table->string('briefingsecurite',5)->nullable()->default('NON');
            $table->date('datebriefingsecurite')->nullable();
            $table->string('notification',5)->nullable()->default('NON');
            $table->string('notefinance',5)->nullable()->default('NON');
            $table->date('datenotefinance')->nullable();
            $table->string('attesteservice',5)->nullable()->default('NON');
            $table->date('dateattesteservice')->nullable();
            $table->string('author',100)->nullable()->default('NON');
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
        Schema::dropIfExists('tchecklist');
    }
}
