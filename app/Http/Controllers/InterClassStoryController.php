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
            ->orderBy('fixTop', 'desc')
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
        // return InterClassStory::create([
        //     'content' => $content,
        //     'schoolId' => $request->schoolId,
        //     'lessonId' => $request->lessonId,
        //     'postId' => $postId,
        //     'userId' => $userId,
        // ]);
        if ($request->publishType == 'pub') {
            InterClassStory::create([
                'content' => $content,
                'postId' => $postId,
                'schoolId' => $request->schoolId,
                'lessonId' => $request->lessonId,
                'userId' => $userId,
            ]);
        } else if ($request->publishType == 'spec') {
            InterClassStory::create([
                'content' => $content,
                'postId' => $postId,
                'schoolId' => $request->schoolId,
                'lessonId' => $request->lessonId,
                'viewList' => $request->specUsers,
                'userId' => $userId,
            ]);
        } else if ($request->publishType == 'pvt') {
            $pvtArr = array();
            array_push($pvtArr, $userId);
            InterClassStory::create([
                'content' => $content,
                'postId' => $postId,
                'schoolId' => $request->schoolId,
                'lessonId' => $request->lessonId,
                'viewList' => $pvtArr,
                'userId' => $userId,
            ]);
        }
        return response()->json([
            'msg' => 'ok'
        ], 200);
    }

    public function updateInterClassStory(Request $request)
    {
    }

    public function deleteInterClassStory(Request $request)
    {
    }
}
