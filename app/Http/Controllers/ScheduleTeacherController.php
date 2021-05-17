<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ScheduleTeacher;
use Illuminate\Support\Facades\Auth;
use App\ScheduleSetting;

class ScheduleTeacherController extends Controller
{
    public function getScheduleTeacher(Request $request)
    {
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        return ScheduleTeacher::where(['userId' => $userId, 'schoolId' => $schoolId])->get();
    }

    public function createScheduleTeacher(Request $request)
    {
        $this->validate($request, [
            'scheduleSettingId' => 'required',
            'subjectName' => 'required',
            'teacherId' => 'required',
            'teacherName' => 'required',
            'lessons' => 'required'
        ]);
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        return ScheduleTeacher::create([
            'userId' => $userId,
            'schoolId' => $schoolId,
            'scheduleSettingId' => $request->scheduleSettingId,
            'subjectName' => $request->subjectName,
            'teacherId' => $request->teacherId,
            'teacherName' => $request->teacherName,
            'lessons' => $request->lessons,
        ]);
    }

    public function updateScheduleTeacher(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'scheduleSettingId' => 'required',
            'subjectName' => 'required',
            'teacherId' => 'required',
            'teacherName' => 'required',
            'lessons' => 'required'
        ]);
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        return ScheduleTeacher::where(['userId' => $userId, 'schoolId' => $schoolId, 'id' => $request->id])->update([
            'scheduleSettingId' => $request->scheduleSettingId,
            'subjectName' => $request->subjectName,
            'teacherId' => $request->teacherId,
            'teacherName' => $request->teacherName,
            'lessons' => $request->lessons,
        ]);
    }

    public function deleteScheduleTeacher(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $userId = Auth::user()->id;
        $schoolId = Auth::user()->schoolId;
        return ScheduleTeacher::where([
            'id' => $request->id,
            'userId' => $userId,
            'schoolId' => $schoolId
        ])->delete();
    }

    public function getScheduleData()
    {
        $schoolId = Auth::user()->schoolId;
        return ScheduleSetting::where('schoolId', $schoolId)->get();
    }
}
