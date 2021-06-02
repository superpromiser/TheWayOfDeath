<?php

namespace App\Http\Controllers;

use App\ReturnTeam;
use App\User;
use App\Alarm;
use App\Post;
use App\Events\NewReturnTeam;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturnTeamController extends Controller
{
    public function createReturnTeam(Request $request)
    {
        $this->validate($request, [
            'avatar' => 'required',
            'leader' => 'required',
            'teacher' => 'required',
            'member' => 'required',
            'name' => 'required',
        ]);

        $userId = Auth::user()->id;
        $lessonId = Auth::user()->lessonId;
        $schoolId = Auth::user()->schoolId;

        // //create remain team when first create of return team
        // $remainTeamData = ReturnTeam::where([
        //     'lessonId' => $lessonId,
        //     'schoolId' => $schoolId,
        //     'name' => '留堂成员',
        // ])->whereDate('updated_at', Carbon::today())->first();

        // if ($remainTeamData == null) {
        //     $remainTeamData = ReturnTeam::create([
        //         'userId' => $userId,
        //         'lessonId' => $lessonId,
        //         'schoolId' => $schoolId,
        //         'name' => '留堂成员',
        //         'member' => []
        //     ]);
        // }

        $returnTeamData = ReturnTeam::create([
            'userId' => $userId,
            'lessonId' => $lessonId,
            'schoolId' => $schoolId,
            'teacherId' => $request->teacher,
            'leaderId' => $request->leader,
            'name' => $request->name,
            'avatar' => $request->avatar,
            'member' => $request->member
        ]);

        return response()->json([
            'msg' => 1,
        ]);
    }


    public function createRemainTeam(Request $request)
    {
        $this->validate($request, [
            'member' => 'required',
        ]);

        $userId = Auth::user()->id;
        $lessonId = Auth::user()->lessonId;
        $schoolId = Auth::user()->schoolId;

        $remainTeamData = ReturnTeam::where([
            'lessonId' => $lessonId,
            'schoolId' => $schoolId,
            'name' => '留堂成员',
        ])->whereDate('updated_at', Carbon::today())->first();

        if ($remainTeamData == null) {
            $viewList = array();
            array_push($viewList, $userId);
            $postId = Post::create([
                'contentId' => 27,
                'userId' => $userId,
                'schoolId' => $schoolId,
                'classId' => $lessonId,
                'viewList' => $viewList
            ])->id;

            $remainTeamData = ReturnTeam::create([
                'userId' => $userId,
                'lessonId' => $lessonId,
                'schoolId' => $schoolId,
                'teacherId' => null,
                'leaderId' => null,
                'name' => '留堂成员',
                'avatar' => '/',
                'postId' => $postId,
                'member' => $request->member
            ]);

            //prepare member...
            $userArr = User::whereIn('id', $remainTeamData->member)->select('id', 'name', 'avatar', 'phoneNumber')->get();
            $remainTeamData->member = $userArr;

            ///////////////////////////boradcasting New Return Team///////////////////////////
            //make broadcasting data
            $broadcastingData['id'] = $remainTeamData->id;
            $broadcastingData['avatar'] = $remainTeamData->avatar;
            $broadcastingData['name'] = $remainTeamData->name;
            $broadcastingData['member'] = $remainTeamData->member;
            $broadcastingData['leaderId'] = null;
            $broadcastingData['teacherId'] = null;

            $returnTeamMemberArr = $request->member;
            foreach ($returnTeamMemberArr as $key => $returnTeamMember) {
                $student = User::where('id', $returnTeamMember)->first();
                $parent = User::where(['phoneNumber' => $student->fatherPhone,])->first();
                if ($parent) {
                    //save new alarm to parent
                    $alarm = Alarm::create([
                        'userId' => $parent->id,
                        'type' => 'NewReturnTeam',
                        'returnTeamId' => $remainTeamData->id,
                        'content' => json_encode($broadcastingData),
                    ]);
                    //Emit Event and push notification to parent of memeber
                    broadcast(new NewReturnTeam($alarm, $parent->id));
                }
            }

            return response()->json([
                'msg' => 1,
            ]);
        } else {
            return response()->json([
                'msg' => 'alreadyExist',
                'teamData' => $remainTeamData
            ]);
        }
    }

    public function getReturnTeam()
    {
        if (Auth::user()->roleId == 4) {
            $children = User::where('id', Auth::user()->id)->first()->children;
            $lessonIds = User::select('lessonId')->whereIn('id', $children)->get();
            $returnTeamArr = ReturnTeam::whereIn('lessonId', $lessonIds)->orderBy('created_at', 'desc')->get();
        } else {
            $returnTeamArr = ReturnTeam::where([
                // 'userId' => Auth::user()->id,
                'lessonId' => Auth::user()->lessonId,
            ])->orderBy('created_at', 'desc')->get();
        }

        foreach ($returnTeamArr as $key => $returnTeam) {
            $userArr = User::whereIn('id', $returnTeam->member)->select('id', 'name', 'avatar', 'phoneNumber')->get();
            $returnTeam->member = $userArr;
        }

        return response()->json([
            'returnTeamArr' => $returnTeamArr->load('teacherId', 'leaderId')
        ], 200);
    }

    public function deleteReturnTeam(Request $request)
    {
        // $id = $request->id;
        // $idArr = $request->idArr;
        if ($request->id) {
            $postId = ReturnTeam::where('id', $request->id)->first()->postId;
            Post::where('id', $postId)->delete();
            return ReturnTeam::where('id', $request->id)->delete();
        } elseif ($request->idArr) {
            $idArr = $request->idArr;
            foreach ($idArr as $key => $value) {
                $postId = ReturnTeam::where('id', $value)->first()->postId;
                Post::where('id', $postId)->delete();
            }
            return ReturnTeam::whereIn('id', $request->idArr)->delete();
        }
    }

    public function updateReturnTeam(Request $request)
    {
        $user = Auth::user();
        if ($request->name == '留堂成员') {

            //if remain team data exist! then we don't need to update it.
            $remainTeamData = ReturnTeam::where([
                'lessonId' => $request->lessonId,
                'schoolId' => $request->schoolId,
                'name' => '留堂成员',
            ])->whereDate('updated_at', Carbon::today())->first();

            // if ($remainTeamData->member == []) {
            $viewList = array();
            array_push($viewList, $user->id);
            $postId = Post::create([
                'contentId' => 27,
                'userId' => $user->id,
                'schoolId' => $user->schoolId,
                'classId' => $user->lessonId,
                'viewList' => $viewList
            ])->id;

            ReturnTeam::where('id', $request->id)->update([
                'avatar' => $request->avatar,
                'name' => $request->name,
                'leaderId' => $request->leaderId,
                'teacherId' => $request->teacherId,
                'member' => $request->member,
                'postId' => $postId,
            ]);

            $remainTeamData = ReturnTeam::where('id', $request->id)->first();
            //prepare member...
            $userArr = User::whereIn('id', $remainTeamData->member)->select('id', 'name', 'avatar', 'phoneNumber')->get();
            $remainTeamData->member = $userArr;

            ///////////////////////////boradcasting New Return Team///////////////////////////
            //make broadcasting data
            $broadcastingData['id'] = $remainTeamData->id;
            $broadcastingData['avatar'] = $remainTeamData->avatar;
            $broadcastingData['name'] = $remainTeamData->name;
            $broadcastingData['member'] = $remainTeamData->member;
            $broadcastingData['leaderId'] = null;
            $broadcastingData['teacherId'] = null;

            $returnTeamMemberArr = $request->member;
            foreach ($returnTeamMemberArr as $key => $returnTeamMember) {
                $student = User::where('id', $returnTeamMember)->first();
                $parent = User::where(['phoneNumber' => $student->fatherPhone,])->first();
                if ($parent) {
                    //save new alarm to parent
                    $alarm = Alarm::create([
                        'userId' => $parent->id,
                        'type' => 'NewReturnTeam',
                        'returnTeamId' => $remainTeamData->id,
                        'content' => json_encode($broadcastingData),
                    ]);
                    //Emit Event and push notification to parent of memeber
                    broadcast(new NewReturnTeam($alarm, $parent->id));
                }
            }
            ///////////////////////////boradcasting New Return Team///////////////////////////
            // } else {
            //     return response()->json([
            //         'msg' => 'aleardyExist',
            //     ]);
            // }
        } else {
            ReturnTeam::where('id', $request->id)->update([
                'avatar' => $request->avatar,
                'name' => $request->name,
                'leaderId' => $request->leaderId,
                'teacherId' => $request->teacherId,
                'member' => $request->member,
            ]);
        }

        return response()->json([
            'msg' => 1,
        ]);
    }
}
