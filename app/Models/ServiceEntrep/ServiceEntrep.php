<?php

namespace App\Models\ServiceEntrep;

use Illuminate\Database\Eloquent\Model;

class ServiceEntrep extends Model
{
    //
    protected $fillable = [
        'nom','titre', 'description', 'photo',
    ];
}
