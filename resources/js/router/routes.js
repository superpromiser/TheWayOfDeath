function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', redirect: { name: 'home' }, name: 'welcome', component: page('welcome.vue') },

  { path: '/login', name: 'login', component: page('welcome.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },
  { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
  { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },
  { path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue') },
  { path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue') },

  //home
  { path: '/home', name: 'home', component: page('home.vue') },
  
  //chat
  { path: '/chat', name: 'chat', component: page('chat/index.vue') },
 
  //newPost
  { path: '/newPost', name: 'mo.newPost', component: page('moNewPost.vue') },

  //circle
  { path: '/circle', name: 'circle', component: page('circle/index.vue') },

  //texteditor
  { path: '/texteditor', name: 'texteditor', component: page('texteditor/index.vue') },

  //selectuser
  { path: '/member/select', name: 'member.selectMo', component: page('member/moChooseMember.vue') },

  //mo post preview
  { path: '/schoolSpace/:schoolId/post/:contentType/preview',name: 'schoolPost.preview', component: page('preview.vue') },

  //chat mobile
  { path: '/chat/mobile', name: 'chatMobile', component: page('chat/mobile/index.vue'),
      children : [
        {path:'',redirect:{name: 'mochat.news'}},
        {path:'news', name:'mochat.news',component:page('chat/mobile/news.vue')},
        {path:'detail', name:'mochat.detail',component:page('chat/mobile/detail.vue')},
        {path:'contact', name:'mochat.contact',component:page('chat/mobile/contact.vue')},
      ]
  },

  //profile
  { path: '/profile', name: 'profile', component: page('profile/index.vue'),
    children : [
      {path:'',redirect:{name: 'profile.list'}},
      {path:'list', name:'profile.list',component:page('profile/list.vue')},
      {path:'password', name:'profile.password',component:page('profile/password.vue')},
      {path:'wechat', name:'profile.wechat',component:page('profile/wechat.vue')},
      {path:'qq', name:'profile.qq',component:page('profile/qq.vue')},
      {path:'myfile', name:'profile.myfile',component:page('profile/myfile.vue')},
      {path:'myshare', name:'profile.myshare',component:page('profile/myshare.vue')},
      {path:'schoolshare', name:'profile.schoolshare',component:page('profile/schoolshare.vue')},
      {path:'name', name:'profile.name',component:page('profile/name.vue')},
      {path:'phone', name:'profile.phone',component:page('profile/phone.vue')},
    ]
  },

  //mo profile
  { path: '/profile/passwordMo', name: 'profile.passwordMo', component: page('profile/passwordMo.vue')},

  //school safety
  {path:'/guest/request', name:'guestRequest', component:page('safety/guestRequest.vue')},

  
  //Admin
  { path: '/admin/assignRole', name: 'admin.assignRole', component: page('admin/assignRole.vue') },
  { path: '/admin/class', name: 'admin.class', component: page('admin/class.vue') },
  { path: '/admin/grade', name: 'admin.grade', component: page('admin/grade.vue') },
  { path: '/admin/imei', name: 'admin.imei', component: page('admin/imei.vue') },
  { path: '/admin/school', name: 'admin.school', component: page('admin/school.vue') },
  { path: '/admin/school/:id/manager', name: 'admin.manager', component: page('admin/schoolManager.vue'), props:true },
  { path: '/admin/stream', name: 'admin.stream', component: page('admin/stream.vue') },
  { path: '/admin/schedule', name: 'admin.schedule', component: page('admin/schedule/schedule.vue') },
  { path: '/admin/scheduleSetting', name: 'admin.scheduleSetting', component: page('admin/schedule/setting.vue')  },
  { path: '/admin/scheduleTeacher', name: 'admin.scheduleTeacher', component: page('admin/schedule/teacher.vue')  },
  { path: '/admin/schedule/class', name: 'admin.scheduleClass', component: page('admin/schedule/class.vue')  },
  { path: '/admin/userlist', name: 'admin.userlist', component: page('admin/userList.vue'),
    children : [
      {path:'',redirect:{name: 'userlist.teacher'}},
      {path:'teacher', name:'userlist.teacher',component:page('admin/userList/teacher.vue')},
      {path:'parent', name:'userlist.parent',component:page('admin/userList/parent.vue')},
      {path:'student', name:'userlist.student',component:page('admin/userList/student.vue')},
    ]
  },
  
  //schoolspace
  {
    path:'/schoolSpace/:schoolId', name:'schoolSpace', component: page('school/schoolSpace.vue'), redirect:{name:'schoolSpace.news'},
    children:[
      {path:'news', name:'schoolSpace.news',component:page('school/news.vue')},
      {path:'application', name:'schoolSpace.application',component:page('school/applications/index.vue')},
      {path:'member', name:'schoolSpace.member',component:page('school/member.vue')},
    ]
  },

  {path:'/schoolSpace/:schoolId/detail', name:"schoolSpace.detail", component:page('details/index.vue'),
    children:[
      {path:'questionnaire', name:'details.quesionnaire', component:page('details/questionnaire/index.vue'),
        children:[
          {path:'answerUsers',name:'details.questionnaireUsers',component:page('details/questionnaire/answerUserList.vue')}
        ]
      },
      {path:'voting', name:'details.voting', component:page('details/voting/index.vue'),
        children:[
          {path:'answerUsers', name:'details.votingUsers', component:page('details/voting/answerUserList.vue')}
        ]
      },
      {path:'sms', name:'details.sms', component:page('details/sms/index.vue')},
      {path:'campus', name:'details.campus', component:page('details/campus/index.vue')},
      {path:'bulletinboard', name:'details.bulletinBoard', component:page('details/bulletinBoard/index.vue')},
      {path:'announcement', name:'details.anouncement', component:page('details/anouncement/index.vue')},
      {path:'share', name:'details.share', component:page('details/share/index.vue')},
      {path:'homevisit', name:'details.homeVisit', component:page('details/homeVisit/index.vue')},
      {path:'regnameResult', name:'details.regnameResult', component:page('details/regname/result.vue')},
      {path:'regnameAnswer', name:'details.regnameAnswer', component:page('details/regname/answer.vue')},
      {path:'shiftMng', name:'details.shiftMng', component:page('details/shiftMng/index.vue')},
      {path:'safeStudy', name:'details.safeStudy', component:page('details/safeStudy/index.vue')},
      {path:'repaire', name:'details.repair', component:page('details/repair/index.vue')},
      {path:'schoolStory', name:'details.schoolStory', component:page('details/schoolStory/index.vue')},
    ]
  },
  
  {path:'/schoolSpace/:schoolId/post', name:'schoolSpace.post', component:page('school/posts/index.vue')},
  {path:'/schoolSpace/:schoolId/post/questionnaire',name:'posts.questionnaire', component:page('school/posts/questionnaire/index.vue'),
    children:[
      {path:'single', name:"questionnaire.single", component:page('school/posts/questionnaire/single.vue')},
      {path:'multi', name:"questionnaire.multi", component:page('school/posts/questionnaire/multi.vue')},
      {path:'questionAnswer', name:"questionnaire.questionAnswer", component:page('school/posts/questionnaire/questionAnswer.vue')},
      {path:'statistics', name:"questionnaire.statistics", component:page('school/posts/questionnaire/statistics.vue')},
      {path:'scoring', name:"questionnaire.scoring", component:page('school/posts/questionnaire/scoring.vue')},
      {path:'tmeplateList', name:"questionnaire.templateList", component:page('school/posts/questionnaire/templateList.vue')},
    ]
  },

  {path:'/schoolSpace/:schoolId/post/questionnaire/newTemplate', name:"questionnaire.templateNew", component:page('school/posts/questionnaire/newTemplate.vue'),
    children:[
      {path:'single',name:'questionnaireTemplate.single',component:page('school/posts/questionnaire/single.vue')},
      {path:'multi',name:'questionnaireTemplate.multi',component:page('school/posts/questionnaire/multi.vue')},
      {path:'questionAnswer',name:'questionnaireTemplate.questionAnswer',component:page('school/posts/questionnaire/questionAnswer.vue')},
      {path:'statistics',name:'questionnaireTemplate.statistics',component:page('school/posts/questionnaire/statistics.vue')},
      {path:'scoring',name:'questionnaireTemplate.scoring',component:page('school/posts/questionnaire/scoring.vue')}
    ]
  },
  {path:'/schoolSpace/:schoolId/post/voting', name:'posts.voting', component:page('school/posts/voting/new.vue')},
  {path:'/schoolSpace/:schoolId/post/voting/templateList', name:'voting.tempList', component:page('school/posts/voting/templateList.vue')},
  {path:'/schoolSpace/:schoolId/post/voting/newTemplate', name:'voting.newTemp', component:page('school/posts/voting/newTemplate.vue')},
  {path:'/schoolSpace/:schoolId/post/sms', name:'posts.sms', component:page('school/posts/sms/new.vue')},
  {path:'/schoolSpace/:schoolId/post/campus', name:'posts.campus', component:page('school/posts/campus/new.vue')},
  {path:'/schoolSpace/:schoolId/post/announcement', name:'posts.announcement', component:page('school/posts/announcement/new.vue')},
  {path:'/schoolSpace/:schoolId/post/share', name:'posts.share', component:page('school/posts/share/new.vue'),
    children:[
      {path:'templateList',name:"share.templateList", component:page('school/posts/share/templateList.vue')}
    ]
  },
  {path:'/schoolSpace/:schoolId/post/share/newTemplate',name:'share.newTemplate',component:page('school/posts/share/newTemplate.vue')},
  {path:'/schoolSpace/:schoolId/post/bulletinboard', name:'posts.bulletinboard', component:page('school/posts/bulletinboard/new.vue')},
  {path:'/schoolSpace/:schoolId/post/homevisit', name:'posts.homevisit', component:page('school/posts/homevisit/new.vue')},
  {path:'/schoolSpace/:schoolId/post/regname', name:'posts.regname', component:page('school/posts/regname/new.vue')},
  {path:'/schoolSpace/:schoolId/post/vacation', name:'posts.vocation', component:page('school/posts/vacation/student/new.vue')},
  {path:'/schoolSpace/:schoolId/post/homework', name:'posts.homework', component:page('school/posts/homework/index.vue'),
    children:[
      {path:'setRule', name:'homework.setRule',component:page('school/posts/homework/rule.vue')},
    ]
  },
  {path:'/schoolSpace/:schoolId/post/shiftMng', name:'posts.shift', component:page('school/posts/shiftManagement/index.vue')},
  {path:'/schoolSpace/:schoolId/post/safeStudy', name:'posts.safeStudy', component:page('school/posts/safeStudy/index.vue')},
  {path:'/schoolSpace/:schoolId/post/repair', name:'posts.repair', component:page('school/posts/repair/index.vue')},
  {path:'/schoolSpace/:schoolId/post/schoolStory', name:'posts.schoolStory', component:page('school/posts/schoolStory/index.vue')},
  
  {path:'/schoolSpace/:schoolId/post/addComment', name:'posts.comment', component:page('school/posts/comments/addComment.vue')},

  //school application

  {path:'/schoolSpace/:schoolId/application/questionnaire',name:'schoolSpace.applications.quesitonnaire',component:page('school/applications/questionnaire/index.vue')},
  {path:'/schoolSpace/:schoolId/application/voting',name:'schoolSpace.applications.voting',component:page('school/applications/voting/index.vue')},
  {path:'/schoolSpace/:schoolId/application/sms',name:'schoolSpace.applications.sms',component:page('school/applications/sms/index.vue')},
  {path:'/schoolSpace/:schoolId/application/campus',name:'schoolSpace.applications.campus',component:page('school/applications/campus/index.vue')},
  {path:'/schoolSpace/:schoolId/application/announcement',name:'schoolSpace.applications.announcement',component:page('school/applications/announcement/index.vue')},
  {path:'/schoolSpace/:schoolId/application/share',name:'schoolSpace.applications.share',component:page('school/applications/share/index.vue')},
  {path:'/schoolSpace/:schoolId/application/regName',name:'schoolSpace.applications.regname',component:page('school/applications/regName/index.vue')},
  {path:'/schoolSpace/:schoolId/application/homeVisit',name:'schoolSpace.applications.homeVisit',component:page('school/applications/homeVisit/index.vue')},
  {path:'/schoolSpace/:schoolId/application/homework',name:'schoolSpace.applications.homework',component:page('school/applications/homework/index.vue')},
  {path:'/schoolSpace/:schoolId/application/bulletinboard',name:'schoolSpace.applications.bulletinboard',component:page('school/applications/bulletinboard/index.vue')},
  {path:'/schoolSpace/:schoolId/application/shiftMng',name:'schoolSpace.applications.shiftMng',component:page('school/applications/shiftMng/index.vue')},
  {path:'/schoolSpace/:schoolId/application/safeStudy',name:'schoolSpace.applications.safeStudy',component:page('school/applications/safeStudy/index.vue')},
  {path:'/schoolSpace/:schoolId/application/repairData',name:'schoolSpace.applications.repair',component:page('school/applications/repair/index.vue')},
  {path:'/schoolSpace/:schoolId/application/schoolStory',name:'schoolSpace.applications.schoolStory',component:page('school/applications/schoolStory/index.vue')},

    //school member
  {path:'/schoolSpace/:schoolId/member/add',name:'schoolSpace.addMember',component:page('member/addMember.vue')},
  {path:'/schoolSpace/:schoolId/member/invite',name:'schoolSpace.inviteMember',component:page('member/inviteMember.vue')},
  {path:'/schoolSpace/:schoolId/member/:userId/profile',name:'schoolSpace.memProfile',component:page('member/memProfile.vue')},
  {path:'/schoolSpace/:schoolId/member/appliMember',name:'schoolSpace.appliMember',component:page('member/application.vue')},
  {path:'/schoolSpace/:schoolId/member/groupMember',name:'schoolSpace.groupMember',component:page('member/groupMember.vue')},
  {path:'/schoolSpace/:schoolId/member/seatMember',name:'schoolSpace.seatMember',component:page('member/seatMember.vue')},
  {path:'/schoolSpace/:schoolId/member/studentIdMember',name:'schoolSpace.studentIdMember',component:page('member/studentIdMember.vue')},

  //classSpace
  {
    path:'/classSpace/:schoolId/:gradeId/:lessonId', name:'classSpace', component: page('class/classSpace.vue'), redirect:{name:'classSpace.news'},
    children:[
      {path:'news', name:'classSpace.news',component:page('class/news.vue')},
      {path:'application', name:'classSpace.application',component:page('class/application.vue')},
      {path:'member', name:'classSpace.member',component:page('class/member.vue')},
    ]
  },
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post', name:'classSpace.post', component:page('class/posts/index.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/questionnaire',name:'posts.Cquestionnaire', component:page('class/posts/questionnaire/index.vue'),
    children:[
      {path:'single', name:"Cquestionnaire.single", component:page('class/posts/questionnaire/single.vue')},
      {path:'multi', name:"Cquestionnaire.multi", component:page('class/posts/questionnaire/multi.vue')},
      {path:'questionAnswer', name:"Cquestionnaire.questionAnswer", component:page('class/posts/questionnaire/questionAnswer.vue')},
      {path:'statistics', name:"Cquestionnaire.statistics", component:page('class/posts/questionnaire/statistics.vue')},
      {path:'scoring', name:"Cquestionnaire.scoring", component:page('class/posts/questionnaire/scoring.vue')},
      {path:'tmeplate', name:"Cquestionnaire.templateList", component:page('class/posts/questionnaire/templateList.vue'),}
    ]
  },
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/newTemplate', name:"Cquestionnaire.templateNew", component:page('class/posts/questionnaire/newTemplate.vue'),
    children:[
      {path:'single',name:'CquestionnaireTemplate.single',component:page('class/posts/questionnaire/single.vue')},
      {path:'multi',name:'CquestionnaireTemplate.multi',component:page('class/posts/questionnaire/multi.vue')},
      {path:'questionAnswer',name:'CquestionnaireTemplate.questionAnswer',component:page('class/posts/questionnaire/questionAnswer.vue')},
      {path:'statistics',name:'CquestionnaireTemplate.statistics',component:page('class/posts/questionnaire/statistics.vue')},
      {path:'scoring',name:'CquestionnaireTemplate.scoring',component:page('class/posts/questionnaire/scoring.vue')}
    ]
  },
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/voting', name:'posts.Cvoting', component:page('class/posts/voting/new.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/homework', name:'posts.Chomework', component:page('class/posts/homework/index.vue'),
    children:[
      {path:'setRule', name:'Chomework.setRule',component:page('class/posts/homework/rule.vue')},
    ]
  },
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/homevisit', name:'posts.Chomevisit', component:page('class/posts/homevisit/new.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/notification', name:'posts.Cnotification', component:page('class/posts/notification/new.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/evaluation', name:'posts.Cevaluation', component:page('class/posts/evaluation/new.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/recognition', name:'posts.Crecognition', component:page('class/posts/recognition/new.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/album', name:'posts.Calbum', component:page('class/posts/album/new.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/file', name:'posts.Cfile', component:page('class/posts/file/new.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/classStory', name:'posts.classStory', component:page('class/posts/classStory/index.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/interClassStory', name:'posts.interClassStory', component:page('class/posts/interClassStory/index.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/share', name:'posts.Cshare', component:page('class/posts/share/new.vue'),
    children:[
      {path:'templateList',name:"share.CtemplateList", component:page('class/posts/share/templateList.vue')}
    ]
  },
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/share/newTemplate',name:'share.CnewTemplate',component:page('class/posts/share/newTemplate.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/regName',name:'posts.CregName',component:page('class/posts/regname/new.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/regName',name:'posts.Cshare',component:page('class/posts/share/new.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/anouncement',name:'posts.Cannouncement',component:page('class/posts/announcement/new.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/safeStudy',name:'posts.CsafeStudy',component:page('class/posts/safeStudy/index.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/vacation',name:'posts.Cvacation',component:page('class/posts/vacation/student/new.vue')},
  //class member  
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/member/add',name:'classSpace.addMember',component:page('member/addMember.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/member/invite',name:'classSpace.inviteMember',component:page('member/inviteMember.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/member/remove',name:'classSpace.removeMember',component:page('member/removeMember.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/member/:userId/profile',name:'classSpace.memProfile',component:page('member/memProfile.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/member/appliMember',name:'classSpace.appliMember',component:page('member/application.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/member/club',name:'classSpace.club',component:page('member/club.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/member/club/new',name:'member.newClub',component:page('member/newClub.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/member/contact',name:'classSpace.contact',component:page('member/contacts.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/member/seatMember',name:'classSpace.seatMember',component:page('member/seatMember.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/member/studentIdMember',name:'classSpace.studentIdMember',component:page('member/studentIdMember.vue')},

  //vacation
  // {path:'/schoolspace/:id/post/vacation/student', name:'posts.vacationStudent', component:page('school/posts/vacation/student/new.vue')},
  {path:'/admin/vacation/teacher', name:'posts.vacationTeacher', component:page('class/posts/vacation/teacher/new.vue')},
  {path:'/admin/vacation/teacher/:vId/reply', name:'posts.vacationTeacherReply', component:page('class/posts/vacation/teacher/reply.vue')},

  //attendance
  {path:'/admin/attendance/index', name:'posts.attendance', component:page('admin/attendance/index.vue')},
  {path:'/admin/attendance/lesson', name:'posts.attendance.lesson', component:page('admin/attendance/lesson.vue')},
  {path:'/admin/attendance/check', name:'posts.attendance.check', component:page('admin/attendance/check.vue')},
  {path:'/admin/attendance/vacation', name:'posts.attendance.vacation', component:page('admin/attendance/vacation.vue')},
  {path:'/admin/attendance/statistics', name:'posts.attendance.statistics', component:page('admin/attendance/statistics.vue')},

  //classPostDetail
  {path:'/schoolSpace/:schoolId/:gradeId/:lessonId/detail', name:"schoolSpace.detail", component:page('details/index.vue'),
    children:[
      {path:'questionnaire', name:'details.classQuesionnaire', component:page('details/questionnaire/index.vue'),
        children:[
          {path:'answerUsers',name:'details.questionnaireUsers',component:page('details/questionnaire/answerUserList.vue')}
        ]
      },
      {path:'voting', name:'details.classVoting', component:page('details/voting/index.vue'),
        children:[
          {path:'answerUsers', name:'details.votingUsers', component:page('details/voting/answerUserList.vue')}
        ]
      },
      {path:'classHomeVisit', name:'details.classHomeVisit', component:page('details/homeVisit/index.vue')},
      {path:'classHomework', name:'details.classHomework', component:page('details/homework/index.vue'),
        children:[
          {path:'offlineTeacher', name:'details.homeworkofflineTeacher', component:page('details/homework/offlineTeacher.vue')},
          {path:'offlineStudent', name:'details.homeworkofflineStudent', component:page('details/homework/offlineStudent.vue')},
          {path:'onlineTeacher', name:'details.homeworkonlineTeacher', component:page('details/homework/onlineTeacher.vue'),
            children:[
              {path:':userId',name:'details.homworkResult.onlineTeacher.selUser', component:page('details/homework/onlineTeacherCheck.vue')}
            ]
          },
          {path:'onlineStudent', name:'details.homeworkonlineStudent', component:page('details/homework/onlineStudent.vue')},
          {path:'testTeacher', name:'details.homeworktestTeacher', component:page('details/homework/testTeacher.vue')},
          {path:'testStudent', name:'details.homeworktestStudent', component:page('details/homework/testStudent.vue')},
        ]
      },
      {path:'homeworkResult',name:'details.homeworkResult',component:page('details/homeworkResult/index.vue'),
        children:[
          {path:'onlineTeacher',name:'details.homeworkResult.onlineTeacher',component:page('details/homeworkResult/onlineTeacher.vue')},
          {path:'onlineStudent',name:'details.homeworkResult.onlineStudent',component:page('details/homeworkResult/onlineStudent.vue')},
        ]
      },
      {path:'classNotification', name:'details.classNotification', component:page('details/notification/index.vue')},
      {path:'classEvaluation', name:'details.classEvaluation', component:page('details/evaluation/index.vue')},
      {path:'classRecognition', name:'details.classRecognition', component:page('details/recognition/index.vue')},
      {path:'classStory', name:'details.classStory', component:page('details/classStory/index.vue')},
      {path:'interClassStory', name:'details.interClassStory', component:page('details/interClassStory/index.vue')},
    ]
  },

  //class application
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/application/questionnaire',name:'classSpace.applications.quesitonnaire',component:page('class/applications/questionnaire/index.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/application/voting',name:'classSpace.applications.voting',component:page('class/applications/voting/index.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/application/homework',name:'classSpace.applications.homework',component:page('class/applications/homework/index.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/application/classStory',name:'classSpace.applications.classStory',component:page('class/applications/classStory/index.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/application/interClassStory',name:'classSpace.applications.interClassStory',component:page('class/applications/interClassStory/index.vue')},

  //manage guest
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/application/manageGuests', name:'classSpace.manageGuests', component:page('class/applications/safety/manageGuests/index.vue')},
  //return team
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/application/returnTeam', name:'classSpace.returnTeam', component:page('class/applications/safety/returnTeam/index.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/application/returnTeam/new', name:'classSpace.newReturnTeam', component:page('class/applications/safety/returnTeam/new.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/application/returnTeam/detail', name:'classSpace.detailReturnTeam', component:page('class/applications/safety/returnTeam/detail.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/application/returnTeam/remain', name:'classSpace.remainReturnTeam', component:page('class/applications/safety/returnTeam/remain.vue')},

  //addMember
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/addMember', name:'classSpace.addMemberName', component:page('class/addMember.vue')},


  //setting
  { path: '/settings',
    component: page('settings/index.vue'),
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: page('settings/profile.vue') },
      { path: 'password', name: 'settings.password', component: page('settings/password.vue') }
    ] },
  
  //fence
  {
    path:'/fence',name:'fence.index',component:page('fence/index.vue')
  },

  //test
  {path:'/testWeather',name:'api.tests',component:page('testApi/weather.vue')},

  { path: '*', component: page('errors/404.vue') }
]
