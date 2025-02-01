<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_promotion_stage extends Model
{
    protected $fillable=['id','name_promotion','author'];
    protected $table = 'tperso_promotion_stage';
}



 