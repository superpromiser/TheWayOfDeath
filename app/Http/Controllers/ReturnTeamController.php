<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReturnTeamController extends Controller
{
    public function createReturnTeam(Request $request)
    {
        $this->validate($request, [
            'avatar' => 'required',
            'leader' => 'required',
            'member' => 'requried',
            'name' => 'required',
            'teacher' => 'required',
        ]);
    }
}
