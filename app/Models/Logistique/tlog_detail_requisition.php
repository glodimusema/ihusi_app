<?php

namespace App\Models\Logistique;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tlog_detail_requisition extends Model
{
    protected $fillable=['id','refEnteteCmd','refProduit','puCmd','devise','taux','qteCmd','author'];
    protected $table = 'tlog_detail_requisition';
}
