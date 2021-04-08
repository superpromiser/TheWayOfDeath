<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeworkResult extends Model
{
    //
    protected $guarded = [];

    public function homework()
    {
        return $this->belongsTo(Homework::class, 'homeworkId');
    }
}
