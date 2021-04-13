<?php

namespace App\Http\Controllers;

use App\ReturnTeam;
use App\User;
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
            'member' => 'required',
            'name' => 'required',
        ]);

        $userId = Auth::user()->id;
        $lessonId = Auth::user()->lessonId;
        $schoolId = Auth::user()->schoolId;
        $returnTeamArr = ReturnTeam::where([
            ['userId', '=', $userId],
            ['lessonId', '=', $lessonId],
            ['name', '!=', '留堂成员'],
            ['leaderId', '!=', null],
        ])->whereDate('updated_at', Carbon::today())->first();
        
        if ($returnTeamArr == null) {
            $classMemeberArr = User::where([
                'roleId' => 5,
                'schoolId' => $schoolId,
                'lessonId' => $lessonId,
            ])->get();            
            $classMemberIdArr = array();
            foreach( $classMemeberArr as $key => $classMember ){
                if( in_array( $classMember->id,  $request->member) ){
                    
                }
                else{
                    array_push($classMemberIdArr, $classMember->id);
                }
            }

            $remainTeamData = ReturnTeam::create([
                'userId' => $userId,
                'lessonId' => $lessonId,
                'schoolId' => $schoolId,
                'name' => '留堂成员',
                'member' => $classMemberIdArr
            ]);
        }
        else{

            $remainTeamData = ReturnTeam::where([
                'lessonId' => $lessonId,
                'schoolId' => $schoolId,
                'name' => '留堂成员',
            ])->whereDate('updated_at', Carbon::today())->first();
            
            $test = $remainTeamData->member;
            $memArr = $request->member;
            foreach($request->member as $memberId){
                if (($key = array_search($memberId, $test)) !== false) {
                    unset($test[$key]);
                }
            }
            $remainTeamData->member = array_values($test);
            $remainTeamData->update();
        }
        
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
            'returnTeamData' => $returnTeamData,
        ]);

    }
    
    public function getReturnTeam()
    {
        $returnTeamArr = ReturnTeam::where([
            'userId' => Auth::user()->id,
            'lessonId' => Auth::user()->lessonId,
        ])->orderBy('created_at', 'desc')->get();

        foreach ($returnTeamArr as $key => $returnTeam){
            $userArr = User::whereIn('id',$returnTeam->member)->select('id', 'name', 'avatar', 'phoneNumber')->get();
            $returnTeam->member = $userArr;
        }

        return response()->json([
            'returnTeamArr'=> $returnTeamArr->load('teacherId', 'leaderId')
        ],200);

    }

    public function deleteReturnTeam(Request $request)
    {
        // $id = $request->id;
        // $idArr = $request->idArr;
        if($request->id){
            return ReturnTeam::where('id', $request->id)->delete();
        }   
        elseif($request->idArr){
            return ReturnTeam::whereIn('id',$request->idArr)->delete();
        }

    }
}
