<?php

namespace App\Models\Ventes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tvente_annexe_commande extends Model
{
    protected $fillable=['id','noms_annexe','refCommande','annexe','author'];
    protected $table = 'tvente_annexe_commande';
}
