<?php

namespace App\Models\Logistique;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tlog_entete_sortie extends Model
{
    protected $fillable=['id','refService','nom_agent','dateSortie','libelle','author'];
    protected $table = 'tlog_entete_sortie';
}
