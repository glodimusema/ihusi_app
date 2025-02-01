<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_presences_temp extends Model
{
    protected $fillable=['id','affectation_id','date_presence','date_entree','date_sortie','retard','justifications', 'author'];
    protected $table = 'tperso_presences_temp';
}

//tperso_presences_temp


 