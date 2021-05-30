<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RepairData;
use App\Post;
use Illuminate\Support\Facades\Auth;
use App\Template;

class RepairDataController extends Controller
{
    //
    public function getRepairData(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
            'status' => 'required',
            'deadline' => 'required'
        ]);
        $status = $request->status;
        $deadline = $request->deadline;
        $userId = Auth::user()->id;
        if ($request->status == 'all') {
            return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 7])
                ->orWhere(function ($query) use ($request) {
                    $query->where(['schoolId' => $request->schoolId, 'contentId' => 7, 'classId' => null]);
                })
                ->with([
                    'likes',
                    'views',
                    'comments.users:id,name',
                    'repairdata' => function ($q) use ($status, $deadline, $userId) {
                        $q->whereDate('created_at', $deadline);
                    },
                    'users:id,name,avatar'
                ])
                ->orderBy('fixTop', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        } else {
            return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 7])
                ->orWhere(function ($query) use ($request) {
                    $query->where(['schoolId' => $request->schoolId, 'contentId' => 7, 'classId' => null]);
                })
                ->with([
                    'likes',
                    'views',
                    'comments.users:id,name',
                    'repairdata' => function ($q) use ($status, $deadline, $userId) {
                        $q->where(['status' => $status])->whereDate('created_at', $deadline);
                    },
                    'users:id,name,avatar'
                ])
                ->orderBy('fixTop', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }
    }

    public function createRepairData(Request $request)
    {
        $this->validate($request, [
            'userName' => 'required',
            'viewListName' => 'required',
            'repairType' => 'required',
            'content' => 'required',
            'deadline' => 'required'
        ]);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'userId' => $userId,
            'contentId' => 7,
            'schoolId' => $request->schoolId,
            'classId' => $request->lessonId
        ])->id;
        return RepairData::create([
            'userName' => $request->userName,
            'userId' => $userId,
            'viewListName' => $request->viewListName,
            'repairType' => $request->repairType,
            'content' => json_encode($request->content),
            'deadline' => date('Y-m-d h:i:s', strtotime($request->deadline)),
            'postId' => $postId,
            'schoolId' => $request->schoolId,
            'lessonId' => $request->lessonId
        ]);
    }

    public function updateRepairData(Request $request)
    {
        $this->validate($request, [
            'status' => 'required',
            'repairId' => 'required'
        ]);
        return RepairData::where('id', $request->repairId)->update([
            'status' => $request->status,
            'reason' => $request->reason
        ]);
    }

    public function deleteRepairData(Request $request)
    {
    }

    public function getTemplateCnt(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
        ]);
        $userId = Auth::user()->id;
        $result['draftCnt'] = Template::where(['contentId' => 7, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'tempType' => 2])->count();
        $result['templateCnt'] = Template::where(['contentId' => 7, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'tempType' => 1])->count();
        return $result;
    }

    public function getTemplateList(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        $userId = Auth::user()->id;
        return Template::where(['contentId' => 7, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId])->get();
    }

    public function createTemplate(Request $request)
    {
        $userId = Auth::user()->id;
        Template::create([
            'contentId' => 7,
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
