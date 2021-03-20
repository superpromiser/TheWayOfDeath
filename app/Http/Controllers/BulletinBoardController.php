<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\BulletinBoard;
use Illuminate\Support\Facades\Auth;

class BulletinBoardController extends Controller
{
    //
    public function getBulletinBoard(){

    }

    public function createBulletinBoard(Request $request){
        $this->validate($request,[
            'type'=>'required',
            'content'=>'required'
        ]);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId'=>6,
            'userId'=>$userId
        ])->id;
        return BulletinBoard::create([
            'type'=>$request->type,
            'content'=>json_encode($request->content),
            'postId'=>$postId
        ]);
    }

    public function updateBulletinBoard(Request $request){

    }

    public function deleteBulletinBoard(Request $request){

    }
}
