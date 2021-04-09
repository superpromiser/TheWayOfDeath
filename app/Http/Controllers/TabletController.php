<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\scheduleClass;

class TabletController extends Controller
{
    //
    public function getDashboardData(Request $request)
    {
        $weekMap = [
            0 => 'sun',
            1 => 'mon',
            2 => 'tue',
            3 => 'wed',
            4 => 'thu',
            5 => 'fri',
            6 => 'sat',
        ];
        $dayOfTheWeek = Carbon::now()->dayOfWeek;
        $weekday = $weekMap[$dayOfTheWeek];
        $schoolId = Auth::user()->schoolId;
        $lessonId = Auth::user()->lessonId;
        $scheduleData = scheduleClass::where(['schoolId' => $schoolId, 'lessonId' => $lessonId])->first()->scheduleData;
    }
}
