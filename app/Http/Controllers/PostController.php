<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Like;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //
    public function getAllPost(){
        $userId = Auth::user()->id;
        // $isLiked = Like::where('userId',$userId)->count();
        return $posts = Post::with([
            'likes',
            'views',
            'comments',
            'questionnaires',
            'votings',
            'sms',
            'users:id,name'])
        ->orderBy('created_at','desc')
        ->paginate(5);
    }
}
