<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Club;
use Illuminate\Support\Facades\Auth;
class ClubController extends Controller
{
    //
    public function getClub(Request $request){
        $this->validate($request,[
            'schoolId'=>'required'
        ]);
        $userId = Auth::user()->id;
        if($request->lessonId){
            return Club::where(['schoolId'=>$request->schoolId,'lessonId'=>$request->lessonId])->get();
        }else{
            return Club::where(['schoolId'=>$request->schoolId,'lessonId'=>0])->get();
        }
    }

    public function createClub(Request $request){
        $this->validate($request,[
            'schoolId'=>'required',
            'lessonId'=>'required',
            'clubName'=>'required',
            'members'=>'required',
        ]);
        $userId = Auth::user()->id;
        $lessonId = 0;
        if($request->lessonId){
            $lessonId = $request->lessonId;
        }
        foreach($request->members as $memberId){
            Club::create([
                'schoolId'=>$request->schoolId,
                'lessonId'=>$lessonId,
                'userId'=>$userId,
                'clubName'=>$request->clubName,
                'memberId'=>$memberId,
            ]);
        }
        return 1;
    }

    public function updateClub(Request $request){
        // $this->validate($request,[
        //     'schoolId'=>'required',
        //     'lessonId'=>'required',
        //     'lessonOrder'=>'required',
        //     'seatData'=>'required'
        // ]);
        // return Club::where(['schoolId'=>$request->schoolId,'lessonId'=>$request->lessonId,'lessonOrder'=>$request->lessonOrder])->update
    }

    public function deleteClub(Request $request){
        $this->validate($request,[
            'id'=>'required'
        ]);
        return Club::where('id',$request->id)->delete();
    }
}
