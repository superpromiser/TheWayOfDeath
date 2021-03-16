<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;


class PostController extends Controller
{
    //
    public function getAllPost(){
        return Post::with([
            'questionnaires',
            'votings',
            'users:id,name'])
        ->paginate(5);
    }
}
