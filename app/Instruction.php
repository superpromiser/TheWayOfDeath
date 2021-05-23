<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instruction extends Model
{
    //
    protected $guarded = [];
    protected $casts = [
        'familyData' => 'array'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
