<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SafeStudy;
use App\Post;
use Illuminate\Support\Facades\Auth;

class SafeStudyController extends Controller
{
    //
    public function getSafeStudy(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 8])
            ->with([
                'likes',
                'views',
                'comments',
                'safestudy',
                'users:id,name'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function createSafeStudy(Request $request)
    {
        $this->validate($request, [
            'content' => 'required'
        ]);
        $shareData = json_encode($request->content);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId' => 8,
            'userId' => $userId,
            'schoolId' => $request->schoolId
        ])->id;
        return SafeStudy::create([
            'content' => $shareData,
            'postId' => $postId,
            'userId' => $userId,
            'schoolId' => $request->schoolId
        ]);
    }

    public function updateSafeStudy(Request $request)
    {
    }

    public function deleteSafeStudy(Request $request)
    {
    }
}
