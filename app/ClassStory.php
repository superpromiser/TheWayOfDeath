<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassStory extends Model
{
    //
    protected $guarded = [];
    protected $casts = [
        'viewList' => 'array'
    ];
}
