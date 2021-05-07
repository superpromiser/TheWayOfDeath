<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\User;
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
        return Group::where(['schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'status' => 'allow'])->with('members:id,name,gender,phoneNumber')->get();
    }

    public function getAllGroupMember(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
            'lessonId' => 'required'
        ]);
        // return Group::where(['schoolId' => $request->schoolId, 'lessonId' => $request->lessonId])->with('members:id,name')->get();
        $userList['teacher'] = User::where(['schoolId' => $request->schoolId])->whereIn('roleId', [3, 7])->get();
        $result['teachers'] = array();
        foreach ($userList['teacher'] as $user) {
            $groupArr = $user->groupArr;
            foreach ($groupArr as $groupId) {
                if ($groupId == $request->lessonId) {
                    array_push($result['teachers'], $user);
                }
            }
        }
        $userList['parent'] = User::where(['schoolId' => $request->schoolId, 'roleId' => 4])->get();
        $result['parents'] = array();
        foreach ($userList['parent'] as $parent) {
            $groupArr = $parent->groupArr;
            foreach ($groupArr as $groupId) {
                if ($groupId == $request->lessonId) {
                    array_push($result['parents'], $parent);
                }
            }
        }
        $userList['student'] = User::where(['schoolId' => $request->schoolId, 'roleId' => 5])->get();
        $result['students'] = array();
        foreach ($userList['student'] as $student) {
            $groupArr = $student->groupArr;
            foreach ($groupArr as $groupId) {
                if ($groupId == $request->lessonId) {
                    array_push($result['students'], $student);
                }
            }
        }
        return $result;
    }

    public function getGroupMember(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
            'lessonId' => 'required'
        ]);
        $result = array();
        if ($request->roleId) {
            $userList = User::where(['schoolId' => $request->schoolId, 'roleId' => $request->roleId])->get();
            foreach ($userList as $user) {
                $groupArr = $user->groupArr;
                foreach ($groupArr as $groupId) {
                    if ($groupId == $request->lessonId) {
                        array_push($result, $user);
                    }
                }
            }
        } else {
            $userList = User::where(['schoolId' => $request->schoolId])->whereIn('roleId', [3, 4, 5, 7])->get();
            foreach ($userList as $user) {
                $groupArr = $user->groupArr;
                foreach ($groupArr as $groupId) {
                    if ($groupId == $request->lessonId) {
                        array_push($result, $user);
                    }
                }
            }
        }
        return $result;
    }

    public function getCanGroupMember(Request $request)
    {
        $this->validate($request, [
            'roleId' => 'required',
            'schoolId' => 'required',
            'groupId' => 'required',
            // 'lessonId'=>'required'
        ]);
        $groupId = (int)$request->groupId;
        $lessonId = $request->lessonId;
        $result = array();
        $userList = User::where(['lessonId'=>$lessonId,'roleId'=>$request->roleId])->get();
        // if ($request->lessonId) {
        //     $userList = User::where(['schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'roleId' => $request->roleId])->get();
        // } else {
        //     $userList = User::where(['schoolId' => $request->schoolId, 'roleId' => $request->roleId])->get();
        // }
        if($request->roleId == 3){
            $userList = User::where(['schoolId' => $request->schoolId])->whereIn('roleId',[3,7])->get();    
        }else{
            if($request->lessonId){
                $userList = User::where(['schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'roleId' => $request->roleId])->get();
            }else{
                $userList = User::where(['schoolId' => $request->schoolId, 'roleId' => $request->roleId])->get();
            }
        }
        // $userList = User::where(['schoolId' => $request->schoolId, 'roleId' => $request->roleId])->get();
        foreach ($userList as $user) {
            $groupArr = $user->groupArr;
            if (($key = array_search($groupId, $groupArr)) == false) {
                array_push($result, $user);
            }
        }
        return $result;
    }

    public function addGroupMember(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
            'lessonId' => 'required'
        ]);
        $userId = Auth::user()->id;
        $roleId = Auth::user()->roleId;
        $lessonId = Auth::user()->lessonId;
        $members = $request->userList;
        if ($roleId == 2) {
            $userList = User::whereIn('id', $members)->get();
            foreach ($userList as $user) {
                $groupArr = $user->groupArr;
                array_push($groupArr, $request->lessonId);
                $user->groupArr = array_values($groupArr);
                $user->update();
            }
        }else if($roleId == 7 && $lessonId == $request->lessonId){
            $userList = User::whereIn('id', $members)->get();
            foreach ($userList as $user) {
                $groupArr = $user->groupArr;
                array_push($groupArr, $request->lessonId);
                $user->groupArr = array_values($groupArr);
                $user->update();
            }
        }else {
            foreach ($members as $memberId) {
                Group::create([
                    'schoolId' => $request->schoolId,
                    'lessonId' => $request->lessonId,
                    'memberId' => $memberId,
                    'userId' => $userId
                ]);
            }
        }
        return true;
    }

    public function deleteGroupMember(Request $request)
    {
        $this->validate($request, [
            'userList' => 'required',
        ]);

        $members = $request->userList;
        foreach ($members as $member) {
            $user = User::where('id', $member)->first();
            $groupArr = $user->groupArr;
            if (($key = array_search($request->lessonId, $groupArr)) !== false) {
                unset($groupArr[$key]);
                $user->groupArr = array_values($groupArr);
                $user->update();
            }
        }
    }

    public function denyGroupMember(Request $request)
    {
        $this->validate($request, [
            'memberId' => 'required'
        ]);
        $id = $request->memberId;
        Group::where('id', $id)->delete();
    }

    public function updateGroupMember(Request $request)
    {
        $this->validate($request, [
            'member' => 'required'
        ]);
        Group::where('id', $request->member['id'])->delete();
        $user = User::where('id', $request->member['memberId'])->first();
        $groupArr = $user->groupArr;
        array_push($groupArr, $request->member['lessonId']);
        $user->groupArr = array_values($groupArr);
        return $user->update();
    }

    public function createStudentId(Request $request)
    {
        $this->validate($request, [
            'userList' => 'required'
        ]);
        $userList = $request->userList;
        foreach ($userList as $user) {
            User::where('id', $user['id'])->update([
                'studentId' => $user['studentId']
            ]);
        }
        return;
    }
}
