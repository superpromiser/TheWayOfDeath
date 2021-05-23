<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Fence;

class FenceController extends Controller
{
    //
    public function getFenceData(Request $request)
    {
        $userId = Auth::user()->id;
        return Fence::where('userId', $userId)->get();
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
