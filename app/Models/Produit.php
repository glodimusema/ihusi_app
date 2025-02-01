<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    //
    protected $fillable=['id','designation','pu','devise','taux','unite','categorie_id','user_id'];
    protected $table = 'produits';

    protected $appends=[
            'fullName'
    ];

    protected $hidden = [
        'categorie'
    ];

    public function getFullNameAttribute()
    {
       return $this->categorie ? $this->categorie->designation : null;
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
}
