<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anouncement;
use App\Post;
use Illuminate\Support\Facades\Auth;
use App\Template;

class AnouncementController extends Controller
{
    //

    public function getAnouncement(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        $userId = Auth::user()->id;
        $roleId = Auth::user()->roleId;
        if ($roleId < 3) {
            return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 5])
                ->orWhere('viewList', 'like', "%{$request->lessonId}%")
                ->with([
                    'likes',
                    'views',
                    'comments.users:id,name',
                    'anouncements',
                    'users:id,name,avatar'
                ])
                ->orderBy('fixTop', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        } else {
            return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 5])
                ->orWhere('viewList', 'like', "%{$request->lessonId}%")
                ->with([
                    'likes',
                    'views',
                    'comments.users:id,name',
                    'anouncements' => function ($query) use ($userId) {
                        $query->where("showList", "like", "%{$userId}")
                            ->orWhere('showList', null);
                    },
                    'users:id,name,avatar'
                ])
                ->orderBy('fixTop', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }
    }

    public function createAnouncement(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'signName' => 'required',
            'scopeFlag' => 'required',
            'content' => 'required'
        ]);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId' => 5,
            'userId' => $userId,
            'schoolId' => $request->schoolId,
            'classId' => $request->lessonId,
            'viewList' => $request->viewList,
        ])->id;
        return Anouncement::create([
            'title' => $request->title,
            'signName' => $request->signName,
            'showList' => $request->showList,
            'viewList' => $request->viewList,
            'scopeFlag' => $request->scopeFlag,
            'content' => json_encode($request->content),
            'schoolId' => $request->schoolId,
            'lessonId' => $request->lessonId,
            'postId' => $postId,
            'userId' => $userId,

        ]);
    }

    public function updateAnouncement(Request $reqeust)
    {
    }

    public function deleteAnouoncement(Request $request)
    {
    }

    public function getTemplateCnt(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
        ]);
        $userId = Auth::user()->id;
        $result['draftCnt'] = Template::where(['contentId' => 5, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'tempType' => 2])->count();
        $result['templateCnt'] = Template::where(['contentId' => 5, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'tempType' => 1])->count();
        return $result;
    }

    public function getTemplateList(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        $userId = Auth::user()->id;
        return Template::where(['contentId' => 5, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId])->get();
    }

    public function createTemplate(Request $request)
    {
        $userId = Auth::user()->id;
        Template::create([
            'contentId' => 5,
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
