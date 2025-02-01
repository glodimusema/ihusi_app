<?php

namespace App\Models\Vehicule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tcar_annexe extends Model
{
    protected $fillable=['id','refEnteteMvt','pdfMouvement','desicriptionPDF','author'];
    protected $table = 'tcar_annexe';
}