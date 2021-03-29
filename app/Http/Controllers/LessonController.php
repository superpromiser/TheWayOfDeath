<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lesson;
use App\Grade;
use App\School;
class LessonController extends Controller
{
    //

    public function getLesson(){
        $lessons = Lesson::all();
        foreach($lessons as $lesson){
            $school = School::select('schoolName')->where('id',$lesson->schoolId)->first();
            $grade = Grade::select('gradeName')->where('id',$lesson->gradeId)->first();
            $lesson->schoolName = $school->schoolName;
            $lesson->gradeName = $grade->gradeName;
        }
        return $lessons;
    }

    public function createLesson(Request $request){
        $this->validate($request,[
            'lessonName'=>'required',
            'imgUrl'=>'required',
            'schoolId'=>'required',
            'gradeId'=>'required'
            ]);

        $lesson = Lesson::create([
            'lessonName'=>$request->lessonName,
            'imgUrl'=>$request->imgUrl,
            'schoolId'=>$request->schoolId,
            'gradeId'=>$request->gradeId
        ]);
        $school = School::select('schoolName')->where('id',$request->schoolId)->first();
        $grade = Grade::select('gradeName')->where('id',$request->gradeId)->first();
        $lesson->schoolName = $school->schoolName;
        $lesson->gradeName = $grade->gradeName;
        return $lesson;
    }

    public function updateLesson(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'lessonName'=>'required',
            'imgUrl'=>'required',
            'schoolId'=>'required',
            'gradeId'=>'required'
            ]);
        Lesson::where('id',$request->id)->update([
            'lessonName'=>$request->lessonName,
            'imgUrl'=>$request->imgUrl,
            'schoolId'=>$request->schoolId,
            'gradeId'=>$request->gradeId
        ]);
        $school = School::where('id',$request->schoolId)->first();
        $grade = Grade::where('id',$request->gradeId)->first();
        return response()->json([
            'schoolName'=>$school->schoolName,
            'gradeName'=>$grade->gradeName
        ]);
    }

    public function deleteLesson(Request $request){
        return Lesson::where('id',$request->id)->delete();
    }

    public function getGradeName(Request $request){
        $id = $request->id;
        return Grade::where('schoolId',$request->id)->get();
    }
}
