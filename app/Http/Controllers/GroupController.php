<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;

use Illuminate\Support\Facades\Auth;
class GroupController extends Controller
{
    //
    public function getGroup(Request $request){
        $this->validate($request,[
            'schoolId'=>'required'
        ]);
        return Group::where('schoolId',$request->schoolId)->get();

    }

    public function createGroup(Request $request){
        $userId = Auth::user()->id;
        $this->validate($request,[
            'schoolId'=>'required',
            'groupName'=>'required'
        ]);
        return Group::create([
            'schoolId'=>$request->schoolId,
            'groupName'=>$request->groupName,
            'userId'=>$userId
        ]);
    }

    public function deleteGroup(Request $request){
        $this->validate($request,[
            'id'=>'required'
        ]);
        return Group::where('id',$request->id)->delete();
    }
}
