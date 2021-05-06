<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\SchoolStory;
use Illuminate\Support\Facades\Auth;

class SchoolStoryController extends Controller
{
    //
    public function getSchoolStory(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 11])
            ->with([
                'likes',
                'views',
                'comments',
                'schoolstory',
                'users:id,name,avatar'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }
    public function getSchoolStoryMo(Request $request)
    {
        $schoolId = $request->schoolId;
        $lessonId = $request->lessonId;

        $classStory =  Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 25])
            ->with([
                'classstory',
                'users:id,name'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        $schoolStory =  Post::where(['schoolId' => $request->schoolId,  'contentId' => 11])
            ->with([
                'schoolstory',
                'users:id,name'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'classStory' => $classStory,
            'schoolStory' => $schoolStory
        ], 200);
        // return response()->json([
        //     'classStory' => "c",
        //     'schoolStory' => "s"
        // ], 200); 
    }

    public function createSchoolStory(Request $request)
    {
        $this->validate($request, [
            'content' => 'required',
            'schoolId' => 'required'
        ]);
        $content = json_encode($request->content);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId' => 11,
            'userId' => $userId,
            'schoolId' => $request->schoolId
        ])->id;
        return SchoolStory::create([
            'content' => $content,
            'schoolId' => $request->schoolId,
            'userId' => $userId,
            'postId' => $postId,
        ]);
    }

    public function updateSchoolStory(Request $request)
    {
    }

    public function deleteSchoolStory(Request $request)
    {
    }
}
