<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;

use Illuminate\Support\Facades\Auth;
class GroupController extends Controller
{
    //
    public function getGroupMemeber(Request $request){

    }

    public function addGroupMember(Request $request){
        $this->validate($request,[
            'schoolId'=>'required',
            'lessonId'=>'required'
        ]);
        $userId = Auth::user()->id;
        $members = $request->userList;
        foreach($members as $member){
            $memberId = $member['id'];
            Group::create([
                'schoolId'=>$request->schoolId,
                'lessonId'=>$request->lessonId,
                'memberId'=>$memberId,
                'userId'=>$userId
            ]);
        };
        return true;
    }

    public function deleteGroupMember(Request $request){

    }
}
