<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleSetting extends Model
{
    //
    protected $guarded = [];

    public function subject(){
        return $this->hasOne('App\Subject','subjectId');
    }

    public function teacher(){
        return $this->hasOne('App\User','userId');
    }

    public function lesson(){
        return $this->hasOne('App\Lesson','lessonId');
    }
    
}
