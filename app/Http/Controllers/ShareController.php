<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Share;
use App\Post;

use Illuminate\Support\Facades\Auth;

class ShareController extends Controller
{
    public function createShare(Request $request){
        $this->validate($request,[
            'content'=>'required'
        ]);
        $shareData = json_encode($request->content);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId'=>23,
            'userId'=>$userId,
            'schoolId'=>$request->schoolId
        ])->id;
        Share::create([
            'content'=>$shareData,
            'postId'=>$postId,
        ]);

        return response()->json([
            'msg' => 'ok'
        ],200);

    }
}
