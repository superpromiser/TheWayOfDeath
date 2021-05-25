<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Regname;
use App\AnswerRegname;
use App\Post;
use App\Template;
use Illuminate\Support\Facades\Auth;


class RegnameController extends Controller
{

    public function getRegname(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        $lessonId = $request->lessonId;
        return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 24])->where('viewList', 'like', "%{$request->lessonId}%")
            // ->orWhere(function ($query) use ($request) {
            //     $query->where('viewList', 'like', "%{$request->lessonId}%")
            //         ->where('contentId', 24);
            // })
            ->with([
                'likes',
                'views',
                'comments.users:id,name',
                'regnames',
                'users:id,name,avatar'
            ])
            ->orderBy('fixTop', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function createRegname(Request $request)
    {
        $this->validate($request, [
            'content' => 'required',
            'startTime' => 'required',
            'endTime' => 'required',
            'viewList' => 'required',
            'inputTypeList' => 'required',
        ]);
        $shareData = json_encode($request->content);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId' => 24,
            'userId' => $userId,
            'schoolId' => $request->schoolId,
            'classId' => $request->lessonId,
            'viewList' => $request->viewList,
        ])->id;

        Regname::create([
            'title' => $request->title,
            'startTime' => $request->startTime,
            'endTime' => $request->endTime,
            'viewList' => json_encode($request->viewList),
            'inputTypeList' => json_encode($request->inputTypeList),
            'checkFlag' => $request->checkFlag,
            'content' => $shareData,
            'postId' => $postId,
            'schoolId' => $request->schoolId,
            'lessonId' => $request->lessonId
        ]);

        return response()->json([
            'msg' => 'ok'
        ], 200);
    }

    public function answerRegname(Request $request)
    {
        $this->validate($request, [
            'answer' => 'required'
        ]);
        $regNameData = Regname::where('id', $request->regnameId)->first();
        if ($regNameData->checkFlag == 0) {
            AnswerRegname::create([
                'userId' => Auth::user()->id,
                'postId' => $request->postId,
                'regnameId' => $request->regnameId,
                'answer' => json_encode($request->answer)
            ]);
        } else {
            AnswerRegname::create([
                'userId' => Auth::user()->id,
                'postId' => $request->postId,
                'regnameId' => $request->regnameId,
                'answer' => json_encode($request->answer),
                'status' => 'pending'
            ]);
        }

        return response()->json([
            'msg' => 'ok'
        ], 200);
    }

    public function getAnswerOne(Request $request)
    {
        $answerData = AnswerRegname::where([
            ['userId', '=', $request->userId],
            ['postId', '=', $request->postId]
        ])->first();

        return response()->json([
            'answer' => $answerData
        ], 200);
    }

    public function getAnswer(Request $request)
    {
        $answerData = AnswerRegname::where([
            ['regnameId', '=', $request->id]
        ])->get();

        return response()->json([
            'answer' => $answerData
        ], 200);
    }

    public function updateAnswer(Request $request)
    {
        AnswerRegname::where('id', $request->id)->update([
            'answer' => json_encode($request->answer)
        ]);

        return response()->json([
            'msg' => 'ok'
        ], 200);
    }

    public function updateAnswerStatus(Request $request)
    {
        AnswerRegname::where('id', $request->answerId)->update([
            'status' => $request->action
        ]);
        return response()->json([
            'msg' => 'ok'
        ], 200);
    }

    public function deleteAnswer(Request $request)
    {
        return AnswerRegname::where('id', $request->answerId)->delete();
    }

    public function getTemplateCnt(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
        ]);
        $userId = Auth::user()->id;
        $result['draftCnt'] = Template::where(['contentId' => 24, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'tempType' => 2])->count();
        $result['templateCnt'] = Template::where(['contentId' => 24, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'tempType' => 1])->count();
        return $result;
    }

    public function getTemplateList(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        $userId = Auth::user()->id;
        return Template::where(['contentId' => 24, 'userId' => $userId, 'schoolId' => $request->schoolId,])->get();
    }

    public function createTemplate(Request $request)
    {
        $userId = Auth::user()->id;
        Template::create([
            'contentId' => 24,
            'userId' => $userId,
            'tempTitle' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'schoolId' => $request->schoolId,
            'tempType' => $request->tempType,
            'lessonId' => $request->lessonId
        ]);
        return true;
    }

    public function deleteTemplate(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        return Template::where('id', $request->id)->delete();
    }
}
