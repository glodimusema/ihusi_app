<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_institution_stage extends Model
{
    protected $fillable=['id','name_institution','adresse_institution','contact_institution','mail_institution','author'];
    protected $table = 'tperso_institution_stage';
}


 