<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fence extends Model
{
    //
    protected $guarded = [];

    protected $casts = [
        'location' => 'array',
        'studentList' => 'array',

    ];
}
