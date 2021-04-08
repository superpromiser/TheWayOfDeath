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

Route::group(['middleware' => 'auth:api', 'prefix' => 'v1'], function () {
    Route::post('/logout', 'Auth\LoginController@logout');

    //get current logged user
    Route::get('/user', 'Auth\UserController@current');
    Route::get('userByRole','UserController@getUserByRole');
    Route::get('selUser','UserController@getSelUser');
    Route::post('user/schoolItem','UserController@postSchoolItem');
    Route::post('user/classItem','UserController@postClassItem');
    Route::get('user/postItem','UserController@getPostItem');
    Route::put('user/profile','UserController@upProfile');
    Route::get('schoolMember','UserController@getSchoolMember');
    //actions with UserController
    Route::post('users', 'UserController@createUser')->name('createUser');
    Route::post('addUsers', 'UserController@addUser')->name('addUser');

    Route::get('staff', 'UserController@readstaff')->name('readstaff');
    Route::post('staff', 'UserController@createStaff')->name('createStaff');
    Route::put('staff', 'UserController@updateStaff')->name('updateStaff');

    Route::get('student', 'UserController@readstudent')->name('readstudent');
    Route::post('student', 'UserController@createStudent')->name('createStudent');
    Route::put('student', 'UserController@updateStudent')->name('updateStudent');
    Route::get('studentBylessonId', 'UserController@getstudentBylessonId')->name('getstudentBylessonId');

    Route::get('users', 'UserController@readUser')->name('readUser');
    Route::get('users/status', 'UserController@getStatus')->name('getStatus');
    Route::put('users', 'UserController@updateUser')->name('updateUser');
    Route::delete('users', 'UserController@deleteUser')->name('deleteUser');
    Route::post('/users/newVideoCount', 'UserController@newVideoCount')->name('newVideoCount');
    Route::post('/users/newLiveCount', 'UserController@newLiveCount')->name('newLiveCount');

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
    Route::post('file/image', 'UploadController@imageUpload');
    Route::post('file/other', 'UploadController@otherUpload');
    Route::post('file/video', 'UploadController@videoUpload');
    Route::delete('file', 'UploadController@deleteFile');

    //subject of manager
    Route::get('manager/subject', 'SubjectController@getSubject')->name('getSubject');
    Route::post('manager/subject', 'SubjectController@storeSubject')->name('storeSubject');
    Route::put('manager/subject', 'SubjectController@updateSubject')->name('updateSubject');
    Route::delete('manager/subject', 'SubjectController@removeSubject')->name('removeSubject');

    //scheduleTeacher of manager
    Route::get('manager/schedule/teacher', 'ScheduleTeacherController@getScheduleTeacher')->name('getScheduleTeacher');
    Route::post('manager/schedule/teacher', 'ScheduleTeacherController@createScheduleTeacher')->name('createScheduleTeacher');
    Route::put('manager/schedule/teacher', 'ScheduleTeacherController@updateScheduleTeacher')->name('updateScheduleTeacher');
    Route::delete('manager/schedule/teacher', 'ScheduleTeacherController@deleteScheduleTeacher')->name('deleteScheduleTeacher');
    
    //session of manager
    Route::get('manager/session', 'SessionController@getSession')->name('getSession');
    Route::post('manager/session', 'SessionController@storeSession')->name('storeSession');
    Route::put('manager/session', 'SessionController@updateSession')->name('updateSession');
    Route::delete('manager/session', 'SessionController@removeSession')->name('removeSession');

    //school
    Route::get('school', 'SchoolController@getSchool')->name('getSchool');
    Route::post('school', 'SchoolController@storeSchool')->name('storeSchool');
    Route::put('school', 'SchoolController@updateSchool')->name('updateSchool');
    Route::delete('school', 'SchoolController@removeSchool')->name('removeSchool');
    Route::post('school/manager', 'SchoolController@storeManager')->name('storeManager');
    Route::get('school/manager', 'SchoolController@getManager')->name('getManager');
    Route::put('school/manager', 'SchoolController@updateManager')->name('updateManager');
    Route::delete('school/manager', 'SchoolController@removeManager')->name('removeManager');
    Route::get('school/tree', 'SchoolController@getSchoolTree')->name('getSchoolTree');


    //grade
    Route::get('grade', 'GradeController@getGrade')->name('getGrade');
    Route::post('grade', 'GradeController@createGrade')->name('createGrade');
    Route::put('grade', 'GradeController@updateGrade')->name('updateGrade');
    Route::delete('grade', 'GradeController@deleteGrade')->name('deleteGrade');
    Route::get('schoolName', 'GradeController@getSchoolName')->name('getSchoolName');

    //class
    Route::get('class', 'LessonController@getLesson')->name('getLesson');
    Route::post('class', 'LessonController@createLesson')->name('createLesson');
    Route::put('class', 'LessonController@updateLesson')->name('updateLesson');
    Route::delete('class', 'LessonController@deleteLesson')->name('deleteLesson');
    Route::get('gradeName', 'LessonController@getGradeName')->name('getGradeName');

    //actions with member table
    // Route::get('grade','MemberController@getGrade')->name('getGrade');

    Route::get('gradeClass', 'MemberController@getGradeClass')->name('getGradeClass');

    Route::get('getLesson', 'MemberController@getLesson')->name('getLesson');
    Route::get('surveySchool', 'MemberController@getSurveySchool');
    Route::get('surveyGrade', 'MemberController@getSurveyGrade');
    Route::get('surveyLesson', 'MemberController@getSurveyLesson');
    Route::get('lessonMember', 'MemberController@getLessonMember');
    Route::post('member', 'MemberController@addMember');
    Route::delete('member', 'MemberController@removeMember');
    Route::get('classMember', 'MemberController@getContacts');

    //post
    Route::get('schoolPost', 'PostController@getSchoolPost');
    Route::get('classPost', 'PostController@getClassPost');
    Route::post('like', 'LikeController@addLike');
    Route::delete('like', 'LikeController@removeLike');
    Route::delete('post', 'PostController@deletePost');

    //template
    Route::get('template', 'TemplateController@getTemplate');
    Route::post('template', 'TemplateController@createTemplate');
    Route::put('template', 'TemplateController@updateTemplate');
    Route::delete('template', 'TemplateController@deleteTemplate');

    //questionnaire
    Route::get('questionnaire', 'QuestionnaireController@getQuestionnaire');
    Route::post('questionnaire', 'QuestionnaireController@createQuestionnaire');
    Route::put('questionnaire', 'QuestionnaireController@updateQuestionnaire');
    Route::delete('questionnaire', 'QuestionnaireController@deleteQuestionnaire');

    Route::get('questionnaireTemp', 'QuestionnaireTempController@getQuestionnaireTemp');
    Route::post('questionnaireTemp', 'QuestionnaireTempController@createQuestionnaireTemp');
    Route::put('questionnaireTemp', 'QuestionnaireTempController@updateQuestionnaireTemp');
    Route::delete('questionnaireTemp', 'QuestionnaireTempController@deleteQuestionnaireTemp');
    Route::get('questionnaireTempCnt', 'QuestionnaireTempController@getQuestionnaireTempCnt');
    //voting
    Route::get('voting', 'VotingController@getVotingData');
    Route::post('voting', 'VotingController@createVotingData');
    Route::put('voting', 'VotingController@updateVotingData');
    Route::delete('voting', 'VotingController@deleteVotingData');
    Route::get('voting/template', 'VotingController@getTemplateList');
    //sms
    Route::get('sms', 'SmsController@getSms');
    Route::post('sms', 'SmsController@createSms');
    Route::put('sms', 'SmsController@updateSms');
    Route::delete('sms', 'SmsController@deleteSms');

    //comment
    Route::post('comment', 'CommentController@createComment');
    Route::get('comment', 'CommentController@getComment');
    Route::delete('comment', 'CommentController@deleteComment');

    //subject
    Route::get('manager/subject', 'SubjectController@getSubject');
    Route::post('manager/subject', 'SubjectController@createSubject');
    Route::put('manager/subject', 'SubjectController@updateSubject');
    Route::delete('manager/subject', 'SubjectController@deleteSubject');

    //schedule
    Route::get('manager/schedule/baseData', 'ScheduleSettingController@getBaseData');
    Route::get('manager/schedule', 'ScheduleSettingController@getSchedule');
    Route::post('manager/schedule', 'ScheduleSettingController@createSchedule');
    Route::put('manager/schedule', 'ScheduleSettingController@updateSchedule');
    Route::delete('manager/schedule', 'ScheduleSettingController@deleteSchedule');

    Route::get('teacher/schedule', 'scheduleClassController@getScheduleClass');
    Route::post('teacher/schedule', 'scheduleClassController@createScheduleClass');
    Route::put('teacher/schedule', 'scheduleClassController@updateScheduleClass');
    Route::delete('teacher/schedule', 'scheduleClassController@deleteScheduleClass');

    //campus
    Route::get('campus', 'CampusController@getCampus');
    Route::post('campus', 'CampusController@createCampus');
    Route::put('campus', 'CampusController@updateCampus');
    Route::delete('campus', 'CampusController@deleteCampus');

    //anouncement
    Route::get('anouncement', 'AnouncementController@getAnouncement');
    Route::post('anouncement', 'AnouncementController@createAnouncement');
    Route::put('anouncement', 'AnouncementController@updateAnouncement');
    Route::delete('anouncement', 'AnouncementController@deleteAnouncement');

    //bulletinBoard
    Route::get('bulletinBoard', 'BulletinBoardController@getBulletinBoard');
    Route::post('bulletinBoard', 'BulletinBoardController@createBulletinBoard');
    Route::put('bulletinBoard', 'BulletinBoardController@updateBulletinBoard');
    Route::delete('bulletinBoard', 'BulletinBoardController@deleteBulletinBoard');

    //homeVisit
    Route::get('homeVisit', 'HomeVisitController@getHomeVisit');
    Route::post('homeVisit', 'HomeVisitController@createHomeVisit');
    Route::put('homeVisit', 'HomeVisitController@updateHomeVisit');
    Route::delete('homeVisit', 'HomeVisitController@deleteHomeVisit');

    //answerQuestionnaire
    Route::post('answerQuestionnaire', 'AnswerQuestionnaireController@createAnswerQuestionnaire');
    Route::get('answerQuestionnaire', 'AnswerQuestionnaireController@getAnswerQuestionnaire');

    //answerVoting
    Route::post('answerVoting', 'AnswerVotingController@createAnswerVoting');
    Route::get('answerVoting', 'AnswerVotingController@getAnswerVoting');

    //class notification
    Route::get('class/notification', 'NotificationController@getNotification');
    Route::post('class/notification', 'NotificationController@createNotification');
    Route::put('class/notification', 'NotificationController@updateNotification');
    Route::delete('class/notification', 'NotificationController@deleteNotification');

    //class evaluation
    Route::get('/class/evaluation', 'EvaluationController@getEvaluation');
    Route::post('/class/evaluation', 'EvaluationController@createEvaluation');
    Route::put('/class/evaluation', 'EvaluationController@updateEvaluation');
    Route::delete('/class/evaluation', 'EvaluationController@deleteEvaluation');

    //class recognition
    Route::get('/class/recognition', 'RecognitionController@getRecognition');
    Route::post('/class/recognition', 'RecognitionController@createRecognition');
    Route::put('/class/recognition', 'RecognitionController@updateRecognition');
    Route::delete('/class/recognition', 'RecognitionController@deleteRecognition');

    //class albums
    Route::get('/class/photos', 'PostController@getClassPhoto');

    //attendance
    Route::get('attendance', 'AttendanceController@getAttendanceData');
    Route::get('statAttendance', 'AttendanceController@getStatData');

    //chat
    Route::get('/chat/userList', 'ChatController@getUserList')->name('getUserList');
    Route::get('/chat/contactList', 'ChatController@getContactList')->name('getContactList');
    Route::post('/chat/newMsgCount', 'ChatController@addNewMessageCount')->name('addNewMessageCount');
    Route::post('/contact', 'ChatController@postContactList')->name('postContactList');

    Route::get('/messages', 'MessageController@index')->name('getMessages');
    Route::get('/messages/group', 'MessageController@getGroupMessage')->name('getGroupMessage');
    Route::post('/messages', 'MessageController@store')->name('saveMessages');
    Route::post('/messages/newgroup', 'ChatRoomController@creatGroup')->name('creatGroup');
    Route::post('/messages/leavegroup', 'ChatController@leavegroup')->name('leavegroup');
    Route::delete('/messages/removeGroup', 'ChatController@removeGroup')->name('removeGroup');
    Route::delete('/messages/removeUser', 'ChatController@removeUser')->name('removeUser');
    //send image
    Route::post('/messages/image', 'MessageController@storeChatSendImage')->name('chatSendImageStore');
    //send video
    Route::post('/messages/video', 'MessageController@storeChatSendVideo')->name('chatSendVideoStore');
    //send file
    Route::post('/messages/file', 'MessageController@storeChatSendFile')->name('chatSendFileStore');
    //send audio
    Route::post('/messages/voice', 'MessageController@storeChatSendVoice')->name('chatSendVoiceStore');
    //send map
    Route::post('/messages/map', 'MessageController@storeChatSendMap')->name('chatSendMapStore');

    //get lesson user list
    Route::get('/lessonUserList', 'UserController@getLessonUserList');

    Route::get('/lessonAttendance', 'LessonAttendanceController@getLessonAttendance');
    Route::post('/lessonAttendance', 'LessonAttendanceController@createLessonAttendance');
    Route::put('/lessonAttendance', 'LessonAttendanceController@updateLessonAttendance');
    Route::delete('/lessonAttendance', 'LessonAttendanceController@deleteLessonAttendance');
    Route::get('/statLessonAttData', 'LessonAttendanceController@getStatLessonAttData');
    Route::get('/statDetailAttData', 'LessonAttendanceCOntroller@getStatDetailAttData');

    //checkIn
    Route::get('/checkIn', 'CheckInController@getCheckInData');
    Route::post('/checkIn', 'CheckInController@createCheckInData');
    Route::put('/checkIn', 'CheckInController@updateCheckInData');
    Route::delete('/checkIn', 'CheckInController@deleteCheckInData');

    //vacation
    Route::get('banziName', 'VacationController@getBanziName');
    Route::get('vacation', 'VacationController@getVacation');
    Route::get('allVacation', 'VacationController@allVacation');
    Route::get('currentVacation', 'VacationController@currentVacation');

    Route::post('vacation', 'VacationController@createVacation');
    Route::put('vacation', 'VacationController@updateVacation');
    Route::delete('vacation', 'VacationController@deleteVacation');

    //group
    Route::get('groupMember', 'GroupController@getGroupMember');
    Route::get('allGroupMember', 'GroupController@getAllGroupMember');
    Route::post('groupMember', 'GroupController@addGroupMember');
    Route::put('groupMember', 'GroupController@updateGroupMember');
    Route::delete('groupMember', 'GroupController@deleteGroup');

    //club
    Route::get('club', 'ClubController@getClub');
    Route::post('club', 'ClubController@createClub');
    Route::put('club', 'ClubController@updateClub');
    Route::delete('club', 'ClubController@deleteClub');

    //share
    Route::post('share', 'ShareController@createShare');

    //regname
    Route::post('regname', 'RegnameController@createRegname');
    Route::post('regname/answer', 'RegnameController@answerRegname');
    Route::get('regname/answer/one', 'RegnameController@getAnswerOne');
    Route::get('regname/answer', 'RegnameController@getAnswer');
    Route::put('regname/answer', 'RegnameController@updateAnswer');

    //seat
    Route::get('seat', 'SeatController@getSeatData');
    Route::post('seat', 'SeatController@createSeatData');
    Route::put('seat', 'SeatController@updateSeatData');
    Route::delete('seat', 'SeatController@deleteSeatData');
});

Route::group(['middleware' => 'guest:api', 'prefix' => 'v1'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');

    //guest manage
    // Route::get('guestRequest')
});
