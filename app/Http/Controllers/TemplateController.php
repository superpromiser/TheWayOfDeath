<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Template;

class TemplateController extends Controller
{
    //
    public function getTemplate(Request $request){
        $this->validate($request,[
            'contentId'=>'required'
        ]);
        $userId = Auth::user()->id;
        return Template::where(['userId'=>$userId,'contentId'=>$request->contentId])->get();
    }

    public function createTemplate(Request $request){
        $this->validate($request,[
            'tempData'=>'required',
            'tempType'=>'required',
            'contentId'=>'required'
        ]);
        $userId = Auth::user()->id;
        $tempData = json_encode($request->tempData);
        $tempType = $request->tempType;
        $contentId = $request->contentId;
        return Template::create([
            'contentId'=>$contentId,
            'tempData'=>$tempData,
            'tempType'=>$tempType,
            'userId'=>$userId
        ]);
    }

    public function updateTemplate(Request $request){

    }

    public function deleteTemplate(Reqeust $request){

    }
}
