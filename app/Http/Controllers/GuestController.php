<?php

namespace App\Http\Controllers;

use App\Guest;
use App\User;
use Illuminate\Http\Request;
use App\Events\NewGuest;

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

        //save base 64 file to public directory
        $image = $request->avatar;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = time().'.'.'png';

        \Image::make($request->avatar)->save(public_path('uploads/image/').$imageName);

        //find member in user table
        $memberData = User::where(['name'=>$request->memberName, 'phoneNumber'=>$request->memberPhone])->first();

        //if member does not exist
        if(!$memberData){
            return response()->json([
                'msg' => 0,
            ]);
        }
        
        //else member exist
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
            
            //save request of guest
            $guestData = Guest::create([
                'name'=> $request->name,
                'avatar'=> '/uploads/image/'.$imageName,
                'cardNum'=> $request->cardNum,
                'memberName'=> $request->memberName,
                'memberPhone'=> $request->memberPhone,
                'meetingDate'=> $request->meetingDate,
                'meetingReason'=> $request->meetingReason,
            ]);

            //make broadcasting data
            $broadcastingData['id'] = $guestData->id;
            $broadcastingData['name'] = $guestData->name;
            $broadcastingData['avatar'] = $guestData->avatar;
            $broadcastingData['memberName'] = $guestData->memberName;
            $broadcastingData['memberPhone'] = $guestData->memberPhone;
            $broadcastingData['meetingReason'] = $guestData->meetingReason;

            //Emit Event and push notification to teacher of memeber
            broadcast(new NewGuest($broadcastingData, $teacherData->id));

            return response()->json([
                'msg' => 1,
            ]);
        }

    }
}
