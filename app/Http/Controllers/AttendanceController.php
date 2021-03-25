<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attendance;
class AttendanceController extends Controller
{
    //

    public function getAttendanceData(){
        return Attendance::with('users')->get();
    }
}
