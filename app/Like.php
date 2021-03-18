<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    //
    protected $guarded = [];

    public function users(){
        return $this->hasOne(User::class,'userId');
    }
}
