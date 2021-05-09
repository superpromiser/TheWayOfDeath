<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sms;
use App\Post;

use Illuminate\Support\Facades\Auth;

class SmsController extends Controller
{
    //
    public function getSms(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 3])
            ->with([
                'likes',
                'views',
                'comments.users:id,name',
                'sms',
                'users:id,name,avatar'
            ])
            ->orderBy('fixTop', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function createSms(Request $request)
    {
        $this->validate($request, [
            'content' => 'required'

        ]);
        $smsData = json_encode($request->content);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId' => 3,
            'userId' => $userId,
            'schoolId' => $request->schoolId
        ])->id;
        return Sms::create([
            'content' => $smsData,
            'schoolId' => $request->schoolId,
            'postId' => $postId,
        ]);
    }

    public function updateSms()
    {
    }

    public function deleteSms()
    {
    }
}
