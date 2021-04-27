<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    //
    protected $guarded = [];

    protected $casts = [
        'content' => 'array'
    ];
}
