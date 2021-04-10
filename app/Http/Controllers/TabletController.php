<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\scheduleClass;
use App\ScheduleTeacher;
use App\Lesson;
use App\Session;
use App\Subject;
use App\Post;

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
        $scheduleData = json_decode(scheduleClass::where(['schoolId' => $schoolId, 'lessonId' => $lessonId])->first()->scheduleData);
        // $lessonName = Lesson::where('id', $lessonId)->first()->lessonName;
        // $mySchoolScheduleTeacherData = ScheduleTeacher::where(['schoolId' => $schoolId])->get();

        // $scheduleTeacherDataArr = array();
        // foreach ($mySchoolScheduleTeacherData as $key => $scheduleTeacherData) {
        //     $lessonArr = $scheduleTeacherData->lessons;
        //     foreach ($lessonArr as $key => $lesson) {
        //         if ($lesson == $lessonName) {
        //             array_push($scheduleTeacherDataArr, $scheduleTeacherData);
        //         }
        //     }
        // }
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
            $schedule['id'] = $oneDaySchedule->$weekday;
            if ($schedule['id'] == -1) {
                $schedule['name'] = '自习';
            } else {
                $schedule['name'] = ScheduleTeacher::where('id', $schedule['id'])->first()->subjectName;
            }
            array_push($todaySchedule, $schedule);
        }
        for ($i = 0; $i < count($subjectArr); $i++) {
            $subjectArr[$i]['id'] = $todaySchedule[$i]['id'];
            $subjectArr[$i]['name'] = $todaySchedule[$i]['name'];
        }
        // $result = array_merge($subjectArr, $todaySchedule);
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
        $tempData = array();
        foreach ($posts as $post) {
            switch ($post->contentId) {
                case 12:
                    $content = json_decode($post->questionnaires->content);

                    array_push($tempData, json_decode($post->questionnaires->content));

                    break;
                case 13:
                    array_push($tempData, $post->votings->content);
                    break;
                case 14:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 15:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 16:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 17:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 18:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 19:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 20:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 21:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 22:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 23:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                default:
                    break;
            }
        }
        return response()->json($subjectArr);
    }
}
