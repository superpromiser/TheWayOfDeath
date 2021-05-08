<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InterClassStory;
use App\Post;
use Illuminate\Support\Facades\Auth;

class InterClassStoryController extends Controller
{
    //
    public function getInterClassStory(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
            'lessonId' => 'required'
        ]);
        return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 26])
            ->with([
                'likes',
                'views',
                'comments.users:id,name',
                'interclassstory',
                'users:id,name,avatar'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function createInterClassStory(Request $request)
    {
        $this->validate($request, [
            'content' => 'required',
            'schoolId' => 'required',
            'lessonId' => 'required'
        ]);
        $userId = Auth::user()->id;
        $content = json_encode($request->content);
        $postId = Post::create([
            'contentId' => 26,
            'userId' => $userId,
            'schoolId' => $request->schoolId,
            'classId' => $request->lessonId
        ])->id;
        return InterClassStory::create([
            'content' => $content,
            'schoolId' => $request->schoolId,
            'lessonId' => $request->lessonId,
            'postId' => $postId,
            'userId' => $userId,
        ]);
    }

    public function updateInterClassStory(Request $request)
    {
    }

    public function deleteInterClassStory(Request $request)
    {
    }
}
