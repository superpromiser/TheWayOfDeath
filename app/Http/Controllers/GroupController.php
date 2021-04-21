<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;

use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    //
    public function getPendingGroupMember(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
            'lessonId' => 'required'
        ]);
        return Group::where(['schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'status' => 'pending'])->with(['members:id,name,gender,phoneNumber,roleId', 'users:id,name'])->get();
    }

    public function getAllowGroupMember(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
            'lessonId' => 'required'
        ]);
        return Group::where(['schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'status' => 'allow'])->with('members:id,name')->get();
    }

    public function getAllGroupMember(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
            'lessonId' => 'required'
        ]);
        return Group::where(['schoolId' => $request->schoolId, 'lessonId' => $request->lessonId])->with('members:id,name')->get();
    }

    public function addGroupMember(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
            'lessonId' => 'required'
        ]);
        $userId = Auth::user()->id;
        $members = $request->userList;
        foreach ($members as $member) {
            Group::create([
                'schoolId' => $request->schoolId,
                'lessonId' => $request->lessonId,
                'memberId' => $member,
                'userId' => $userId
            ]);
        };
        return true;
    }

    public function deleteGroupMember(Request $request)
    {
        $this->validate($request, [
            'userList' => 'required',
        ]);

        $members = $request->userList;
        foreach ($members as $member) {
            Group::where('memberId', $member)->delete();
        }
    }

    public function updateGroupMember(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        return Group::where('id', $request->id)->update([
            'status' => 'allow'
        ]);
    }
}
