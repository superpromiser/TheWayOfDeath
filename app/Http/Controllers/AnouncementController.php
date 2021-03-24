<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anouncement;
use App\Post;
use Illuminate\Support\Facades\Auth;
class AnouncementController extends Controller
{
    //

    public function getAnnouncement(){

    }

    public function createAnouncement(Request $request){
        $this->validate($request,[
            'title'=>'required',
            'signName'=>'required',
            'viewList'=>'required',
            'scopeFlag'=>'required',
            'content'=>'required'
        ]);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId'=>5,
            'userId'=>$userId,
            'schoolId'=>$request->schoolId
        ])->id;
        return Anouncement::create([
            'title'=>$request->title,
            'signName'=>$request->signName,
            'viewList'=>json_encode($request->viewList),
            'scopeFlag'=>$request->scopeFlag,
            'content'=>json_encode($request->content),
            'postId'=>$postId,

        ]);

    }

    public function updateAnouncement(Request $reqeust){

    }

    public function deleteAnouoncement(Request $request){

    }
}
