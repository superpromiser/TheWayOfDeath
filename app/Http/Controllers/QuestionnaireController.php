<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Questionnaire;
use Illuminate\Support\Facades\Auth;

class QuestionnaireController extends Controller
{
    //
    public function getQuestionnaire(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        if ($request->lessonId) {
            return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId])->whereIn('contentId', [1, 12])
                ->orWhere(function ($query) use ($request) {
                    $query->where('viewList', 'like', "%{$request->lessonId}%")
                        ->whereIn('contentId', [1, 12]);
                })
                ->with([
                    'likes',
                    'views',
                    'comments.users:id,name',
                    'questionnaires',
                    'users:id,name,avatar'
                ])
                ->orderBy('fixTop', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        } else {
            return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 1])
                ->with([
                    'likes',
                    'views',
                    'comments.users:id,name',
                    'questionnaires',
                    'users:id,name,avatar'
                ])
                ->orderBy('updated_at', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }
    }

    public function createQuestionnaire(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'viewList' => 'required',
            'deadline' => 'required',
            'questionnaireFlag' => 'required',
            'resultFlag' => 'required',
            'answerFlag' => 'required',
            'content' => 'required',
            'schoolId' => 'required'
        ]);
        $title = $request->title;
        $desc = $request->description;
        $viewList = json_encode($request->viewList);
        $deadline = $request->deadline;
        $questionnaireFlg = $request->questionnaireFlag;
        $resultFlag = $request->resultFlag;
        $answerFlag = $request->answerFlag;
        $content = json_encode($request->content);
        $userId = Auth::user()->id;
        if ($request->classId) {
            $classId = $request->classId;
            $contentId = 12;
        } else {
            $classId = NULL;
            $contentId = 1;
        }
        $postId = Post::create([
            'contentId' => $contentId,
            'userId' => $userId,
            'schoolId' => $request->schoolId,
            'classId' => $classId,
            'viewList' => $request->viewList
        ])->id;
        $data = Questionnaire::create([
            'title' => $title,
            'desc' => $desc,
            'viewList' => $viewList,
            'deadline' => $deadline,
            'questionnaireFlag' => $questionnaireFlg,
            'resultFlag' => $resultFlag,
            'answerFlag' => $answerFlag,
            'content' => $content,
            'schoolId' => $request->schoolId,
            'classId' => $classId,
            'postId' => $postId
        ]);
        return response()->json([
            'data' => $data,
            'state' => 201
        ]);
    }

    public function updateQuestionnaire()
    {
    }

    public function deleteQusetionaire()
    {
    }
}
