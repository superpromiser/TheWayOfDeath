<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleTeacher extends Model
{
    protected $guarded = [];

    protected $casts = [
        'lessons' => 'array',
    ];

    public function teacher()
    {
        return $this->belongsTo('App\User', 'teacherId');
    }
}
