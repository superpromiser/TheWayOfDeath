<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\SchoolStory;
use Illuminate\Support\Facades\Auth;
use App\Template;

class SchoolStoryController extends Controller
{
    //
    public function getSchoolStory(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 11])
            ->with([
                'likes',
                'views',
                'comments.users:id,name',
                'schoolstory',
                'users:id,name,avatar'
            ])
            ->orderBy('fixTop', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }
    public function getSchoolStoryMo(Request $request)
    {
        $schoolId = $request->schoolId;
        $lessonId = $request->lessonId;

        $classStory =  Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 25])
            ->with([
                'likes',
                'views',
                'comments.users:id,name',
                'classstory',
                'users:id,name,avatar'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        $schoolStory =  Post::where(['schoolId' => $request->schoolId,  'contentId' => 11])
            ->with([
                'likes',
                'views',
                'comments.users:id,name',
                'schoolstory',
                'users:id,name,avatar'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'classStory' => $classStory,
            'schoolStory' => $schoolStory
        ], 200);
        // return response()->json([
        //     'classStory' => "c",
        //     'schoolStory' => "s"
        // ], 200); 
    }

    public function createSchoolStory(Request $request)
    {
        $this->validate($request, [
            'content' => 'required',
            'schoolId' => 'required'
        ]);
        $content = json_encode($request->content);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId' => 11,
            'userId' => $userId,
            'schoolId' => $request->schoolId
        ])->id;
        // return SchoolStory::create([
        //     'content' => $content,
        //     'schoolId' => $request->schoolId,
        //     'userId' => $userId,
        //     'postId' => $postId,
        // ]);
        if ($request->publishType == 'pub') {
            SchoolStory::create([
                'content' => $content,
                'postId' => $postId,
                'schoolId' => $request->schoolId,
                'userId' => $userId,
            ]);
        } else if ($request->publishType == 'spec') {
            SchoolStory::create([
                'content' => $content,
                'postId' => $postId,
                'schoolId' => $request->schoolId,
                'viewList' => $request->specUsers,
                'userId' => $userId,
            ]);
        } else if ($request->publishType == 'pvt') {
            $pvtArr = array();
            array_push($pvtArr, $userId);
            SchoolStory::create([
                'content' => $content,
                'postId' => $postId,
                'schoolId' => $request->schoolId,
                'viewList' => $pvtArr,
                'userId' => $userId,
            ]);
        }
        return response()->json([
            'msg' => 'ok'
        ], 200);
    }

    public function updateSchoolStory(Request $request)
    {
    }

    public function deleteSchoolStory(Request $request)
    {
    }

    public function getTemplateCnt(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
        ]);
        $userId = Auth::user()->id;
        $result['draftCnt'] = Template::where(['contentId' => 11, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'tempType' => 2])->count();
        $result['templateCnt'] = Template::where(['contentId' => 11, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'tempType' => 1])->count();
        return $result;
    }

    public function getTemplateList(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        $userId = Auth::user()->id;
        return Template::where(['contentId' => 11, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId])->get();
    }

    public function createTemplate(Request $request)
    {
        $userId = Auth::user()->id;
        Template::create([
            'contentId' => 11,
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
