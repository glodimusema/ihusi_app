<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_enmission extends Model
{
    protected $fillable=['id','affectation_id','date_depart','date_retour','objets','lieu','autres_details','author'];
    protected $table = 'tperso_enmission';
}
