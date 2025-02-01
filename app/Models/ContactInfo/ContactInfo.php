<?php

namespace App\Models\ContactInfo;

use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    //
    protected $fillable = [
        'name','email','telephone','subject','message',
    ];
}
