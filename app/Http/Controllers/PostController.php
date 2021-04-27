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
        return Post::whereIn('contentId', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 23, 24])
            ->where('schoolId', $request->schoolId)
            ->with([
                'likes',
                'views',
                'comments.users:id,name',
                'questionnaires',
                'votings',
                'sms',
                'campus',
                'anouncements',
                'bulletinBoards',
                'homeVisit',
                'shares',
                'shiftMng',
                'safestudy',
                'repairdata' => function ($q) {
                    $q->whereIn('status', ['progress', 'done']);
                },
                'schoolstory',
                'regnames',
                'users:id,name,avatar'
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
        return Post::whereIn('contentId', [5, 8, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26])
            ->where('classId', $classId)
            ->with([
                'likes',
                'views',
                'comments',
                'questionnaires',
                'votings',
                'anouncements',
                'homeVisit',
                'notifications',
                'evaluations',
                'recognitions',
                'homework.homeworkresult',
                'homeworkResult.homework',
                'safestudy',
                'shares',
                'regnames',
                'classstory',
                'interclassstory',
                'users:id,name,avatar'
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
                'homework:postId,content',
                'homeVisit:postId,content',
                'notifications:postId,description',
                'evaluations:postId,selMedalList',
                'recognitions:postId,imgUrl',
                'homeworkResult:postId,content',
                'users:id,name'
            ])
            ->orderBy('created_at', 'desc')
            ->get();
        $albumData = array();
        foreach ($posts as $post) {
            switch ($post->contentId) {
                case 12:
                    $contentData = json_decode($post->questionnaires->content);
                    foreach ($contentData as $content) {
                        if ($content->type == 'single') {
                            $postingData = $content->singleContentDataArr;
                            foreach ($postingData as $questionItem) {
                                $imgUrls = $questionItem->imgUrl;
                                foreach ($imgUrls as $imgUrl) {
                                    $path = $imgUrl->path;
                                    array_push($albumData, $path);
                                }
                            }
                        } else if ($content->type == 'multi') {
                            $postingData = $content->multiContentDataArr;
                            foreach ($postingData as $questionItem) {
                                $imgUrls = $questionItem->imgUrl;
                                foreach ($imgUrls as $imgUrl) {
                                    $path = $imgUrl->path;
                                    array_push($albumData, $path);
                                }
                            }
                        } else if ($content->type == 'qa') {
                            $postingData = $content->qaContentDataArr;
                            foreach ($postingData as $questionItem) {
                                $imgUrls = $questionItem->imgUrl;
                                foreach ($imgUrls as $imgUrl) {
                                    $path = $imgUrl->path;
                                    array_push($albumData, $path);
                                }
                            }
                        } else if ($content->type == 'score') {
                            $postingData = $content->scoringDataArr;
                            foreach ($postingData as $contentData) {
                                $post = $contentData->contentData;
                                foreach ($post as $questionItem) {
                                    $imgUrls = $questionItem->imgUrl;
                                    foreach ($imgUrls as $imgUrl) {
                                        $path = $imgUrl->path;
                                        array_push($albumData, $path);
                                    }
                                }
                            }
                        }
                    }
                    break;
                case 13:
                    $contentData = json_decode($post->votings->content);
                    foreach ($contentData as $questionItem) {
                        $imgUrls = $questionItem->imgUrl;
                        foreach ($imgUrls as $imgUrl) {
                            $path = $imgUrl->path;
                            array_push($albumData, $path);
                        }
                    }
                    break;
                case 14:
                    // array_push($tempData, $post->questionniare->content);
                    $contentData = json_decode($post->homework->content);
                    $imgUrls = $contentData->imgUrl;
                    foreach ($imgUrls as $imgUrl) {
                        $path = $imgUrl->path;
                        array_push($albumData, $path);
                    }
                    break;
                case 15:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 16:
                    // array_push($tempData, $post->questionniare->content);
                    $contentData = json_decode($post->homeVisit->content);
                    $imgUrls = $contentData->imgUrl;
                    foreach ($imgUrls as $imgUrl) {
                        $path = $imgUrl->path;
                        array_push($albumData, $path);
                    }
                    break;
                case 17:
                    // array_push($tempData, $post->questionniare->content);
                    $contentData = json_decode($post->notifications->description);
                    $imgUrls = $contentData->imgUrl;
                    foreach ($imgUrls as $imgUrl) {
                        $path = $imgUrl->path;
                        array_push($albumData, $path);
                    }
                    break;
                case 18:
                    // array_push($tempData, $post->questionniare->content);
                    // $contentData = json_decode($post->evaluations->selMedalList);
                    break;
                case 19:
                    // array_push($tempData, $post->questionniare->content);
                    // $contentData = $post;
                    // $contentData = $post;
                    // $contentData = $post->recognitions;
                    // $contentData = $post->recognitions->imgUrl;
                    break;
                case 20:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 21:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 22:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 23:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                default:
                    break;
            }
        }
        return $albumData;
    }

    public function getClassFile(Request $request)
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
                'homework:postId,content',
                'homeVisit:postId,content',
                'notifications:postId,description',
                'evaluations:postId,selMedalList',
                'recognitions:postId,imgUrl',
                'homeworkResult:postId,content',
                'users:id,name'
            ])
            ->orderBy('created_at', 'desc')
            ->get();
        $fileData = array();
        $videoData = array();
        foreach ($posts as $post) {
            switch ($post->contentId) {
                case 12:
                    $contentData = json_decode($post->questionnaires->content);
                    foreach ($contentData as $content) {
                        if ($content->type == 'single') {
                            $postingData = $content->singleContentDataArr;
                            foreach ($postingData as $questionItem) {
                                $otherUrls = $questionItem->otherUrl;
                                foreach ($otherUrls as $otherUrl) {
                                    // $path = $otherUrl->path;
                                    array_push($fileData, $otherUrl);
                                }
                                $videoUrls = $questionItem->videoUrl;
                                foreach ($videoUrls as $videoUrl) {
                                    // $path = $videoUrl->path;
                                    array_push($videoData, $videoUrl);
                                }
                            }
                        } else if ($content->type == 'multi') {
                            $postingData = $content->multiContentDataArr;
                            foreach ($postingData as $questionItem) {
                                $otherUrls = $questionItem->otherUrl;
                                foreach ($otherUrls as $otherUrl) {
                                    // $path = $otherUrl->path;
                                    array_push($fileData, $otherUrl);
                                }
                                $videoUrls = $questionItem->videoUrl;
                                foreach ($videoUrls as $videoUrl) {
                                    // $path = $videoUrl->path;
                                    array_push($videoData, $videoUrl);
                                }
                            }
                        } else if ($content->type == 'qa') {
                            $postingData = $content->qaContentDataArr;
                            foreach ($postingData as $questionItem) {
                                $otherUrls = $questionItem->otherUrl;
                                foreach ($otherUrls as $otherUrl) {
                                    // $path = $otherUrl->path;
                                    array_push($fileData, $otherUrl);
                                }
                                $videoUrls = $questionItem->videoUrl;
                                foreach ($videoUrls as $videoUrl) {
                                    // $path = $videoUrl->path;
                                    array_push($videoData, $videoUrl);
                                }
                            }
                        } else if ($content->type == 'score') {
                            $postingData = $content->scoringDataArr;
                            foreach ($postingData as $contentData) {
                                $post = $contentData->contentData;
                                foreach ($post as $questionItem) {
                                    $otherUrls = $questionItem->otherUrl;
                                    foreach ($otherUrls as $otherUrl) {
                                        // $path = $otherUrl->path;
                                        array_push($fileData, $otherUrl);
                                    }
                                    $videoUrls = $questionItem->videoUrl;
                                    foreach ($videoUrls as $videoUrl) {
                                        // $path = $videoUrl->path;
                                        array_push($videoData, $videoUrl);
                                    }
                                }
                            }
                        }
                    }
                    break;
                case 13:
                    $contentData = json_decode($post->votings->content);
                    foreach ($contentData as $questionItem) {
                        $otherUrls = $questionItem->otherUrl;
                        foreach ($otherUrls as $otherUrl) {
                            // $path = $otherUrl->path;
                            array_push($fileData, $otherUrl);
                        }
                        $videoUrls = $questionItem->videoUrl;
                        foreach ($videoUrls as $videoUrl) {
                            // $path = $videoUrl->path;
                            array_push($videoData, $videoUrl);
                        }
                    }
                    break;
                case 14:
                    // array_push($tempData, $post->questionniare->content);
                    $contentData = json_decode($post->homework->content);
                    $otherUrls = $contentData->otherUrl;
                    foreach ($otherUrls as $otherUrl) {
                        // $path = $otherUrl->path;
                        array_push($fileData, $otherUrl);
                    }
                    $videoUrls = $contentData->videoUrl;
                    foreach ($videoUrls as $videoUrl) {
                        // $path = $videoUrl->path;
                        array_push($videoData, $videoUrl);
                    }
                    break;
                case 15:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 16:
                    // array_push($tempData, $post->questionniare->content);
                    $contentData = json_decode($post->homeVisit->content);
                    $otherUrls = $contentData->otherUrl;
                    foreach ($otherUrls as $otherUrl) {
                        // $path = $otherUrl->path;
                        array_push($fileData, $otherUrl);
                    }
                    $videoUrls = $contentData->videoUrl;
                    foreach ($videoUrls as $videoUrl) {
                        // $path = $videoUrl->path;
                        array_push($videoData, $videoUrl);
                    }
                    break;
                case 17:
                    // array_push($tempData, $post->questionniare->content);
                    $contentData = json_decode($post->notifications->description);
                    $otherUrls = $contentData->otherUrl;
                    foreach ($otherUrls as $otherUrl) {
                        // $path = $otherUrl->path;
                        array_push($fileData, $otherUrl);
                    }
                    $videoUrls = $contentData->videoUrl;
                    foreach ($videoUrls as $videoUrl) {
                        // $path = $videoUrl->path;
                        array_push($videoData, $videoUrl);
                    }
                    break;
                case 18:
                    // array_push($tempData, $post->questionniare->content);
                    // $contentData = json_decode($post->evaluations->selMedalList);
                    break;
                case 19:
                    // array_push($tempData, $post->questionniare->content);
                    // $contentData = $post;
                    // $contentData = $post;
                    // $contentData = $post->recognitions;
                    // $contentData = $post->recognitions->imgUrl;
                    break;
                case 20:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 21:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 22:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                case 23:
                    // array_push($tempData, $post->questionniare->content);
                    break;
                default:
                    break;
            }
        }
        return response()->json([
            'fileData' => $fileData,
            'videoData' => $videoData
        ], 200);
    }

    public function deletePost(Request $request)
    {
        $this->validate($request, [
            'postId' => 'required'
        ]);
        return Post::where('id', $request->postId)->delete();
    }
}
