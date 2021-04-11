<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\BulletinBoard;
use Illuminate\Support\Facades\Auth;

class BulletinBoardController extends Controller
{
    //
    public function getBulletinBoard(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 6])
            ->with([
                'likes',
                'views',
                'comments',
                'bulletinBoards',
                'users:id,name'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function createBulletinBoard(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
            'content' => 'required'
        ]);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId' => 6,
            'userId' => $userId,
            'schoolId' => $request->schoolId
        ])->id;
        return BulletinBoard::create([
            'type' => $request->type,
            'content' => json_encode($request->content),
            'postId' => $postId,
            'schoolId' => $request->schoolId
        ]);
    }

    public function updateBulletinBoard(Request $request)
    {
    }

    public function deleteBulletinBoard(Request $request)
    {
    }
}
