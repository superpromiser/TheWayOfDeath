<?php

namespace App\Http\Controllers;

use App\VotingTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VotingTempController extends Controller
{
    //
    public function getVotingTemp(Request $request)
    {
    }

    public function createVotingTemp(Request $request)
    {
        // $this->validate($request, [
        //     'tempTitle' => 'required',
        //     'tempType' => 'required',
        //     'description' => 'required',
        //     'imgUrl' => 'required',
        //     'content' => 'required'
        // ]);
        $userId = Auth::user()->id;
        return VotingTemp::create([
            'tempTitle' => $request->tempTitle,
            'tempType' => $request->tempType,
            'description' => $request->description,
            'imgUrl' => $request->imgUrl,
            'content' => $request->content,
            'schoold' => $request->schoolId,
            'lessonId' => $request->lessonId,
            'userId' => $userId,
        ]);
    }

    public function updateVotingTemp(Request $request)
    {
    }

    public function deleteVotingTemp(Request $request)
    {
    }
}
