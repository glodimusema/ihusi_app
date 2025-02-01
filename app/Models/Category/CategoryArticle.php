<?php

namespace App\Models\Category;

use Illuminate\Database\Eloquent\Model;

class CategoryArticle extends Model
{
    //
    protected $fillable = [
        'nom', 'slug'
    ];
}
