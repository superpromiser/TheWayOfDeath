<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regname extends Model
{
    protected $guarded = [];

    
    public function answers(){
        return $this->hasMany(AnswerRegname::class,'regnameId');
    }

}
