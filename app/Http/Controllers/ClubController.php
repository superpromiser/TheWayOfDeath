<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Club;
use App\ClubMember;
use Illuminate\Support\Facades\Auth;

class ClubController extends Controller
{
    //
    public function getClub(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        $userId = Auth::user()->id;
        if ($request->lessonId) {
            return Club::where(['schoolId' => $request->schoolId, 'lessonId' => $request->lessonId])->with('member.user')->get();
        } else {
            return Club::where(['schoolId' => $request->schoolId, 'lessonId' => 0])->get();
        }
    }

    public function createClub(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
            'lessonId' => 'required',
            'clubName' => 'required',
            'memberNames' => 'required',
            'memberIds' => 'required',
        ]);
        $userId = Auth::user()->id;
        $lessonId = 0;
        if ($request->lessonId) {
            $lessonId = $request->lessonId;
        }
        $clubId = Club::create([
            'clubName' => $request->clubName,
            'members' => $request->memberNames,
            'schoolId' => $request->schoolId,
            'lessonId' => $request->lessonId,
            'userId' => $userId
        ])->id;
        foreach ($request->memberIds as $memberId) {
            ClubMember::create([
                'clubId' => $clubId,
                'memberId' => $memberId
            ]);
        }
        return 1;
    }

    public function updateClub(Request $request)
    {
        $this->validate($request,[
            'schoolId'=>'required',
            'lessonId'=>'required',
            'clubName'=>'required',
            'memberNames'=>'required',
            'memberIds'=>'required',
            'clubId'=>'required'
        ]);
        Club::where('id',$request->clubId)->update([
            'clubName'=>$request->clubName,
            'members'=>$request->memberNames
        ]);
        ClubMember::where('clubId',$request->clubId)->delete();
        foreach ($request->memberIds as $memberId) {
            ClubMember::create([
                'clubId' => $request->clubId,
                'memberId' => $memberId
            ]);
        }
        return true;
        // $this->validate($request,[
        //     'schoolId'=>'required',
        //     'lessonId'=>'required',
        //     'lessonOrder'=>'required',
        //     'seatData'=>'required'
        // ]);
        // return Club::where(['schoolId'=>$request->schoolId,'lessonId'=>$request->lessonId,'lessonOrder'=>$request->lessonOrder])->update
    }

    public function deleteClub(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        return Club::where('id', $request->id)->delete();
    }
}
