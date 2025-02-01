<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_type_stage extends Model
{
    protected $fillable=['id','name_typestage','author'];
    protected $table = 'tperso_type_stage';
}



