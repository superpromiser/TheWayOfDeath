<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use App\Post;
use Illuminate\Support\Facades\Auth;
class NotificationController extends Controller
{
    //

    public function getNotification(){

    }

    public function createNotification(Request $request){
        $this->validate($request,[
            'title'=>'required',
            'signName'=>'required',
            'description'=>'required'
        ]);
        $userId = Auth::user()->id;
        $title = $request->title;
        $signName = $request->signName;
        $description = $request->description;
        $postId = Post::create([
            'contentId'=>17,
            'userId'=>$userId
        ])->id;
        return Notification::create([
            'title'=>$title,
            'signName'=>$signName,
            'description'=>json_encode($description),
            'postId'=>$postId
        ]);
    }
}
