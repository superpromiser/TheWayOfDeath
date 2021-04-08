<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Like;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //
    public function getSchoolPost(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        $userId = Auth::user()->id;
        // $isLiked = Like::where('userId',$userId)->count();
        return Post::whereIn('contentId', [1, 2, 3, 4, 5, 6, 10, 23, 24])
            ->where('schoolId', $request->schoolId)
            ->with([
                'likes',
                'views',
                'comments',
                'questionnaires',
                'votings',
                'sms',
                'campus',
                'anouncements',
                'bulletinBoards',
                'homeVisit',
                'shares',
                'regnames',
                'users:id,name'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function getClassPost(Request $request)
    {
        $this->validate($request, [
            'classId' => 'required'
        ]);
        // $userId = Auth::user()->id;
        $classId = $request->classId;
        return Post::whereIn('contentId', [12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22])
            ->where('classId', $classId)
            ->with([
                'likes',
                'views',
                'comments',
                'questionnaires',
                'votings',
                'homeVisit',
                'notifications',
                'evaluations',
                'recognitions',
                'homework',
                'homeworkResult.homework',
                'users:id,name'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function getClassPhoto(Request $request)
    {
        $this->validate($request, [
            'classId' => 'required'
        ]);
        $classId = $request->classId;
        $posts = Post::whereIn('contentId', [12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22])
            ->where('classId', $classId)
            ->with([
                'questionnaires:postId,content',
                'votings:postId,content',
                'homeVisit:postId,content',
                'notifications:postId,description',
                'evaluations:postId,selMedalList',
                'recognitions:postId,imgUrl',
                'users:id,name'
            ])
            ->orderBy('created_at', 'desc')
            ->get();
        // file_put_contents('post.txt',$posts);
        $tempData = [];
        foreach ($posts as $post) {
            switch ($post->contentId) {
                case 19:
                    array_push($tempData, $post->recognitions->imgUrl);
                    break;
                case 18:
                    array_push($tempData, $post->evaluations->selMedalList);
                    break;
                case 17:
                    array_push($tempData, $post->notifications->description);
                    break;
                case 16:
                    array_push($tempData, $post->homeVisit->content);
                    break;
                case 13:
                    array_push($tempData, $post->votings->content);
                    break;
                case 12:
                    array_push($tempData, $post->questionnaires->content);
                    break;
                default:
                    break;
            }
        }
        // file_put_content('post.txt',$tempData);
        return $tempData;
    }

    public function deletePost(Request $request)
    {
        $this->validate($request, [
            'postId' => 'required'
        ]);
        return Post::where('id', $request->postId)->delete();
    }
}
