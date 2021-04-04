<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;
use App\AnswerVoting;
use Illuminate\Support\Facades\Auth;

class AnswerVotingController extends Controller
{
    //
    public function getAnswerVoting(Request $request)
    {
        $this->validate($request, [
            'postId'
        ]);
        return AnswerVoting::where('postId', $request->postId)->with('user:id,name')->get();
    }

    public function createAnswerVoting(Request $request)
    {
        $this->validate($request, [
            'answer' => 'required',
            'postId' => 'required'
        ]);
        $userId = Auth::user()->id;
        // $answerId = Answer::create([
        //     'postId'=>$request->postId,
        //     'userId'=>$userId
        // ])->id;
        return AnswerVoting::create([
            'answerData' => json_encode($request->answer),
            'postId' => $request->postId,
            'userId' => $userId,
        ]);
    }
}
