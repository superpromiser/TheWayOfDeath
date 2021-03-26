<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CheckIn;
use Illuminate\Support\Facades\Auth;

class CheckInController extends Controller
{
    //
    public function getCheckInData(){

    }

    public function createCheckInData(Request $request){
        $this->validate($request,[
            'checkInDate'=>'required',
            'checkAttendanceType'=>'required',
            'checkType'=>'required',
            'studentId'=>'required',
            'signal'=>'required',
            'startTime'=>'required',
            'reason'=>'required',
            'hospital'=>'required'
        ]);
        $userId = Auth::user()->id;
        return CheckIn::create([
            'checkInDate'=>$request->checkAttendanceDate,
            'checkAttendanceType'=>$request->checkAttendanceType,
            'checkType'=>$request->checkType,
            'studentId'=>$request->studentId,
            'signal'=>$request->signal,
            'startTime'=>$request->startTime,
            'reason'=>$request->reason,
            'hospital'=>$request->hospital,
            'userId'=>$request->userId
        ]);

    }

    public function updateCheckInData(){

    }

    public function deleteCheckInData(){

    }
}
