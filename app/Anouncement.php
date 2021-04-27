<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anouncement extends Model
{
    //
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
