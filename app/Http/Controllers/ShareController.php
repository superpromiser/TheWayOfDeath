<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Share;
use App\Post;

use Illuminate\Support\Facades\Auth;

class ShareController extends Controller
{

    public function getShare(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        if($request->userId){
            return Post::where(['schoolId' => $request->schoolId, 'userId' => $request->userId, 'contentId' => 23])
                ->with([
                    'likes',
                    'views',
                    'comments',
                    'shares',
                    'users:id,name'
                ])
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }
        else{
            return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 23])
                ->with([
                    'likes',
                    'views',
                    'comments',
                    'shares',
                    'users:id,name'
                ])
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }
    }

    public function createShare(Request $request)
    {
        $this->validate($request, [
            'content' => 'required'
        ]);
        $shareData = json_encode($request->content);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId' => 23,
            'userId' => $userId,
            'schoolId' => $request->schoolId
        ])->id;
        Share::create([
            'content' => $shareData,
            'postId' => $postId,
            'schoolId' => $request->schoolId
        ]);

        return response()->json([
            'msg' => 'ok'
        ], 200);
    }
}
