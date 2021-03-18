<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    //
    protected $guarded = [];

    public function users(){
        return $this->hasOne(User::class,'userId');
    }
}
