<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InterClassStory;
use App\Post;
use Illuminate\Support\Facades\Auth;
use App\Template;

class InterClassStoryController extends Controller
{
    //
    public function getInterClassStory(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
            'lessonId' => 'required'
        ]);
        $userId = Auth::user()->id;
        return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 26])
            ->with([
                'likes',
                'views',
                'comments.users:id,name',
                'interclassstory' => function ($query) use ($userId) {
                    $query->where("viewList", "like", "%{$userId}")
                        ->orWhere('viewList', null);;
                },
                'users:id,name,avatar'
            ])
            ->orderBy('fixTop', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function createInterClassStory(Request $request)
    {
        $this->validate($request, [
            'content' => 'required',
            'schoolId' => 'required',
            'lessonId' => 'required'
        ]);
        $userId = Auth::user()->id;
        $content = json_encode($request->content);
        $postId = Post::create([
            'contentId' => 26,
            'userId' => $userId,
            'schoolId' => $request->schoolId,
            'classId' => $request->lessonId
        ])->id;
        // return InterClassStory::create([
        //     'content' => $content,
        //     'schoolId' => $request->schoolId,
        //     'lessonId' => $request->lessonId,
        //     'postId' => $postId,
        //     'userId' => $userId,
        // ]);
        if ($request->publishType == 'pub') {
            InterClassStory::create([
                'content' => $content,
                'postId' => $postId,
                'schoolId' => $request->schoolId,
                'lessonId' => $request->lessonId,
                'userId' => $userId,
            ]);
        } else if ($request->publishType == 'spec') {
            InterClassStory::create([
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
            InterClassStory::create([
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

    public function updateInterClassStory(Request $request)
    {
    }

    public function deleteInterClassStory(Request $request)
    {
    }

    public function getTemplateCnt(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
        ]);
        $userId = Auth::user()->id;
        $result['draftCnt'] = Template::where(['contentId' => 26, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'tempType' => 2])->count();
        $result['templateCnt'] = Template::where(['contentId' => 26, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'tempType' => 1])->count();
        return $result;
    }

    public function getTemplateList(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        $userId = Auth::user()->id;
        return Template::where(['contentId' => 26, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId])->get();
    }

    public function createTemplate(Request $request)
    {
        $userId = Auth::user()->id;
        Template::create([
            'contentId' => 26,
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
