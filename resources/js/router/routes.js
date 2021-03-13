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
  {path:'/schoolspace/:id/post/questionnaire', name:'posts.questionnaire', component:page('school/posts/questionnaire/new.vue')},
  
  //Voting
  {path:'/schoolspace/:id/post/voting', name:'posts.voting', component:page('school/posts/voting/new.vue')},
  
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
