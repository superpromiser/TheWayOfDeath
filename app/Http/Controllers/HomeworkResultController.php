<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HomeworkResult;
use Illuminate\Support\Facades\Auth;
use App\Post;

class HomeworkResultController extends Controller
{
    //
    public function getHomeworkResult(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        $userId = Auth::user()->id;
        return HomeworkResult::where([
            'schoolId' => $request->schoolId,
            'lessonId' => $request->lessonId,
            'userId' => $userId,
            'homeworkId' => $request->homeworkId
        ])->first();
    }

    public function createHomeworkResult(Request $request)
    {
        $this->validate($request, [
            'homeworkId' => 'required',
            'content' => 'required',
            'homeworkType' => 'required',
            'schoolId' => 'required'
        ]);

        $userId = Auth::user()->id;

        $postId = Post::create([
            'schoolId' => $request->schoolId,
            'classId' => $request->lessonId,
            'userId' => $userId,
            'contentId' => 22
        ])->id;

        return HomeworkResult::create([
            'homeworkId' => $request->homeworkId,
            'content' => json_encode($request->content),
            'homeworkType' => $request->homeworkType,
            'schoolId' => $request->schoolId,
            'lessonId' => $request->lessonId,
            'userId' => $userId,
            'postId' => $postId
        ]);
    }

    public function getOfflineTeacher(Request $request)
    {
        $this->validate($request, [
            'postId' => 'required'
        ]);
        return HomeworkResult::where('postId', $request->postId)->with('user:id,name')->get();
    }

    public function createOfflineTeacher(Request $request)
    {
        $this->validate($request, [
            'ratingList' => 'required'
        ]);
        foreach ($request->ratingList as $data) {
            HomeworkResult::create([
                'homeworkId' => $data['homeworkId'],
                'userId' => $data['userId'],
                'rating' => $data['rating'],
                'schoolId' => $data['schoolId'],
                'lessonId' => $data['lessonId'],
                'postId' => $data['postId'],
                'homeworkType' => $data['homeworkType']
            ]);
        }
        return;
    }

    public function updateTeacherAnswer(Request $request)
    {
        $this->validate($request, [
            'teacherAnswer' => 'required',
            'rating' => 'required',
            'id' => 'required'
        ]);

        return HomeworkResult::where('id', $request->id)->update([
            'teacherAnswer' => json_encode($request->teacherAnswer),
            'rating' => $request->rating
        ]);
    }

    public function getOfflineStudent(Request $request)
    {
        $this->validate($request, [
            'postId' => 'required'
        ]);
        $userId = Auth::user()->id;
        return HomeworkResult::where(['userId' => $userId, 'postId' => $request->postId])->first();
    }
}
