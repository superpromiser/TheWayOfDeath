<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\Evaluation;
class EvaluationController extends Controller
{
    // 
    public function getEvaluation(){
        
    }

    public function createEvaluation(Request $request){
        $this->validate($request,[
            'userList'=>'required',
            'selMedalList'=>'required',
            'classId'=>'required'
        ]);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId'=>18,
            'userId'=>$userId,
            'classId'=>$request->classId,
            'schoolId'=>$request->schoolId
        ])->id;
        Evaluation::create([
            'userList'=>json_encode($request->userList),
            'selMedalList'=>$request->selMedalList,
            'classId'=>$request->classId,
            'postId'=>$postId
        ]);

        return response()->json([
            'msg' => 'ok'
        ], 201);

    }

    public function updateEvaluation(Request $request){

    }

    public function deleteEvaluation(Request $request){

    }
}
