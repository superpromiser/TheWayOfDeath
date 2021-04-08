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
    public function getBaseData(Request $request){
        
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        $baseData['subjectArr'] = ScheduleSetting::select('id','subjectName', 'gradeId')->where([
            'schoolId'=>$schoolId
        ])->get();
        $baseData['teacherArr'] = User::select('id','name')->where([
            'schoolId'=>$schoolId,
            'roleId'=>3
        ])->get();
        $baseData['gradeArr'] = Grade::select('id','gradeName')->with('lessons:id,lessonName,gradeId')->where('schoolId',$schoolId)->get();

        
        return response()->json([
            'data'=>$baseData,
            'status'=>200
        ]);
    }

    public function getSchedule(Request $request){
        $this->validate($request,[
            'gradeId'=>'required'
        ]);
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        return ScheduleSetting::where(['schoolId'=>$schoolId,'userId'=>$userId,'gradeId'=>$request->gradeId,'isActived'=>0])->get();
    }

    public function createSchedule(Request $request){
        $this->validate($request,[
            'gradeId'=>'required',
            'subjectName'=>'required'
        ]);
        $subjectName = $request->subjectName;
        $gradeId = $request->gradeId;
        // Subject::where('id',$request->subject['id'])->update([
        //     'isActived'=>1
        // ]);
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        return ScheduleSetting::create([
            'gradeId'=>$request->gradeId,
            'subjectName'=>$request->subjectName,
            'schoolId'=>$schoolId,
            'userId'=>$userId
        ]);
    }

    public function updateSchedule(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'subjectName'=>'required'
        ]);
        $subjectName = $request->subjectName;
        $gradeId = $request->gradeId;
        // Subject::where('id',$request->subject['id'])->update([
        //     'isActived'=>1
        // ]);
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        return ScheduleSetting::where(['userId'=>$userId,'schoolId'=>$schoolId,'id'=>$request->id])->update([
            'gradeId'=>$gradeId,
            'subjectName'=>$request->subjectName,
        ]);
    }

    public function deleteSchedule(Request $request){
        $this->validate($request,[
            'id'=>'required'
        ]);
        return ScheduleSetting::where('id',$request->id)->delete();
    }
}
