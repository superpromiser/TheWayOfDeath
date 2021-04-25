<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
