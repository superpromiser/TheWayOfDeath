<template>
  <v-container>
      <v-row v-for="(itemGroup, i) in contentItemList" :key="i" class="ma-0">
          <v-col cols="12">
              <v-chip
                  class="ma-2 px-5"
                  color="primary"
                  outlined
              >
                  <v-icon left>
                      {{itemGroup.icon}}
                  </v-icon>
                  {{itemGroup.title}}
              </v-chip>
          </v-col>
          <v-col v-for="(item, j) in itemGroup.items" :key="j" cols="12" sm="6" md="4" lg="3">
              <ApplicationItem :item="item" @selected="selectedPost"/>
          </v-col>
      </v-row>
  </v-container>
</template>

<script>
import lang from '~/helper/lang.json'
import ApplicationItem from '~/components/applicationItem'
import {getDashboardData} from '~/api/tablet'
export default {
  middleware:'auth',
  components:{
    ApplicationItem,
  },
  data:() => ({
    lang,
    
    contentItemList : [
            {
                title:"智能考勤",//지능출근
                icon:"mdi-calendar-month-outline",
                items:[
                    // {
                    //     color:"#3EBBE8",
                    //     title:"课程维护",//수업유지
                    //     imgUrl:"/asset/img/newIcon/tools.png",
                    //     path:"admin.schedule"
                    // },
                    // {
                    //     color:"#3EBBE8",
                    //     title:"请假单",//휴가신청
                    //     imgUrl:"/asset/img/newIcon/颜色填充 2.png",
                    //     path:"posts.vocation"
                    // },
                    {
                        color:"#3EBBE8",
                        title:"请假审批",//휴가심사
                        imgUrl:"/asset/img/newIcon/审批.png",
                        path:"posts.vocation"
                    },
                    {
                        color:"#3EBBE8",
                        title:"考勤",//출근
                        imgUrl:"/asset/img/newIcon/考勤.png",
                        path:"posts.attendance"
                    },
                    {
                        color:"#3EBBE8",
                        title:"课程表",//시간표
                        imgUrl:"/asset/img/newIcon/calendar.png",
                        path:"admin.scheduleClass"
                    },
                ]
            },
            {
                title:"基础沟通",//기초의사소통
                icon:"mdi-message-text",
                items:[
                    {
                        color:"#B673E0",
                        title:"通讯录",//주소록
                        imgUrl:"/asset/img/newIcon/address book.png",
                        path:"classSpace.member"
                    },
                    {
                        color:"#B673E0",
                        title:"文件",//문건
                        imgUrl:"/asset/img/newIcon/paper clip.png",
                        path:"posts.Cfile"
                    },
                    // {
                    //     color:"#B673E0",
                    //     title:"话题",//화제
                    //     imgUrl:"/asset/img/newIcon/话题.png",
                    //     path:"posts."
                    // },
                    // {
                    //     color:"#B673E0",
                    //     title:"分享",//공유
                    //     imgUrl:"/asset/img/newIcon/图层 3.png",
                    //     path:"posts.share"
                    // },
                    {
                        color:"#B673E0",
                        title:"问卷",//설문
                        imgUrl:"/asset/img/newIcon/颜色填充 1.png",
                        path:"classSpace.applications.quesitonnaire"
                    },
                    {
                        color:"#B673E0",
                        title:"投票",//투표
                        imgUrl:"/asset/img/newIcon/graph chart 3.png",
                        path:"classSpace.applications.voting"
                    },
                    // {
                    //     color:"#B673E0",
                    //     title:"报名",//이름등록
                    //     imgUrl:"/asset/img/newIcon/Shape 18.png",
                    //     path:"posts.regname"
                    // },
                    // {
                    //     color:"#B673E0",
                    //     title:"短信",//통보문
                    //     imgUrl:"/asset/img/newIcon/短信.png",
                    //     path:"posts.sms"
                    // },
                ]
            },
            {
                title:"校园安全",//교내안전
                icon:"mdi-account-cog-outline",
                items:[
                    {
                        color:"#98BB3A",
                        title:"访客管理",//방문자관리
                        imgUrl:"/asset/img/newIcon/图层 1.png",
                        path:"classSpace.manageGuests"
                    },
                    {
                        color:"#98BB3A",
                        title:"归程队",//귀한팀관리
                        imgUrl:"/asset/img/newIcon/排队数.png",
                        path:"classSpace.returnTeam"
                    },
                    // {
                    //     color:"#98BB3A",
                    //     title:"打卡管理",//카드긋기
                    //     imgUrl:"/asset/img/newIcon/打卡.png",
                    //     path:"posts."
                    // },
                    // {
                    //     color:"#98BB3A",
                    //     title:"交接班",//교대반관리
                    //     imgUrl:"/asset/img/newIcon/交接班.png",
                    //     path:"posts.shift"
                    // },
                    // {
                    //     color:"#98BB3A",
                    //     title:"维修工单",//수리공
                    //     imgUrl:"/asset/img/newIcon/维修.png",
                    //     path:"posts.repair"
                    // },
                    // {
                    //     color:"#98BB3A",
                    //     title:"请假放行",//휴가항행
                    //     imgUrl:"/asset/img/newIcon/图层 2.png",
                    //     path:"posts."
                    // },
                ]
            },
            {
                title:"校园文化",//
                icon:"mdi-lifebuoy",
                items:[
                    // {
                    //     color:"#C95384",
                    //     title:"学生风采",//학생풍모
                    //     imgUrl:"/asset/img/newIcon/graduate.png",
                    //     path:"posts.",

                    // },
                    // {
                    //     color:"#C95384",
                    //     title:"教师风采",//교사풍모
                    //     imgUrl:"/asset/img/newIcon/教师 (1).png",
                    //     path:"posts.",

                    // },
                    // {
                    //     color:"#C95384",
                    //     title:"学校动态",//학교동태
                    //     imgUrl:"/asset/img/newIcon/hourglass.png",
                    //     path:"posts.schoolStory",

                    // },
                    {
                        color:"#C95384",
                        title:"班级动态",//학급동태
                        imgUrl:"/asset/img/newIcon/班级动态 (1).png",
                        path:"classSpace.applications.classStory",

                    },
                    {
                        color:"#C95384",
                        title:"班际动态",//학급별동태
                        imgUrl:"/asset/img/newIcon/动态.png",
                        path:"classSpace.applications.interClassStory",
                    },
                ]
            },
            {
                title:"家校互动",
                icon:"mdi-nfc-tap",
                items:[
                    {
                        color:"#E4BC16",
                        title:"作业",//숙제
                        imgUrl:"/asset/img/newIcon/open book 2.png",
                        path:"posts.Chomework"
                    },
                    // {
                    //     color:"#E4BC16",
                    //     title:"公告",//공시
                    //     imgUrl:"/asset/img/newIcon/megaphone 2.png",
                    //     path:"posts.announcement"
                    // }
                ]
            },
            {
                title:"工具",
                icon:"mdi-hammer-wrench",
                items:[
                    {
                        color:"#DA7042",
                        title:"我的",//프로필
                        imgUrl:"/asset/img/newIcon/我 的.png",
                        path:"profile.list"
                    },
                    // {
                    //     color:"#DA7042",
                    //     title:"话题",//화제
                    //     imgUrl:"/asset/img/newIcon/相册 (1).png",
                    //     path:"posts."
                    // }
                ]
            }
        ]
  }),
  created(){
    //   getDashboardData().then(res=>{
    //       console.log(res.data)
    //   }).catch(err=>{
    //       console.log(err.response)
    //   })
  },
  methods:{
    selectedPost(){

    }
  }
}
</script>

<style>

</style>