<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tfonctionmedecin extends Model
{
    protected $fillable=['id','designation'];
    protected $table = 'tfonctionmedecin';
}
