<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'postId');
    }

    public function views()
    {
        return $this->hasMany(View::class, 'postId');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'postId')->orderBy('created_at', 'desc');
    }

    public function questionnaires()
    {
        return $this->hasOne(Questionnaire::class, 'postId');
    }

    public function votings()
    {
        return $this->hasOne(Voting::class, 'postId');
    }

    public function sms()
    {
        return $this->hasOne(Sms::class, 'postId');
    }

    public function campus()
    {
        return $this->hasOne(Campus::class, 'postId');
    }

    public function anouncements()
    {
        return $this->hasOne(Anouncement::class, 'postId');
    }

    public function bulletinBoards()
    {
        return $this->hasOne(BulletinBoard::class, 'postId');
    }

    public function homeVisit()
    {
        return $this->hasOne(HomeVisit::class, 'postId');
    }

    public function notifications()
    {
        return $this->hasOne(Notification::class, 'postId');
    }

    public function evaluations()
    {
        return $this->hasOne(Evaluation::class, 'postId');
    }

    public function recognitions()
    {
        return $this->hasOne(Recognition::class, 'postId');
    }

    public function shares()
    {
        return $this->hasOne(Share::class, 'postId');
    }

    public function regnames()
    {
        return $this->hasOne(Regname::class, 'postId');
    }

    public function homework()
    {
        return $this->hasOne(Homework::class, 'postId');
    }

    public function homeworkResult()
    {
        return $this->hasOne(HomeworkResult::class, 'postId');
    }

    public function shiftMng()
    {
        return $this->hasOne(ShiftMng::class, 'postId');
    }
}
