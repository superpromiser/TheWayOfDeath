<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ScheduleSetting;
use App\ScheduleClass;

use Illuminate\Support\Facades\Auth;

class ScheduleClassController extends Controller
{
    //
    public function getSCheduleClass(){
        $lessonId = Auth::user()->lessonId;
        return $subjectItems = ScheduleSetting::where(['lessonId'=>$lessonId])->with('subjects')->get();
        
        // foreach($subjectItems as $subjectItem){
        //     $subjectOrder = $subjectItem->subjects->subjectType;
        //     switch($subjectOrder){
        //         case "第一节":
        //            array_push($result->item1,$subjectItem->subjects); 
        //            break;
        //         case "第二节":
        //            array_push($result->item2,$subjectItem->subjects); 
        //            break;
        //         case "第三节":
        //            array_push($result->item3,$subjectItem->subjects); 
        //            break;
        //         case "第四节":
        //            array_push($result->item4,$subjectItem->subjects); 
        //            break;
        //         case "第五节":
        //            array_push($result->item5,$subjectItem->subjects); 
        //            break;
        //         case "第六节":
        //            array_push($result->item6,$subjectItem->subjects); 
        //            break;
        //         case "第七节":
        //            array_push($result->item7,$subjectItem->subjects); 
        //            break;
        //         default:
        //             break;
        //     }
        // }
        // return response()->json([
        //     'data'=>$result,
        //     'status'=>'200'
        // ]);
    }

    public function createScheduleClass(Request $request){
        
    }

    public function updateScheduleClass(Request $request){

    }

    public function deleteScheduleClass(Request $request){

    }
}
