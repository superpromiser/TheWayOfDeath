<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;
use App\AnswerQuestionnaire;
use Illuminate\Support\Facades\Auth;

class AnswerQuestionnaireController extends Controller
{
    //
    public function getAnswerQuestionnaire(Request $request)
    {
        $this->validate($request, [
            'postId' => 'required'
        ]);
        return AnswerQuestionnaire::where('postId', $request->postId)->with('user:id,name')->get();
    }

    public function createAnswerQuestionnaire(Request $request)
    {
        $this->validate($request, [
            // 'singleAnswer'=>'required',
            // 'multiAnswer'=>'required',
            // 'questionAnswer'=>'required',
            // 'statAnswer'=>'required',
            // 'scoringAnswer'=>'required',
            'postId' => 'required',
            'answerData' => 'required'
        ]);
        $userId = Auth::user()->id;
        // $answerId = Answer::create([
        //     'postId'=>$request->postId,
        //     'userId'=>$userId
        // ])->id;
        return AnswerQuestionnaire::create([
            'answerData' => json_encode($request->answerData),
            'schoolId' => $request->schoolId,
            'lessonId' => $request->lessonId,
            'postId' => $request->postId,
            'userId' => $userId
        ]);
    }
}
