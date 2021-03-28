<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class VacationController extends Controller
{
    //
    public function getBanziName(){
        $lessonId = Auth::user()->lessonId;
        return User::select('name')->where(['lessonId'=>$lessonId,'roleId'=>3])->first();
    }
}
