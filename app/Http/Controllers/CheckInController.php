<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CheckIn;
use Illuminate\Support\Facades\Auth;

class CheckInController extends Controller
{
    //
    public function getCheckInData(Request $request)
    {
        return CheckIn::where('checkInDate', $request->checkInDate)->get();
    }

    public function createCheckInData(Request $request)
    {
        $this->validate($request, [
            'checkInDate' => 'required',
            'checkAttendanceType' => 'required',
            'checkType' => 'required',
            'studentId' => 'required',
            'signal' => 'required',
            'startTime' => 'required',
            'reason' => 'required',
            'hospital' => 'required'
        ]);
        $userId = Auth::user()->id;
        return CheckIn::create([
            'checkInDate' => $request->checkInDate,
            'checkAttendanceType' => $request->checkAttendanceType,
            'checkType' => $request->checkType,
            'studentId' => $request->studentId,
            'signal' => $request->signal,
            'startTime' => $request->startTime,
            'reason' => $request->reason,
            'hospital' => $request->hospital,
            'userId' => $userId
        ]);
    }

    public function updateCheckInData(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'checkInDate' => 'required',
            'checkAttendanceType' => 'required',
            'checkType' => 'required',
            'studentId' => 'required',
            'signal' => 'required',
            'startTime' => 'required',
            'reason' => 'required',
            'hospital' => 'required'
        ]);
        return CheckIn::where('id', $request->id)->update([
            'checkInDate' => $request->checkInDate,
            'checkAttendanceType' => $request->checkAttendanceType,
            'checkType' => $request->checkType,
            'studentId' => $request->studentId,
            'signal' => $request->signal,
            'startTime' => $request->startTime,
            'reason' => $request->reason,
            'hospital' => $request->hospital,
        ]);
    }

    public function deleteCheckInData(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        return CheckIn::where('id', $request->id)->delete();
    }
}
