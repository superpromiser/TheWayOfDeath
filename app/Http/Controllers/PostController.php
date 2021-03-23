<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Like;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //
    public function getSchoolPost(){
        $userId = Auth::user()->id;
        // $isLiked = Like::where('userId',$userId)->count();
        return $posts = Post::whereIn('contentId',[1,2,3,4,5,6,10])
        ->with([
            'likes',
            'views',
            'comments',
            'questionnaires',
            'votings',
            'sms',
            'campus',
            'anouncements',
            'bulletinBoards',
            'homeVisit',
            'users:id,name'])
        ->orderBy('created_at','desc')
        ->paginate(5);
    }

    public function getClassPost(Request $request){
        $this->validate($request,[
            'classId'=>'required'
        ]);
        // $userId = Auth::user()->id;
        $classId = $request->classId;
        return Post::whereIn('contentId',[12,13,14,15,16,17,18,19,20,21,22])
        ->where('classId',$classId)
        ->with([
            'likes',
            'views',
            'comments',
            'questionnaires',
            'votings',
            'homeVisit',
            'notifications',
            'evaluations',
            'recognitions',
            'users:id,name'
        ])
        ->orderBy('created_at','desc')
        ->paginate(5);
    }

    public function getClassPhoto(Request $request){
        $this->validate($request,[
            'classId'=>'required'
        ]);
        $classId = $request->classId;
        $posts = Post::whereIn('contentId',[12,13,14,15,16,17,18,19,20,21,22])
        ->where('classId',$classId)
        ->with([
            'likes',
            'views',
            'comments',
            'questionnaires',
            'votings',
            'homeVisit',
            'notifications',
            'evaluations',
            'recognitions',
            'users:id,name'
        ])
        ->orderBy('created_at','desc')
        ->get();
        file_put_contents('post.txt',$posts);
        return $posts;
    }
}
