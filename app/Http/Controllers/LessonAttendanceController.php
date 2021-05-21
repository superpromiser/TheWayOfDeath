<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LessonAttendance;
use App\Session;
use App\Subject;
use Illuminate\Support\Facades\Auth;

class LessonAttendanceController extends Controller
{
    //

    public function getLessonAttendance(Request $request)
    {
        $this->validate($request, [
            'attDate' => 'required'
        ]);
        $attDate = $request->attDate;
        $lessonId = Auth::user()->lessonId;
        return LessonAttendance::select('attendanceDay', 'attendanceTime', 'resultArr')->where(['attendanceDay' => $request->attDate, 'lessonId' => $lessonId])->get();
    }

    public function createLessonAttendance(Request $request)
    {
        $this->validate($request, [
            'attendanceDay' => 'required',
            'attendanceTime' => 'required',
            'resultArr' => 'required'
        ]);
        $lessonId = Auth::user()->lessonId;
        $schoolId = Auth::user()->schoolId;
        $gradeId = Auth::user()->gradeId;
        return LessonAttendance::create([
            'attendanceDay' => $request->attendanceDay,
            'attendanceTime' => $request->attendanceTime,
            'resultArr' => json_encode($request->resultArr),
            'schoolId' => $schoolId,
            'gradeId' => $gradeId,
            'lessonId' => $lessonId
        ]);
    }

    public function updateLessonAttendance(Request $request)
    {
    }

    public function deleteLessonAttendance(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        return LessonAttendance::where('id', $request->id)->delete();
    }

    public function getStatLessonAttData(Request $request)
    {
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required'
        ]);
        $from = $request->from;
        $to = $request->to;
        if (Auth::user()->roleId == 2) {
            $schoolId = Auth::user()->schoolId;
            return LessonAttendance::whereBetween('attendanceDay', [$from, $to])->where('schoolId', $schoolId)->get();
        } else {
            $lessonId = Auth::user()->lessonId;
            return LessonAttendance::whereBetween('attendanceDay', [$from, $to])->where('lessonId', $lessonId)->get();
        }
    }

    public function getStatDetailAttData(Request $request)
    {
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required',
        ]);
        $from = $request->from;
        $to = $request->to;
        if ($request->schoolId) {
            $schoolId = $request->schoolId;
            return LessonAttendance::whereBetween('attendanceDay', [$from, $to])->where('schoolId', $schoolId)->get();
        } else {
            $lessonId = $request->lessonId;
            return LessonAttendance::whereBetween('attendanceDay', [$from, $to])->where('lessonId', $lessonId)->get();
        }
    }
    public function getLessonItem(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
        ]);
        $schoolId = $request->schoolId;
        $lastSession = Session::latest('id')->first();
        $subjectOrder = array();
        if ($lastSession) {
            $subjectOrder = Subject::where(['schoolId' => Auth::user()->schoolId, 'sessionId' => $lastSession->id])->get();
        }

        return $subjectOrder;
    }
}
