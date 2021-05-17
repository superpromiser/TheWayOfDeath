<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TodayDuty;
use App\Post;
use Illuminate\Support\Facades\Auth;

class TodayDutyController extends Controller
{
    //
    public function getTodayDutyData(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 15])
            ->with([
                'likes',
                'views',
                'comments.users:id,name',
                'todayduty',
                'users:id,name,avatar'
            ])
            ->orderBy('fixTop', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function createTodayDutyData(Request $request)
    {
        $this->validate($request, [
            'userList' => 'required',
            'dutyDate' => 'required',
            'schoolId' => 'required',
            'lessonId' => 'required',
        ]);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId' => 15,
            'userId' => $userId,
            'schoolId' => $request->schoolId,
            'classId' => $request->lessonId
        ])->id;
        TodayDuty::create([
            'userList' => $request->userList,
            'dutyDate' => $request->dutyDate,
            'schoolId' => $request->schoolId,
            'lessonId' => $request->lessonId,
            'userId' => $userId,
            'postId' => $postId,
        ]);
        return true;
    }

    public function updateTodayDutyData(Request $request)
    {
    }

    public function deleteTodayDutyData(Request $request)
    {
    }
}
