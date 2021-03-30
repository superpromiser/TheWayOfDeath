<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seat;
use Illuminate\Support\Facades\Auth;
class SeatController extends Controller
{
    //
    public function getSeatData(Request $request){
        $this->validate($request,[
            'schoolId'=>'required',
            'lessonId'=>'required',
            'lessonOrder'=>'required'
        ]);
        $userId = Auth::user()->id;

        return Seat::where(['schoolId'=>$request->schoolId,'lessonId'=>$request->lessonId,'lessonOrder'=>$request->lessonOrder])->first();
    }

    public function createSeatData(Request $request){
        $this->validate($request,[
            'schoolId'=>'required',
            'lessonId'=>'required',
            'lessonOrder'=>'required',
            'seatData'=>'required'
        ]);
        $userId = Auth::user()->id;
        Seat::where(['schoolId'=>$request->schoolId,'lessonId'=>$request->lessonId,'lessonOrder'=>$request->lessonOrder])->delete();
        return Seat::create([
            'schoolId'=>$request->schoolId,
            'lessonId'=>$request->lessonId,
            'lessonOrder'=>$request->lessonOrder,
            'seatData'=>json_encode($request->seatData),
            'userId'=>$userId
        ]);
    }

    public function updateSeatData(Request $request){
        $this->validate($request,[
            'schoolId'=>'required',
            'lessonId'=>'required',
            'lessonOrder'=>'requried',
            'seatData'=>'required'
        ]);
        return Seat::where(['schoolId'=>$request->schoolId,'lessonId'=>$request->lessonId,'lessonOrder'=>$request->lessonOrder])
                        ->update(['seatData'=>$request->seatData]);
    }

    public function deleteSeatData(Request $request){

    }
}
