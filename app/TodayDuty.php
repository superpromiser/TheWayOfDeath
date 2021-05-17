<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TodayDuty extends Model
{
    //
    protected $guarded = [];

    protected $casts = [
        'userList' => 'array'
    ];
}
