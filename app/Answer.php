<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //
    protected $guarded = [];

    public function questionnaires(){
        return $this->hasOne(AnswerQuestionnaire::class,'answerId');
    }
}
