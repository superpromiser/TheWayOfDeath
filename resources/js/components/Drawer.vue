<template>
  <v-navigation-drawer
    v-model="drawer"
    width="260"
    @input="changedStatusToggle"
    app
    dark
    class="drawer-bg"
    :permanent="!$vuetify.breakpoint.smAndDown"
  > 
    <template v-slot:prepend>
      <v-toolbar
        color="primary-bg"
        height="74"
        >
        <v-toolbar-title class="d-flex align-center pl-4">
          <img :src="`${baseUrl}/asset/img/logo.png`" alt="Logo" class="logo-img">
        </v-toolbar-title>

        <v-spacer></v-spacer>

      </v-toolbar>
    </template>
    <!-------------User Info--------------->
    <v-list-item class="pa-2 pl-5" color="blue accent-2">
      <v-list-item-avatar>
        <v-avatar
          color="blue accent-3"
          size="40"
          >
          <img v-if="user.avatar !== '/'" :src="`${baseUrl}${user.avatar}`" :alt="user? user.name[0] : ''" />
          <span v-else class="white--text headline"> {{user? user.name[0] : ''}}</span>
        </v-avatar>
      </v-list-item-avatar>
      <v-list-item-title>{{user? user.name : ''}}</v-list-item-title>
    </v-list-item>
    <!-------------User Info--------------->
    <v-divider></v-divider>
    <!----------------Menu------------------>
    <v-list>
      <v-list-group
        active-class="header-active"
        prepend-icon="mdi-cog-outline"
        v-if="user.roleId == 1 || user.roleId == 2 || user.roleId == 3 || user.roleId == 7"
      >
        <template v-slot:activator>
          <v-list-item-title v-if="user.roleId == 2">学校管理</v-list-item-title>
          <v-list-item-title v-else-if="user.roleId == 1">系统设置</v-list-item-title>
          <v-list-item-title v-else-if="user.roleId == 3">考勤管理</v-list-item-title>
          <v-list-item-title v-else-if="user.roleId == 7">考勤管理</v-list-item-title>
        </template>
          <v-list-item
            active-class="sub-header-active"

            link
            to="/admin/userlist"
            v-if="user.role.id == 2"
            >
            <v-list-item-title class="ml-9">名单</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-account-group</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item
            active-class="sub-header-active"
            link
            to="/admin/assignRole"
            v-if="user.role.id == 1"
            >
            <v-list-item-title class="ml-9">角色</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-account-box-multiple</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item
            active-class="sub-header-active"
            link
            to="/admin/school"
            v-if="user.role.id == 1"
            >
            <v-list-item-title class="ml-9">学校</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-school</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item
            active-class="sub-header-active"
            link
            to="/admin/grade"
            v-if="user.role.id == 1"
            >
            <v-list-item-title class="ml-9">年级</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-medal</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item
            active-class="sub-header-active"
            link
            to="/admin/class"
            v-if="user.role.id == 1"
            >
            <v-list-item-title class="ml-9">班级</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-google-classroom</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list class="py-0" v-if="user.role.id == 2">
            <v-list-group  active-class="header-active">
            <template v-slot:activator>
              <v-list-item-title class="ml-9">课程维护</v-list-item-title>
            </template>
              <v-list-item
                active-class="sub-header-active"
                link
                to="/admin/schedule"
                >
                <v-list-item-title class="ml-16">课程维护</v-list-item-title>
                <v-list-item-icon>
                  <v-icon>mdi-calendar-month</v-icon>
                </v-list-item-icon>
              </v-list-item>
              <v-list-item
                active-class="sub-header-active"
                link
                to="/admin/scheduleTeacher"
                >
                <v-list-item-title class="ml-16">任课教师</v-list-item-title>
                <v-list-item-icon>
                  <v-icon>mdi-calendar-month</v-icon>
                </v-list-item-icon>
              </v-list-item>
              <v-list-item
                active-class="sub-header-active"
                link
                to="/admin/scheduleSetting"
                >
                <v-list-item-title class="ml-16">课程维护</v-list-item-title>
                <v-list-item-icon>
                  <v-icon>mdi-calendar-month</v-icon>
                </v-list-item-icon>
              </v-list-item>
              
            </v-list-group>
          </v-list>
          <v-list class="py-0" v-if="user.role.id == 2 || user.role.id == 3 || user.role.id == 7">
            <v-list-group  active-class="header-active">
              <template v-slot:activator>
                <v-list-item-title class="ml-9">考勤</v-list-item-title>
              </template>
              <v-list-item
                active-class="sub-header-active"
                link
                to="/admin/attendance/index"
                >
                <v-list-item-title class="ml-16">进离校</v-list-item-title>
                <v-list-item-icon>
                  <v-icon>mdi-account-clock </v-icon>
                </v-list-item-icon>
              </v-list-item>
              <v-list-item
                active-class="sub-header-active"
                link
                to="/admin/attendance/lesson"
                >
                <v-list-item-title class="ml-16">课堂考勤</v-list-item-title>
                <v-list-item-icon>
                 <v-icon>mdi-badge-account  </v-icon>
                </v-list-item-icon>
              </v-list-item>
              <v-list-item
                active-class="sub-header-active"
                link
                to="/admin/attendance/check"
                >
                <v-list-item-title class="ml-16">晨午检</v-list-item-title>
                <v-list-item-icon>
                  <v-icon>mdi-account-search </v-icon>
                </v-list-item-icon>
              </v-list-item>
              <v-list-item
                active-class="sub-header-active"
                link
                to="/admin/attendance/vacation"
                >
                <v-list-item-title class="ml-16">请假</v-list-item-title>
                <v-list-item-icon>
                  <v-icon>mdi-check-decagram-outline </v-icon>
                </v-list-item-icon>
              </v-list-item>
              <v-list-item
                active-class="sub-header-active"
                link
                to="/admin/attendance/statistics"
                >
                <v-list-item-title class="ml-16">统计</v-list-item-title>
                <v-list-item-icon>
                  <v-icon>mdi-hexagon-slice-4  </v-icon>
                </v-list-item-icon>
              </v-list-item>
            </v-list-group>
          </v-list>
      </v-list-group>
      <v-list-group active-class="header-active" prepend-icon="mdi-school" v-for="(school, indexOfSchool) in mySchoolList" :key="indexOfSchool">
        <template v-slot:activator>
          <v-list-item-title>{{school.schoolName}}</v-list-item-title>
        </template>
        <v-list-item
          :class="{'custom-header-active':activeSchool && school.id == currentPath.params.schoolId}"
          class="custom-header"
          link
          :to="{name:'schoolSpace',params:{schoolId:school.id}}"
          >
          <v-list-item-title class="ml-9">学校空间</v-list-item-title>
          <v-list-item-icon>
            <v-icon>mdi-cast-education</v-icon>
          </v-list-item-icon>
        </v-list-item>
        <v-list class="py-0">
            <v-list-group
              active-class="header-active"
              v-for="(grade, indexOfGrade) in school.grades" :key="indexOfGrade"
            >
              <template v-slot:activator>
                <v-list-item-title class="ml-9">{{grade.gradeName}}</v-list-item-title>
              </template>
              <v-list-item
                :class="{'custom-header-active':activeLesson && lesson.id == currentPath.params.lessonId}"
                v-for="(lesson, index) in grade.lessons" :key="index"
                link
                class="custom-header"
                :to="{name:'classSpace',params:{schoolId:school.id,gradeId:grade.id,lessonId:lesson.id}}"
                >
                <v-list-item-title class="ml-16">{{lesson.lessonName}}</v-list-item-title>
                <v-list-item-icon>
                  <v-icon>mdi-google-classroom</v-icon>
                </v-list-item-icon>
              </v-list-item>
            </v-list-group>
          </v-list>
      </v-list-group>
      <v-list-item
        active-class="sub-header-active" link to="/home">
        <v-list-item-icon>
          <v-icon>mdi-home</v-icon>
        </v-list-item-icon>

        <v-list-item-title>{{lang.home}}</v-list-item-title>
      </v-list-item>
      <v-list-item
        active-class="sub-header-active" link to="/chat">
        <v-list-item-icon>
          <v-icon>mdi-chat-processing-outline</v-icon>
        </v-list-item-icon>

        <v-list-item-title>即时通讯</v-list-item-title>
      </v-list-item>
      <v-list-item
        active-class="sub-header-active" link to="/fence">
        <v-list-item-icon>
          <v-icon>mdi-map</v-icon>
        </v-list-item-icon>

        <v-list-item-title>地图</v-list-item-title>
      </v-list-item>
      <v-list-item
        active-class="sub-header-active" @click="logout" v-if="$isMobile()">
        <v-list-item-icon>
          <v-icon>mdi-logout</v-icon>
        </v-list-item-icon>

        <v-list-item-title>退出</v-list-item-title>
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
import { mapGetters, } from 'vuex'
import lang from '~/helper/lang.json'
export default {
  name: 'DefaultDrawer',

  components: {
    
  },
  
  data: () => ({
    admins: [
      ['Management', 'mdi-account-multiple-outline'],
      ['Settings', 'mdi-cog-outline'],
    ],
    baseUrl: window.Laravel.base_url,
    lang,
    classData : null,
    classItemList : [],
    mySchoolList:[],
    activeSchool:false,
    activeLesson:false
  }),

  computed: {
    ...mapGetters({
      mini : 'toggledrawer/mini',
      user : 'auth/user',
      schoolData : 'schooltree/schoolData',
      memberData : 'schooltree/memberData',
      // drawer : 'toggledrawer/drawer'
    }),
    drawer: {
      get() {
        return this.$store.state.toggledrawer.drawer;
      },
      set(value) {
        this.$store.dispatch('toggledrawer/turnDrawer', {
          drawer: value,
        })
      }
    },
    currentPath(){
      return this.$route
    }
    // ...mapActions(['toggledrawer/turnDrawer'])
  },
  watch:{
    currentPath:{
      handler(val){
        this.activeSchool = false
        this.activeLesson = false
        let path = val.path.split('/')
        if(path[1] == 'schoolSpace'){
          this.activeSchool = true
        }else if(path[1] == 'classSpace'){
          this.activeLesson = true
        }
      },
      deeper:true
    }
  },
  created() {
    console.log("this.schoolData",this.schoolData)
    let path = this.currentPath.path.split('/')
    if(path[1] == 'schoolSpace'){
      this.activeSchool = true
    }else if(path[1] == 'classSpace'){
      this.activeLesson = true
    }
    if(this.user.roleId !== 1){
      this.schoolData.map(schoolItem=>{
        console.log(schoolItem)
        if(this.user.schoolId == schoolItem.id){
          this.mySchoolList.push(schoolItem)
        }
      })
    }else{
      this.mySchoolList = this.schoolData
    }
  },

  methods:{
    changedStatusToggle(val){
      if(val == false){
        this.$store.dispatch('toggledrawer/turnDrawer', {
          drawer: val,
        })
      }
    },

    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')
      // Redirect to login.
      this.$router.push({ name: 'login' })
    },
    
  }
}
</script>

<style lang="sass">
#default-drawer
  .v-list-item
    margin-bottom: 8px

  .v-list-item::before,
  .v-list-item::after
    display: none

  .v-list-group__header__prepend-icon,
  .v-list-item__icon
    margin-top: 12px
    margin-bottom: 12px
    margin-left: 4px

  &.v-navigation-drawer--mini-variant
    .v-list-item
      justify-content: flex-start !important
</style>
