<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $guarded = [];

    public function users(){
        return $this->belongsTo(User::class,'userId');
    }

    public function questionnaires(){
        return $this->hasOne(Questionnaire::class,'postId');
    }

    public function votings(){
        return $this->hasOne(Voting::class,'postId');
    }

}
