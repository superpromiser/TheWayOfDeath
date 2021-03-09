<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Grade;
use App\School;
class GradeController extends Controller
{
    //
    public function getGrade(){
        $grades = Grade::all();
        foreach($grades as $grade){
            $schoolName = School::select('schoolName')->where('id',$grade->schoolId)->get();
            $grade->schoolName = $schoolName[0]->schoolName;
        }
        return $grades;
    }

    public function createGrade(Request $request){
        $this->validate($request,[
            'gradeName'=>'required',
            'imgUrl'=>'required',
            'schoolId'=>'required'
        ]);
        $grade = Grade::create([
            'gradeName'=>$request->gradeName,
            'imgUrl'=>$request->imgUrl,
            'schoolId'=>$request->schoolId
        ]);
        $schoolName = School::select('schoolName')->where('id',$grade->schoolId)->get();
        $grade->schoolName = $schoolName[0]->schoolName;
        return $grade;
    }

    public function updateGrade(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'gradeName'=>'required',
            'imgUrl'=>'required',
            'schoolId'=>'required'
        ]);
        $grade = Grade::where('id',$request->id)->update([
            'gradeName'=>$request->gradeName,
            'imgUrl'=>$request->imgUrl,
            'schoolId'=>$request->schoolId
        ]);
        $schoolName = School::select('schoolName')->where('id',$request->schoolId)->get();
        file_put_contents('schoolName.txt',$schoolName[0]->schoolName);
        return response()->json([
            'schoolName'=>$schoolName[0]->schoolName
        ]);
    }

    public function deleteGrade(Request $request){
        return Grade::where('id',$request->id)->delete();
    }

    public function getSchoolName(){
        $school = School::select('id','schoolName')->get();
        return $school;
    }
}
