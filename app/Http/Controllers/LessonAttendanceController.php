<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LessonAttendance;
use Illuminate\Support\Facades\Auth;
class LessonAttendanceController extends Controller
{
    //

    public function getLessonAttendance(Request $request){
        $this->validate($request,[
            'attDate'=>'required'
        ]);
        $attDate = $request->attDate;
        $lessonId = Auth::user()->lessonId;
        return LessonAttendance::select('attendanceDay','attendanceTime','resultArr')->where(['attendanceDay'=>$request->attDate,'lessonId'=>$lessonId])->get();
    }

    public function createLessonAttendance(Request $request){
        $this->validate($request,[
            'attendanceDay'=>'required',
            'attendanceTime'=>'required',
            'resultArr'=>'required'
        ]);
        $lessonId = Auth::user()->lessonId;
        return LessonAttendance::create([
            'attendanceDay'=>$request->attendanceDay,
            'attendanceTime'=>$request->attendanceTime,
            'resultArr'=>json_encode($request->resultArr),
            'lessonId'=>$lessonId
        ]);

    }

    public function updateLessonAttendance(Request $request){

    }

    public function deleteLessonAtttendance(Request $request){

    }
}