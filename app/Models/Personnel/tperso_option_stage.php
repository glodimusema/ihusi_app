<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_option_stage extends Model
{
    protected $fillable=['id','name_option','domaine_id','author'];
    protected $table = 'tperso_option_stage';
}


 