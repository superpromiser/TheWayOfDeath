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

  //circle
  { path: '/circle', name: 'circle', component: page('circle/index.vue') },

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
  { path: '/profile', name: 'profile', component: page('profile/index.vue') },

  //Admin
  { path: '/admin/assignRole', name: 'admin.assignRole', component: page('admin/assignRole.vue') },
  { path: '/admin/class', name: 'admin.class', component: page('admin/class.vue') },
  { path: '/admin/grade', name: 'admin.grade', component: page('admin/grade.vue') },
  { path: '/admin/imei', name: 'admin.imei', component: page('admin/imei.vue') },
  { path: '/admin/school', name: 'admin.school', component: page('admin/school.vue') },
  { path: '/admin/school/:id/manager', name: 'admin.manager', component: page('admin/schoolManager.vue'), props:true },
  { path: '/admin/stream', name: 'admin.stream', component: page('admin/stream.vue') },
  { path: '/admin/schedule', name: 'admin.schedule', component: page('admin/schedule.vue') },
  { path: '/admin/schedule/setting', name: 'admin.scheduleSetting', component: page('admin/scheduleSetting.vue')  },
  { path: '/admin/schedule/class', name: 'admin.scheduleClass', component: page('admin/scheduleClass.vue')  },
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
      {path:'application', name:'schoolSpace.application',component:page('school/application.vue')},
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
      {path:'tmeplate', name:"questionnaire.templateList", component:page('school/posts/questionnaire/templateList.vue')},
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
  {path:'/schoolSpace/:schoolId/post/sms', name:'posts.sms', component:page('school/posts/sms/new.vue')},
  {path:'/schoolSpace/:schoolId/post/campus', name:'posts.campus', component:page('school/posts/campus/new.vue')},
  {path:'/schoolSpace/:schoolId/post/announcement', name:'posts.announcement', component:page('school/posts/announcement/new.vue')},
  {path:'/schoolSpace/:schoolId/post/share', name:'posts.share', component:page('school/posts/share/new.vue')},
  {path:'/schoolSpace/:schoolId/post/bulletinboard', name:'posts.bulletinboard', component:page('school/posts/bulletinboard/new.vue')},
  {path:'/schoolSpace/:schoolId/post/homevisit', name:'posts.homevisit', component:page('school/posts/homevisit/new.vue')},
  {path:'/schoolSpace/:schoolId/post/regname', name:'posts.regname', component:page('school/posts/regname/new.vue')},
  {path:'/schoolSpace/:schoolId/post/vacation', name:'posts.vocation', component:page('school/posts/vacation/student/new.vue')},
  {path:'/schoolSpace/:schoolId/post/addComment', name:'posts.comment', component:page('school/posts/comments/addComment.vue')},
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
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/homevisit', name:'posts.Chomevisit', component:page('class/posts/homevisit/new.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/notification', name:'posts.Cnotification', component:page('class/posts/notification/new.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/evaluation', name:'posts.Cevaluation', component:page('class/posts/evaluation/new.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/recognition', name:'posts.Crecognition', component:page('class/posts/recognition/new.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/post/album', name:'posts.Calbum', component:page('class/posts/album/new.vue')},
  //class member  
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/member/add',name:'classSpace.addMember',component:page('member/addMember.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/member/invite',name:'classSpace.inviteMember',component:page('member/inviteMember.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/member/:userId/profile',name:'classSpace.memProfile',component:page('member/memProfile.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/member/appliMember',name:'classSpace.appliMember',component:page('member/application.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/member/club',name:'classSpace.club',component:page('member/club.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/member/seatMember',name:'classSpace.seatMember',component:page('member/seatMember.vue')},
  {path:'/classSpace/:schoolId/:gradeId/:lessonId/member/studentIdMember',name:'classSpace.studentIdMember',component:page('member/studentIdMember.vue')},

  //vacation
  // {path:'/schoolspace/:id/post/vacation/student', name:'posts.vacationStudent', component:page('school/posts/vacation/student/new.vue')},
  {path:'/admin/vacation/teacher', name:'posts.vacationTeacher', component:page('school/posts/vacation/teacher/new.vue')},
  {path:'/admin/vacation/teacher/:vId/reply', name:'posts.vacationTeacherReply', component:page('school/posts/vacation/teacher/reply.vue')},

  //attendance
  {path:'/admin/attendance/index', name:'posts.attendance', component:page('admin/attendance/index.vue')},
  {path:'/admin/attendance/lesson', name:'posts.attendance.lesson', component:page('admin/attendance/lesson.vue')},
  {path:'/admin/attendance/check', name:'posts.attendance.check', component:page('admin/attendance/check.vue')},
  {path:'/admin/attendance/vacation', name:'posts.attendance.vacation', component:page('admin/attendance/vacation.vue')},
  {path:'/admin/attendance/statistics', name:'posts.attendance.statistics', component:page('admin/attendance/statistics.vue')},

  //classPostDetail
  {path:'/schoolspace/:id/class/:gradeId/:classId/postDetail/12', name:'details.classQuesionnaire', component:page('school/details/questionnaire/index.vue')},
  {path:'/schoolspace/:id/class/:gradeId/:classId/postDetail/13', name:'details.classVoting', component:page('school/details/voting/index.vue')},
  {path:'/schoolspace/:id/class/:gradeId/:classId/1postDetail/16', name:'details.classHomeVisit', component:page('school/details/homeVisit/index.vue')},
  {path:'/schoolspace/:id/class/:gradeId/:classId/1postDetail/17', name:'details.classNotification', component:page('school/details/notification/index.vue')},
  {path:'/schoolspace/:id/class/:gradeId/:classId/postDetail/18', name:'details.classEvaluation', component:page('school/details/evaluation/index.vue')},
  {path:'/schoolspace/:id/class/:gradeId/:classId/postDetail/19', name:'details.classRecognition', component:page('school/details/recognition/index.vue')},

  //setting
  { path: '/settings',
    component: page('settings/index.vue'),
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: page('settings/profile.vue') },
      { path: 'password', name: 'settings.password', component: page('settings/password.vue') }
    ] },

  { path: '*', component: page('errors/404.vue') }
]
