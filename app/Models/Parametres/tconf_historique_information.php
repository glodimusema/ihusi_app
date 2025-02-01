<?php

namespace App\Models\Parametres;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class tconf_historique_information extends Model
{
    // use SoftDeletes;
    
    protected $fillable=['id','user_id','user_name','type_operation','detail_operation','date_entree','detail_information','user_created','tables','champs','valeurs'];
    protected $table = 'tconf_historique_information';
}
