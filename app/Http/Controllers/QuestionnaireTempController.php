<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\QuestionnaireTemp;

class QuestionnaireTempController extends Controller
{
    //
    public function getQuestionnaireTemp(Request $request)
    {
        $userId = Auth::user()->id;
        return QuestionnaireTemp::where([
            'userId' => $userId,
            // 'temType' => 1
        ])->get();
    }

    public function createQuestionnaireTemp(Request $request)
    {
        $this->validate($request, [
            'temTitle' => 'required',
            'imgUrl' => 'required',
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'temType' => 'required'
        ]);
        $userId = Auth::user()->id;
        return QuestionnaireTemp::create([
            'temTitle' => $request->temTitle,
            'imgUrl' => $request->imgUrl,
            'title' => $request->title,
            'description' => $request->description,
            'content' => json_encode($request->content),
            'temType' => $request->temType,
            'userId' => $userId
        ]);
    }

    public function getQuestionnaireTempCnt()
    {
        $userId = Auth::user()->id;
        $result['tempCnt'] = QuestionnaireTemp::where(['temType' => 1, 'userId' => $userId])->count();
        $result['draftCnt'] = QuestionnaireTemp::where(['temType' => 2, 'userId' => $userId])->count();
        return response()->json($result);
    }
}
