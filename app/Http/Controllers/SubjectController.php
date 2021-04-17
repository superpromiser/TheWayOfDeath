<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;
use App\ScheduleTeacher;
use App\Lesson;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function getSubject(Request $request)
    {
        $sessionId = $request->sessionId;
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        return Subject::where(['userId' => $userId, 'schoolId' => $schoolId, 'sessionId' => $sessionId])->get();
    }

    public function createSubject(Request $request)
    {
        $this->validate($request, [
            'subjectOrderName' => 'required',
            'subjectOrderType' => 'required',
            'startTime' => 'required',
            'endTime' => 'required',
            'subjectStartDate' => 'required'
        ]);
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        return Subject::create([
            'userId' => $userId,
            'schoolId' => $schoolId,
            'sessionId' => $request->sessionId,
            'subjectOrderName' => $request->subjectOrderName,
            'subjectOrderType' => $request->subjectOrderType,
            'startTime' => $request->startTime,
            'endTime' => $request->endTime,
            'subjectStartDate' => $request->subjectStartDate,
        ]);
    }

    public function updateSubject(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'subjectOrderName' => 'required',
            'subjectOrderType' => 'required',
            'subjectStartDate' => 'required',
            'startTime' => 'required',
            'endTime' => 'required',
        ]);
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        return Subject::where(['userId' => $userId, 'schoolId' => $schoolId, 'id' => $request->id])->update([
            'subjectOrderName' => $request->subjectOrderName,
            'subjectOrderType' => $request->subjectOrderType,
            'subjectStartDate' => $request->subjectStartDate,
            'startTime' => $request->startTime,
            'endTime' => $request->endTime
        ]);
    }

    public function deleteSubject(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        return Subject::where([
            'id' => $request->id,
            'userId' => $userId,
            'schoolId' => $schoolId
        ])->delete();
    }


    public function getMySubject(Request $request)
    {
        // $schoolId = Auth::user()->schoolId;
        // if($schoolId == 0){

        // }
        $schoolId = $request->schoolId;
        $lessonId = $request->lessonId;
        $lessonName = Lesson::where('id', $lessonId)->first()->lessonName;
        $mySubject = array();
        $subjectList = ScheduleTeacher::where('schoolId', $schoolId)->get();
        foreach ($subjectList as $subject) {
            $lessons = $subject->lessons;
            foreach ($lessons as $lesson) {
                if ($lesson == $lessonName) {
                    array_push($mySubject, $subject->subjectName);
                }
            }
        }
        return $mySubject;
    }
}
