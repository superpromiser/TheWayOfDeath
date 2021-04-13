<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnTeam extends Model
{
    protected $guarded = [];

    public function teacherId(){
        return $this->belongsTo(User::class, 'teacherId')->select(['id', 'name', 'avatar', 'gender', 'phoneNumber']);
    }

    public function leaderId(){
        return $this->belongsTo(User::class, 'leaderId')->select(['id', 'name', 'avatar', 'gender', 'phoneNumber']);
    }

    protected $casts = [
        'member' => 'array',
    ];
}
