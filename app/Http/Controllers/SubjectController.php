<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;
use Illuminate\Support\Facades\Auth;
class SubjectController extends Controller
{
    public function getSubject(){
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        return Subject::where(['userId'=>$userId,'schoolId'=>$schoolId])->get();
    }

    public function createSubject(Request $request){
        $this->validate($request,[
            'subjectName'=>'required',
            'subjectType'=>'required',
            'startTime'=>'required',
            'endTime'=>'required',
        ]);
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        return Subject::create([
            'userId'=>$userId,
            'schoolId'=>$schoolId,
            'subjectName'=>$request->subjectName,
            'subjectType'=>$request->subjectType,
            'startTime'=>$request->startTime,
            'endTime'=>$request->endTime
        ]);

    }

    public function updateSubject(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'subjectName'=>'required',
            'subjectType'=>'required',
            'startTime'=>'required',
            'endTime'=>'required',
        ]);
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        return Subject::where(['userId'=>$userId,'schoolId'=>$schoolId,'id'=>$request->id])->update([
            'subjectName'=>$request->subjectName,
            'subjectType'=>$request->subjectType,
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
        return Subject::where([
            'id'=>$request->id,
            'userId'=>$userId,
            'schoolId'=>$schoolId
        ])->delete();
    }
}
