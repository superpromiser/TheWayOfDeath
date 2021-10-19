<template>
  <v-container class="pa-0">
    <v-container class="px-10 z-index-2 banner-custom">
      <v-row>
        <v-col cols="6" md="4" class="d-flex align-center position-relative">
          <a @click="$router.go(-1)">
            <v-icon size="70" class="left-24p">
              mdi-chevron-left
            </v-icon>
          </a>
        </v-col>
        <v-col
          cols="6"
          md="4"
          class="d-flex align-center justify-start justify-md-center"
        >
          <h2>统计</h2>
        </v-col>
        <v-col cols="12" md="4" class="d-flex align-center justify-end">
          <v-btn depressed color="#7879FF" dark @click="searchAction">
            査洵
          </v-btn>
        </v-col>
      </v-row>
    </v-container>
    <v-row class="pa-10">
      <v-col cols="12" md="6" class="d-flex align-center">
        开始日期
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
              solo
              hide-details
              v-bind="attrs"
              v-on="on"
            ></v-text-field>
          </template>
          <v-date-picker
            no-title
            scrollable
            v-model="startDate"
            @input="selStartDate"
          ></v-date-picker>
        </v-menu>
      </v-col>
      <v-col cols="12" md="6" class="d-flex align-center">
        结束日期
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
              hide-details
              solo
              v-bind="attrs"
              v-on="on"
            ></v-text-field>
          </template>
          <v-date-picker
            v-model="endDate"
            no-title
            scrollable
            @input="selEndDate"
          ></v-date-picker>
        </v-menu>
      </v-col>
    </v-row>
    <div class="px-10">
      <v-data-table
        :headers="headers"
        :items="desserts"
        :loading="isLoading"
        loading-text="正在加载..."
        item-key="name"
        sort-by="calories"
        class="px-10 elevation-1"
      >
        <template v-slot:[`item.actions`]="{ item }">
          <span @click="detail(item)" class="text-primary hover-cursor-point"
            >立即查看</span
          >
        </template>
        <template v-slot:no-data>
          <p>没有统计信息</p>
        </template>
      </v-data-table>
    </div>
    <v-row justify="center">
      <v-dialog
        :overlay-opacity="$isMobile() ? '0' : '0.4'"
        v-model="dialog"
        max-width="700px"
      >
        <v-data-table
          dense
          :headers="dialogHeader"
          :items="detailItem"
          :loading="isLoading"
          item-key="name"
          class="elevation-1 pa-3"
        >
          <template v-slot:[`item.attendance`]="{ item }">
            <v-icon v-if="item.attendance == true">
              mdi-check
            </v-icon>
          </template>
          <template v-slot:[`item.late`]="{ item }">
            <v-icon v-if="item.late == true">
              mdi-check
            </v-icon>
          </template>
          <template v-slot:[`item.absent`]="{ item }">
            <v-icon v-if="item.absent == true">
              mdi-check
            </v-icon>
          </template>
          <template v-slot:[`item.sick`]="{ item }">
            <v-icon v-if="item.sick == true">
              mdi-check
            </v-icon>
          </template>
          <template v-slot:[`item.remark`]="{ item }">
            <span class="text-primary hover-cursor-point" v-if="item.remark">{{
              item.remark
            }}</span>
          </template>
          <template v-slot:no-data>
            <p>没有统计信息</p>
          </template>
        </v-data-table>
      </v-dialog>
    </v-row>
  </v-container>
</template>

<script>
import { getStatData } from "~/api/attendance";
import { getStatLessonAttData, getStatDetailAttData } from "~/api/attendance";
import { getLessonUserList } from "~/api/user";
import { mapGetters } from "vuex";
export default {
  data: () => ({
    desserts: [],
    headers: [
      {
        text: "姓名",
        align: "start",
        sortable: false,
        value: "name"
      },
      { text: "总考勤次数", value: "all" },
      // { text: '考勤結果', value: 'attResult' },
      { text: "出勤", value: "attendance" },
      { text: "迟到", value: "late" },
      { text: "缺勤", value: "absent" },
      { text: "请假", value: "sick" },
      { text: "操作", value: "actions" }
    ],
    dialogHeader: [
      {
        text: "考勤日期",
        align: "start",
        sortable: false,
        value: "attendanceDay"
      },
      { text: "考勤时间", value: "attendanceTime" },
      // { text: '考勤結果', value: 'attResult' },
      { text: "出勤", value: "attendance" },
      { text: "迟到", value: "late" },
      { text: "缺勤", value: "absent" },
      { text: "请假", value: "sick" },
      { text: "备注", value: "remark" }
    ],
    detailItem: [],
    startMenu: false,
    endMenu: false,
    startDate: new Date().toISOString().substr(0, 10),
    endDate: new Date().toISOString().substr(0, 10),
    isLoading: false,
    dialog: false
  }),
  computed: {
    currentPath() {
      return this.$route;
    },
    ...mapGetters({
      user: "auth/user"
    })
  },
  created() {
    this.searchAction();
  },
  methods: {
    selStartDate() {
      this.startMenu = false;
    },
    selEndDate() {
      this.endMenu = false;
    },
    async searchAction() {
      this.desserts = [];
      this.isLoading = true;
      await getLessonUserList().then(res => {
        res.data.map(user => {
          if (this.user.roleId != 5) {
            let statObj = {};
            statObj.userId = user.id;
            statObj.lessonId = user.lessonId;
            statObj.name = user.name;
            statObj.all = 0;
            statObj.attendance = 0;
            statObj.late = 0;
            statObj.absent = 0;
            statObj.sick = 0;
            this.desserts.push(statObj);
          } else {
            if (user.name == this.user.name) {
              let statObj = {};
              statObj.id = user.id;
              statObj.lessonId = user.lessonId;
              statObj.name = user.name;
              statObj.all = 0;
              statObj.attendance = 0;
              statObj.late = 0;
              statObj.absent = 0;
              statObj.sick = 0;
              this.desserts.push(statObj);
            }
          }
        });
      });
      // return
      // getStatData({startDate:this.startDate,endDate:this.endDate}).then(res=>{
      //   console.log(res.data)
      // }).catch(err=>{
      //   console.log(err.response)
      // })
      await getStatLessonAttData({ from: this.startDate, to: this.endDate })
        .then(res => {
          // console.log(res.data)
          let resultArr = [];
          res.data.map(item => {
            // console.log(JSON.parse(item.resultArr))
            let itemResultArr = JSON.parse(item.resultArr);
            itemResultArr.map(lessonArr => {
              resultArr.push(lessonArr);
            });
            // resultArr.push(JSON.parse(item.resultArr))
          });
          resultArr.map(item => {
            this.desserts.map(user => {
              if (user.name == item.studentName) {
                user[this.CountAttendanceResult(item.attendanceResult)]++;
                user.all++;
              }
            });
          });
          this.isLoading = false;
        })
        .catch(err => {
          console.log(err.response);
          this.isLoading = false;
        });
    },
    CountAttendanceResult(type) {
      switch (type) {
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
    async detail(item) {
      this.dialog = true;
      this.detailItem = [];
      await getStatDetailAttData({
        from: this.startDate,
        to: this.endDate,
        lessonId: item.lessonId
      })
        .then(res => {
          res.data.map(data => {
            let resultArr = JSON.parse(data.resultArr);
            resultArr.map(att => {
              if (att.studentName == item.name) {
                switch (att.attendanceResult) {
                  case "正常出勤":
                    this.$set(data, "attendance", true);
                    break;
                  case "出勤(带病)":
                    this.$set(data, "attendance", true);
                    break;
                  case "迟到":
                    this.$set(data, "late", true);
                    this.$set(data, "remark", "身体不适");
                    break;
                  case "病假":
                    this.$set(data, "sick", true);
                    this.$set(data, "remark", "肠胃感昌");
                    break;
                  case "事假":
                    this.$set(data, "sick", true);
                    this.$set(data, "remark", "肠胃感昌");
                    break;
                  case "缺勤":
                    this.$set(data, "absent", true);
                    this.$set(data, "remark", "那肚子");
                    break;
                  case "其他":
                    this.$set(data, "absent", true);
                    this.$set(data, "remark", "那肚子");
                    break;
                }
              }
            });
          });
          this.detailItem = res.data;
        })
        .catch(err => {
          console.log(err.response);
        });
    }
  }
};
</script>

<style></style>
