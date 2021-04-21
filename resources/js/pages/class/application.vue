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
                title : "基础沟通",
                icon : "mdi-message-text",
                items : [
                    {
                        color : "#98BB3A",
                        title : "问卷",
                        imgUrl : "/asset/img/newIcon/问卷.png",
                        path : "classSpace.applications.quesitonnaire"
                    },
                    {
                        color : "#C95384",
                        title : "投票",
                        imgUrl : "/asset/img/newIcon/投票.png",
                        path : "classSpace.applications.voting"
                    },
                ],
            },
            {
                title : "家校互动",
                icon : "mdi-nfc-tap",
                items : [
                    {
                        color : "#DA7042",
                        title : "作业",
                        imgUrl : "/asset/img/newIcon/作业.png",
                        path : "classSpace.applications.homework"
                    },
                    // {
                    //     color : "#E4BC16",
                    //     title : "习题",
                    //     imgUrl : "/asset/img/newIcon/习题.png",
                    //     path : "something"
                    // },
                    {
                        color : "#DA7042",
                        title : "家访",
                        imgUrl : "/asset/img/newIcon/家访.png",
                        path : "classSpace.applications.homevisit"
                    },
                    {
                        color : "#EB5846",
                        title : "班级动态",
                        imgUrl : "/asset/img/newIcon/班级动态.png",
                        path : "classSpace.applications.classStory"
                    },
                    {
                        color : "#EB5846",
                        title : "班际动态",
                        imgUrl : "/asset/img/newIcon/班际动态.png",
                        path : "classSpace.applications.interClassStory"
                    },
                ],
            },
            {
                title : "移动办公",
                icon : "mdi-calendar-month-outline",
                items : [
                    {
                        color : "red accent-3",
                        title : "通知",
                        imgUrl : "/asset/img/icon/通知 拷贝.png",
                        path : "posts.Cnotification"
                    },
                ],
            },
            {
                title : "数字德育",
                icon : "mdi-calendar-month-outline",
                items : [
                    {
                        color : "lime darken-4",
                        title : "评价",
                        imgUrl : "/asset/img/icon/评价.png",
                        path : "posts.Cevaluation"
                    },
                    {
                        color : "lime darken-4",
                        title : "表彰",
                        imgUrl : "/asset/img/icon/表彰.png",
                        path : "posts.Crecognition"
                    },
                ],
            },
            {
                title : "工具",
                icon : "mdi-calendar-month-outline",
                items : [
                    {
                        color : "indigo accent-2",
                        title : "课表",
                        imgUrl : "/asset/img/icon/组 29.png",
                        path : "something"
                    },
                    {
                        color : "#3EBBE8",
                        title : "相册",
                        imgUrl : "/asset/img/newIcon/相册.png",
                        path : "posts.Calbum"
                    },
                    {
                        color : "indigo accent-2",
                        title : "文件",
                        imgUrl : "/asset/img/icon/文件.png",
                        path : "file"
                    },
                ],
            },
            {
                title : "校园安全",
                icon : "mdi-safe",
                items : [
                    {
                        color : "indigo accent-2",
                        title : "访客管理",
                        imgUrl : "/asset/img/icon/组 29.png",
                        path : "manageGuests"
                    },
                ],
            },
            {
                title : "校园安全", //safety
                icon : "mdi-message-text",
                items : [
                    {
                        color : "#DA7042",
                        title : "访客管理", //Guest management
                        imgUrl : "/asset/img/newIcon/访客管理.png",
                        path : "classSpace.manageGuests"
                    },
                    {
                        color : "#98BB3A",
                        title : "归程队管理",//Return team management
                        imgUrl : "/asset/img/newIcon/归程队.png",
                        path : "classSpace.returnTeam"
                    },
                    {
                        color : "#98BB3A",
                        title : "打卡管理",//check in
                        imgUrl : "/asset/img/newIcon/打卡管理.png",
                        path : "posts.sms"
                    },
                    {
                        color : "#98BB3A",
                        title : "交接班管理",//Shift management
                        imgUrl : "/asset/img/newIcon/交接班.png",
                        path : "posts.Cshift"
                    },
                    {
                        color : "#7180EA",
                        title : "维修工单",//Repair work order
                        imgUrl : "/asset/img/newIcon/维修工单.png",
                        path : "posts.announcement"
                    },
                    {
                        color : "#DA7042",
                        title : "请假放行", //Ask for leave
                        imgUrl : "/asset/img/newIcon/闸机.png",
                        path : "posts.share"
                    },
                ],
            },
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