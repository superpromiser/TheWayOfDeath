<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\QuestionnaireTemp;
use App\Template;
class QuestionnaireTempController extends Controller
{
    //
    public function getQuestionnaireTemp(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        $userId = Auth::user()->id;
        if($request->lessonId){
            $contentId = 12;
        }else{
            $contentId = 1;
        }
        return Template::where(['contentId' => $contentId, 'userId' => $userId, 'schoolId' => $request->schoolId,'lessonId'=>$request->lessonId])->get();
    }

    public function createQuestionnaireTemp(Request $request)
    {
        $userId = Auth::user()->id;
        if($request->lessonId){
            $contentId = 12;
        }else{
            $contentId = 1;
        }
        Template::create([
            'contentId' => $contentId,
            'userId' => $userId,
            'tempTitle' => $request->tempTitle,
            'description' => $request->description,
            'content' => $request->content,
            'schoolId' => $request->schoolId,
            'tempType' => $request->tempType,
            'lessonId'=>$request->lessonId
        ]);
        return true;
        
    }

    public function getQuestionnaireTempCnt(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
        ]);
        if($request->lessonId){
            $contentId = 12;
        }else{
            $contentId = 1;
        }
        $userId = Auth::user()->id;
        $result['draftCnt'] = Template::where(['contentId' => $contentId, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId'=>$request->lessonId, 'tempType' => 2])->count();
        $result['templateCnt'] = Template::where(['contentId' => $contentId, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId'=>$request->lessonId, 'tempType' => 1])->count();
        return $result;
    }

    public function deleteQuestionnaireTemp(Request $request){
        $this->validate($request,[
            'id'=>'required'
        ]);
        return Template::where('id',$request->id)->delete();
    }
}
