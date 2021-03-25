<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LessonAttendance extends Model
{
    //

    protected $guarded = [];

    public function users(){
        return $this->belongsTo(User::class, 'userId');
    }
}
