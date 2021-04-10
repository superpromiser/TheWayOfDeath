<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    //

    public function getAttendanceData(Request $request)
    {
        if (is_null($request->selDate)) {
            $selDate = Carbon::today();
        } else {
            $selDate = $request->selDate;
        }
        return Attendance::whereDate('date', $selDate)->with('user:id,name')->get();
    }

    public function getStatData(Request $request)
    {
        $this->validate($request, [
            'startDate' => 'required',
            'endDate' => 'required'
        ]);
        $from = $request->startDate;
        $to = $request->endDate;
        return Attendance::whereBetween('date', [$from, $to])->with(['school:id,schoolName', 'grade:id,gradeName', 'lesson:id,lessonName', 'user:id,name'])->get();
    }
}
