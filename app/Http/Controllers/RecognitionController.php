<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Recognition;
use Illuminate\Support\Facades\Auth;

class RecognitionController extends Controller
{
    //
    public function getRecognition(){

    }

    public function createRecognition(Request $request){
        $this->validate($request,[
            'type'=>'required',
            'students'=>'required',
            'awardTitle'=>'required',
            'publishDate'=>'required',
            'description'=>'required',
            'imgUrl'=>'required',
            'classId'=>'required'
        ]);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'userId'=>$userId,
            'contentId'=>19,
            'classId'=>$request->classId
        ])->id;
        return Recognition::create([
            'type'=>$request->type,
            'students'=>json_encode($request->students),
            'awardTitle'=>$request->awardTitle,
            'publishDate'=>$request->publishDate,
            'description'=>$request->description,
            'imgUrl'=>$request->imgUrl,
            'postId'=>$postId
        ]);
    }

    public function updateRecognition(){

    }

    public function deleteRecognition(){

    }
}
