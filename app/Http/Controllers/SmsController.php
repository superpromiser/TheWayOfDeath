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
            'smsData'=>'required'
        ]);
        $smsData = json_encode($request->smsData);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId'=>3,
            'userId'=>$userId
        ])->id;
        return Sms::create([
            'content'=>$smsData,
            'postId'=>$postId
        ]);

    }

    public function updateSms(){

    }

    public function deleteSms(){

    }
}
