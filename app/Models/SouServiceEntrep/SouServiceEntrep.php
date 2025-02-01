<?php

namespace App\Models\SouServiceEntrep;

use Illuminate\Database\Eloquent\Model;

class SouServiceEntrep extends Model
{
    //
    protected $fillable = [
        'nom','titre', 'description', 'photo','id_service','prix',
    ];
}
