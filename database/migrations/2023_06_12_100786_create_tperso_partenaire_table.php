<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpersoPartenaireTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tperso_partenaire', function (Blueprint $table) {
            $table->id();
            $table->string('nom_org',100)->unique();
            $table->string('adresse_org');
            $table->string('contact_org');
            $table->string('mail_org');
            $table->string('rccm_org');
            $table->string('idnat_org');       
            $table->string('author');
            $table->string('photo');
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
        Schema::dropIfExists('tperso_partenaire');
    }
}
