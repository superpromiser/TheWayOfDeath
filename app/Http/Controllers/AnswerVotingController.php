<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;
use App\AnswerVoting;
use Illuminate\Support\Facades\Auth;
class AnswerVotingController extends Controller
{
    //
    public function getAnswerVoting(Request $request){
        $this->validate($request,[
            'postId'
        ]);
        return AnswerVoting::where('postId',$request->postId)->get();
    }

    public function createAnswerVoting(Request $request){
        $this->validate($request,[
            'multiAnswer'=>'required',
            'postId'=>'required'
        ]);
        $userId = Auth::user()->id;
        $answerId = Answer::create([
            'postId'=>$request->postId,
            'userId'=>$userId
        ])->id;
        return AnswerVoting::create([
            'multiAnswer'=>json_encode($request->multiAnswer),
            'postId'=>$request->postId,
            'userId'=>$userId,
            'answerId'=>$answerId
        ]);
    }
}
