<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'userId', 
        'schoolId', 
        'subjectName', 
        'subjectType', 
        'startTime', 
        'endTime', 
        'subjectDate'
    ];
}
