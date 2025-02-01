<?php

namespace App\Models\Logistique;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tlog_service extends Model
{
    protected $fillable=['id','designation','author'];
    protected $table = 'tlog_service';
}
