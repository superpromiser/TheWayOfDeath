<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Questionnaire;

class QuestionnaireController extends Controller
{
    //
    public function getQuestionnaire(){
        
    }

    public function createQuestionnaire(Request $request){
        $this->validate($request,[
            'title'=>'required',
            'description'=>'required',
            'viewList'=>'required',
            'deadline'=>'required',
            'questionnaireFlag'=>'required',
            'resultFlag'=>'required',
            'answerFlag'=>'required',
            'content'=>'required',
        ]);
        $title = $request->title;
        $desc = $request->description;
        $viewList = json_encode($request->viewList);
        $deadline = $request->deadline;
        $questionnaireFlg = $request->questionnaireFlag;
        $resultFlag = $request->resultFlag;
        $answerFlag = $request->answerFlag;
        $content = json_encode($request->content);
        $postId = Post::create(['contentId'=>1])->id;
        $data = Questionnaire::create([
            'title'=>$title,
            'desc'=>$desc,
            'viewList'=>$viewList,
            'deadline'=>$deadline,
            'questionnaireFlag'=>$questionnaireFlg,
            'resultFlag'=>$resultFlag,
            'answerFlag'=>$answerFlag,
            'content'=>$content,
            'postId'=>$postId
        ]);
        return response()->json([
            'data'=>$data,
            'state'=>201
        ]);
    }

    public function updateQuestionnaire(){

    }

    public function deleteQusetionaire(){

    }
}
