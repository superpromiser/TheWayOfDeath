<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VotingTemp extends Model
{
    //
    protected $guarded = [];

    protected $casts = [
        'content' => 'array'
    ];
}
