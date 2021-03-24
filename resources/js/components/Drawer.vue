<template>
  <v-navigation-drawer
    v-model="drawer"
    dark
    width="260"
    @input="changedStatusToggle"
    app
    :permanent="!$vuetify.breakpoint.smAndDown"
  > 
    <template v-slot:prepend>
      <v-toolbar
        color="blue"
        height="74"
        >
        <v-toolbar-title class="d-flex align-center pl-4">
          <img :src="`${baseUrl}/asset/img/logo.png`" alt="Logo" class="logo-img">
        </v-toolbar-title>

        <v-spacer></v-spacer>

      </v-toolbar>
    </template>
    <!-------------User Info--------------->
    <v-list-item class="pa-2" color="blue accent-2">
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
        :value="true"
        prepend-icon="mdi-cog-outline"
        v-if="user.roleId == 1 || user.roleId == 2 || user.roleId == 3"
      >
        <template v-slot:activator>
          <v-list-item-title v-if="user.roleId == 2">学校管理</v-list-item-title>
          <v-list-item-title v-else-if="user.roleId == 1">系统设置</v-list-item-title>
          <v-list-item-title v-else-if="user.roleId == 3">教授管理</v-list-item-title>
        </template>
          <v-list-item
            link
            to="/admin/userlist"
            v-if="user.role.roleName == 'manager'"
            >
            <v-list-item-title>名单</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-account-group</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item
            link
            to="/admin/assignRole"
            v-if="user.role.roleName == 'admin'"
            >
            <v-list-item-title>角色</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-account-box-multiple</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item
            link
            to="/admin/school"
            v-if="user.role.roleName == 'admin'"
            >
            <v-list-item-title>学校</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-school</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item
            link
            to="/admin/grade"
            v-if="user.role.roleName == 'admin'"
            >
            <v-list-item-title>创建年级</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-medal</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item
            link
            to="/admin/class"
            v-if="user.role.roleName == 'admin'"
            >
            <v-list-item-title>班级</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-google-classroom</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item
            link
            to="/admin/schedule"
            v-if="user.role.roleName == 'manager'"
            >
            <v-list-item-title>课程维护</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-calendar-month</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item
            link
            to="/admin/stream"
            v-if="user.role.roleName == 'manager'"
            >
            <v-list-item-title>流媒体设置</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-view-stream</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item
            link
            to="/admin/imei"
            v-if="user.role.roleName == 'manager'"
            >
            <v-list-item-title>IMEI管理</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-sd</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item
            link
            to="/admin/schedule/class"
            v-if="user.role.roleName == 'teacher'"
            >
            <v-list-item-title>课程表管理</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-calendar-month</v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list-item
            link
            to="/admin/vacation/teacher"
            v-if="user.role.roleName == 'teacher'"
            >
            <v-list-item-title>请假审批</v-list-item-title>
            <v-list-item-icon>
              <v-icon>mdi-check-decagram </v-icon>
            </v-list-item-icon>
          </v-list-item>
          <v-list class="py-0">
            <v-list-group 
              :value="true"
            >
            <template v-slot:activator>
              <v-list-item-title>考勤</v-list-item-title>
            </template>
              <v-list-item
                link
                to="/admin/attendance/index"
                >
                <v-list-item-title class="ml-5">进离校</v-list-item-title>
                <v-list-item-icon>
                  <v-icon>mdi-account-clock </v-icon>
                </v-list-item-icon>
              </v-list-item>
              <v-list-item
                link
                to="/admin/attendance/lesson"
                >
                <v-list-item-title class="ml-5">课堂考勤</v-list-item-title>
                <v-list-item-icon>
                 <v-icon>mdi-badge-account  </v-icon>
                </v-list-item-icon>
              </v-list-item>
              <v-list-item
                link
                to="/admin/attendance/check"
                >
                <v-list-item-title class="ml-5">晨午检</v-list-item-title>
                <v-list-item-icon>
                  <v-icon>mdi-account-search </v-icon>
                </v-list-item-icon>
              </v-list-item>
              <v-list-item
                link
                to="/admin/attendance/vacation"
                >
                <v-list-item-title class="ml-5">请假</v-list-item-title>
                <v-list-item-icon>
                  <v-icon>mdi-check-decagram-outline </v-icon>
                </v-list-item-icon>
              </v-list-item>
              <v-list-item
                link
                to="/admin/attendance/statistics"
                >
                <v-list-item-title class="ml-5">统计</v-list-item-title>
                <v-list-item-icon>
                  <v-icon>mdi-hexagon-slice-4  </v-icon>
                </v-list-item-icon>
              </v-list-item>
            </v-list-group>
          </v-list>
      </v-list-group>
      <v-list-group :value="true" prepend-icon="mdi-school" v-for="(school, indexOfSchool) in mySchoolList" :key="indexOfSchool">
        <template v-slot:activator>
          <v-list-item-title>{{school.schoolName}}</v-list-item-title>
        </template>
        <v-list-item
          link
          :to="{name:'schoolSpace',params:{schoolId:school.id}}"
          >
          <v-list-item-title>学校空间</v-list-item-title>
          <v-list-item-icon>
            <v-icon>mdi-cast-education</v-icon>
          </v-list-item-icon>
        </v-list-item>
        <v-list class="py-0">
            <v-list-group
              :value="true"
              v-for="(grade, indexOfGrade) in school.grades" :key="indexOfGrade"
            >
              <template v-slot:activator>
                <v-list-item-title class="ml-5">{{grade.gradeName}}</v-list-item-title>
              </template>
              <v-list-item
                v-for="(lesson, index) in grade.lessons" :key="index"
                link
                :to="{name:'classSpace',params:{schoolId:school.id,gradeId:grade.id,lessonId:lesson.id}}"
                >
                <v-list-item-title class="ml-10">{{lesson.lessonName}}</v-list-item-title>
                <v-list-item-icon>
                  <v-icon>mdi-google-classroom</v-icon>
                </v-list-item-icon>
              </v-list-item>
            </v-list-group>
          </v-list>
      </v-list-group>
      <v-list-item link to="/home">
        <v-list-item-icon>
          <v-icon>mdi-home</v-icon>
        </v-list-item-icon>

        <v-list-item-title>{{lang.home}}</v-list-item-title>
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
  }),

  computed: {
    ...mapGetters({
      mini : 'toggledrawer/mini',
      user : 'auth/user',
      schoolData : 'schooltree/schoolData',
      memberData : 'schooltree/memberData',
      schoolTree : 'schooltree/schoolTree'
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
  
  created() {
    console.log("this.currentPath",this.currentPath)
    console.log("this.schoolData", this.schoolData);
    console.log("this.memberData", this.memberData);
    console.log("this.user", this.user);
    if(this.user.roleId !== 1){
      this.schoolData.map(schoolItem=>{
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
    }
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
