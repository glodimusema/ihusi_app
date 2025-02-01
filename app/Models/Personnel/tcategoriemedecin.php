<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tcategoriemedecin extends Model
{
    protected $fillable=['id','designation'];
    protected $table = 'tcategoriemedecin';
}
