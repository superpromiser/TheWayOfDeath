<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ScheduleSetting;
use App\ScheduleClass;

use Illuminate\Support\Facades\Auth;

class ScheduleClassController extends Controller
{
    //
    public function getSCheduleClass(){
        $userId = Auth::user()->id;
        return ScheduleSetting::where(['teacherId'=>$userId,'isActived'=>0])->with('subjects')->get();
    }

    public function createScheduleClass(Request $request){
        
    }

    public function updateScheduleClass(Request $request){

    }

    public function deleteScheduleClass(Request $request){

    }
}
