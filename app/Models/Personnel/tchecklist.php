<?php

namespace App\Models\Personnel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tchecklist extends Model
{
    protected $fillable=['id','refAgent','checklist','motivation','cv','diplome','carteidentite','actenaissance',
    'actenaissanceenfant','aptitudephysique','viemoeurs','servicerendu','ficheidentite','contrattravail',
    'jobdescription','actemariage','briefingmission','datebriefingmission','organigramme','dateorganigramme',
    'briefingposte','datebriefingposte','planstrategique','dateplanstrategique','briefinggestion',
    'datebriefinggestion','mannuel','datemannuel','evaluationstaff','datestaff1','datestaff2',
    'datestaff3','periodeconge','dateconge1','dateconge2','dateconge3',
    'briefingsecurite','datebriefingsecurite','notification','notefinance','datenotefinance','attesteservice',
    'dateattesteservice','author'];
    protected $table = 'tchecklist';
}


 