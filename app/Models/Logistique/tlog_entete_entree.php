<?php

namespace App\Models\Logistique;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tlog_entete_entree extends Model
{
    protected $fillable=['id','refFournisseur','dateEntree','libelle','author'];
    protected $table = 'tlog_entete_entree';
}
