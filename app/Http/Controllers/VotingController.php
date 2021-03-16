<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Voting;

use Illuminate\Support\Facades\Auth;

class VotingController extends Controller
{
    //
    public function getVotingData(){

    }

    public function createVotingData(Request $request){
        $this->validate($request,[
            'votingType'=>'required',
            'viewList'=>'required',
            'deadline'=>'required',
            'maxVote'=>'required',
            'anonyVote'=>'required',
            'content'=>'required',
        ]);
        $votingType = $request->votingType;
        $viewList = json_encode($request->viewList);
        $deadline = $request->deadline;
        $maxVote = $request->maxVote;
        $anonyVote = $request->anonyVote;
        $content = json_encode($request->content);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId'=>2,
            'userId'=>$userId
        ])->id;
        $data = Voting::create([
            'votingType'=>$votingType,
            'viewList'=>$viewList,
            'deadline'=>$deadline,
            'maxVote'=>$maxVote,
            'anonyVote'=>$anonyVote,
            'content'=>$content,
            'postId'=>$postId
        ]);
        return response()->json([
            'data'=>$data,
            'state'=>201
        ]);

    }

    public function updateVotingData(){

    }

    public function deleteVotingData(){

    }
}
