<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Homework;
use App\Post;

class HomeworkController extends Controller
{
    //
    public function getHomeworkData(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
            'lessonId' => 'required',
        ]);
        return Homework::where(['schoolId' => $request->schoolId, 'lessonId' => $request->lessonId])->get();
    }

    public function createHomeworkData(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
            'lessonId' => 'required',
            'subjectName' => 'required',
            'homeworkType' => 'required',
            'content' => 'required',
        ]);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId' => 14,
            'userId' => $userId,
            'schoolId' => $request->schoolId,
            'classId' => $request->lessonId
        ])->id;

        return Homework::create([
            'subjectName' => $request->subjectName,
            'homeworkType' => $request->homeworkType,
            'content' => json_encode($request->content),
            'deadline' => $request->deadline,
            'monitorName' => $request->monitorName,
            'parentCheck' => $request->parentCheck,
            'schoolId' => $request->schoolId,
            'lessonId' => $request->lessonId,
            'userId' => $userId,
            'postId' => $postId
        ]);
    }

    public function updateHomeworkData(Request $request)
    {
    }

    public function deleteHomeworkData(Request $request)
    {
    }
}
