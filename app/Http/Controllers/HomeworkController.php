<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Homework;
use App\Post;

class HomeworkController extends Controller
{
    //
    public function getHomeworkData(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
            'lessonId' => 'required',
        ]);
        $userId = Auth::user()->id;
        return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 14])
            ->orWhere('viewList', 'like', "%{$request->lessonId}%")
            ->with([
                'likes',
                'views',
                'comments.users:id,name',
                'homework:postId,content' => function ($query) use ($userId) {
                    $query->where("viewList", "like", "%{$userId}%")
                        ->orWhere('viewList', null);
                },
                'users:id,name,avatar'
            ])
            ->orderBy('updated_at', 'desc')
            ->paginate(5);
    }

    public function createHomeworkData(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
            'lessonId' => 'required',
            'subjectName' => 'required',
            'homeworkType' => 'required',
            'content' => 'required',
        ]);
        $userId = Auth::user()->id;
        $deadline = $request->deadline;

        //if teacher set post time of homework
        if($deadline){
            return Homework::create([
                'subjectName' => $request->subjectName,
                'homeworkType' => $request->homeworkType,
                'content' => json_encode($request->content),
                'deadline' => $request->deadline,
                'monitorName' => $request->monitorName,
                'parentCheck' => $request->parentCheck,
                'viewList' => json_encode($request->viewList),
                'schoolId' => $request->schoolId,
                'lessonId' => $request->lessonId,
                'userId' => $userId,
            ]);
        }
        else{
            $postId = Post::create([
                'contentId' => 14,
                'userId' => $userId,
                'schoolId' => $request->schoolId,
                'classId' => $request->lessonId
            ])->id;
            
            return Homework::create([
                'subjectName' => $request->subjectName,
                'homeworkType' => $request->homeworkType,
                'content' => json_encode($request->content),
                'deadline' => $request->deadline,
                'monitorName' => $request->monitorName,
                'parentCheck' => $request->parentCheck,
                'viewList' => json_encode($request->viewList),
                'schoolId' => $request->schoolId,
                'lessonId' => $request->lessonId,
                'userId' => $userId,
                'postId' => $postId,
            ]);
        }
    }

    public function getAppHomeworkData(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        $userId = Auth::user()->id;
        if ($request->lessonId) {
            return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 14])
                ->with([
                    'likes',
                    'views',
                    'comments',
                    'homework' => function ($query) use ($userId) {
                        $query->where("viewList", "like", "%{$userId}%")
                            ->orWhere('viewList', null);
                    },
                    'users:id,name,avatar'
                ])
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        } else {
            // return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 1])
            //     ->with([
            //         'likes',
            //         'views',
            //         'comments',
            //         'questionnaires',
            //         'users:id,name'
            //     ])
            //     ->orderBy('created_at', 'desc')
            //     ->paginate(5);
        }
    }

    public function updateHomeworkData(Request $request)
    {
    }

    public function deleteHomeworkData(Request $request)
    {
    }
}
