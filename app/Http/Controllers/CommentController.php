<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comment;

class CommentController extends Controller
{
    //
    public function createComment(Request $request)
    {
        $this->validate($request, [
            'text' => 'required',
            'postId' => 'required'
        ]);
        $userId = Auth::user()->id;
        $commentId = Comment::create([
            'comments' => $request->text,
            'userId' => $userId,
            'postId' => $request->postId
        ])->id;
        return Comment::where('id', $commentId)->with('users:id,name')->first();
    }
}
