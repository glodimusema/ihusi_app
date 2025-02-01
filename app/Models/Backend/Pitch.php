<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Pitch extends Model
{
    //
    protected $fillable = [
        'id_entreprise', 'pitch'
    ];
}
