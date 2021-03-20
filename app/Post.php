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

    public function likes(){
        return $this->hasMany(Like::class,'postId');
    }

    public function views(){
        return $this->hasMany(View::class,'postId');
    }

    public function comments(){
        return $this->hasMany(Comment::class,'postId')->orderBy('created_at','desc');
    }

    public function questionnaires(){
        return $this->hasOne(Questionnaire::class,'postId');
    }

    public function votings(){
        return $this->hasOne(Voting::class,'postId');
    }

    public function sms(){
        return $this->hasOne(Sms::class,'postId');
    }

    public function campus(){
        return $this->hasOne(Campus::class,'postId');
    }

    public function anouncements(){
        return $this->hasOne(Announcement::class,'postId');
    }

    public function bulletinBoards(){
        return $this->hasOne(BulletinBoard::class,'postId');
    }

}
