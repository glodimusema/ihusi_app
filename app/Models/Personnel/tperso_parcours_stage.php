<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_parcours_stage extends Model
{
    protected $fillable=['id','stage_id','service_id','date_debut_parcours','date_fin_parcours','tache_parcours','apprecition_parcours','author'];
    protected $table = 'tperso_parcours_stage';
}



 