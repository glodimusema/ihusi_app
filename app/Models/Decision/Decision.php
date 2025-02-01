<?php

namespace App\Models\Decision;

use Illuminate\Database\Eloquent\Model;

class Decision extends Model
{
    //
    protected $fillable = [
        'titre', 'description', 'photo',
    ];
}
