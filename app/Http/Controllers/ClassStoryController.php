<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\ClassStory;
use Illuminate\Support\Facades\Auth;
use App\Template;

class ClassStoryController extends Controller
{
    //
    public function getClassStory(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
            'lessonId' => 'required'
        ]);
        $userId = Auth::user()->id;
        return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 25])
            ->with([
                'likes',
                'views',
                'comments.users:id,name',
                'classstory' => function ($query) use ($userId) {
                    $query->where("viewList", "like", "%{$userId}")
                        ->orWhere('viewList', null);;
                },
                'users:id,name,avatar'
            ])
            ->orderBy('fixTop', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function createClassStory(Request $request)
    {
        $this->validate($request, [
            'content' => 'required',
            'schoolId' => 'required',
            'lessonId' => 'required'
        ]);
        $userId = Auth::user()->id;
        $content = json_encode($request->content);
        $postId = Post::create([
            'contentId' => 25,
            'userId' => $userId,
            'schoolId' => $request->schoolId,
            'classId' => $request->lessonId
        ])->id;
        // return ClassStory::create([
        //     'content' => $content,
        //     'schoolId' => $request->schoolId,
        //     'lessonId' => $request->lessonId,
        //     'postId' => $postId,
        //     'userId' => $userId,
        // ]);
        if ($request->publishType == 'pub') {
            ClassStory::create([
                'content' => $content,
                'postId' => $postId,
                'schoolId' => $request->schoolId,
                'lessonId' => $request->lessonId,
                'userId' => $userId,
            ]);
        } else if ($request->publishType == 'spec') {
            ClassStory::create([
                'content' => $content,
                'postId' => $postId,
                'schoolId' => $request->schoolId,
                'lessonId' => $request->lessonId,
                'viewList' => $request->specUsers,
                'userId' => $userId,
            ]);
        } else if ($request->publishType == 'pvt') {
            $pvtArr = array();
            array_push($pvtArr, $userId);
            ClassStory::create([
                'content' => $content,
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

    public function updateClassStory()
    {
    }

    public function deleteClassStory()
    {
    }

    public function getTemplateCnt(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
        ]);
        $userId = Auth::user()->id;
        $result['draftCnt'] = Template::where(['contentId' => 25, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'tempType' => 2])->count();
        $result['templateCnt'] = Template::where(['contentId' => 25, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'tempType' => 1])->count();
        return $result;
    }

    public function getTemplateList(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        $userId = Auth::user()->id;
        return Template::where(['contentId' => 25, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId])->get();
    }

    public function createTemplate(Request $request)
    {
        $userId = Auth::user()->id;
        Template::create([
            'contentId' => 25,
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
