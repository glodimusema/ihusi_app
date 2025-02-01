<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable=['id','noms','sexe','contact','mail','adresse','pieceidentite','numeroPiece',
    'dateLivrePiece','lieulivraisonCarte','nationnalite',
    'datenaissance','lieunaissance','profession','occupation','nombreEnfant',
    'dateArriverGoma','arriverPar','refCategieClient',
    'photo','slug','user_id'];
    protected $table = 'clients';

    public function factures()
    {
        return $this->hasMany(Facture::class);
    }
}
