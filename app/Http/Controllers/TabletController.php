<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\ScheduleClass;
use App\ScheduleTeacher;
use App\Lesson;
use App\Session;
use App\Subject;
use App\Post;
use App\Anouncement;
use App\Attendance;
use App\ClassStory;
use App\ScheduleSetting;
use App\SchoolStory;

class TabletController extends Controller
{
    //
    public function getDashboardData(Request $request)
    {
        $weekMap = [
            0 => 'sun',
            1 => 'mon',
            2 => 'tue',
            3 => 'wed',
            4 => 'thu',
            5 => 'fri',
            6 => 'sat',
        ];
        $dayOfTheWeek = Carbon::now()->dayOfWeek;
        $weekday = $weekMap[$dayOfTheWeek];
        $schoolId = Auth::user()->schoolId;
        $lessonId = Auth::user()->lessonId;
        $encodeData = ScheduleClass::where(['schoolId' => $schoolId, 'lessonId' => $lessonId])->first();
        $scheduleData = array();
        if (!is_null($encodeData)) {
            $scheduleData = json_decode($encodeData->scheduleData);
        }
        $lastSession = Session::latest('id')->first();
        $subjectData = Subject::select('subjectOrderName', 'subjectOrderType', 'startTime', 'endTime')->where('sessionId', $lastSession->id)->get();
        $subjectArr = array();
        foreach ($subjectData as $key => $subjectObj) {
            $subject['subjectOrderName'] = $subjectObj->subjectOrderName;
            $subject['subjectOrderType'] = $subjectObj->subjectOrderType;
            $subject['startTime'] = $subjectObj->startTime;
            $subject['endTime'] = $subjectObj->endTime;
            array_push($subjectArr, $subject);
        }
        $todaySchedule = array();
        foreach ($scheduleData as $key => $oneDaySchedule) {
            $schedule['name'] = $oneDaySchedule->$weekday;
            array_push($todaySchedule, $schedule);
        }
        for ($i = 0; $i < count($subjectArr); $i++) {
            $subjectArr[$i]['name'] = $todaySchedule[$i]['name'];
        }
        $posts = Post::whereIn('contentId', [12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22])
            ->where('classId', $lessonId)
            ->with([
                'questionnaires:postId,content',
                'votings:postId,content',
                'homework:postId,content',
                'homeVisit:postId,content',
                'notifications:postId,description',
                'evaluations:postId,selMedalList',
                'recognitions:postId,imgUrl',
                'homeworkResult:postId,content',
                'users:id,name'
            ])
            ->orderBy('created_at', 'desc')
            ->get();
        $albumData = array();
        $schoolStoryData = array();
        $schoolStory = SchoolStory::select('content')->where('schoolId', $schoolId)->get();
        foreach ($schoolStory as $content) {
            $contentData = json_decode($content->content)[0];
            $imgUrls = $contentData->imgUrl;
            foreach ($imgUrls as $imgUrl) {
                array_push($schoolStoryData, $imgUrl->path);
            }
        }

        $classStoryData = array();
        $classStory = ClassStory::select('content')->where('lessonId', $lessonId)->get();
        foreach ($classStory as $content) {
            $contentData = json_decode($content->content)[0];
            $imgUrls = $contentData->imgUrl;
            foreach ($imgUrls as $imgUrl) {
                array_push($classStoryData, $imgUrl->path);
            }
        }

        $announcementData = array();
        $allAnounceData = Anouncement::where('schoolId', $schoolId)->with('users:id,name,avatar')->get();
        foreach ($allAnounceData as $data) {
            $lessonArr = $data->viewList;
            foreach ($lessonArr as $lesson) {
                if ($lesson == $lessonId) {
                    array_push($announcementData, $data);
                }
            }
        }
        $today = Carbon::today();
        $standStartTime = "08:00:00";
        $standEndTime = "17:00:00";
        $attendanceData = Attendance::select('startTime', 'endTime', 'userId')->where(['lessonId' => $lessonId, 'date' => $today])->with('user:id,name')->get();
        $attendData['absent'] = 0;
        $attendData['late'] = 0;
        $attendData['normal'] = 0;
        $attendData['leave'] = 0;
        foreach ($attendanceData as $userData) {
            $startTime = $userData->startTime;
            $endTime = $userData->endTime;
            if (is_null($startTime) && is_null($endTime)) {
                $attendData['absent']++;
            }
            if ($startTime >  strtotime($standStartTime)) {
                $attendData['late']++;
            } else {
                if ($endTime > strtotime($standEndTime)) {
                    $attendData['normal']++;
                } else {
                    $attendData['leave']++;
                }
            }
        }

        $resultData['timeTableData'] = $subjectArr;
        $resultData['albumData'] = $albumData;
        $resultData['announceData'] = $announcementData;
        $resultData['attendanceData'] = $attendData;
        $resultData['schoolStoryData'] = $schoolStoryData;
        $resultData['classStoryData'] = $classStoryData;
        return response()->json($resultData);
    }

    public function getLessonTimeTable(Request $request)
    {
        $lessonId = Auth::user()->lessonId;
        $schedule = ScheduleClass::where('lessonId', $lessonId)->first()->scheduleData;
        return $schedule;
    }
}
