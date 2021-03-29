<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    protected $guarded = [];

    public function users(){
        return $this->belongsTo(User::class,'userId');
    }

    public function members(){
        return $this->belongsTo(User::class,'memberId');
    }
}
