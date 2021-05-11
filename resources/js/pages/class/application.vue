<template>
  <v-container>
      <v-row v-for="(itemGroup, i) in contentItemList" :key="i" class="ma-0">
          <v-col cols="12">
              <v-chip
                  class="ma-2 px-5"
                  color="#7879ff"
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
import {mapGetters} from 'vuex'
export default {
  middleware:'auth',
  components:{
    ApplicationItem,
  },
  data:() => ({
    lang,
    contentItemList : [],
    adminItem:[
        {
            title:"基础沟通",//기초의사소통
            icon:"mdi-message-text",
            items:[
                {
                    color:"#B673E0",
                    title:"分享",//공유
                    imgUrl:"/asset/img/newIcon/share1.png",
                    path:"classSpace.applications.share"
                },
                {
                    color:"#B673E0",
                    title:"问卷",//설문
                    imgUrl:"/asset/img/newIcon/questionnaire.png",
                    path:"classSpace.applications.questionnaire"
                },
                {
                    color:"#B673E0",
                    title:"投票",//투표
                    imgUrl:"/asset/img/newIcon/voting.png",
                    path:"classSpace.applications.voting"
                },
                {
                    color:"#B673E0",
                    title:"报名",//이름등록
                    imgUrl:"/asset/img/newIcon/regName.png",
                    path:"classSpace.applications.regname"
                },
            ]
        },
        {
            title:"家校互动",//가교호상활동
            icon:"mdi-nfc-tap",
            items:[
                
                {
                    color:"#E4BC16",
                    title:"分享",//공유
                    imgUrl:"/asset/img/newIcon/share2.png",
                    path:"classSpace.applications.share"
                },
                {
                    color:"#E4BC16",
                    title:"公告",//공시
                    imgUrl:"/asset/img/newIcon/announcement.png",
                    path:"classSpace.applications.announcement"
                },
                {
                    color:"#E4BC16",
                    title:"作业",//숙제
                    imgUrl:"/asset/img/newIcon/homework.png",
                    path:"classSpace.applications.homework"
                },
            ]
        },
        {
            title:"校园安全",//교내안전
            icon:"mdi-account-cog-outline",
            items:[
                {
                    color:"#98BB3A",
                    title:"维修工单",//수리공
                    imgUrl:"/asset/img/newIcon/repair.png",
                    path:"classSpace.applications.repair"
                },
                {
                    color:"#98BB3A",
                    title:"安全教育",//안전교육
                    imgUrl:"/asset/img/newIcon/safeStudy.png",
                    path:"classSpace.applications.safeStudy"
                },
            ]
        },
        {
            title:"校园文化",//
            icon:"mdi-lifebuoy",
            items:[
                {
                    color:"#C95384",
                    title:"班级动态",//학급동태
                    imgUrl:"/asset/img/newIcon/classStory.png",
                    path:"classSpace.applications.classStory",

                },
                {
                    color:"#C95384",
                    title:"班际动态",//학급별동태
                    imgUrl:"/asset/img/newIcon/interClassStory.png",
                    path:"classSpace.applications.interClassStory",
                },
                {
                    color:"#C95384",
                    title:"表彰",//영예표창
                    imgUrl:"/asset/img/newIcon/recognition.png",
                    path:"classSpace.applications.recognition",

                },
            ]
        },
    ],
    managerItem:[
        {
            title:"基础沟通",//기초의사소통
            icon:"mdi-message-text",
            items:[
               
                {
                    color:"#B673E0",
                    title:"分享",//공유
                    imgUrl:"/asset/img/newIcon/share1.png",
                    path:"classSpace.applications.share"
                },
                {
                    color:"#B673E0",
                    title:"问卷",//설문
                    imgUrl:"/asset/img/newIcon/questionnaire.png",
                    path:"classSpace.applications.questionnaire"
                },
                {
                    color:"#B673E0",
                    title:"投票",//투표
                    imgUrl:"/asset/img/newIcon/voting.png",
                    path:"classSpace.applications.voting"
                },
                {
                    color:"#B673E0",
                    title:"报名",//이름등록
                    imgUrl:"/asset/img/newIcon/regName.png",
                    path:"classSpace.applications.regname"
                },
            ]
        },
        {
            title:"家校互动",//가교호상활동
            icon:"mdi-nfc-tap",
            items:[
                
                {
                    color:"#E4BC16",
                    title:"分享",//공유
                    imgUrl:"/asset/img/newIcon/share2.png",
                    path:"classSpace.applications.share"
                },
                {
                    color:"#E4BC16",
                    title:"公告",//공시
                    imgUrl:"/asset/img/newIcon/announcement.png",
                    path:"classSpace.applications.announcement"
                },
                {
                    color:"#E4BC16",
                    title:"作业",//숙제
                    imgUrl:"/asset/img/newIcon/homework.png",
                    path:"classSpace.applications.homework"
                },
            ]
        },
        {
            title:"校园安全",//교내안전
            icon:"mdi-account-cog-outline",
            items:[
                {
                    color:"#98BB3A",
                    title:"维修工单",//수리공
                    imgUrl:"/asset/img/newIcon/repair.png",
                    path:"classSpace.applications.repair"
                },
                {
                    color:"#98BB3A",
                    title:"安全教育",//안전교육
                    imgUrl:"/asset/img/newIcon/safeStudy.png",
                    path:"classSpace.applications.safeStudy"
                },
            ]
        },
        {
            title:"校园文化",//
            icon:"mdi-lifebuoy",
            items:[
                {
                    color:"#C95384",
                    title:"班级动态",//학급동태
                    imgUrl:"/asset/img/newIcon/classStory.png",
                    path:"classSpace.applications.classStory",

                },
                {
                    color:"#C95384",
                    title:"班际动态",//학급별동태
                    imgUrl:"/asset/img/newIcon/interClassStory.png",
                    path:"classSpace.applications.interClassStory",
                },
                {
                    color:"#C95384",
                    title:"表彰",//영예표창
                    imgUrl:"/asset/img/newIcon/recognition.png",
                    path:"classSpace.applications.recognition",

                },
            ]
        },
    ],
    teacherItem:[
        {
            title:"智能考勤",//지능출근
            icon:"mdi-calendar-month-outline",
            items:[
                {
                    color:"#3EBBE8",
                    title:"请假审批",//휴가심사
                    imgUrl:"/asset/img/newIcon/vocationReply.png",
                    path:"classSpace.applications.vacation"
                },
                {
                    color:"#3EBBE8",
                    title:"课程表",//시간표
                    imgUrl:"/asset/img/newIcon/scheduleClass.png",
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
                    title:"分享",//공유
                    imgUrl:"/asset/img/newIcon/share1.png",
                    path:"classSpace.applications.share"
                },
                {
                    color:"#B673E0",
                    title:"问卷",//설문
                    imgUrl:"/asset/img/newIcon/questionnaire.png",
                    path:"classSpace.applications.questionnaire"
                },
                {
                    color:"#B673E0",
                    title:"投票",//투표
                    imgUrl:"/asset/img/newIcon/voting.png",
                    path:"classSpace.applications.voting"
                },
                {
                    color:"#B673E0",
                    title:"报名",//이름등록
                    imgUrl:"/asset/img/newIcon/regName.png",
                    path:"classSpace.applications.regname"
                },
            ]
        },
        {
            title:"家校互动",//가교호상활동
            icon:"mdi-nfc-tap",
            items:[
                
                {
                    color:"#E4BC16",
                    title:"分享",//공유
                    imgUrl:"/asset/img/newIcon/share2.png",
                    path:"classSpace.applications.share"
                },
                {
                    color:"#E4BC16",
                    title:"公告",//공시
                    imgUrl:"/asset/img/newIcon/announcement.png",
                    path:"classSpace.applications.announcement"
                },
                {
                    color:"#E4BC16",
                    title:"作业",//숙제
                    imgUrl:"/asset/img/newIcon/homework.png",
                    path:"classSpace.applications.homework"
                },
            ]
        },
        {
            title:"校园安全",//교내안전
            icon:"mdi-account-cog-outline",
            items:[
                {
                    color:"#98BB3A",
                    title:"访客管理",//방문자관리
                    imgUrl:"/asset/img/newIcon/manageGuests.png",
                    path:"classSpace.manageGuests"
                },
                {
                    color:"#98BB3A",
                    title:"归程队",//귀한팀관리
                    imgUrl:"/asset/img/newIcon/returnTeam.png",
                    path:"classSpace.returnTeam"
                },
                {
                    color:"#98BB3A",
                    title:"维修工单",//수리공
                    imgUrl:"/asset/img/newIcon/repair.png",
                    path:"classSpace.applications.repair"
                },
                {
                    color:"#98BB3A",
                    title:"安全教育",//안전교육
                    imgUrl:"/asset/img/newIcon/safeStudy.png",
                    path:"classSpace.applications.safeStudy"
                },
            ]
        },
        {
            title:"校园文化",//
            icon:"mdi-lifebuoy",
            items:[
                {
                    color:"#C95384",
                    title:"班级动态",//학급동태
                    imgUrl:"/asset/img/newIcon/classStory.png",
                    path:"classSpace.applications.classStory",

                },
                {
                    color:"#C95384",
                    title:"班际动态",//학급별동태
                    imgUrl:"/asset/img/newIcon/interClassStory.png",
                    path:"classSpace.applications.interClassStory",
                },
                {
                    color:"#C95384",
                    title:"表彰",//영예표창
                    imgUrl:"/asset/img/newIcon/recognition.png",
                    path:"classSpace.applications.recognition",

                },
            ]
        },
    ],
    parentItem:[
        // {
        //     title:"智能考勤",//지능출근
        //     icon:"mdi-calendar-month-outline",
        //     items:[
        //         {
        //             color:"#3EBBE8",
        //             title:"课程表",//시간표
        //             imgUrl:"/asset/img/newIcon/scheduleClass.png",
        //             path:"admin.scheduleClass"
        //         },
        //     ]
        // },
        {
            title:"基础沟通",//기초의사소통
            icon:"mdi-message-text",
            items:[
                {
                    color:"#B673E0",
                    title:"分享",//공유
                    imgUrl:"/asset/img/newIcon/share1.png",
                    path:"classSpace.applications.share"
                },
                {
                    color:"#B673E0",
                    title:"问卷",//설문
                    imgUrl:"/asset/img/newIcon/questionnaire.png",
                    path:"classSpace.applications.questionnaire"
                },
                {
                    color:"#B673E0",
                    title:"投票",//투표
                    imgUrl:"/asset/img/newIcon/voting.png",
                    path:"classSpace.applications.voting"
                },
                {
                    color:"#B673E0",
                    title:"报名",//이름등록
                    imgUrl:"/asset/img/newIcon/regName.png",
                    path:"classSpace.applications.regname"
                },
            ]
        },
        {
            title:"家校互动",//가교호상활동
            icon:"mdi-nfc-tap",
            items:[
                
                {
                    color:"#E4BC16",
                    title:"分享",//공유
                    imgUrl:"/asset/img/newIcon/share2.png",
                    path:"classSpace.applications.share"
                },
                {
                    color:"#E4BC16",
                    title:"公告",//공시
                    imgUrl:"/asset/img/newIcon/announcement.png",
                    path:"classSpace.applications.announcement"
                },
                {
                    color:"#E4BC16",
                    title:"作业",//숙제
                    imgUrl:"/asset/img/newIcon/homework.png",
                    path:"classSpace.applications.homework"
                },
            ]
        },
        // {
        //     title:"校园安全",//교내안전
        //     icon:"mdi-account-cog-outline",
        //     items:[
        //         {
        //             color:"#98BB3A",
        //             title:"归程队",//귀한팀관리
        //             imgUrl:"/asset/img/newIcon/returnTeam.png",
        //             path:"classSpace.returnTeam"
        //         },
        //         {
        //             color:"#98BB3A",
        //             title:"维修工单",//수리공
        //             imgUrl:"/asset/img/newIcon/repair.png",
        //             path:"classSpace.applications.repair"
        //         },
        //         {
        //             color:"#98BB3A",
        //             title:"安全教育",//안전교육
        //             imgUrl:"/asset/img/newIcon/safeStudy.png",
        //             path:"classSpace.applications.safeStudy"
        //         },
        //     ]
        // },
        {
            title:"校园文化",//
            icon:"mdi-lifebuoy",
            items:[
                {
                    color:"#C95384",
                    title:"班级动态",//학급동태
                    imgUrl:"/asset/img/newIcon/classStory.png",
                    path:"classSpace.applications.classStory",

                },
                {
                    color:"#C95384",
                    title:"班际动态",//학급별동태
                    imgUrl:"/asset/img/newIcon/interClassStory.png",
                    path:"classSpace.applications.interClassStory",
                },
                {
                    color:"#C95384",
                    title:"表彰",//영예표창
                    imgUrl:"/asset/img/newIcon/recognition.png",
                    path:"classSpace.applications.recognition",

                },
            ]
        },
    ],
    studentItem:[
        {
            title:"智能考勤",//지능출근
            icon:"mdi-calendar-month-outline",
            items:[
                {
                    color:"#3EBBE8",
                    title:"请假单",//휴가신청
                    imgUrl:"/asset/img/newIcon/vocationRequest.png",
                    path:"classSpace.applications.vacation"
                },
                {
                    color:"#3EBBE8",
                    title:"课程表",//시간표
                    imgUrl:"/asset/img/newIcon/scheduleClass.png",
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
                    title:"分享",//공유
                    imgUrl:"/asset/img/newIcon/share1.png",
                    path:"classSpace.applications.share"
                },
                {
                    color:"#B673E0",
                    title:"问卷",//설문
                    imgUrl:"/asset/img/newIcon/questionnaire.png",
                    path:"classSpace.applications.questionnaire"
                },
                {
                    color:"#B673E0",
                    title:"投票",//투표
                    imgUrl:"/asset/img/newIcon/voting.png",
                    path:"classSpace.applications.voting"
                },
                {
                    color:"#B673E0",
                    title:"报名",//이름등록
                    imgUrl:"/asset/img/newIcon/regName.png",
                    path:"classSpace.applications.regname"
                },
            ]
        },
        {
            title:"家校互动",//가교호상활동
            icon:"mdi-nfc-tap",
            items:[
                
                {
                    color:"#E4BC16",
                    title:"分享",//공유
                    imgUrl:"/asset/img/newIcon/share2.png",
                    path:"classSpace.applications.share"
                },
                {
                    color:"#E4BC16",
                    title:"公告",//공시
                    imgUrl:"/asset/img/newIcon/announcement.png",
                    path:"classSpace.applications.announcement"
                },
                {
                    color:"#E4BC16",
                    title:"作业",//숙제
                    imgUrl:"/asset/img/newIcon/homework.png",
                    path:"classSpace.applications.homework"
                },
            ]
        },
        {
            title:"校园安全",//교내안전
            icon:"mdi-account-cog-outline",
            items:[
                // {
                //     color:"#98BB3A",
                //     title:"访客管理",//방문자관리
                //     imgUrl:"/asset/img/newIcon/manageGuests.png",
                //     path:"posts."
                // },
                {
                    color:"#98BB3A",
                    title:"归程队",//귀한팀관리
                    imgUrl:"/asset/img/newIcon/returnTeam.png",
                    path:"classSpace.returnTeam"
                },
                // {
                //     color:"#98BB3A",
                //     title:"打卡管理",//카드긋기
                //     imgUrl:"/asset/img/newIcon/cardcheck.png",
                //     path:"posts."
                // },
                {
                    color:"#98BB3A",
                    title:"维修工单",//수리공
                    imgUrl:"/asset/img/newIcon/repair.png",
                    path:"classSpace.applications.repair"
                },
                {
                    color:"#98BB3A",
                    title:"安全教育",//안전교육
                    imgUrl:"/asset/img/newIcon/safeStudy.png",
                    path:"classSpace.applications.safeStudy"
                },
            ]
        },
        {
            title:"校园文化",//
            icon:"mdi-lifebuoy",
            items:[
                {
                    color:"#C95384",
                    title:"班级动态",//학급동태
                    imgUrl:"/asset/img/newIcon/classStory.png",
                    path:"classSpace.applications.classStory",

                },
                {
                    color:"#C95384",
                    title:"班际动态",//학급별동태
                    imgUrl:"/asset/img/newIcon/interClassStory.png",
                    path:"classSpace.applications.interClassStory",
                },
                {
                    color:"#C95384",
                    title:"表彰",//영예표창
                    imgUrl:"/asset/img/newIcon/recognition.png",
                    path:"classSpace.applications.recognition",

                },
            ]
        },
    ],
  }),
  computed:{
      ...mapGetters({
          user:'auth/user'
      })
  },
  created(){
      switch(this.user.roleId){
          case 1:
              this.contentItemList = this.adminItem
              break;
          case 2:
              this.contentItemList = this.managerItem
              break;
          case 3:
              this.contentItemList = this.teacherItem
              break;
          case 4:
              this.contentItemList = this.parentItem
              break;
          case 5:
              this.contentItemList = this.studentItem
              break;
          case 7:
              this.contentItemList = this.teacherItem 
      }
  },
  methods:{
    selectedPost(){

    }
  }
}
</script>

<style>

</style>