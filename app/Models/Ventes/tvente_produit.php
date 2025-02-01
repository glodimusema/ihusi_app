<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_produit extends Model
{
    protected $fillable=['id','designation','refCategorie','refUniteBase','uniteBase','pu','qte',
    'cmup','stock_alerte','devise','taux','Oldcode','Newcode','tvaapplique','estvendable','author','refUser'];
    protected $table = 'tvente_produit';    


    public function categories()
    {
        return $this->hasMany(tvente_categorie_produit::class, 'refCategorie');
    }

}
