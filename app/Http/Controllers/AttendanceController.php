<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attendance;
use Carbon\Carbon;
class AttendanceController extends Controller
{
    //

    public function getAttendanceData(Request $request){
        if(is_null($request->selDate)){
            $selDate = Carbon::today();
        }else{
            $selDate = $request->selDate;
        }
        return Attendance::whereDate('date',$selDate)->with('users:id,name')->get();
    }
}
