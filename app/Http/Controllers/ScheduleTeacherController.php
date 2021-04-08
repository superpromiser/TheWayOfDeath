<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ScheduleTeacher;
use Illuminate\Support\Facades\Auth;

class ScheduleTeacherController extends Controller
{
    public function getSubject(Request $request){
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        return ScheduleTeacher::where(['userId'=>$userId,'schoolId'=>$schoolId ])->get();
    }

    public function createSubject(Request $request){
        $this->validate($request,[
            'subjectOrderName'=>'required',
            'subjectOrderType'=>'required',
            'startTime'=>'required',
            'endTime'=>'required',
            'subjectStartDate'=>'required'
        ]);
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        return ScheduleTeacher::create([
            'userId'=>$userId,
            'schoolId'=>$schoolId,
            'sessionId'=>$request->sessionId,
            'subjectOrderName'=>$request->subjectOrderName,
            'subjectOrderType'=>$request->subjectOrderType,
            'startTime'=>$request->startTime,
            'endTime'=>$request->endTime,
            'subjectStartDate'=>$request->subjectStartDate,
        ]);

    }

    public function updateSubject(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'subjectOrderName'=>'required',
            'subjectOrderType'=>'required',
            'subjectStartDate'=>'required',
            'startTime'=>'required',
            'endTime'=>'required',
        ]);
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        return ScheduleTeacher::where(['userId'=>$userId,'schoolId'=>$schoolId,'id'=>$request->id])->update([
            'subjectOrderName'=>$request->subjectOrderName,
            'subjectOrderType'=>$request->subjectOrderType,
            'subjectStartDate'=>$request->subjectStartDate,
            'startTime'=>$request->startTime,
            'endTime'=>$request->endTime
        ]);
        
    }

    public function deleteSubject(Request $request){
        $this->validate($request,[
            'id'=>'required'
        ]);
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        return ScheduleTeacher::where([
            'id'=>$request->id,
            'userId'=>$userId,
            'schoolId'=>$schoolId
        ])->delete();
    }
}
