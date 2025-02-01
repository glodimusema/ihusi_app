<?php

namespace App\Models\Logistique;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tlog_emplacements extends Model
{
    protected $fillable=['id','nom_emplacement','author'];
    protected $table = 'tlog_emplacements';
}
