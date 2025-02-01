<?php

namespace App\Models\Vehicule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tcar_producteur extends Model
{
    protected $fillable=['id','nom_producteur','adresse_prod','contact_prod','mail_prod','autres_details','author'];
    protected $table = 'tcar_producteur';
}
