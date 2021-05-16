<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolStory extends Model
{
    //
    protected $guarded = [];
    protected $casts = [
        'viewList' => 'array'
    ];
}
