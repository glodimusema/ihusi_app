<?php

namespace App\Models\RoleService;

use Illuminate\Database\Eloquent\Model;

class RoleService extends Model
{
    //
    protected $fillable = [
        'titre', 'description', 'photo',
    ];
}
