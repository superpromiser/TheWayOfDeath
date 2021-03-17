<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;


class PostController extends Controller
{
    //
    public function getAllPost(){
        return Post::with([
            'questionnaires',
            'votings',
            'sms',
            'users:id,name'])
        ->orderBy('created_at','desc')
        ->paginate(5);
    }

    public function likeAction(Request $request){
        $this->validate($request,[
            'isLiked'=>'required',
            'likeCnt'=>'required',
            'contentId'=>'required'
        ]);
        return Post::where('id',$request->contentId)->update([
            'isLiked'=>$request->isLiked,
            'likeCnt'=>$request->likeCnt
        ]);

    }
}
