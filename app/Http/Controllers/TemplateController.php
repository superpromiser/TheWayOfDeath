<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Template;
class TemplateController extends Controller
{
    //
    

    public function getQuestionnareTemp(Request $request){
        $userId = Auth::user()->id; 
        return Template::where([
            'contentId'=>1,
            'userId'=>$userId
        ])->with('questionnaire')->get();
    }
}
