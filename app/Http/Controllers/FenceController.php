<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Fence;
use App\User;

class FenceController extends Controller
{
    //
    public function getFenceData(Request $request)
    {
        $userId = Auth::user()->id;
        $roleId = Auth::user()->roleId;
        $schoolId = Auth::user()->schoolId;
        $fenceList = array();
        $managerId = User::where(['schoolId' => $schoolId, 'roleId' => 2])->first()->id;

        if ($roleId == 2) {
            $fenceList = Fence::where(['userId' => $userId])->get();
        } else if ($roleId == 7) {
            $fenceList = Fence::whereIn('userId', [$userId, $managerId])->get();
        } else if ($roleId == 4) {
            $children = Auth::user()->children;
            $userList = User::whereIn('id', $children)->get();
            foreach ($userList as $user) {
                $lessonId = User::where('id', $user->id)->first()->lessonId;
                $banzhuId = User::where(['lessonId' => $lessonId, 'roleId' => 7])->first()->id;
                $fenceData = Fence::whereIn('userId', [$userId, $managerId, $banzhuId])->get();
                foreach ($fenceData as $fence) {
                    if (!in_array($fence, $fenceList, true)) {
                        array_push($fenceList, $fence);
                    }
                }
            }
        }
        return $fenceList;
    }

    public function createFenceData(Request $request)
    {
        $this->validate($request, [
            'studentList' => 'required',
            'fenceName' => 'required',
            'fenceType' => 'required',
            'location' => 'required'
        ]);
        $userId = Auth::user()->id;
        $roleId = Auth::user()->roleId;
        $schoolId = Auth::user()->schoolId;
        $lessonId = Auth::user()->lessonId;
        return Fence::create([
            'studentList' => $request->studentList,
            'fenceName' => $request->fenceName,
            'fenceType' => $request->fenceType,
            'location' => $request->location,
            'userId' => $userId,
            'schoolId' => $schoolId,
            'lessonId' => $lessonId,
            'roleId' => $roleId
        ]);
    }

    public function updateFenceData(Request $request)
    {
    }

    public function deleteFenceData(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        return Fence::where('id', $request->id)->delete();
    }
}
