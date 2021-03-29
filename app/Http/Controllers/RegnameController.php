<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Regname;
use App\Post;

use Illuminate\Support\Facades\Auth;


class RegnameController extends Controller
{
    public function createRegname(Request $request){
        $this->validate($request,[
            'content'=>'required'

        ]);
        $shareData = json_encode($request->content);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId'=>24,
            'userId'=>$userId,
            'schoolId'=>$request->schoolId
        ])->id;
        return Regname::create([
            'content'=>$shareData,
            'postId'=>$postId,
        ]);

    }
}
