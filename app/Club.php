<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    //
    protected $guarded = [];
    protected $casts = [
        'members' => 'array'
    ];

    public function member()
    {
        return $this->hasMany(ClubMember::class, 'clubId');
    }
}
