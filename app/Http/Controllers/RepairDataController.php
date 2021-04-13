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
            'schoolId' => 'required'
        ]);
        return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 7])
            ->with([
                'likes',
                'views',
                'comments',
                'repairdata',
                'users:id,name'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function createRepairData(Request $request)
    {
        $this->validate($request, [
            'userName' => 'required',
            'viewListId' => 'required',
            'viewListName' => 'required',
            'repairType' => 'required',
            'content' => 'required',
            'deadline' => 'required'
        ]);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'userId' => $userId,
            'contentId' => 7,
            'schoolId' => $request->schoolId
        ])->id;
        return RepairData::create([
            'userName' => $request->userName,
            'userId' => $userId,
            'viewListId' => $request->viewListId,
            'viewListName' => $request->viewListName,
            'repairType' => $request->repairType,
            'content' => json_encode($request->content),
            'deadline' => $request->deadline,
            'postId' => $postId,
            'schoolId' => $request->schoolId,
            'lessonId' => $request->lessonId
        ]);
    }

    public function updateRepairData(Request $request)
    {
    }

    public function deleteRepairData(Request $request)
    {
    }
}
