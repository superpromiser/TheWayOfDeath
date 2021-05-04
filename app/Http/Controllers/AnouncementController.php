<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anouncement;
use App\Post;
use Illuminate\Support\Facades\Auth;

class AnouncementController extends Controller
{
    //

    public function getAnouncement(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 5])
            ->with([
                'likes',
                'views',
                'comments',
                'anouncements',
                'users:id,name,avatar'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function createAnouncement(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'signName' => 'required',
            'viewList' => 'required',
            'scopeFlag' => 'required',
            'content' => 'required'
        ]);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId' => 5,
            'userId' => $userId,
            'schoolId' => $request->schoolId,
            'classId' => $request->lessonId,
            'viewList' => $request->viewList,
        ])->id;
        return Anouncement::create([
            'title' => $request->title,
            'signName' => $request->signName,
            'viewList' => json_encode($request->viewList),
            'scopeFlag' => $request->scopeFlag,
            'content' => json_encode($request->content),
            'schoolId' => $request->schoolId,
            'lessonId' => $request->lessonId,
            'postId' => $postId,
            'userId' => $userId,

        ]);
    }

    public function updateAnouncement(Request $reqeust)
    {
    }

    public function deleteAnouoncement(Request $request)
    {
    }
}
