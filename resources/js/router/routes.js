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
    path:'/schoolspace/:id',
    component: page('school/schoolSpace.vue'),
    children:[
      {path:'',redirect:{name: 'schoolSpace.news'}},
      {path:'news', name:'schoolSpace.news',component:page('school/news.vue')},
      {path:'application', name:'schoolSpace.application',component:page('school/application.vue')},
      {path:'member', name:'schoolSpace.member',component:page('school/member.vue')},
    ]
  },
  
  //index of Posts
  {path:'/schoolspace/:id/post', name:'schoolSpace.post', component:page('school/posts/index.vue'),
    children:[
    ]
  },

  //Questionnaire
  {path:'/schoolspace/:id/post/questionnaire', name:'posts.questionnaire', component:page('school/posts/questionnaire/index.vue'),
    children:[
      // {path:'', redirect:{name:"questionnaire.new"}},
      // {path:'new',name:'questionnaire.new', component:page('school/posts/questionnaire/new.vue')},
      // {path:'test',name:'questionnaire.test', component:page('school/posts/questionnaire/test.vue')},
      {path:'single', name:"questionnaire.single", component:page('school/posts/questionnaire/single.vue')},
      {path:'multi', name:"questionnaire.multi", component:page('school/posts/questionnaire/multi.vue')},
      {path:'questionAnswer', name:"questionnaire.questionAnswer", component:page('school/posts/questionnaire/questionAnswer.vue')},
      {path:'statistics', name:"questionnaire.statistics", component:page('school/posts/questionnaire/statistics.vue')},
      {path:'scoring', name:"questionnaire.scoring", component:page('school/posts/questionnaire/scoring.vue')},
      {path:'template', name:"questionnaire.template", component:page('school/posts/questionnaire/newTemplate.vue')},
    ]
  },
  
  //Voting
  {path:'/schoolspace/:id/post/voting', name:'posts.voting', component:page('school/posts/voting/new.vue')},

  //SMS
  {path:'/schoolspace/:id/post/sms', name:'posts.sms', component:page('school/posts/sms/new.vue')},

  //Campus
  {path:'/schoolspace/:id/post/campus', name:'posts.campus', component:page('school/posts/campus/new.vue')},

  //vacation
  {path:'/schoolspace/:id/post/vacation/student', name:'posts.vacationStudent', component:page('school/posts/vacation/student/new.vue')},
  {path:'/admin/vacation/teacher', name:'posts.vacationTeacher', component:page('school/posts/vacation/teacher/new.vue')},
  {path:'/admin/vacation/teacher/reply', name:'posts.vacationTeacherReply', component:page('school/posts/vacation/teacher/reply.vue')},

  //attendance
  {path:'/admin/attendance/index', name:'posts.attendance', component:page('admin/attendance/index.vue')},
  {path:'/admin/attendance/lesson', name:'posts.attendance.lesson', component:page('admin/attendance/lesson.vue')},
  {path:'/admin/attendance/check', name:'posts.attendance.check', component:page('admin/attendance/check.vue')},
  {path:'/admin/attendance/vacation', name:'posts.attendance.vacation', component:page('admin/attendance/vacation.vue')},
  {path:'/admin/attendance/statistics', name:'posts.attendance.statistics', component:page('admin/attendance/statistics.vue')},

  //postDetail
  {path:'/schoolspace/:id/postDetail', name:'posts.detail', component:page('school/posts/detail.vue')},
  
  //addComment
  {path:'/schoolspace/:id/post/addComment', name:'posts.comment', component:page('school/posts/comments/addComment.vue')},
   
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
