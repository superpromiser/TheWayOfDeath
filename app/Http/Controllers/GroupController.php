<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;

use Illuminate\Support\Facades\Auth;
class GroupController extends Controller
{
    //
    public function getGroupMember(Request $request){
        $this->validate($request,[
            'schoolId'=>'required'
        ]);
        if($request->lessonId){
            return Group::where(['schoolId'=>$request->schoolId,'lessonId'=>$request->lessonId,'status'=>'pending'])->with(['members:id,name,gender,phoneNumber,roleId','users:id,name'])->get();
        }else{
            return Group::where(['schoolId'=>$request->schoolId,'lessonId'=>0,'status'=>'pending'])->with(['members:id,name,gender,phoneNumber,roleId','users:id,name'])->get();
        }
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

    public function updateGroupMember(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'status'=>'required'
        ]);
        return Group::where('id',$request->id)->update([
            'status'=>$request->status
        ]);
    }

    public function deleteGroupMember(Request $request){

    }
}
