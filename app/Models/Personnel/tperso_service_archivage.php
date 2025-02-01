<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_service_archivage extends Model
{
    protected $fillable=['id','name_service','description_service','categorie_id','division_id','author'];
    protected $table = 'tperso_service_archivage';
}



 