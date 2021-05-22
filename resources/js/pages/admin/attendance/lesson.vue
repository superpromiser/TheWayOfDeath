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
            <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                <h2>课堂考勤</h2>
            </v-col>
            <v-col cols="12" md="4" class="d-flex align-center justify-end">
              <export-excel
                  :data="attendanceData"
                  :fields="json_fields"
                  :worksheet="attendanceDate"
                  :meta="json_meta"
                  type="xls"
                  :name="`进离校-${attendanceDate}.xls`">
                    <v-btn
                      dark
                      color="#7879ff"
                      tile
                      class="ml-4"
                      large
                  >
                      导出
                      <v-icon right>
                          mdi-export 
                      </v-icon>
                  </v-btn>
              </export-excel>
                 
                <v-btn
                      :dark="attendanceDate !== ''"
                      color="#f19861"
                      tile
                      class="ml-4"
                      large
                      :disabled="attendanceDate == ''"
                      @click="newAttendance"
                    >
                      新增考勤
                    <v-icon right>
                        mdi-plus
                    </v-icon>
                  </v-btn>
            </v-col>
        </v-row>
    </v-container>
    <v-dialog :overlay-opacity="$isMobile()? '0': '0.4'" 
        persistent
        v-model="dialog"
        max-width="800px"
      >
        <v-card>
          <v-card-title>
            <span class="headline">{{ formTitle }}</span>
          </v-card-title>

        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" class="d-flex align-center">
                <h3>{{editedItem.attendanceDay}}</h3>
              </v-col>
              <v-col cols="12" sm="6" >
                <v-select
                  solo
                  v-model="editedItem.attendanceTime"
                  :menu-props="{ top: false, offsetY: true }"
                  :items="lessonTimeItem"
                  item-text="lessonTimeName"
                  item-value="lessonTimeValue"
                  @change="selectedLessonTime"
                  label="考勤时间"
                  hide-details
              ></v-select>
              </v-col>
              <v-col cols="12">
                <v-data-table
                  :headers="dialogHeaders"
                  :items="editedItem.resultArr"
                  sort-by="calories"
                  class="elevation-1"
                >
                  <template v-slot:[`item.attendanceResult`]="{ item }">
                    <v-select 
                      :items="attendanceResultItem"
                      :menu-props="{ top: false, offsetY: true }"
                      item-text="resultType"
                      item-value="resultValue"
                      v-model="item.attendanceResult"
                      hide-details
                    >
                    </v-select>
                  </template>
                  <template v-slot:[`item.other`]="{ item }">
                    <v-text-field
                      v-model="item.other"
                      label=""
                      hide-details
                    ></v-text-field>
                  </template>
                </v-data-table>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="close"
          >
            {{lang.cancel}}
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            :loading="isCreatingSchool"
            @click="save"
          >
            {{lang.save}}
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
      <v-dialog :overlay-opacity="$isMobile()? '0': '0.4'" 
        persistent
        v-model="viewDialog"
        max-width="800px"
      >
        <v-card>
          <v-card-title>
            <span class="headline">查看考勤</span>
          </v-card-title>

        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" >
                <h3>{{editedItem.attendanceDay}}</h3>
              </v-col>
              <v-col cols="12" sm="6" >
                <v-select
                  solo
                  v-model="editedItem.attendanceTime"
                  :menu-props="{ top: false, offsetY: true }"
                  :items="lessonTimeItem"
                  item-text="lessonTimeName"
                  item-value="lessonTimeValue"
                  label="考勤时间"
                  hide-details
                  readonly
              ></v-select>
              </v-col>
              <v-col cols="12">
                <v-data-table
                  :headers="dialogHeaders"
                  :items="editedItem.resultArr"
                  sort-by="calories"
                  class="elevation-1"
                >
                  <template v-slot:[`item.attendanceResult`]="{ item }">
                    <v-select 
                      :items="attendanceResultItem"
                      :menu-props="{ top: false, offsetY: true }"
                      item-text="resultType"
                      item-value="resultValue"
                      v-model="item.attendanceResult"
                      hide-details
                      readonly
                    >
                    </v-select>
                  </template>
                  <template v-slot:[`item.other`]="{ item }">
                    <v-text-field
                      v-model="item.other"
                      label="人员姓名"
                      hide-details
                      readonly
                    ></v-text-field>
                  </template>
                </v-data-table>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <!-- <v-btn
            color="blue darken-1"
            text
            @click="close"
          >
            {{lang.cancel}}
          </v-btn> -->
          <v-btn
            color="blue darken-1"
            text
            :loading="isCreatingSchool"
            @click="viewDialog = false"
          >
            {{lang.ok}}
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog :overlay-opacity="$isMobile()? '0': '0.4'"  persistent v-model="dialogDelete" max-width="500px">
      <v-card>
        <v-card-title class="headline">{{lang.confirmSentence}}</v-card-title>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="closeDelete">{{lang.cancel}}</v-btn>
          <v-btn color="blue darken-1" text @click="deleteItemConfirm" :loading="isDeleteSchool">{{lang.ok}}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
                
    <v-row class="pa-10 px-7 ma-0">
      <v-col cols="12">
        <v-data-table
          :headers="headers"
          :items="attendanceData"
          :loading="isLoadingSchoolData"
          loading-text="正在加载..."
          sort-by="calories"
          class="elevation-1"
        >
          <template v-slot:top>
            <v-toolbar
                flat
            >
              
              
              <div class="d-flex align-center">
                  <p class="mb-0 mr-5">考勤日期</p>
                  <v-menu
                      ref="menu"
                      v-model="menu"
                      :close-on-content-click="false"
                      :return-value.sync="attendanceDate"
                      transition="scale-transition"
                      offset-y
                      min-width="auto"
                  >
                      <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                          solo
                          v-model="attendanceDate"
                          prepend-icon="mdi-calendar"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                          hide-details
                      ></v-text-field>
                      </template>
                      <v-date-picker
                          v-model="attendanceDate"
                          no-title
                          scrollable
                          @change="onSelectAttendanceDate"
                          locale="zh-cn"
                      >
                      </v-date-picker>
                  </v-menu>
              </div>
                
              
            </v-toolbar>
          </template>
          <template v-slot:[`item.resultNormal`]="{ item }">
            <v-chip
              class="ma-2"
              color="green"
              text-color="white"
            >
              {{item.resultNormal}}
            </v-chip>
          </template>
          <template v-slot:[`item.resultLate`]="{ item }">
            <v-chip
              class="ma-2"
              color="orange"
              text-color="white"
            >
              {{item.resultLate}}
            </v-chip>
          </template>
          <template v-slot:[`item.resultMiss`]="{ item }">
            <v-chip
              class="ma-2"
              color="red"
              text-color="white"
            >
              {{item.resultMiss}}
            </v-chip>
          </template>
          <template v-slot:[`item.resultRest`]="{ item }">
            <v-chip
              class="ma-2"
              color="deep-purple accent-1"
              text-color="white"
            >
              {{item.resultRest}}
            </v-chip>
          </template>
          <template v-slot:[`item.actions`]="{ item }">
              <v-icon
                  small
                  class="mr-2"
                  @click="viewItem(item)"
              >
                  mdi-eye
              </v-icon>
              <v-icon
                  small
                  class="mr-2"
                  @click="editItem(item)"
              >
                  mdi-pencil
              </v-icon>
              <v-icon
                  small
                  @click="deleteItem(item)"
              >
                  mdi-delete
              </v-icon>
          </template>
          <template v-slot:no-data>
            <p>没有课堂考勤信息</p>
          </template>
        </v-data-table>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import {getLessonUserList,} from '~/api/user'
import {getLessonAttendanceData,
        createLessonAttendanceData,
        updateLessonAttendanceData,
        deleteLessonAttendanceData,
      getLessonItem}
  from '~/api/attendance';
import lang from '~/helper/lang.json'
import {mapGetters} from 'vuex'
export default {
    components:{
    },

    data: () => ({
        lang,
        menu: false,
        dialog: false,
        viewDialog: false,
        dialogDelete: false,
        attendanceDate : new Date().toISOString().substr(0, 10),
        headers: [
            { text: '考勤日期', value: 'attendanceDay',sortable: false, align: 'start',},
            { text: '考勤时间', value: 'attendanceTime', sortable: false ,},
            { text: '出勤', value: 'resultNormal', align:'center' , sortable: false},
            { text: '迟到', value: 'resultLate', align:'center', sortable: false },
            { text: '缺勤', value: 'resultMiss', align:'center', sortable: false },
            { text: '请假', value: 'resultRest', align:'center', sortable: false },
            { text: '操作', value: 'actions', sortable: false, align:'center',},
        ],
        //excel
        json_fields:{
            '考勤日期': 'attendanceDay',
            '考勤时间': 'attendanceTime',
            '出勤': 'resultNormal',
            '迟到': 'resultLate',
            '缺勤': 'resultMiss',
            '请假': 'resultRest',
        },

        json_meta: [
            [
                {
                    'key': 'charset',
                    'value': 'utf-8'
                }
            ]
        ],

        dialogHeaders: [
            { text: '考勤人员', value: 'studentName',sortable: false, align: 'start',},
            { text: '考勤结果', value: 'attendanceResult', sortable: false ,},
            { text: '考勤备注', value: 'other', },
        ],
        lessonTimeItem : [
          
        ],
        attendanceResultItem : [
          {
            resultType : "正常出勤", // Normal attendance
            resultValue : "正常出勤",
          },
          {
            resultType : "出勤(带病)", // Attendance (with illness)
            resultValue : "出勤(带病)",
          },
          {
            resultType : "迟到",//Late
            resultValue : "迟到",
          },
          {
            resultType : "病假",//sick leave
            resultValue : "病假",
          },
          {
            resultType : "事假",//Personal leave
            resultValue : "事假",
          },
          {
            resultType : "缺勤",//Absent from work
            resultValue : "缺勤",
          },
          {
            resultType : "其他",//other
            resultValue : "其他",
          },
        ],
        attendanceData: [],
        
        editedIndex: -1,
        editedItem: {
          id:0,
          attendanceDay:  new Date().toISOString().substr(0, 10),
          attendanceTime: '',
          resultArr:[
          ],
          schoolId:0,
          gradeId:0,
          lessonId:0,
          resultNormal:0,
          resultLate:0,
          resultMiss:0,
          resultRest:0
        },
        defaultItem: {
          id:0,
          attendanceDay: new Date().toISOString().substr(0, 10),
          attendanceTime: '',
          resultArr:[
          ],
          schoolId:0,
          gradeId:0,
          lessonId:0,
          resultNormal:0,
          resultLate:0,
          resultMiss:0,
          resultRest:0
        },
        baseUrl:window.Laravel.base_url,
        isCreatingSchool : false,
        isLoadingSchoolData : false,
        isDeleteSchool : false,
        vacationReasonData : '',

        addAttendenceData: {
          lessonTime: '',
          lessonTimeValue: ''
        },
        
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? '新增考勤' : '修改考勤'
      },
      ...mapGetters({
        user:'auth/user'
      }),
      currentPath(){
        return this.$route
      }

    },


    async created(){
        this.editedItem.schoolId = this.currentPath.params.schoolId
        this.editedItem.gradeId = this.currentPath.params.gradeId
        this.editedItem.lessonId = this.currentPath.params.lessonId
        this.defaultItem.schoolId = this.currentPath.params.schoolId
        this.defaultItem.gradeId = this.currentPath.params.gradeId
        this.defaultItem.lessonId = this.currentPath.params.lessonId
        //we have to make result array for editedItem from student list
        // this needs very high skill...
          this.isLoadingSchoolData = true;
        getLessonItem({schoolId:this.user.schoolId}).then(res=>{
          res.data.map(data=>{
            let lessonItem = {}
            lessonItem.lessonTimeName = data.subjectOrderName
            lessonItem.lessonTimeValue = data.subjectOrderName
            this.lessonTimeItem.push(lessonItem)
          })

        }).catch(err=>{
          console.log(err.response)
        })
        getLessonAttendanceData({attDate:this.attendanceDate,lessonId:this.currentPath.params.lessonId}).then(res=>{
          res.data.map(item=>{
            item.resultArr = JSON.parse(item.resultArr)
          })
          this.attendanceData = res.data
        }).catch(err=>{
          console.log(err.response)
        })

        getLessonUserList({lessonId:this.currentPath.params.lessonId}).then(res=>{
          res.data.map(data=>{
            let element = {}
            element.studentName = data.name
            element.attendanceResult = '正常出勤'
            element.other = ''
            this.defaultItem.resultArr.push(element)
          })
          // this.editedItem = Object.assign({}, this.defaultItem)
          this.editedItem = JSON.parse(JSON.stringify(this.defaultItem))
          this.isLoadingSchoolData = false;
        }).catch(err=>{
          console.log(err.response)
          this.isLoadingSchoolData = false;
        })

    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
    },

    methods: {
      editItem (item) {
        this.editedIndex = this.attendanceData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.attendanceData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },
      newAttendance(){
        console.log(this.defaultItem)
        // this.editedItem = Object.assign({}, this.defaultItem)
        this.editedItem = JSON.parse(JSON.stringify(this.defaultItem))
        console.log(this.editedItem)
        this.dialog = !this.dialog
      },

      close () {
        this.dialog = false
        // this.editedItem = Object.assign({}, this.defaultItem)
        this.editedItem = JSON.parse(JSON.stringify(this.defaultItem))
        console.log("this.defaultItem",this.defaultItem)
        console.log("this.editedItem",this.editedItem)
        this.editedIndex = -1
        // this.$nextTick(() => {
        //   this.editedItem = Object.assign({}, this.defaultItem)
        //   this.editedIndex = -1
        // })
      },

      closeDelete () {
        this.dialogDelete = false
        // this.editedItem = Object.assign({}, this.defaultItem)
        this.editedItem = JSON.parse(JSON.stringify(this.defaultItem))
          this.editedIndex = -1
        // this.$nextTick(() => {
        //   this.editedItem = Object.assign({}, this.defaultItem)
        //   this.editedIndex = -1
        // })
      },

        async deleteItemConfirm () {
          this.isDeleteSchool = true
          console.log(this.editedItem)
          await deleteLessonAttendanceData({id:this.editedItem.id}).then(res=>{
            this.isDeleteSchool = false
            this.attendanceData.splice(this.editedIndex, 1)
          }).catch(err=>{
            console.log(err.response)
            this.isDeleteSchool = false
          })
          this.closeDelete()
        },

        async save () {
            //update attendanceData
            this.editedItem.resultNormal = this.getNumberOfAttendanceResult('normal',this.editedItem)
            this.editedItem.resultLate = this.getNumberOfAttendanceResult('late',this.editedItem)
            this.editedItem.resultMiss = this.getNumberOfAttendanceResult('miss',this.editedItem)
            this.editedItem.resultRest = this.getNumberOfAttendanceResult('rest',this.editedItem)
            console.log(this.editedItem)
            // return

            if(this.editedItem.attendanceTime == ''){
              return this.$snackbar.showMessage({content:this.lang.requiredlessonName,color:'error'})
            }
            this.isCreatingSchool = true;
            if (this.editedIndex > -1) {
              await updateLessonAttendanceData(this.editedItem).then(res=>{
                this.isCreatingSchool = false;
                Object.assign(this.attendanceData[this.editedIndex], this.editedItem)
              }).catch(err=>{
                console.log(err.response)
                this.isCreatingSchool = false
              })
            } 
            //save attendanceData
            else {
                await createLessonAttendanceData(this.editedItem).then(res=>{
                  console.log(res.data)
                  this.isCreatingSchool = false;
                  if(res.data.status == 207){
                    
                    return this.$snackbar.showMessage({content:this.lang.alreadyExist,color:'error'})
                  }else{
                    this.attendanceData.push(this.editedItem)
                  }
                  
                }).catch(err=>{
                  this.isCreatingSchool = false
                  console.log(err.response)
                })
            }
            this.close()
        },

        selectedLessonTime(val){
          this.editedItem.attendanceTime = val;
        },

        getNumberOfAttendanceResult(type, item){
          let counter = 0;
          switch (type) {
            case 'normal':
              item.resultArr.map(x=> {
                if(x.attendanceResult == '正常出勤' || x.attendanceResult == '出勤(带病)'){
                  counter ++;
                }
              })
            break;
            case 'late':
              item.resultArr.map(x=> {
                if(x.attendanceResult == '迟到'){
                  counter ++;
                }
              })
            break;
            case 'miss':
              item.resultArr.map(x=> {
                if(x.attendanceResult == '缺勤' || x.attendanceResult == '其他'){
                  counter ++;
                }
              })
            break;
            case 'rest':
              item.resultArr.map(x=> {
                if(x.attendanceResult == '病假' || x.attendanceResult == '事假'){
                  counter ++;
                }
              })
            break;
          }
          return counter;
        },

        async onSelectAttendanceDate(val){          
          this.$refs.menu.save(val);
          this.attendanceDate = val;
          this.editedItem.attendanceDay = val;
          this.defaultItem.attendanceDay = val;
          this.isLoadingSchoolData = true

          await getLessonAttendanceData({attDate:val,lessonId:this.currentPath.params.lessonId}).then(res=>{
            res.data.map(item=>{
              item.resultArr = JSON.parse(item.resultArr)
            })
            this.isLoadingSchoolData = false
            this.attendanceData = res.data
          }).catch(err=>{
            console.log(err.response)
          })
        },

        viewItem(item){
          this.editedItem = item;
          this.viewDialog = true
        }
    },
}
</script>
<style>

</style>