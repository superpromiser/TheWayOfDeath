<template>
  <v-container>
    <v-row>
      <v-col cols="4">
        <p>
          开姶日期
        </p>
        <v-menu
          v-model="startMenu"
          :close-on-content-click="false"
          :nudge-right="40"
          transition="scale-transition"
          offset-y
          min-width="auto"
        >
          <template v-slot:activator="{ on, attrs }">
          <v-text-field
              v-model="startDate"
              prepend-icon="mdi-calendar"
              readonly
              v-bind="attrs"
              v-on="on"
          ></v-text-field>
          </template>
          <v-date-picker
          v-model="startDate"
          @input="selStartDate"
          ></v-date-picker>
        </v-menu>
      </v-col>
      <v-col cols="4">
        <p>
          结東日期
        </p>
        <v-menu
          v-model="endMenu"
            :close-on-content-click="false"
            :nudge-right="40"
            transition="scale-transition"
            offset-y
            min-width="auto"
        >
          <template v-slot:activator="{ on, attrs }">
          <v-text-field
              v-model="endDate"
              prepend-icon="mdi-calendar"
              readonly
              v-bind="attrs"
              v-on="on"
          ></v-text-field>
          </template>
          <v-date-picker
          v-model="endDate"
          @input="selEndDate"
          ></v-date-picker>
        </v-menu>
      </v-col>
      <v-col cols="4">
        <v-btn
          depressed
          color="#7879FF"
          @click="searchAction"
          class="float-right mt-3 text-light"
        >
          査洵
        </v-btn>
      </v-col>
    </v-row>
    <v-data-table
      dense
      :headers="headers"
      :items="desserts"
      :loading="isLoading"
      item-key="name"
      class="elevation-1"
    >
      <template v-slot:[`item.actions`]="{ item }">
        <span @click="detail(item)" class="text-primary hover-cursor-point">立即查若</span>
      </template>
      <template v-slot:no-data>
        <p>没有学习资料</p>
      </template>
    </v-data-table>
    <v-row justify="center">
      <v-dialog
        v-model="dialog"
        max-width="600px"
      >
        <v-data-table
          dense
          :headers="dialogHeader"
          :items="detailItem"
          :loading="isLoading"
          item-key="name"
          class="elevation-1 pa-3"
        >
          <template v-slot:[`item.actions`]="{ item }">
            <span @click="detail(item)" class="text-primary hover-cursor-point">立即查若</span>
          </template>
          <template v-slot:no-data>
            <p>没有学习资料</p>
          </template>
        </v-data-table>
      </v-dialog>
    </v-row>  
  </v-container>
</template>

<script>
import {getStatData} from '~/api/attendance';
import {getStatLessonAttData,getStatDetailAttData} from '~/api/attendance';
import {getLessonUserList} from '~/api/user';
import {mapGetters} from 'vuex';
export default {
  data:()=>({
      desserts: [
        
      ],
      headers: [
        {
          text: '姓名',
          align: 'start',
          sortable: false,
          value: 'name',
        },
        { text: '总考勤次数', value: 'all' },
        // { text: '考勤結果', value: 'attResult' },
        { text: '出勤', value: 'attendance' }, 
        { text: '迟勤', value: 'late' },
        { text: '缺勤', value: 'absent' },
        { text: '清假', value: 'sick' },
        { text: '操作', value: 'actions' },

      ],
      dialogHeader: [
        {
          text: '考勤日期',
          align: 'start',
          sortable: false,
          value: 'attendanceDay',
        },
        { text: '考勤时间', value: 'attendanceTime' },
        // { text: '考勤結果', value: 'attResult' },
        { text: '出勤', value: 'attendance' }, 
        { text: '迟勤', value: 'late' },
        { text: '缺勤', value: 'absent' },
        { text: '清假', value: 'sick' },
        { text: '备注', value: 'remark' },

      ],
      detailItem:[],
      startMenu:false,
      endMenu:false,
      startDate:new Date().toISOString().substr(0, 10),
      endDate:new Date().toISOString().substr(0, 10),
      isLoading:false,
      dialog: false,
  }),
  computed:{
    currentPath(){
      return this.$route
    },
    ...mapGetters({
      user:'auth/user'
    })
  },
  created(){
    console.log("this.user",this.user)
  },
  methods:{
    selStartDate(){
      this.startMenu = false
      console.log(this.startDate) 
    },
    selEndDate(){
      this.endMenu = false
      console.log(this.endDate)
    },
    async searchAction(){
      this.desserts = []
      this.isLoading = true
      console.log(this.startDate,this.endDate)
      await getLessonUserList().then(res=>{
        console.log(res.data)
        res.data.map(user=>{
          if(this.user.roleId != 5){
            console.log(user)
            let statObj = {}
            statObj.id = user.id
            statObj.lessonId = user.lessonId
            statObj.name = user.name
            statObj.all = 0;
            statObj.attendance = 0
            statObj.late = 0
            statObj.absent = 0
            statObj.sick = 0
            this.desserts.push(statObj)
          }else{
            if(user.name == this.user.name){
              let statObj = {}
              statObj.id = user.id
              statObj.lessonId = user.lessonId
              statObj.name = user.name
              statObj.all = 0;
              statObj.attendance = 0
              statObj.late = 0
              statObj.absent = 0
              statObj.sick = 0
              this.desserts.push(statObj)
            }
          }
        })
      })
      // return 
      // getStatData({startDate:this.startDate,endDate:this.endDate}).then(res=>{
      //   console.log(res.data)
      // }).catch(err=>{
      //   console.log(err.response)
      // })
      await getStatLessonAttData({from:this.startDate,to:this.endDate}).then(res=>{
        // console.log(res.data)
        let resultArr = []
        res.data.map(item=>{
          // console.log(JSON.parse(item.resultArr))
          let itemResultArr = JSON.parse(item.resultArr)
          itemResultArr.map(lessonArr=>{
            resultArr.push(lessonArr)
          })
          // resultArr.push(JSON.parse(item.resultArr))
        })
        resultArr.map(item=>{
          console.log(item)
          this.desserts.map(user=>{
            if(user.name == item.studentName){
              user[this.CountAttendanceResult(item.attendanceResult)] ++
              user.all ++
            }
          })  
        })
        this.isLoading = false
      }).catch(err=>{
        console.log(err.response)
        this.isLoading = false
      })
    },
    CountAttendanceResult(type){
      switch(type){
        case "正常出勤":
          return "attendance";
        case "出勤(带病)":
          return "attendance";
        case "迟到":
          return "late";
        case "病假":
          return "sick";
        case "事假":
          return "sick";
        case "缺勤":
          return "absent";
        case "其他":
          return "absent";       
      }
    },
    async detail(item){
      this.dialog = true
      await getStatDetailAttData({from:this.startDate,to:this.endDate,lessonId:item.lessonId}).then(res=>{
        console.log(res.data)
        this.detailItem = res.data
      }).catch(err=>{
        console.log(err.response)
      })
      // console.log(item)
    }
  }
}
</script>

<style>

</style>