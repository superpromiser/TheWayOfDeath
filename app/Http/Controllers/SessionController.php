<?php

namespace App\Http\Controllers;
use App\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function getSession()
    {
        $schoolId = Auth::user()->schoolId;
        return Session::where(['schoolId'=>$schoolId])->get();
    }
    public function storeSession(Request $request)
    {   
        $this->validate($request,[
            'sessionName'=>'required',
            'sessionDate'=>'required'
        ]);
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        $sessionDate = $request->sessionDate;
        $session = Session::create([
            'userId' => $userId,
            'schoolId' => $schoolId,
            'sessionName' => $request->sessionName,
            'sessionDate'=>$sessionDate,
        ]);
        return response()->json([
            'msg'=> 1,
            'id'=> $session->id
        ]);
    }
    public function updateSession(Request $request)
    {
        $this->validate($request,[
            'id' => 'required',
            'sessionName' => 'required',
        ]);
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        Session::where(['userId'=>$userId, 'schoolId'=>$schoolId, 'id'=>$request->id])->update([
            'sessionName' => $request->sessionName,
        ]);
        return response()->json([
            'msg'=> 1,
        ]);
    }
    public function removeSession(Request $request)
    {
        $this->validate($request,[
            'id'=>'required'
        ]);
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        Session::where([
            'id'=>$request->id,
            'userId'=>$userId,
            'schoolId'=>$schoolId
        ])->delete();
        return response()->json([
            'msg'=> 1,
        ]);
    }
}
