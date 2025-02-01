<?php

namespace App\Models\Logistique;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tlog_entete_requisition extends Model
{
    protected $fillable=['id','refFournisseur','dateCmd','libelle','author'];
    protected $table = 'tlog_entete_requisition';
}
