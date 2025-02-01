<?php

namespace App\Models\Patients;

use Illuminate\Database\Eloquent\Model;

class trdv_malade extends Model
{
    //
    protected $fillable = [
        'id','numeroCarte','refUser','dateRDV','noms','contact','lieu','motif','statut','author'
    ];
    protected $table = 'trdv_malade';
}
