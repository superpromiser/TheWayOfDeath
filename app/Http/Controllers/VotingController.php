<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Voting;
use App\VotingTemp;
use App\Template;
use Illuminate\Support\Facades\Auth;

class VotingController extends Controller
{
    //
    public function getVotingData(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        if ($request->lessonId) {
            return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId])->whereIn('contentId', [2, 13])
                ->orWhere(function ($query) use ($request) {
                    $query->where('viewList', 'like', "%{$request->lessonId}%")
                        ->whereIn('contentId', [2, 13]);
                })
                ->with([
                    'likes',
                    'views',
                    'comments.users:id,name',
                    'votings',
                    'users:id,name,avatar'
                ])
                ->orderBy('fixTop', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        } else {
            return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 2])
                ->with([
                    'likes',
                    'views',
                    'comments',
                    'votings',
                    'users:id,name,avatar'
                ])
                ->orderBy('updated_at', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        }
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
            'viewList' => $request->viewList,
        ])->id;
        $data = Voting::create([
            'votingType' => $votingType,
            'viewList' => $viewList,
            'deadline' => $deadline,
            'maxVote' => $maxVote,
            'anonyVote' => $anonyVote,
            'content' => $content,
            'schoolId' => $request->schoolId,
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
        $userId = Auth::user()->id;
        if ($request->lessonId) {
            $contentId = 13;
        } else {
            $contentId = 2;
        }
        Template::create([
            'contentId' => $contentId,
            'userId' => $userId,
            'tempTitle' => $request->tempTitle,
            'description' => $request->description,
            'content' => $request->content,
            'schoolId' => $request->schoolId,
            'tempType' => $request->tempType,
            'lessonId' => $request->lessonId
        ]);
        return true;
    }
    public function getTemplate(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        $userId = Auth::user()->id;
        if ($request->lessonId) {
            $contentId = 13;
        } else {
            $contentId = 2;
        }
        return Template::where(['contentId' => $contentId, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId])->get();
    }

    public function deleteTemplate(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        return Template::where('id', $request->id)->delete();
    }

    public function getTemplateCnt(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required',
        ]);
        if ($request->lessonId) {
            $contentId = 13;
        } else {
            $contentId = 2;
        }
        $userId = Auth::user()->id;
        $result['draftCnt'] = Template::where(['contentId' => $contentId, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'tempType' => 2])->count();
        $result['templateCnt'] = Template::where(['contentId' => $contentId, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId' => $request->lessonId, 'tempType' => 1])->count();
        return $result;
    }
}
