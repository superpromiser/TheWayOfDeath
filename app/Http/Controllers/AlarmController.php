<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Alarm;

class AlarmController extends Controller
{
    public function getAlarm(Request $request)
    {   
        return Alarm::where('userId', Auth::user()->id)->get();
    }

    public function deleteAlarm(Request $request)
    {
        return Alarm::where('id', $request->alarmId)->delete();
    }
}
