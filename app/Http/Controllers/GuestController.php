<?php

namespace App\Http\Controllers;

use App\Guest;
use App\User;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function createGuestRequest(Request $request)
    {   
        $this->validate($request,[
            'name'=>'required',
            'avatar'=>'required',
            'cardNum'=>'required',
            'memberName'=>'required',
            'memberPhone'=>'required',
            'meetingDate'=>'required',
            'meetingReason'=>'required',
        ]);

        $memberData = User::where(['name'=>$request->memberName, 'phoneNumber'=>$request->memberPhone])->first();
        if(!$memberData){
            return response()->json([
                'msg' => 0,
            ]);
        }

        else{
            if($memberData->roldId == 3){
                $teacherData = $memberData;
            }
            else{
                $teacherData = User::where([
                    'roleId' => 3,
                    'lessonId' => $memberData->lessonId,
                ])->first();
            }

            //Emit Event and push notification to teacher of memeber
            


            //save request of guest
            Guest::create([
                'name'=> $request->name,
                'avatar'=> $request->avatar,
                'cardNum'=> $request->cardNum,
                'memberName'=> $request->memberName,
                'memberPhone'=> $request->memberPhone,
                'meetingDate'=> $request->meetingDate,
                'meetingReason'=> $request->meetingReason,
            ]);

            return response()->json([
                'msg' => 1,
                'teacherData' => $teacherData
            ]);
        }

    }
}
