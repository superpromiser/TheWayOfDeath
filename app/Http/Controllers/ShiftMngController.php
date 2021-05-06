<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\ShiftMng;
use Illuminate\Support\Facades\Auth;
use App\Template;
class ShiftMngController extends Controller
{
    //
    public function getShiftMng(Request $request)
    {
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        return Post::where(['schoolId' => $request->schoolId, 'classId' => $request->lessonId, 'contentId' => 9])
            ->with([
                'likes',
                'views',
                'comments',
                'shiftMng',
                'users:id,name,avatar'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function createShiftMng(Request $request)
    {
        $this->validate($request, [
            'prevName' => 'required',
            'prevNameId' => 'required',
            'nextName' => 'required',
            'nextNameId' => 'required',
            'scheduleDate' => 'required',
            'itemList' => 'required',
            'schoolId' => 'required',
        ]);
        $userId = Auth::user()->id;
        $postId = Post::create([
            'contentId' => 9,
            'userId' => $userId,
            'schoolId' => $request->schoolId
        ])->id;

        return ShiftMng::create([
            'prevName' => $request->prevName,
            'prevNameId' => $request->prevNameId,
            'nextName' => $request->nextName,
            'nextNameId' => $request->nextNameId,
            'schoolId' => $request->schoolId,
            'scheduleDate' => $request->scheduleDate,
            'itemList' => $request->itemList,
            'postId' => $postId,
        ]);
    }

    public function updateShiftMng(Request $request)
    {
    }

    public function deleteShiftMng(Request $request)
    {
    }

    public function getTemplateCnt(Request $request){
        $this->validate($request, [
            'schoolId' => 'required',
        ]);
        $userId = Auth::user()->id;
        $result['draftCnt'] = Template::where(['contentId' => 9, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId'=>$request->lessonId, 'tempType' => 2])->count();
        $result['templateCnt'] = Template::where(['contentId' => 9, 'userId' => $userId, 'schoolId' => $request->schoolId, 'lessonId'=>$request->lessonId, 'tempType' => 1])->count();
        return $result;
    }

    public function getTemplateList(Request $request){
        $this->validate($request, [
            'schoolId' => 'required'
        ]);
        $userId = Auth::user()->id;
        return Template::where(['contentId' => 9, 'userId' => $userId, 'schoolId' => $request->schoolId,])->get();
    }

    public function createTemplate(Request $reqeust){
        $userId = Auth::user()->id;
        Template::create([
            'contentId' => 9,
            'userId' => $userId,
            'tempTitle' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'schoolId' => $request->schoolId,
            'tempType' => $request->tempType,
            'lessonId'=>$request->lessonId
        ]);
        return true;
    }

    public function deleteTemplate(Request $request){
        $this->validate($request,[
            'id'=>'required'
        ]);
        return Template::where('id',$request->id)->delete();
    }
}
