<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    //
    protected $guarded = [];

    protected $casts = [
        'selMedalList' => 'array',
    ];


}
