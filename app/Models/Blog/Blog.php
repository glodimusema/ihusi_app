<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    //
    protected $fillable = [
        'titre', 'description', 'photo','etat','id_cat','slug','user_id'
    ];
}
