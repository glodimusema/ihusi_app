<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_user_service extends Model
{
    protected $fillable=['id','refUser','refService','active','author'];
    protected $table = 'tvente_user_service'; 
}



