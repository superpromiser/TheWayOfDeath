<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Permission;
use App\Content;
use App\UserRole;
use App\Member;
use Illuminate\Support\Facades\Auth;
use Hash;
use Carbon\Carbon;
use DateTime;
class UserController extends Controller
{
    public function createStaff(Request $request){
        $schoolId = Auth::user()->schoolId;
        $staffData['name'] = $request->name;
        $staffData['phoneNumber'] = $request->phoneNumber;
        $staffData['password'] = bcrypt($request->password);
        $staffData['avatar'] = $request->avatar;
        $staffData['schoolId'] = $schoolId;
        $staffData['gender'] = $request->gender;
        $staffData['nation'] = $request->nation;
        $staffData['cardNum'] = $request->cardNum;
        $staffData['roleId'] = $request->roleId;
        $staffData['familyAddress'] = json_encode($request->familyAddress);
        $staffData['residenceAddress'] = json_encode($request->residenceAddress);
        $manager = User::create($staffData);

        $memberData['schoolId'] = $schoolId;
        $memberData['gradeId'] = $request->gradeId;
        $memberData['lessonId'] = $request->lessonId;
        $memberData['userId'] = $manager->id;
        $memberData['userRoleId'] = $request->roleId;
        $member = Member::create($memberData);

        return response()->json([
            'msg' => 1,
            'id' => $manager->id
        ], 201);
    }

    public function updateStaff(Request $request){
        User::where('id',$request->id)->update([
            'name'=>$request->name,
            'phoneNumber'=>$request->phoneNumber,
            'password'=>bcrypt($request->password),
            'avatar'=>$request->avatar,
            'gender'=>$request->gender,
            'cardNum'=>$request->cardNum,
            'nation'=>$request->nation,
            'roleId'=>$request->roleId,
            'familyAddress'=>json_encode($request->familyAddress),
            'residenceAddress'=>json_encode($request->residenceAddress),
        ]);
        return response()->json([
            'msg' => 1
        ], 200);
    }

    public function createStudent(Request $request){
        $schoolId = Auth::user()->schoolId;
        $studentData['name'] = $request->name;
        $studentData['phoneNumber'] = $request->phoneNumber;
        $studentData['password'] = bcrypt($request->password);
        $studentData['avatar'] = $request->avatar;
        $studentData['schoolId'] = $schoolId;
        $studentData['gender'] = $request->gender;
        $studentData['cardNum'] = $request->cardNum;
        $studentData['imei'] = $request->imei;
        $studentData['fatherName'] = $request->fatherName;
        $studentData['fatherPhone'] = $request->fatherPhone;
        $studentData['fatherJob'] = $request->fatherJob;
        $studentData['introduce'] = $request->introduce;
        $studentData['birthday'] = new DateTime($request->birthday);
        $studentData['roleId'] = 5;
        $studentData['familyAddress'] = json_encode($request->familyAddress);
        $student = User::create($studentData);

        $memberData['schoolId'] = $schoolId;
        $memberData['gradeId'] = $request->gradeId;
        $memberData['lessonId'] = $request->lessonId;
        $memberData['userId'] = $student->id;
        $memberData['userRoleId'] = 5;
        $member = Member::create($memberData);

        return response()->json([
            'msg' => 1,
            'id' => $student->id
        ], 201);
    }

    public function updateStudent(Request $request){
        User::where('id',$request->id)->update([
            'name'=>$request->name,
            'phoneNumber'=>$request->phoneNumber,
            'password'=>bcrypt($request->password),
            'avatar'=>$request->avatar,
            'gender'=>$request->gender,
            'cardNum'=>$request->cardNum,
            'imei'=>$request->imei,
            'fatherName'=>$request->fatherName,
            'fatherPhone'=>$request->fatherPhone,
            'fatherJob'=>$request->fatherJob,
            'introduce'=>$request->introduce,
            'birthday'=>new DateTime($request->birthday),
            'familyAddress'=>json_encode($request->familyAddress),
        ]);
        return response()->json([
            'msg' => 1
        ], 200);
    }

    public function getstudentBylessonId(Request $request){
        $lessonId = $request->lessonId;
        $gradeId = $request->gradeId;
        $studentList = [];
        $memberList = Member::where([['lessonId', '=', $lessonId]])->where([['gradeId', '=', $gradeId]])->where([['userRoleId', '=', 5]])->get();
        foreach ($memberList as $key => $member) {
            $userId = $member->userId;
            $userData = User::where([['id', '=', $userId]])->where([['roleId', '=', 5]])->first();
            array_push($studentList, $userData); 
        }
        return $studentList;
    }

    public function readUser(){
        return User::all();
    }
    public function readstudent(){
        return User::where([['roleId', '=', '5']])->where([['schoolId', '=', Auth::user()->schoolId]])->get();
    }

    public function updateUser(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'phoneNumber' => "required|unique:users,phoneNumber,$request->id",
            'password' => 'min:6',
            'roleId' => 'required'
        ]);
        $data = [
            'name' => $request->name,
            'phoneNumber' => $request->phoneNumber,
            'roleId' => $request->roleId
        ];
        if($request->password){
            $password = bcrypt($request->password);
            $data['password'] = $password;
        }
        
        $user = User::where('id',$request->id)->update($data);
        Permission::where('userId',$request->id)->update([
            'roleId'=>$request->roleId
        ]);
        return response()->json([
            'user'=>$user
        ],200);
    }

    public function deleteUser(Request $request){
        $this->validate($request,[
            'id' => 'required'
        ]);
        User::where('id',$request->id)->delete();
        return response()->json([
            'msg' => 1
        ], 200);
    }

    public function readContact(Request $request){
        $schoolId = $request->schoolId;
        $classId = $request->classId;
        if($classId == null){
            $schoolMembers = Member::where('schoolId', $schoolId)->get();
            $schoolMembersUserIdList = array();
            foreach ($schoolMembers as $key => $member){
                array_push($schoolMembersUserIdList, $member->userId);
            }
            $user = User::whereIn('id', $schoolMembersUserIdList)
                            ->orderBy('name','asc')
                            ->get();
            $userName = User::select('name')
                            ->whereIn('id', $schoolMembersUserIdList)
                            ->orderBy('name')
                            ->get();
            return response()->json([
                'user'=>$user,
                'userName'=>$userName
            ]);
        }

        else{
            $schoolMembers = Member::where('schoolId', $schoolId)->where('lessonId', $classId)->get();
            $schoolMembersUserIdList = array();
            foreach ($schoolMembers as $key => $member){
                array_push($schoolMembersUserIdList, $member->userId);
            }
            $user = User::whereIn('id', $schoolMembersUserIdList)
                            ->orderBy('name','asc')
                            ->get();
            $userName = User::select('name')
                            ->whereIn('id', $schoolMembersUserIdList)
                            ->orderBy('name')
                            ->get();
            return response()->json([
                'user'=>$user,
                'userName'=>$userName
            ]);
        }

    }

    public function memberContact(){
        
    }

    public function updateProfile(Request $request){
        $userId = $request->userId;
        if($request->userName){
            $userName = $request->userName;
            $data = User::where('id',$userId)->update(['name'=>$userName]);
        }else if($request->phoneNumber){
            $phoneNumber = $request->phoneNumber;
            $data = User::where('id',$userId)->update(['phoneNumber'=>$phoneNumber]);
        }else if($request->newPassword){
            $inputedOldPassword = $request->oldPassword;
            $inputedNewPassword = $request->newPassword;
            if (Hash::check($inputedOldPassword, Auth::user()->password)) {
                return response()->json([
                    'msg'=> 0,
                ]);
            }
            User::where('id',$userId)->update(['password'=>bcrypt($inputedNewPassword)]);
            return response()->json([
                'msg'=> 1,
            ]);
        }else if($request->avatar){
            $avatar = $request->avatar;
            $data = User::where('id',$userId)->update(['avatar'=>$avatar]);
        }else if($request->faceImg){
            $faceImg = $request->faceImg;
            $data = User::where('id',$userId)->update(['faceImg'=>$faceImg]);
        }else if($request->isActived == 1){
            $isActived = $request->isActived;
            $data = User::where('id',$userId)->update(['isActived'=>1]);
        }else if($request->isActived == 0){
            $isActived = $request->isActived;
            $data = User::where('id',$userId)->update(['isActived'=>0]);
        }
        return $data;
    }

    public function updateStatus(Request $request){
        $userId = Auth::user()->id;
        $userData = User::where('id', $userId)->first();
        $userData->status = $request->status;
        $userData->statusFrom = $request->statusFrom;
        $userData->statusTo = $request->statusTo;
        $userData->save();
        return response()->json([
            'msg'=> 1
        ]);
    }

    public function newVideoCount(Request $request){
        $userId = Auth::user()->id;
        $userData = User::where('id', $userId)->first();
        $newVideoCnt = $request->new_video_cnt;
        $userData->new_video_cnt = $newVideoCnt;
        $userData->save();
    }

    public function newLiveCount(Request $request){
        $userId = Auth::user()->id;
        $userData = User::where('id', $userId)->first();
        $newLiveCnt = $request->new_live_cnt;
        $userData->new_live_cnt = $newLiveCnt;
        $userData->save();
    }

    public function getUserById(Request $request){
        $this->validate($request,[
            'id'=>'required'
        ]);
        $id = $request->id;
        return User::where('id',$request->id)->get();
    }

    public function search(Request $request){
        $searchedUserList = array();
        $searchedContentList = array();
        $userList = User::all();
        $contentList = Content::all();
        foreach ($userList as $key => $user){
            $userName = $user->name;
            if(strpos($userName, $request->searchWord) !== false){
                // if(Auth::user()->id == $user->id){
                //     return;
                // }
                array_push($searchedUserList, $user->load('role'));
            }
        }
        foreach ($contentList as $key => $content){
            $contentName = $content->contentName;
            if(strpos($contentName, $request->searchWord) !== false){
                array_push($searchedContentList, $content);
            }
        }

        return response()->json([
            'userList'=> $searchedUserList,
            'contentList'=> $searchedContentList,
        ]);

    }
    public function getStudentList(){
        return User::where('roleId',5)->get();
    }

    public function readstaff(){
        return User::where('roleId',3)->orWhere('roleId', 4)->where('schoolId', Auth::user()->schoolId)->get();
    }

    public function getStatus(Request $request){
        $userData = User::where('id', Auth::user()->id)->first();
        if($userData->statusTo == null){
            return response()->json([
                'isChanged'=> 2, // normal status
            ]);
        }
        else{
            $statusTo = new DateTime($userData->statusTo);
            $nowTime = new DateTime();
            if($nowTime > $statusTo){
                $userData->status = 0;
                $userData->statusFrom = null;
                $userData->statusTo = null;
                $userData->save();
                return response()->json([
                    'isChanged'=> 1, // have changed to normal status
                ]);
            }
            else{
                return response()->json([
                    'isChanged'=> 0, // not changed the status
                    'status'=> $userData->status,
                    'statusFrom'=> $userData->statusFrom,
                    'statusTo'=> $userData->statusTo,
                ]);
            }
        }
    }
    
}