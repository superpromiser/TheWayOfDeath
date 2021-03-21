<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    //
    protected $guarded = [];

    public function users(){
        return $this->belongsTo(User::class,'userId');
    }

    public function questionnaire(){
        return $this->hasMany(QuestionnaireTemp::class,'tempId');
    }
}
