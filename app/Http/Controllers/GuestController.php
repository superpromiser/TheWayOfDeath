<?php

namespace App\Http\Controllers;

use App\Guest;
use App\User;
use App\Alarm;

use App\Events\NewGuest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestController extends Controller
{
    public function createGuestRequest(Request $request)
    {   
        $this->validate($request,[
            'name'=>'required',
            'avatar'=>'required',
            'cardNum'=>'required',
            'phoneNumber'=>'required',
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
                    'roleId' => 7,
                    'lessonId' => $memberData->lessonId,
                ])->first();
            }
            
            //save request of guest
            $guestData = Guest::create([
                'name'=> $request->name,
                'avatar'=> '/uploads/image/'.$imageName,
                'cardNum'=> $request->cardNum,
                'phoneNumber'=> $request->phoneNumber,
                'memberName'=> $request->memberName,
                'memberPhone'=> $request->memberPhone,
                'memberSchoolId'=>$memberData->schoolId,
                'memberGradeId'=>$memberData->gradeId,
                'memberLessonId'=>$memberData->lessonId,
                'meetingDate'=> $request->meetingDate,
                'meetingReason'=> $request->meetingReason,
            ]);

            ///////////////////////////boradcasting New Guest///////////////////////////
            //make broadcasting data
            $broadcastingData['id'] = $guestData->id;
            $broadcastingData['name'] = $guestData->name;
            $broadcastingData['avatar'] = $guestData->avatar;
            $broadcastingData['cardNum'] = $guestData->cardNum;
            $broadcastingData['status'] = 'pending';
            $broadcastingData['phoneNumber'] = $guestData->phoneNumber;
            $broadcastingData['meetingDate'] = $guestData->meetingDate;
            $broadcastingData['memberName'] = $guestData->memberName;
            $broadcastingData['memberPhone'] = $guestData->memberPhone;
            $broadcastingData['meetingReason'] = $guestData->meetingReason;

            //save new alarm
            $alarm = Alarm::create([
                'userId' => $teacherData->id,
                'type' => 'NewGuest',
                'guestId' => $guestData->id,
                'content' => json_encode($broadcastingData),
            ]);

            //Emit Event and push notification to teacher of memeber
            broadcast(new NewGuest($alarm, $teacherData->id));
            ///////////////////////////boradcasting New Guest///////////////////////////
            
            return response()->json([
                'msg' => 1,
            ]);
        }

    }

    public function getGuest()
    {   
        if(Auth::user()->roleId == 2){
            return Guest::where([
                'schoolId' => Auth::user()->schoolId,
                ])->get();
        }
        else if(Auth::user()->roleId == 7){
            return Guest::where([
                'memberSchoolId' => Auth::user()->schoolId,
                'memberGradeId' => Auth::user()->gradeId,
                'memberLessonId' => Auth::user()->lessonId,
                ])->get();
        }
    }

    public function updateGuest(Request $request)
    {
        Guest::where('id', $request->id)->update(['status'=> $request->status]);
        return response()->json([
            'msg' => 1,
        ]);
    }
}
