<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_bareme extends Model
{
    protected $fillable=['id','taux_bareme','usd_bareme','tranche1_bareme','tranche2_bareme'];
    protected $table = 'tperso_bareme';
}