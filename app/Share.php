<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    protected $guarded = [];

    protected $casts = [
        'viewList' => 'array',
    ];
}
