<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Vacation;
use Illuminate\Support\Facades\Auth;

class VacationController extends Controller
{
    //
    public function getBanziName()
    {
        $lessonId = Auth::user()->lessonId;
        return User::select('id', 'name')->where(['lessonId' => $lessonId, 'roleId' => 7])->first();
    }

    public function currentVacation(Request $request)
    {
        $this->validate($request, [
            'vId' => 'required'
        ]);
        return Vacation::where('id', $request->vId)->first();
    }

    public function getVacation(Request $request)
    {
        $userId = Auth::user()->id;
        return Vacation::where(['teacherId' => $userId])->orWhere(['studentId' => $userId])->get();
    }

    public function allVacation(Request $request)
    {
        $userId = Auth::user()->id;
        $this->validate($request, [
            'schoolId' => 'required',
            'lessonId'=>'required'
        ]);
        if ($request->lessonId) {
            return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 20])
                ->with([
                    'likes',
                    'views',
                    'comments',
                    'vacations'=>function ($q) use($userId) {
                        $q->where('teacherId',$userId)->orWhere('studentId',$userId);
                    },
                    'users:id,name,avatar'
                ])
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }
    }

    public function createVacation(Request $request)
    {
        $this->validate($request, [
            'studentName' => 'required',
            'teacherName' => 'required',
            'startTime' => 'required',
            'endTime' => 'required',
            'reason' => 'required',
            'reasonFlag' => 'required',
            'isHeat' => 'required',
            'reasonFlag' => 'required'
        ]);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId' => 20,
            'userId' => $userId,
            'schoolId' => $request->schoolId,
            'classId' => $request->lessonId
        ])->id;
        $schoolId = $request->schoolId;
        $lessonId = $request->lessonId;

        return Vacation::create([
            'studentName' => $request->studentName,
            'teacherName' => $request->teacherName,
            'startTime' => $request->startTime,
            'endTime' => $request->endTime,
            'reason' => $request->reason,
            'reasonFlag' => $request->reasonFlag,
            'isHeat' => $request->isHeat,
            'painDesc' => $request->painDesc,
            'postId' => $postId,
            'studentId' => $userId,
            'teacherId' => $request->teacherId,
            'schoolId' => $request->schoolId,
            'lessonId' => $request->lessonId,
        ]);
    }

    public function updateVacation(Request $request)
    {
        $this->validate($request, [
            'status' => 'required',
            'vId' => 'required'
        ]);
        return Vacation::where([
            'id' => $request->vId,

        ])->update(['status' => $request->status]);
    }

    public function deleteVacation(Request $request)
    {
        $this->validate($request, [
            'postId' => 'required'
        ]);
        $id = $request->vId;
        // return Vacation::where('id',$request->vId)->delete();
        return Post::where('id', $request->postId)->delete();
    }
}
