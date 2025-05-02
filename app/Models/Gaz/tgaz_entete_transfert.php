<?php

namespace App\Models\Gaz;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tgaz_entete_transfert extends Model
{
    protected $fillable=['id','refService','module_id','date_transfert','author','refUser'];
    protected $table = 'tgaz_entete_transfert';
}
