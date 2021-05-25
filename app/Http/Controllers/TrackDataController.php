<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TrackData;
use App\Message;
use App\Contact;
use App\Events\NewPosition;
use App\Events\NewMessage;
use App\User;
use Illuminate\Support\Facades\Auth;

class TrackDataController extends Controller
{
    //
    public function getTrackData(Request $request)
    {
        $this->validate($request, [
            'imei' => 'required',
            'startTime' => 'required',
            'endTime' => 'required'
        ]);
        $from = $request->startTime;
        $to = $request->endTime;
        return  TrackData::select('lat', 'lng')->where(['imei' => $request->imei])->whereBetween('trackDate', [$from, $to])->get();
    }

    public function createTrackData(Request $request)
    {
        $this->validate($request, [
            'imei' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'trackDate' => 'required'
        ]);
        $id = TrackData::create([
            'imei' => $request->imei,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'trackDate' => $request->trackDate
        ])->id;

        $broadcastingData['imei'] = $request->imei;
        $broadcastingData['lat'] = $request->lat;
        $broadcastingData['lng'] = $request->lng;
        // $broadcastingData['trackDate'] = $request->trackDate;

        // $userId = Auth::user()->id;
        $user = User::where('imei', $request->imei)->first();
        $schoolId = $user->schoolId;
        $lessonId = $user->groupArr;
        $userId = $user->id;
        $manager = User::where(['schoolId' => $schoolId, 'roleId' => 2])->first();
        if (isset($manager)) {
            $managerId = $manager->id;
            broadcast(new NewPosition($broadcastingData, $managerId));
        }
        $teacher = User::whereIn('lessonId', $lessonId)->where('roleId', 7)->first();
        if (isset($teacher)) {
            $teacherId = $teacher->id;
            broadcast(new NewPosition($broadcastingData, $teacherId));
        }
        $parent = User::where('children', 'like', "%{$userId}%")->first();
        if (isset($parent)) {
            $parentId = $parent->id;
            broadcast(new NewPosition($broadcastingData, $parentId));
        }
        return $id;
    }

    public function updateTrackData(Request $request)
    {
    }

    public function deleteTrackData(Request $request)
    {
    }

    public function createFenceAlarm(Request $request)
    {
        $this->validate($request, [
            'userName' => 'required',
            'ownerId' => 'required'
        ]);

        // $data = request(['from', 'to', 'text']);
        $data['from'] = 1;
        $data['to'] = $request->ownerId;
        $data['text'] = $request->userName . 'outed';

        $message = Message::create($data);

        Contact::where(function ($query) use ($request) {
            $query->where('userId', 1);
            $query->where('contactUserId', $request->ownerId);
        })->orWhere(function ($query) use ($request) {
            $query->where('userId', $request->ownerId);
            $query->where('contactUserId', 1);
        })->update([
            'last_message' => $data['text'],
            'last_time' => \Carbon\Carbon::now()->setTimezone('Asia/Shanghai'),
            'last_sender' => 1
        ]);

        //broadcast Event
        broadcast(new NewMessage($message->load('from'), $request->ownerId));
        return $request->userName;
    }
}
