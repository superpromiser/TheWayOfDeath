<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SafeStudy;
use App\Post;
use Illuminate\Support\Facades\Auth;
use App\Template;

class SafeStudyController extends Controller
{
    //
    public function getSafeStudy(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 8])
            ->with([
                'likes',
                'views',
                'comments.users:id,name',
                'safestudy',
                'users:id,name'
            ])
            ->orderBy('fixTop', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function createSafeStudy(Request $request)
    {
        $this->validate($request, [
            'content' => 'required'
        ]);
        $shareData = json_encode($request->content);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId' => 8,
            'userId' => $userId,
            'schoolId' => $request->schoolId,
            'classId' => $request->lessonId
        ])->id;
        // return SafeStudy::create([
        //     'content' => $shareData,
        //     'postId' => $postId,
        //     'userId' => $userId,
        //     'schoolId' => $request->schoolId,
        //     'lessonId' => $request->lessonId
        // ]);
        if ($request->publishType == 'pub') {
            SafeStudy::create([
                'content' => $shareData,
                'postId' => $postId,
                'schoolId' => $request->schoolId,
                'lessonId' => $request->lessonId,
                'userId' => $userId,
            ]);
        } else if ($request->publishType == 'spec') {
            SafeStudy::create([
                'content' => $shareData,
                'postId' => $postId,
                'schoolId' => $request->schoolId,
                'lessonId' => $request->lessonId,
                'viewList' => $request->viewList,
                'userId' => $userId,
            ]);
        } else if ($request->publishType == 'pvt') {
            $pvtArr = array();
            array_push($pvtArr, $userId);
            SafeStudy::create([
                'content' => $shareData,
                'postId' => $postId,
                'schoolId' => $request->schoolId,
                'lessonId' => $request->lessonId,
                'viewList' => $pvtArr,
                'userId' => $userId,
            ]);
        }
        return response()->json([
            'msg' => 'ok'
        ], 200);
    }

    public function updateSafeStudy(Request $request)
    {
    }

    public function deleteSafeStudy(Request $request)
    {
    }

    public function getTemplateCnt(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
        ]);
        $userId = Auth::user()->id;
        $result['draftCnt'] = Template::where(['contentId' => 21, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'tempType' => 2])->count();
        $result['templateCnt'] = Template::where(['contentId' => 21, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'tempType' => 1])->count();
        return $result;
    }

    public function getTemplateList(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        $userId = Auth::user()->id;
        return Template::where(['contentId' => 21, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId])->get();
    }

    public function createTemplate(Request $request)
    {
        $userId = Auth::user()->id;
        Template::create([
            'contentId' => 21,
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
