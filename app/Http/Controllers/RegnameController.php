<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Regname;
use App\AnswerRegname;
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
        
        Regname::create([
            'title'=>$request->title,
            'startTime'=>$request->startTime,
            'endTime'=>$request->endTime,
            'viewList'=>json_encode($request->viewList),
            'inputTypeList'=>json_encode($request->inputTypeList),
            'checkFlag'=>$request->checkFlag,
            'content'=>$shareData,
            'postId'=>$postId,
        ]);
        
        return response()->json([
            'msg' => 'ok'
        ],200);

    }

    public function answerRegname(Request $request){
        $this->validate($request,[
            'answer'=>'required'
        ]);
        AnswerRegname::create([
            'userId'=> Auth::user()->id,
            'postId'=> $request->postId,
            'regnameId'=> $request->regnameId,
            'answer'=> json_encode($request->answer)
        ]);
        
        return response()->json([
            'msg' => 'ok'
        ],200);
    }

    public function getAnswerOne(Request $request)
    {   
        $answerData = AnswerRegname::where([
            ['userId', '=', $request->userId],
            ['postId', '=', $request->postId]
        ])->first();

        return response()->json([
            'answer' => $answerData
        ],200);
    }

    public function getAnswer(Request $request)
    {   
        $answerData = AnswerRegname::where([
            ['regnameId', '=', $request->id]
        ])->get();

        return response()->json([
            'answer' => $answerData
        ],200);
    }

    public function updateAnswer(Request $request)
    {
        AnswerRegname::where('id', $request->id)->update([
            'answer' => json_encode($request->answer)
        ]);

        return response()->json([
            'msg' => 'ok'
        ],200);
    }
}
