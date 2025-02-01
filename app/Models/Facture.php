<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Facture extends Model
{
    protected $fillable=['id','client_id','dateVente','libelle','user_id'];
    protected $table = 'factures';

    protected $appends=[
            'clientName',
            'clientPieceidentite',
            'clientAdresse',
            'clientContact',
            'clientSexe',
            'clientMail',
            'codeFacture'
    ];

    protected $hidden = [
        'client'
    ];

   // selectRaw('CONCAT("F",YEAR(dateVente),"",MONTH(dateVente),"00",tvente_entete_vente.id) as codeFacture')

    public function getCodeFactureAttribute()
    {
      $idFacture = $this->id ? $this->id : null;
      $year =  Carbon::parse($this->dateVente)->format('Y');
      $mounth =  Carbon::parse($this->dateVente)->format('M');
      $codeFacture = 'F'.$year.''.$mounth.'00'.$idFacture;
      return strtoupper($codeFacture);
    }
    public function getClientNameAttribute()
    {
       return $this->client ? strtoupper($this->client->noms) : null;
    }
    public function getClientPieceidentiteAttribute()
    {
       return $this->client ? $this->client->pieceidentite : null;
    }
    public function getClientAdresseAttribute()
    {
       return $this->client ? $this->client->adresse : null;
    }
    public function getClientContactAttribute()
    {
       return $this->client ? $this->client->contact : null;
    }
    public function getClientSexeAttribute()
    {
       return $this->client ? $this->client->sexe : null;
    }
    public function getClientMailAttribute()
    {
       return $this->client ? $this->client->mail : null;
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function detail_factures()
    {
        return $this->hasMany(DetailFacture::class);
    }
}
