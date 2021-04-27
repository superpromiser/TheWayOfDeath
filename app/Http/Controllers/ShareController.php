<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Share;
use App\Post;
use App\Template;
use Illuminate\Support\Facades\Auth;

class ShareController extends Controller
{

    public function getShare(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        if ($request->userId) {
            return Post::where(['schoolId' => $request->schoolId, 'userId' => $request->userId, 'contentId' => 23])
                ->with([
                    'likes',
                    'views',
                    'comments',
                    'shares',
                    'users:id,name,avatar'
                ])
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        } else {
            return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 23])
                ->with([
                    'likes',
                    'views',
                    'comments',
                    'shares',
                    'users:id,name,avatar'
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

    public function getTempCnt(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
        ]);
        $userId = Auth::user()->id;
        $result['draftCnt'] = Template::where(['contentId' => 23, 'userId' => $userId, 'schoolId' => $request->schoolId, 'tempType' => 2])->count();
        $result['templateCnt'] = Template::where(['contentId' => 23, 'userId' => $userId, 'schoolId' => $request->schoolId, 'tempType' => 1])->count();
        return $result;
    }

    public function getTempList(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        $userId = Auth::user()->id;
        return Template::where(['contentId' => 23, 'userId' => $userId, 'schoolId' => $request->schoolId,])->get();
    }

    public function createTemp(Request $request)
    {
        $userId = Auth::user()->id;
        Template::create([
            'contentId' => 23,
            'userId' => $userId,
            'tempTitle' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'schoolId' => $request->schoolId,
            'tempType' => $request->tempType
        ]);
        return true;
    }

    public function deleteTemp(Request $request)
    {
    }
}
