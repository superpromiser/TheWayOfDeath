<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ScheduleSetting;
use App\ScheduleClass;
use App\ScheduleTeacher;
use App\Subject;
use App\Lesson;

use App\Session;

use Illuminate\Support\Facades\Auth;

class ScheduleClassController extends Controller
{
    //
    public function getSCheduleClass(){
        $lessonId = Auth::user()->lessonId;
        $lessonName = Lesson::where(['id'=>$lessonId])->first()->lessonName;
        $lastSession = Session::latest('id')->first();
        
        if($lastSession){ // error appears next line with id is non defined, so setted if condition
            $subjectOrder = Subject::where(['schoolId'=>Auth::user()->schoolId, 'sessionId'=>$lastSession->id])->get();
            $mySchoolScheduleTeacherData = ScheduleTeacher::where(['schoolId'=>Auth::user()->schoolId])->get();
    
            $scheduleTeacherDataArr = array();
            foreach ($mySchoolScheduleTeacherData as $key => $scheduleTeacherData){
                $lessonArr = $scheduleTeacherData->lessons;
                foreach ($lessonArr as $key => $lesson){
                    if($lesson == $lessonName){
                        array_push($scheduleTeacherDataArr, $scheduleTeacherData);
                    }
                }
            }
            $scheduleData = ScheduleClass::where(['lessonId'=>$lessonId])->get();
            return response()->json([
                'scheduleData' => $scheduleData,
                'lastSession' => $lastSession,
                'scheduleTeacherDataArr' => $scheduleTeacherDataArr,
                'subjectOrder' => $subjectOrder,
            ]);
        }
    }

    public function createScheduleClass(Request $request){
        $this->validate($request,[
            'classSchedule'=>'required',
        ]);
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        $gradeId = Auth::user()->gradeId;
        $lessonId = Auth::user()->lessonId;

        $scheduleData = json_encode($request->classSchedule);
        
        ScheduleClass::create([
            'userId' => $userId,
            'schoolId' => $schoolId,
            'gradeId' => $gradeId,
            'lessonId' => $lessonId,
            'scheduleData'=> $scheduleData
        ]);
        return response()->json([
            'msg' => 1,
        ]);
    }

    public function updateScheduleClass(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'classSchedule'=>'required',
        ]);
        $scheduleData = json_encode($request->classSchedule);

        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;

        ScheduleClass::where(['id'=>$request->id])->update([
            'scheduleData' => $scheduleData,
        ]);

        return response()->json([
            'msg' => 1,
        ]);
    }

    public function deleteScheduleClass(Request $request){

    }
}
