<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thotel_salle extends Model
{
    protected $fillable=['id','designation','prix_salle','devise','taux','author','refUser'];
    protected $table = 'thotel_salle';
}
