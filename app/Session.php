<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'userId', 
        'schoolId', 
        'sessionName',
        'sessionDate' 
    ];
}
