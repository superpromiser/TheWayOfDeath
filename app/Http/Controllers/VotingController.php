<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Voting;
use App\VotingTemp;
use Illuminate\Support\Facades\Auth;

class VotingController extends Controller
{
    //
    public function getVotingData()
    {
    }

    public function createVotingData(Request $request)
    {
        $this->validate($request, [
            'votingType' => 'required',
            'viewList' => 'required',
            'deadline' => 'required',
            'maxVote' => 'required',
            'anonyVote' => 'required',
            'content' => 'required',
        ]);
        $votingType = $request->votingType;
        $viewList = json_encode($request->viewList);
        $deadline = $request->deadline;
        $maxVote = $request->maxVote;
        $anonyVote = $request->anonyVote;
        $content = json_encode($request->content);
        $userId = Auth::user()->id;
        $classId = $request->classId;
        if ($classId) {
            $contentId = 13;
        } else {
            $contentId = 2;
        }
        $postId = Post::create([
            'contentId' => $contentId,
            'userId' => $userId,
            'schoolId' => $request->schoolId,
            'classId' => $classId,
        ])->id;
        $data = Voting::create([
            'votingType' => $votingType,
            'viewList' => $viewList,
            'deadline' => $deadline,
            'maxVote' => $maxVote,
            'anonyVote' => $anonyVote,
            'content' => $content,
            'classId' => $classId,
            'postId' => $postId
        ]);
        return response()->json([
            'data' => $data,
            'state' => 201
        ]);
    }

    public function updateVotingData()
    {
    }

    public function deleteVotingData()
    {
    }

    public function createTemplate(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
            'title' => 'required',
            'tempTitle' => 'required',
            'description' => 'required',
            'imgUrl' => 'required',
            'content' => 'required'
        ]);
        $userId = Auth::user()->id;
        VotingTemp::create([
            'title' => $request->title,
            'tempTitle' => $request->tempTitle,
            'description' => $request->description,
            'imgUrl' => $request->imgUrl,
            'content' => json_encode($request->content),
            'userId' => $userId,
            'schoolId' => $request->schoolId,
            'lessonId' => $request->lessonId
        ]);
    }
    public function getTemplateList(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        return VotingTemp::where('schoolId', $request->schoolId)->get();
    }
}
