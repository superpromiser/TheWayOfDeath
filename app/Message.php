<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'from',
        'to',
        'text',
        'image',
        'video',
        'voice',
        'map',
        'file',
        'roomId',
    ];

    public function from(){
        return $this->belongsTo(User::class, 'from')->select(['id', 'name', 'avatar']);
    }
    public function to(){
        return $this->belongsTo(User::class,'to');
    }
    public function roomId(){
        return $this->belongsTo(ChatRoom::class,'roomId');
    }
}
