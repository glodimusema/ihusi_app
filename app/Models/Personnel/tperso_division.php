<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_division extends Model
{
    protected $fillable=['id','name_division','description_division','author'];
    protected $table = 'tperso_division';
}

   


 