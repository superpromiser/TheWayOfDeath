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
export default {
  middleware:'auth',
  components:{
    ApplicationItem,
  },
  data:() => ({
    lang,
    
    contentItemList : [
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
                        path : "posts.campus"
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

  methods:{
    selectedPost(){

    }
  }
}
</script>

<style>

</style>