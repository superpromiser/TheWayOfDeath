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
use App\Anouncement;
use App\Attendance;
use App\ClassStory;
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
            $schedule['name'] = $oneDaySchedule->$weekday;
            // if ($schedule['id'] == -1) {
            //     $schedule['name'] = '自习';
            // } else {
            //     $schedule['name'] = ScheduleTeacher::where('id', $schedule['id'])->first()->subjectName;
            // }
            array_push($todaySchedule, $schedule);
        }
        for ($i = 0; $i < count($subjectArr); $i++) {
            // $subjectArr[$i]['id'] = $todaySchedule[$i]['id'];
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
        $albumData = array();
        // foreach ($posts as $post) {
        //     switch ($post->contentId) {
        //         case 12:
        //             $contentData = json_decode($post->questionnaires->content);
        //             foreach ($contentData as $content) {
        //                 if ($content->type == 'single') {
        //                     $postingData = $content->singleContentDataArr;
        //                     foreach ($postingData as $questionItem) {
        //                         $imgUrls = $questionItem->imgUrl;
        //                         foreach ($imgUrls as $imgUrl) {
        //                             $path = $imgUrl->path;
        //                             array_push($albumData, $path);
        //                         }
        //                     }
        //                 } else if ($content->type == 'multi') {
        //                     $postingData = $content->multiContentDataArr;
        //                     foreach ($postingData as $questionItem) {
        //                         $imgUrls = $questionItem->imgUrl;
        //                         foreach ($imgUrls as $imgUrl) {
        //                             $path = $imgUrl->path;
        //                             array_push($albumData, $path);
        //                         }
        //                     }
        //                 } else if ($content->type == 'qa') {
        //                     $postingData = $content->qaContentDataArr;
        //                     foreach ($postingData as $questionItem) {
        //                         $imgUrls = $questionItem->imgUrl;
        //                         foreach ($imgUrls as $imgUrl) {
        //                             $path = $imgUrl->path;
        //                             array_push($albumData, $path);
        //                         }
        //                     }
        //                 } else if ($content->type == 'score') {
        //                     $postingData = $content->scoringDataArr;
        //                     foreach ($postingData as $contentData) {
        //                         $post = $contentData->contentData;
        //                         foreach ($post as $questionItem) {
        //                             $imgUrls = $questionItem->imgUrl;
        //                             foreach ($imgUrls as $imgUrl) {
        //                                 $path = $imgUrl->path;
        //                                 array_push($albumData, $path);
        //                             }
        //                         }
        //                     }
        //                 }
        //             }
        //             break;
        //         case 13:
        //             $contentData = json_decode($post->votings->content);
        //             foreach ($contentData as $questionItem) {
        //                 $imgUrls = $questionItem->imgUrl;
        //                 foreach ($imgUrls as $imgUrl) {
        //                     $path = $imgUrl->path;
        //                     array_push($albumData, $path);
        //                 }
        //             }
        //             break;
        //         case 14:
        //             // array_push($tempData, $post->questionniare->content);
        //             $contentData = json_decode($post->homework->content);
        //             $imgUrls = $contentData->imgUrl;
        //             foreach ($imgUrls as $imgUrl) {
        //                 $path = $imgUrl->path;
        //                 array_push($albumData, $path);
        //             }
        //             break;
        //         case 15:
        //             // array_push($tempData, $post->questionniare->content);
        //             break;
        //         case 16:
        //             // array_push($tempData, $post->questionniare->content);
        //             $contentData = json_decode($post->homeVisit->content);
        //             $imgUrls = $contentData->imgUrl;
        //             foreach ($imgUrls as $imgUrl) {
        //                 $path = $imgUrl->path;
        //                 array_push($albumData, $path);
        //             }
        //             break;
        //         case 17:
        //             // array_push($tempData, $post->questionniare->content);
        //             $contentData = json_decode($post->notifications->description);
        //             $imgUrls = $contentData->imgUrl;
        //             foreach ($imgUrls as $imgUrl) {
        //                 $path = $imgUrl->path;
        //                 array_push($albumData, $path);
        //             }
        //             break;
        //         case 18:
        //             // array_push($tempData, $post->questionniare->content);
        //             $contentData = json_decode($post->evaluations->selMedalList);
        //             break;
        //         case 19:
        //             // array_push($tempData, $post->questionniare->content);
        //             $contentData = $post->recognitions->imgUrl;
        //             break;
        //         case 20:
        //             // array_push($tempData, $post->questionniare->content);
        //             break;
        //         case 21:
        //             // array_push($tempData, $post->questionniare->content);
        //             break;
        //         case 22:
        //             // array_push($tempData, $post->questionniare->content);
        //             break;
        //         case 23:
        //             // array_push($tempData, $post->questionniare->content);
        //             break;
        //         default:
        //             break;
        //     }
        // }

        $schoolStoryData = array();
        $schoolStory = SchoolStory::select('content')->where('schoolId', $schoolId)->get();
        foreach ($schoolStory as $content) {
            $contentData = json_decode($content->content);
            $imgUrls = $contentData->imgUrl;
            foreach ($imgUrls as $imgUrl) {
                array_push($schoolStoryData, $imgUrl->path);
            }
        }

        $classStoryData = array();
        $classStory = ClassStory::select('content')->where('lessonId', $lessonId)->get();
        foreach ($classStory as $content) {
            $contentData = json_decode($content->content);
            $imgUrls = $contentData->imgUrl;
            foreach ($imgUrls as $imgUrl) {
                array_push($classStoryData, $imgUrl->path);
            }
        }

        $announcementData = array();
        $allAnounceData = Anouncement::where('schoolId', $schoolId)->get();
        foreach ($allAnounceData as $data) {
            $lessonArr = json_decode($data->viewList);
            foreach ($lessonArr as $lesson) {
                if ($lesson == $lessonId) {
                    array_push($announcementData, $data);
                }
            }
        }
        $today = Carbon::today();
        $attendanceData = Attendance::select('startTime', 'endTime', 'userId')->where(['lessonId' => $lessonId, 'date' => $today])->with('user:id,name')->get();

        $resultData['timeTableData'] = $subjectArr;
        $resultData['albumData'] = $albumData;
        $resultData['announceData'] = $announcementData;
        $resultData['attendanceData'] = $attendanceData;
        $resultData['schoolStoryData'] = $schoolStoryData;
        $resultData['classStoryData'] = $classStoryData;
        return response()->json($resultData);
    }

    public function getLessonTimeTable(Request $request)
    {
        $lessonId = Auth::user()->lessonId;
        $lessonName = Lesson::where('id', $lessonId)->first->lessonName;
        $scheduleData = scheduleClass::where('lessonId', $lessonId)->first()->scheduleData;
        $schoolId = Auth::user()->schoolId;
        $scheduleTeachers = ScheduleTeacher::where('schoolId', $schoolId)->get();
        foreach ($scheduleData as $scheduleOrder) {
            $scheduleOrder = json_decode($scheduleOrder);
            $monId = $scheduleOrder['mon'];
            $tueId = $scheduleOrder['tue'];
            $wedId = $scheduleOrder['wed'];
            $thuId = $scheduleOrder['thu'];
            $friId = $scheduleOrder['fri'];
            $satId = $scheduleOrder['sat'];
            $sunId = $scheduleOrder['sun'];
        }
        // $scheduleLessons = array();
        // foreach ($scheduleTeachers as $schedule) {
        //     $lessons = $schedule->lessons;
        //     foreach ($lessons as $lesson) {
        //         if ($lesson == $lessonName) {
        //             array_push($schedulelessons, $schedule);
        //         }
        //     }
        // }
    }
}
