<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Grade;
use App\Lesson;
use App\Permission;
use App\Content;
use App\UserRole;
use App\Member;
use App\Post;
use App\Like;
use App\Contact;

use Hash;
use Carbon\Carbon;
use DateTime;

class UserController extends Controller
{
    public function createStaff(Request $request)
    {
        $schoolId = Auth::user()->schoolId;

        $staffData['name'] = $request->name;
        $staffData['phoneNumber'] = $request->phoneNumber;
        $staffData['password'] = bcrypt('password');
        $staffData['avatar'] = $request->avatar;
        $staffData['schoolId'] = $schoolId;
        $staffData['gradeId'] = $request->gradeId;
        $staffData['lessonId'] = $request->lessonId;
        $staffData['gender'] = $request->gender;
        $staffData['nation'] = $request->nation;
        $staffData['cardNum'] = $request->cardNum;
        $staffData['roleId'] = $request->roleId;
        if ($request->roleId == 4) {
            $staffData['status'] = "上课中";
        }
        $staffData['familyAddress'] = json_encode($request->familyAddress);
        $staffData['residenceAddress'] = json_encode($request->residenceAddress);
        $groupArr = array();
        array_push($groupArr, 0);
        if (!is_null($request->lessonId)) {
            array_push($groupArr, $request->lessonId);
        }
        $staffData['groupArr'] = $groupArr;
        $manager = User::create($staffData);

        $contactInfo['userId'] = $manager->id;
        $contactInfo['contactUserId'] = 1;
        $contact = Contact::create($contactInfo);

        return response()->json([
            'msg' => 1,
            'id' => $manager->id
        ], 201);
    }

    public function updateStaff(Request $request)
    {
        $groupArr = array();
        array_push($groupArr, 0);
        $roleId = $request->roleId;
        if (!is_null($request->lessonId)) {
            array_push($groupArr, $request->lessonId);
            $roleId = 7;
        }
        User::where('id', $request->id)->update([
            'name' => $request->name,
            'phoneNumber' => $request->phoneNumber,
            // 'password' => bcrypt($request->password),
            'avatar' => $request->avatar,
            'gender' => $request->gender,
            'cardNum' => $request->cardNum,
            'nation' => $request->nation,
            'gradeId' => $request->gradeId,
            'lessonId' => $request->lessonId,
            'roleId' => $roleId,
            'familyAddress' => json_encode($request->familyAddress),
            'residenceAddress' => json_encode($request->residenceAddress),
            'groupArr' => $groupArr
        ]);
        Member::where('userId', $request->id)->update([
            'gradeId' => $request->gradeId,
            'lessonId' => $request->lessonId,
        ]);
        return response()->json([
            'msg' => 1
        ], 200);
    }

    public function createStudent(Request $request)
    {
        $schoolId = Auth::user()->schoolId;
        $studentData['name'] = $request->name;
        $studentData['phoneNumber'] = $request->phoneNumber;
        $studentData['password'] = bcrypt('password');
        $studentData['avatar'] = $request->avatar;
        $studentData['schoolId'] = $schoolId;
        $studentData['gradeId'] = $request->gradeId;
        $studentData['lessonId'] = $request->lessonId;
        $studentData['nation'] = $request->nation;
        $studentData['gender'] = $request->gender;
        $studentData['cardNum'] = $request->cardNum;
        $studentData['imei'] = $request->imei;
        $studentData['fatherName'] = $request->fatherName;
        $studentData['fatherPhone'] = $request->fatherPhone;
        $studentData['fatherJob'] = $request->fatherJob;
        $studentData['introduce'] = $request->introduce;
        $studentData['status'] = "上课中";
        $studentData['birthday'] = new DateTime($request->birthday);
        $studentData['roleId'] = 5;
        $studentData['familyAddress'] = json_encode($request->familyAddress);
        $groupArr = array();
        array_push($groupArr, 0);
        array_push($groupArr, $request->lessonId);
        $studentData['groupArr'] = $groupArr;
        $student = User::create($studentData);

        //create contact with chatbot
        $contactInfo['userId'] = $student->id;
        $contactInfo['contactUserId'] = 1;
        $contact = Contact::create($contactInfo);

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

    public function updateStudent(Request $request)
    {
        $groupArr = array();
        array_push($groupArr, 0);
        array_push($groupArr, $request->lessonId);
        User::where('id', $request->id)->update([
            'name' => $request->name,
            'phoneNumber' => $request->phoneNumber,
            'password' => bcrypt($request->password),
            'avatar' => $request->avatar,
            'gender' => $request->gender,
            'cardNum' => $request->cardNum,
            'imei' => $request->imei,
            'gradeId' => $request->gradeId,
            'lessonId' => $request->lessonId,
            'fatherName' => $request->fatherName,
            'fatherPhone' => $request->fatherPhone,
            'fatherJob' => $request->fatherJob,
            'introduce' => $request->introduce,
            'birthday' => new DateTime($request->birthday),
            'familyAddress' => json_encode($request->familyAddress),
            'groupArr' => $groupArr
        ]);
        Member::where('userId', $request->id)->update([
            'gradeId' => $request->gradeId,
            'lessonId' => $request->lessonId,
        ]);
        return response()->json([
            'msg' => 1
        ], 200);
    }

    public function getstudentBylessonId(Request $request)
    {
        $lessonId = $request->lessonId;
        return User::where("groupArr", "like", "%{$lessonId}%")->where('roleId', 5)->get();
    }

    public function readUser()
    {
        return User::all();
    }
    public function readstudent()
    {
        return User::where([['roleId', '=', '5']])->where([['schoolId', '=', Auth::user()->schoolId]])->get();
    }

    public function updateUser(Request $request)
    {
        $this->validate($request, [
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
        if ($request->password) {
            $password = bcrypt($request->password);
            $data['password'] = $password;
        }

        $user = User::where('id', $request->id)->update($data);
        Permission::where('userId', $request->id)->update([
            'roleId' => $request->roleId
        ]);
        return response()->json([
            'user' => $user
        ], 200);
    }

    public function deleteUser(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        User::where('id', $request->id)->delete();
        return response()->json([
            'msg' => 1
        ], 200);
    }

    public function readContact(Request $request)
    {
        $schoolId = $request->schoolId;
        $classId = $request->classId;
        if ($classId == null) {
            $schoolMembers = Member::where('schoolId', $schoolId)->get();
            $schoolMembersUserIdList = array();
            foreach ($schoolMembers as $key => $member) {
                array_push($schoolMembersUserIdList, $member->userId);
            }
            $user = User::whereIn('id', $schoolMembersUserIdList)
                ->orderBy('name', 'asc')
                ->get();
            $userName = User::select('name')
                ->whereIn('id', $schoolMembersUserIdList)
                ->orderBy('name')
                ->get();
            return response()->json([
                'user' => $user,
                'userName' => $userName
            ]);
        } else {
            $schoolMembers = Member::where('schoolId', $schoolId)->where('lessonId', $classId)->get();
            $schoolMembersUserIdList = array();
            foreach ($schoolMembers as $key => $member) {
                array_push($schoolMembersUserIdList, $member->userId);
            }
            $user = User::whereIn('id', $schoolMembersUserIdList)
                ->orderBy('name', 'asc')
                ->get();
            $userName = User::select('name')
                ->whereIn('id', $schoolMembersUserIdList)
                ->orderBy('name')
                ->get();
            return response()->json([
                'user' => $user,
                'userName' => $userName
            ]);
        }
    }

    public function memberContact()
    {
    }

    public function updateProfile(Request $request)
    {
        $userId = $request->userId;
        if ($request->userName) {
            $userName = $request->userName;
            $data = User::where('id', $userId)->update(['name' => $userName]);
        } else if ($request->phoneNumber) {
            $phoneNumber = $request->phoneNumber;
            $data = User::where('id', $userId)->update(['phoneNumber' => $phoneNumber]);
        } else if ($request->newPassword) {
            $inputedOldPassword = $request->oldPassword;
            $inputedNewPassword = $request->newPassword;
            if (Hash::check($inputedOldPassword, Auth::user()->password)) {
                return response()->json([
                    'msg' => 0,
                ]);
            }
            User::where('id', $userId)->update(['password' => bcrypt($inputedNewPassword)]);
            return response()->json([
                'msg' => 1,
            ]);
        } else if ($request->avatar) {
            $avatar = $request->avatar;
            $data = User::where('id', $userId)->update(['avatar' => $avatar]);
        } else if ($request->faceImg) {
            $faceImg = $request->faceImg;
            $data = User::where('id', $userId)->update(['faceImg' => $faceImg]);
        } else if ($request->isActived == 1) {
            $isActived = $request->isActived;
            $data = User::where('id', $userId)->update(['isActived' => 1]);
        } else if ($request->isActived == 0) {
            $isActived = $request->isActived;
            $data = User::where('id', $userId)->update(['isActived' => 0]);
        }
        return $data;
    }

    public function updateStatus(Request $request)
    {
        $userId = Auth::user()->id;
        $userData = User::where('id', $userId)->first();
        $userData->status = $request->status;
        $userData->statusFrom = $request->statusFrom;
        $userData->statusTo = $request->statusTo;
        $userData->save();
        return response()->json([
            'msg' => 1
        ]);
    }

    public function newVideoCount(Request $request)
    {
        $userId = Auth::user()->id;
        $userData = User::where('id', $userId)->first();
        $newVideoCnt = $request->new_video_cnt;
        $userData->new_video_cnt = $newVideoCnt;
        $userData->save();
    }

    public function newLiveCount(Request $request)
    {
        $userId = Auth::user()->id;
        $userData = User::where('id', $userId)->first();
        $newLiveCnt = $request->new_live_cnt;
        $userData->new_live_cnt = $newLiveCnt;
        $userData->save();
    }

    public function getUserById(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $id = $request->id;
        return User::where('id', $request->id)->get();
    }

    public function search(Request $request)
    {
        $searchedUserList = array();
        $searchedContentList = array();
        $userList = User::all();
        $contentList = Content::all();
        foreach ($userList as $key => $user) {
            $userName = $user->name;
            if (strpos($userName, $request->searchWord) !== false) {
                // if(Auth::user()->id == $user->id){
                //     return;
                // }
                array_push($searchedUserList, $user->load('role'));
            }
        }
        foreach ($contentList as $key => $content) {
            $contentName = $content->contentName;
            if (strpos($contentName, $request->searchWord) !== false) {
                array_push($searchedContentList, $content);
            }
        }

        return response()->json([
            'userList' => $searchedUserList,
            'contentList' => $searchedContentList,
        ]);
    }
    public function getStudentList()
    {
        return User::where('roleId', 5)->get();
    }

    public function readstaff()
    {
        return User::whereIn('roleId', [3, 4, 7])->where('schoolId', Auth::user()->schoolId)->get();
    }

    public function getStatus(Request $request)
    {
        $userData = User::where('id', Auth::user()->id)->first();
        if ($userData->statusTo == null) {
            return response()->json([
                'isChanged' => 2, // normal status
            ]);
        } else {
            $statusTo = new DateTime($userData->statusTo);
            $nowTime = new DateTime();
            if ($nowTime > $statusTo) {
                $userData->status = 0;
                $userData->statusFrom = null;
                $userData->statusTo = null;
                $userData->save();
                return response()->json([
                    'isChanged' => 1, // have changed to normal status
                ]);
            } else {
                return response()->json([
                    'isChanged' => 0, // not changed the status
                    'status' => $userData->status,
                    'statusFrom' => $userData->statusFrom,
                    'statusTo' => $userData->statusTo,
                ]);
            }
        }
    }

    public function getLessonUserList(Request $request)
    {
        $lessonId = $request->lessonId;
        if (Auth::user()->roleId == 2) {
            if ($lessonId) {
                return User::select('id', 'name', 'lessonId', 'avatar', 'studentId')->where(['lessonId' => $lessonId, 'roleId' => 5])->get();
            } else {
                $schoolId = Auth::user()->schoolId;
                return User::select('id', 'name', 'lessonId', 'avatar')->where(['schoolId' => $schoolId, 'roleId' => 5])->get();
            }
        } else {
            $lessonId = Auth::user()->lessonId;
            if ($request->lessonId) {
                $lessonId = $request->lessonId;
            }
            return User::select('id', 'name', 'lessonId', 'avatar', 'studentId')->where(['lessonId' => $lessonId, 'roleId' => 5])->get();
        }
    }

    public function getSchoolUsers(Request $request)
    {
        $schoolId = $request->schoolId;
        return User::select('id', 'name', 'avatar', 'gender', 'phoneNumber')->where(['schoolId' => $schoolId, 'roleId' => 5])->get();
    }

    public function getLessonUsers(Request $request)
    {
        $lessonId = $request->lessonId;
        return User::select('id', 'name', 'avatar', 'gender', 'phoneNumber')->where('groupArr', 'like', "%{$lessonId}%")->where(['roleId' => 5])->get();
    }

    public function getUserByRole(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
        ]);
        if ($request->lessonId) {
            $userList['teachers'] = User::select('id', 'name', 'avatar', 'phoneNumber')->where(['roleId' => 3, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId])->get();
        } else {
            $userList['teachers'] = User::select('id', 'name', 'avatar', 'phoneNumber')->where(['roleId' => 3, 'schoolId' => $request->schoolId])->get();
        }
        if ($request->lessonId) {
            $userList['parents'] = User::select('id', 'name', 'avatar', 'phoneNumber')->where(['roleId' => 4, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId])->get();
        } else {
            $userList['parents'] = User::select('id', 'name', 'avatar', 'phoneNumber')->where(['roleId' => 4, 'schoolId' => $request->schoolId])->get();
        }
        if ($request->lessonId) {
            $userList['students'] = User::select('id', 'name', 'avatar', 'phoneNumber')->where(['roleId' => 5, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId])->get();
        } else {
            $userList['students'] = User::select('id', 'name', 'avatar', 'phoneNumber')->where(['roleId' => 5, 'schoolId' => $request->schoolId])->get();
        }
        // return response()->json([
        //     'data'=>$userList,
        //     'status'=>200
        // ]);
        return $userList;
    }

    public function getSelUser(Request $request)
    {
        $this->validate($request, [
            'userId' => 'required'
        ]);
        return User::where('id', $request->userId)->first();
    }

    public function getSchoolMember(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        if ($request->roleId == 'teacher') {
            if ($request->lessonId) {
                return User::select('id', 'name', 'gender', 'phoneNumber', 'avatar')
                    ->where([
                        'schoolId' => $request->schoolId,
                    ])
                    ->whereIn(
                        'roleId',
                        [3, 7]
                    )->get();
            } else {
                return User::select('id', 'name', 'gender', 'phoneNumber', 'avatar')
                    ->where([
                        'schoolId' => $request->schoolId,
                        'roleId' => 3
                    ])
                    ->orWhere([
                        'schoolId' => $request->schoolId,
                        'roleId' => 7
                    ])
                    ->get();
            }
        } elseif ($request->roleId) {
            if ($request->lessonId) {
                return User::select('id', 'name', 'gender', 'phoneNumber', 'avatar')->where(['schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'roleId' => $request->roleId])->get();
            } else {
                return User::select('id', 'name', 'gender', 'phoneNumber', 'avatar')->where(['schoolId' => $request->schoolId, 'roleId' => $request->roleId])->get();
            }
        } else {
            if ($request->lessonId) {
                return User::select('id', 'name', 'gender', 'phoneNumber', 'avatar')->where(['schoolId' => $request->schoolId, 'lessonId' => $request->lessonId])->get();
            } else {
                return User::select('id', 'name', 'gender', 'phoneNumber', 'avatar')->where(['schoolId' => $request->schoolId])->get();
            }
        }
    }

    public function postSchoolItem(Request $request)
    {
        $userId = Auth::user()->id;
        $userData = User::where('id', $userId)->first();
        $userData->schoolItem = json_encode($request->schoolItem);
        $userData->save();
        return response()->json([
            'msg' => 1
        ]);
    }
    public function postClassItem(Request $request)
    {
        $userId = Auth::user()->id;
        $userData = User::where('id', $userId)->first();
        $userData->classItem = json_encode($request->classItem);
        $userData->save();
        return response()->json([
            'msg' => 1
        ]);
    }
    public function getPostItem()
    {
        $userId = Auth::user()->id;
        $userData = User::where('id', $userId)->first();
        return response()->json([
            'msg' => 1,
            'schoolItem' => $userData->schoolItem,
            'classItem' => $userData->classItem,
        ]);
    }

    public function upProfile(Request $request)
    {
        $userId = $request->userId;
        if ($request->application) {
            $data = User::where('id', $userId)->update([
                'avatar' => $request->avatar,
                'name' => $request->name,
                'phoneNumber' => $request->phoneNumber,
                'status' => $request->status,
                'subjectName' => $request->subjectName
            ]);
        }
        if ($request->userName && $request->avatar) {
            $avatar = $request->avatar;
            $userName = $request->userName;
            $data = User::where('id', $userId)->update(['avatar' => $avatar, 'name' => $userName]);
        } else if ($request->userName) {
            $userName = $request->userName;
            $data = User::where('id', $userId)->update(['name' => $userName]);
        } else if ($request->phoneNumber) {
            $phoneNumber = $request->phoneNumber;
            $data = User::where('id', $userId)->update(['phoneNumber' => $phoneNumber]);
        } else if ($request->newPassword) {
            $inputedOldPassword = $request->oldPassword;
            $inputedNewPassword = $request->newPassword;
            if (Hash::check($inputedOldPassword, Auth::user()->password)) {
                User::where('id', $userId)->update(['password' => bcrypt($inputedNewPassword)]);
                return response()->json([
                    'msg' => 1,
                ]);
            }
            return response()->json([
                'msg' => 0,
            ]);
        } else if ($request->avatar) {
            $avatar = $request->avatar;
            $data = User::where('id', $userId)->update(['avatar' => $avatar]);
        } else if ($request->status) {
            $status = $request->status;
            $data = User::where('id', $userId)->update(['status' => $status]);
        } else if ($request->wechat) {
            $wechat = $request->wechat;
            $data = User::where('id', $userId)->update(['wechat' => $wechat]);
        } else if ($request->qq) {
            $qq = $request->qq;
            $data = User::where('id', $userId)->update(['qq' => $qq]);
        }
        return response()->json([
            'msg' => "ok",
        ]);
        // return $data;
    }

    public function getEmployeeList()
    {
        $schoolId = Auth::user()->schoolId;
        if ($schoolId == 0) {
            return User::select('id', 'name', 'schoolId')->where(['roleId' => 6])->get();
        }
        return User::select('id', 'name', 'schoolId', 'nation', 'cardNum', 'gender', 'phoneNumber', 'avatar')->where(['roleId' => 6, 'schoolId' => $schoolId])->get();
    }

    public function createEmployee(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phoneNumber' => 'required',
            'gender' => 'required',
            'nation' => 'required',
            'cardNum' => 'required',
            'avatar' => 'required'
        ]);
        $schoolId = Auth::user()->schoolId;
        $employee = User::create([
            'name' => $request->name,
            'phoneNumber' => $request->phoneNumber,
            'gender' => $request->gender,
            'nation' => $request->nation,
            'cardNum' => $request->cardNum,
            'avatar' => $request->avatar,
            'schoolId' => $schoolId,
            'password' => bcrypt('password'),
            'roleId' => 6
        ]);

        //create contact with chatbot
        $contactInfo['userId'] = $employee->id;
        $contactInfo['contactUserId'] = 1;
        $contact = Contact::create($contactInfo);

        return true;
    }

    public function updateEmployee(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phoneNumber' => 'required',
            'gender' => 'required',
            'nation' => 'required',
            'cardNum' => 'required',
            'avatar' => 'required'
        ]);
        User::where('id', $request->id)->update([
            'name' => $request->name,
            'phoneNumber' => $request->phoneNumber,
            'gender' => $request->gender,
            'nation' => $request->nation,
            'cardNum' => $request->cardNum,
            'avatar' => $request->avatar
        ]);
        return true;
    }

    public function getStudentWithIds(Request $request)
    {
        $this->validate($request, [
            'studentList' => 'required'
        ]);
        return User::select('id', 'name', 'avatar', 'phoneNumber', 'imei')->whereIn('id', $request->studentList)->get();
    }

    public function getMyFile()
    {
        $userId = Auth::user()->id;
        $posts = Post::whereIn('contentId', [1, 2, 3, 6, 7, 8, 11, 12, 13, 16, 17, 23, 24, 25, 26])
            ->where('userId', $userId)
            ->with([
                'questionnaires:postId,content', //1, 12
                'votings:postId,content', //2, 13
                'sms:postId,content', //3
                'bulletinBoards:postId,content', //6
                'shares:postId,content', //23
                'safestudy:postId,content', //8
                'repairdata' => function ($q) { //7
                    $q->whereIn('status', ['progress', 'done']);
                },
                'schoolstory:postId,content', // 11
                'regnames:postId,content', // 24
                'homeVisit:postId,content', // 16
                'notifications:postId,description', // 17
                'classstory:postId,content', //25
                'interclassstory:postId,content', // 26
                'users:id,name'
            ])
            ->orderBy('created_at', 'desc')
            ->get();
        $imageFileList = array();
        $videoFileList = array();
        $otherFileList = array();
        foreach ($posts as $post) {
            switch ($post->contentId) {
                case 1:     //questionnaire
                    $contentData = json_decode($post->questionnaires->content);
                    foreach ($contentData as $content) {
                        if ($content->type == 'single') {
                            $postingData = $content->singleContentDataArr;
                            foreach ($postingData as $questionItem) {
                                $imgUrls = $questionItem->imgUrl;
                                foreach ($imgUrls as $imgUrl) {
                                    $path = $imgUrl->path;
                                    array_push($imageFileList, $path);
                                }
                                $videoUrls = $questionItem->videoUrl;
                                foreach ($videoUrls as $videoUrl) {
                                    array_push($videoFileList, $videoUrl);
                                }
                                $otherUrls = $questionItem->otherUrl;
                                foreach ($otherUrls as $otherUrl) {
                                    array_push($otherFileList, $otherUrl);
                                }
                            }
                        } else if ($content->type == 'multi') {
                            $postingData = $content->multiContentDataArr;
                            foreach ($postingData as $questionItem) {
                                $imgUrls = $questionItem->imgUrl;
                                foreach ($imgUrls as $imgUrl) {
                                    $path = $imgUrl->path;
                                    array_push($imageFileList, $path);
                                }
                                $videoUrls = $questionItem->videoUrl;
                                foreach ($videoUrls as $videoUrl) {
                                    array_push($videoFileList, $videoUrl);
                                }
                                $otherUrls = $questionItem->otherUrl;
                                foreach ($otherUrls as $otherUrl) {
                                    array_push($otherFileList, $otherUrl);
                                }
                            }
                        } else if ($content->type == 'qa') {
                            $postingData = $content->qaContentDataArr;
                            foreach ($postingData as $questionItem) {
                                $imgUrls = $questionItem->imgUrl;
                                foreach ($imgUrls as $imgUrl) {
                                    $path = $imgUrl->path;
                                    array_push($imageFileList, $path);
                                }
                                $videoUrls = $questionItem->videoUrl;
                                foreach ($videoUrls as $videoUrl) {
                                    array_push($videoFileList, $videoUrl);
                                }
                                $otherUrls = $questionItem->otherUrl;
                                foreach ($otherUrls as $otherUrl) {
                                    array_push($otherFileList, $otherUrl);
                                }
                            }
                        } else if ($content->type == 'score') {
                            $postingData = $content->scoringDataArr;
                            foreach ($postingData as $contentData) {
                                $post = $contentData->contentData;
                                foreach ($post as $questionItem) {
                                    $imgUrls = $questionItem->imgUrl;
                                    foreach ($imgUrls as $imgUrl) {
                                        $path = $imgUrl->path;
                                        array_push($imageFileList, $path);
                                    }
                                    $videoUrls = $questionItem->videoUrl;
                                    foreach ($videoUrls as $videoUrl) {
                                        array_push($videoFileList, $videoUrl);
                                    }
                                    $otherUrls = $questionItem->otherUrl;
                                    foreach ($otherUrls as $otherUrl) {
                                        array_push($otherFileList, $otherUrl);
                                    }
                                }
                            }
                        }
                    }
                    break;
                case 12:    //questionnaire
                    $contentData = json_decode($post->questionnaires->content);
                    foreach ($contentData as $content) {
                        if ($content->type == 'single') {
                            $postingData = $content->singleContentDataArr;
                            foreach ($postingData as $questionItem) {
                                $imgUrls = $questionItem->imgUrl;
                                foreach ($imgUrls as $imgUrl) {
                                    $path = $imgUrl->path;
                                    array_push($imageFileList, $path);
                                }
                                $videoUrls = $questionItem->videoUrl;
                                foreach ($videoUrls as $videoUrl) {
                                    array_push($videoFileList, $videoUrl);
                                }
                                $otherUrls = $questionItem->otherUrl;
                                foreach ($otherUrls as $otherUrl) {
                                    array_push($otherFileList, $otherUrl);
                                }
                            }
                        } else if ($content->type == 'multi') {
                            $postingData = $content->multiContentDataArr;
                            foreach ($postingData as $questionItem) {
                                $imgUrls = $questionItem->imgUrl;
                                foreach ($imgUrls as $imgUrl) {
                                    $path = $imgUrl->path;
                                    array_push($imageFileList, $path);
                                }
                                $videoUrls = $questionItem->videoUrl;
                                foreach ($videoUrls as $videoUrl) {
                                    array_push($videoFileList, $videoUrl);
                                }
                                $otherUrls = $questionItem->otherUrl;
                                foreach ($otherUrls as $otherUrl) {
                                    array_push($otherFileList, $otherUrl);
                                }
                            }
                        } else if ($content->type == 'qa') {
                            $postingData = $content->qaContentDataArr;
                            foreach ($postingData as $questionItem) {
                                $imgUrls = $questionItem->imgUrl;
                                foreach ($imgUrls as $imgUrl) {
                                    $path = $imgUrl->path;
                                    array_push($imageFileList, $path);
                                }
                                $videoUrls = $questionItem->videoUrl;
                                foreach ($videoUrls as $videoUrl) {
                                    array_push($videoFileList, $videoUrl);
                                }
                                $otherUrls = $questionItem->otherUrl;
                                foreach ($otherUrls as $otherUrl) {
                                    array_push($otherFileList, $otherUrl);
                                }
                            }
                        } else if ($content->type == 'score') {
                            $postingData = $content->scoringDataArr;
                            foreach ($postingData as $contentData) {
                                $post = $contentData->contentData;
                                foreach ($post as $questionItem) {
                                    $imgUrls = $questionItem->imgUrl;
                                    foreach ($imgUrls as $imgUrl) {
                                        $path = $imgUrl->path;
                                        array_push($imageFileList, $path);
                                    }
                                    $videoUrls = $questionItem->videoUrl;
                                    foreach ($videoUrls as $videoUrl) {
                                        array_push($videoFileList, $videoUrl);
                                    }
                                    $otherUrls = $questionItem->otherUrl;
                                    foreach ($otherUrls as $otherUrl) {
                                        array_push($otherFileList, $otherUrl);
                                    }
                                }
                            }
                        }
                    }
                    break;
                case 2:     //voting
                    $contentData = json_decode($post->votings->content);
                    foreach ($contentData as $questionItem) {
                        $imgUrls = $questionItem->imgUrl;
                        foreach ($imgUrls as $imgUrl) {
                            $path = $imgUrl->path;
                            array_push($imageFileList, $path);
                        }
                        $videoUrls = $questionItem->videoUrl;
                        foreach ($videoUrls as $videoUrl) {
                            array_push($videoFileList, $videoUrl);
                        }
                        $otherUrls = $questionItem->otherUrl;
                        foreach ($otherUrls as $otherUrl) {
                            array_push($otherFileList, $otherUrl);
                        }
                    }
                    break;
                case 13:    //voting
                    $contentData = json_decode($post->votings->content);
                    foreach ($contentData as $questionItem) {
                        $imgUrls = $questionItem->imgUrl;
                        foreach ($imgUrls as $imgUrl) {
                            $path = $imgUrl->path;
                            array_push($imageFileList, $path);
                        }
                        $videoUrls = $questionItem->videoUrl;
                        foreach ($videoUrls as $videoUrl) {
                            array_push($videoFileList, $videoUrl);
                        }
                        $otherUrls = $questionItem->otherUrl;
                        foreach ($otherUrls as $otherUrl) {
                            array_push($otherFileList, $otherUrl);
                        }
                    }
                    break;
                case 3:     //sms
                    $contentData = json_decode($post->sms->content);
                    foreach ($contentData as $questionItem) {
                        $imgUrls = $questionItem->imgUrl;
                        foreach ($imgUrls as $imgUrl) {
                            $path = $imgUrl->path;
                            array_push($imageFileList, $path);
                        }
                        $videoUrls = $questionItem->videoUrl;
                        foreach ($videoUrls as $videoUrl) {
                            array_push($videoFileList, $videoUrl);
                        }
                        $otherUrls = $questionItem->otherUrl;
                        foreach ($otherUrls as $otherUrl) {
                            array_push($otherFileList, $otherUrl);
                        }
                    }
                    break;
                case 6:     //bulletinBoards
                    $contentData = json_decode($post->bulletinBoards->content);
                    $imgUrls = $contentData->imgUrl;
                    foreach ($imgUrls as $imgUrl) {
                        $path = $imgUrl->path;
                        array_push($imageFileList, $path);
                    }
                    $videoUrls = $contentData->videoUrl;
                    foreach ($videoUrls as $videoUrl) {
                        array_push($videoFileList, $videoUrl);
                    }
                    $otherUrls = $contentData->otherUrl;
                    foreach ($otherUrls as $otherUrl) {
                        array_push($otherFileList, $otherUrl);
                    }
                    break;
                case 23:    //shares
                    $contentData = json_decode($post->shares->content);
                    foreach ($contentData as $questionItem) {
                        $imgUrls = $questionItem->imgUrl;
                        foreach ($imgUrls as $imgUrl) {
                            $path = $imgUrl->path;
                            array_push($imageFileList, $path);
                        }
                        $videoUrls = $questionItem->videoUrl;
                        foreach ($videoUrls as $videoUrl) {
                            array_push($videoFileList, $videoUrl);
                        }
                        $otherUrls = $questionItem->otherUrl;
                        foreach ($otherUrls as $otherUrl) {
                            array_push($otherFileList, $otherUrl);
                        }
                    }
                    break;
                case 8:     //safestudy
                    $contentData = json_decode($post->safestudy->content);
                    foreach ($contentData as $questionItem) {
                        $imgUrls = $questionItem->imgUrl;
                        foreach ($imgUrls as $imgUrl) {
                            $path = $imgUrl->path;
                            array_push($imageFileList, $path);
                        }
                        $videoUrls = $questionItem->videoUrl;
                        foreach ($videoUrls as $videoUrl) {
                            array_push($videoFileList, $videoUrl);
                        }
                        $otherUrls = $questionItem->otherUrl;
                        foreach ($otherUrls as $otherUrl) {
                            array_push($otherFileList, $otherUrl);
                        }
                    }
                    break;
                case 7:     //repair data
                    $contentData = json_decode($post->repairdata->content);
                    $imgUrls = $contentData->imgUrl;
                    foreach ($imgUrls as $imgUrl) {
                        $path = $imgUrl->path;
                        array_push($imageFileList, $path);
                    }
                    $videoUrls = $contentData->videoUrl;
                    foreach ($videoUrls as $videoUrl) {
                        array_push($videoFileList, $videoUrl);
                    }
                    $otherUrls = $contentData->otherUrl;
                    foreach ($otherUrls as $otherUrl) {
                        array_push($otherFileList, $otherUrl);
                    }
                    break;
                case 11:    //schoolstory
                    $contentData = json_decode($post->schoolstory->content)[0];
                    $imgUrls = $contentData->imgUrl;
                    foreach ($imgUrls as $imgUrl) {
                        $path = $imgUrl->path;
                        array_push($imageFileList, $path);
                    }
                    $videoUrls = $contentData->videoUrl;
                    foreach ($videoUrls as $videoUrl) {
                        array_push($videoFileList, $videoUrl);
                    }
                    $otherUrls = $contentData->otherUrl;
                    foreach ($otherUrls as $otherUrl) {
                        array_push($otherFileList, $otherUrl);
                    }
                    break;
                case 24:    //regnames
                    $contentData = json_decode($post->regnames->content);
                    foreach ($contentData as $questionItem) {
                        $imgUrls = $questionItem->imgUrl;
                        foreach ($imgUrls as $imgUrl) {
                            $path = $imgUrl->path;
                            array_push($imageFileList, $path);
                        }
                        $videoUrls = $questionItem->videoUrl;
                        foreach ($videoUrls as $videoUrl) {
                            array_push($videoFileList, $videoUrl);
                        }
                        $otherUrls = $questionItem->otherUrl;
                        foreach ($otherUrls as $otherUrl) {
                            array_push($otherFileList, $otherUrl);
                        }
                    }
                    break;
                case 16:    //homeVisit
                    $contentData = json_decode($post->homeVisit->content);
                    $imgUrls = $contentData->imgUrl;
                    foreach ($imgUrls as $imgUrl) {
                        $path = $imgUrl->path;
                        array_push($imageFileList, $path);
                    }
                    $videoUrls = $contentData->videoUrl;
                    foreach ($videoUrls as $videoUrl) {
                        array_push($videoFileList, $videoUrl);
                    }
                    $otherUrls = $contentData->otherUrl;
                    foreach ($otherUrls as $otherUrl) {
                        array_push($otherFileList, $otherUrl);
                    }
                    break;
                case 17:    //notifications
                    $contentData = json_decode($post->notifications->description);
                    $imgUrls = $contentData->imgUrl;
                    foreach ($imgUrls as $imgUrl) {
                        $path = $imgUrl->path;
                        array_push($imageFileList, $path);
                    }
                    $videoUrls = $contentData->videoUrl;
                    foreach ($videoUrls as $videoUrl) {
                        array_push($videoFileList, $videoUrl);
                    }
                    $otherUrls = $contentData->otherUrl;
                    foreach ($otherUrls as $otherUrl) {
                        array_push($otherFileList, $otherUrl);
                    }
                    break;
                case 25:    //classstory
                    $contentData = json_decode($post->classstory->content)[0];
                    $imgUrls = $contentData->imgUrl;
                    foreach ($imgUrls as $imgUrl) {
                        $path = $imgUrl->path;
                        array_push($imageFileList, $path);
                    }
                    $videoUrls = $contentData->videoUrl;
                    foreach ($videoUrls as $videoUrl) {
                        array_push($videoFileList, $videoUrl);
                    }
                    $otherUrls = $contentData->otherUrl;
                    foreach ($otherUrls as $otherUrl) {
                        array_push($otherFileList, $otherUrl);
                    }
                    break;
                case 26:    //interclassstory
                    $contentData = json_decode($post->interclassstory->content)[0];
                    $imgUrls = $contentData->imgUrl;
                    foreach ($imgUrls as $imgUrl) {
                        $path = $imgUrl->path;
                        array_push($imageFileList, $path);
                    }
                    $videoUrls = $contentData->videoUrl;
                    foreach ($videoUrls as $videoUrl) {
                        array_push($videoFileList, $videoUrl);
                    }
                    $otherUrls = $contentData->otherUrl;
                    foreach ($otherUrls as $otherUrl) {
                        array_push($otherFileList, $otherUrl);
                    }
                    break;

                default:
                    break;
            }
        }

        return response()->json([
            'imageFileList' => $imageFileList,
            'videoFileList' => $videoFileList,
            'otherFileList' => $otherFileList,
        ]);
    }

    public function excelImport()
    {
        $user = Auth::user();
        if ($user->roleId == 2) {
            $userList = User::where('schoolId', $user->schoolId)->where('roleId', 5)->with('role')->get();
        } else if ($user->roleId == 7 || $user->roleId == 4 || $user->roleId == 5) {
            $userList = User::where('schoolId', $user->schoolId)->where('lessonId', $user->lessonId)->with('role')->where('roleId', 5)->get();
        } else {
            $userList = [];
        }
        return response()->json([
            'userList' => $userList,
        ]);
    }
}
