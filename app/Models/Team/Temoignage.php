<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Model;

class Temoignage extends Model
{
    //
    protected $fillable = [
        'nom','fonction', 'message', 'photo',
    ];
}
