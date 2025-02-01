<?php

namespace App\Models\Hotel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class thotel_incident_reservation_salle extends Model
{
    protected $fillable=['id','refReservation','montant_incident','devise','taux',
    'autres_details','author','refUser'];
    protected $table = 'thotel_incident_reservation_salle';
}
