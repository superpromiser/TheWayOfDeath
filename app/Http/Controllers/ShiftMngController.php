<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\ShiftMng;
use Illuminate\Support\Facades\Auth;

class ShiftMngController extends Controller
{
    //
    public function getShiftMng(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 9])
            ->with([
                'likes',
                'views',
                'comments',
                'shiftMng',
                'users:id,name'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function createShiftMng(Request $request)
    {
        $this->validate($request, [
            'prevName' => 'required',
            'prevNameId' => 'required',
            'nextName' => 'required',
            'nextNameId' => 'required',
            'scheduleDate' => 'required',
            'itemList' => 'required',
            'schoolId' => 'required',
        ]);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId' => 9,
            'userId' => $userId,
            'schoolId' => $request->schoolId
        ])->id;

        return ShiftMng::create([
            'prevName' => $request->prevName,
            'prevNameId' => $request->prevNameId,
            'nextName' => $request->nextName,
            'nextNameId' => $request->nextNameId,
            'schoolId' => $request->schoolId,
            'scheduleDate' => $request->scheduleDate,
            'itemList' => $request->itemList,
            'postId' => $postId,
        ]);
    }

    public function updateShiftMng(Request $request)
    {
    }

    public function deleteShiftMng(Request $request)
    {
    }
}
