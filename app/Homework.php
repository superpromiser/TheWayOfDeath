<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    //
    protected $guarded = [];

    public function homeworkresult()
    {
        return $this->hasOne(HomeworkResult::class, 'homeworkId');
    }
}
