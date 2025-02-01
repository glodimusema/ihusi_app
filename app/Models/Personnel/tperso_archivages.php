<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tperso_archivages extends Model
{
    protected $fillable=['id','name_archive','description_archive','fichier_archive','service_id','author'];
    protected $table = 'tperso_archivages';
}


 