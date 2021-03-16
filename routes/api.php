<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api', 'prefix'=>'v1'], function () {
    Route::post('/logout', 'Auth\LoginController@logout');

    //get current logged user
    Route::get('/user', 'Auth\UserController@current');

    //actions with UserController
    Route::post('users','UserController@createUser')->name('createUser');
    Route::post('addUsers','UserController@addUser')->name('addUser');

    Route::get('staff','UserController@readstaff')->name('readstaff');
    Route::post('staff','UserController@createStaff')->name('createStaff');
    Route::put('staff','UserController@updateStaff')->name('updateStaff');

    Route::get('student','UserController@readstudent')->name('readstudent');
    Route::post('student','UserController@createStudent')->name('createStudent');
    Route::put('student','UserController@updateStudent')->name('updateStudent');
    Route::get('studentBylessonId','UserController@getstudentBylessonId')->name('getstudentBylessonId');
    
    Route::get('users','UserController@readUser')->name('readUser');
    Route::get('users/status','UserController@getStatus')->name('getStatus');
    Route::put('users','UserController@updateUser')->name('updateUser');
    Route::delete('users','UserController@deleteUser')->name('deleteUser');
    Route::post('/users/newVideoCount','UserController@newVideoCount')->name('newVideoCount');
    Route::post('/users/newLiveCount','UserController@newLiveCount')->name('newLiveCount');

    Route::post('search', 'UserController@search')->name('search');


    //setting
    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');
    
    //userRole API
    Route::get('userRole', 'UserRoleController@getUserRole');
    Route::post('userRole', 'UserRoleController@createUserRole');
    Route::put('userRole', 'UserRoleController@updateUserRole');
    Route::delete('userRole', 'UserRoleController@deleteUserRole');

    //upload file
    Route::post('file/image','UploadController@imageUpload');
    Route::post('file/other','UploadController@otherUpload');
    Route::post('file/video','UploadController@videoUpload');
    Route::delete('file','UploadController@deleteFile');

    //school
    Route::get('school','SchoolController@getSchool')->name('getSchool');
    Route::post('school','SchoolController@storeSchool')->name('storeSchool');
    Route::put('school','SchoolController@updateSchool')->name('updateSchool');
    Route::delete('school','SchoolController@removeSchool')->name('removeSchool');
    Route::post('school/manager','SchoolController@storeManager')->name('storeManager');
    Route::get('school/manager','SchoolController@getManager')->name('getManager');
    Route::put('school/manager','SchoolController@updateManager')->name('updateManager');
    Route::delete('school/manager','SchoolController@removeManager')->name('removeManager');
    Route::get('school/tree','SchoolController@getSchoolTree')->name('getSchoolTree');


    //grade
    Route::get('grade','GradeController@getGrade')->name('getGrade');
    Route::post('grade','GradeController@createGrade')->name('createGrade');
    Route::put('grade','GradeController@updateGrade')->name('updateGrade');
    Route::delete('grade','GradeController@deleteGrade')->name('deleteGrade');
    Route::get('schoolName','GradeController@getSchoolName')->name('getSchoolName');

    //class
    Route::get('class','LessonController@getLesson')->name('getLesson');
    Route::post('class','LessonController@createLesson')->name('createLesson');
    Route::put('class','LessonController@updateLesson')->name('updateLesson');
    Route::delete('class','LessonController@deleteLesson')->name('deleteLesson');
    Route::get('gradeName','LessonController@getGradeName')->name('getGradeName');

    //actions with member table
    // Route::get('grade','MemberController@getGrade')->name('getGrade');

    Route::get('gradeClass','MemberController@getGradeClass')->name('getGradeClass');

    Route::get('getLesson','MemberController@getLesson')->name('getLesson');
    Route::get('surveySchool','MemberController@getSurveySchool');
    Route::get('surveyGrade','MemberController@getSurveyGrade');
    Route::get('surveyLesson','MemberController@getSurveyLesson');
    Route::get('lessonMember','MemberController@getLessonMember');
    Route::post('member','MemberController@addMember');
    Route::delete('member','MemberController@removeMember');
    Route::get('classMember','MemberController@getContacts');

    //post
    Route::get('allPost','PostController@getAllPost');

    //template
    Route::get('template','TemplateController@getTemplate');
    Route::post('template','TemplateController@createTemplate');
    Route::put('template','TemplateController@updateTemplate');
    Route::delete('template','TemplateController@deleteTemplate');
    
    //questionnaire
    Route::get('questionnaire','QuestionnaireController@getQuestionnaire');
    Route::post('questionnaire','QuestionnaireController@createQuestionnaire');
    Route::put('questionnaire','QuestionnaireController@updateQuestionnaire');
    Route::delete('questionnaire','QuestionnaireController@deleteQuestionnaire');

    //voting
    Route::get('voting','VotingController@getVotingData');
    Route::post('voting','VotingController@createVotingData');
    Route::put('voting','VotingController@updateVotingData');
    Route::delete('voting','VotingController@deleteVotingData');


});

Route::group(['middleware' => 'guest:api','prefix' => 'v1'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
