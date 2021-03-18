<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Like;

class LikeController extends Controller
{
    //
    public function addLike(Request $request){
        $this->validate($request,[
            'postId'=>'required'
        ]);
        $userId = Auth::user()->id;
        $postId = $request->postId;
        return Like::create([
            'userId'=>$userId,
            'postId'=>$postId
        ]);
    }

    public function removeLike(Request $request){
        $this->validate($request,[
            'postId'=>'required'
        ]);
        $userId = Auth::user()->id;
        $postId = $request->postId;
        return Like::where([
            'postId'=>$postId,
            'userId'=>$userId
        ])->delete();
    }
}
