<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sms;
use App\Post;

use Illuminate\Support\Facades\Auth;
class SmsController extends Controller
{
    //
    public function getSms(){

    }

    public function createSms(Request $request){
        $this->validate($request,[
            'content'=>'required'

        ]);
        $smsData = json_encode($request->content);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId'=>3,
            'userId'=>$userId,
            'schoolId'=>$request->schoolId
        ])->id;
        return Sms::create([
            'content'=>$smsData,
            'postId'=>$postId,
        ]);

    }

    public function updateSms(){

    }

    public function deleteSms(){

    }
}
