<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RepairData;
use App\Post;
use Illuminate\Support\Facades\Auth;

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
        return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 7])
            ->with([
                'likes',
                'views',
                'comments.users:id,name',
                'repairdata' => function ($q) use ($status, $deadline, $userId) {
                    $q->where(['status' => $status])->whereDate('deadline', $deadline);
                },
                'users:id,name,avatar'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(5);
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
            'status' => $request->status
        ]);
    }

    public function deleteRepairData(Request $request)
    {
    }
}
