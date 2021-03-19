<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;
use App\User;
use App\Grade;
use App\ScheduleSetting;
use Illuminate\Support\Facades\Auth;
class ScheduleSettingController extends Controller
{
    //
    public function getBaseData(){
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        $baseData['subjectArr'] = Subject::select('id','subjectName')->where([
            'userId'=>$userId,
            'schoolId'=>$schoolId
        ])->get();
        $baseData['teacherArr'] = User::select('id','name')->where([
            'schoolId'=>$schoolId,
            'roleId'=>3
        ])->get();
        $baseData['gradeArr'] = Grade::select('id','gradeName')->with('lessons:id,lessonName,gradeId')->where('schoolId',$schoolId)->get();

        $baseData['scheduleArr'] = ScheduleSetting::select('id','subjectName','teacherName','lessonName')->where(['schoolId'=>$schoolId,'userId'=>$userId])->get();
        return response()->json([
            'data'=>$baseData,
            'status'=>200
        ]);
    }

    public function createSchedule(Request $request){
        $this->validate($request,[
            'lesson'=>'required',
            'subject'=>'required',
            'teacher'=>'required'
        ]);
        $subject = $request->subject;
        $lesson = $request->lesson;
        $teacher = $request->teacher;
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        return ScheduleSetting::create([
            'subjectName'=>$request->subject['subjectName'],
            'subjectId'=>$request->subject['id'],
            'teacherName'=>$request->teacher['teacherName'],
            'teacherId'=>$request->teacher['id'],
            'lessonName'=>$request->lesson['lessonName'],
            'lessonId'=>$request->lesson['id'],
            'schoolId'=>$schoolId,
            'userId'=>$userId
        ]);
    }
}
