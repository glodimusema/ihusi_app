<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_categorie_produit extends Model
{
    protected $fillable=['id','code','designation','compte_achat','compte_vente','compte_variationstock',
    'compte_perte','compte_produit','compte_destockage','compte_stockage','id_groupe_categorie','author','refUser'];
    protected $table = 'tvente_categorie_produit';


    public function produit()
    {
        return $this->belongsTo(tvente_produit::class, 'refCategorie');
    }
}
