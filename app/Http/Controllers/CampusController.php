<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Campus;
use App\Post;

class CampusController extends Controller
{
    //
    public function getCampus(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 4])
            ->with([
                'likes',
                'views',
                'comments',
                'campus',
                'users:id,name'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function createCampus(Request $request)
    {
        $this->validate($request, [
            'camposeCategory' => 'required',
            'title' => 'required',
            'imgUrl' => 'required',
            'content' => 'required'
        ]);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId' => 4,
            'userId' => $userId,
            'schoolId' => $request->schoolId
        ])->id;
        return Campus::create([
            'category' => $request->camposeCategory,
            'title' => $request->title,
            'imgUrl' => $request->imgUrl,
            'content' => json_encode($request->content),
            'schoolId' => $request->schoolId,
            'postId' => $postId
        ]);
    }

    public function updateCampus(Request $request)
    {
    }

    public function deleteCampus(Request $request)
    {
    }
}
