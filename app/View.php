<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    //
    protected $guarded = [];

    public function users(){
        return $this->hasOne(User::class,'userId');
    }
}
