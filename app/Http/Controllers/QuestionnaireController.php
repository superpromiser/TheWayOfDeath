<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Questionnaire;

class QuestionnaireController extends Controller
{
    //
    public function getQuestionnaire(){
        
    }

    public function createQuestionnaire(Request $request){
        $postId = Post::create('contentId',1)->id;
        
    }

    public function updateQuestionnaire(){

    }

    public function deleteQusetionaire(){

    }
}
