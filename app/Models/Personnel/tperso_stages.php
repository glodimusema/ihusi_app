<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_stages extends Model
{
    protected $fillable=['id','institution_id','personnel_id','option_id','promotion_id','annee_id','typestage_id',
    'date_debut_stage','date_fin_stage','author'];
    protected $table = 'tperso_stages';
}



 