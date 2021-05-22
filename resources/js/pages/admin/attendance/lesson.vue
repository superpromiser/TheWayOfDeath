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
                  :data="attendanceDataForExcel"
                  :fields="json_fields"
                  :worksheet="attendanceData.attendanceDay"
                  :meta="json_meta"
                  type="xls"
                  :name="`课堂考勤-${attendanceData.attendanceDay}.xls`">
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
                      @click="dialog = !dialog"
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
        <v-spacer></v-spacer>
        </v-card-actions>
      </v-card>
    </v-dialog>
                
    <v-row class="pa-10">
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
              {{getNumberOfAttendanceResult('normal', item)}}
            </v-chip>
          </template>
          <template v-slot:[`item.resultLate`]="{ item }">
            <v-chip
              class="ma-2"
              color="orange"
              text-color="white"
            >
              {{getNumberOfAttendanceResult('late', item)}}
            </v-chip>
          </template>
          <template v-slot:[`item.resultMiss`]="{ item }">
            <v-chip
              class="ma-2"
              color="red"
              text-color="white"
            >
              {{getNumberOfAttendanceResult('miss', item)}}
            </v-chip>
          </template>
          <template v-slot:[`item.resultRest`]="{ item }">
            <v-chip
              class="ma-2"
              color="deep-purple accent-1"
              text-color="white"
            >
              {{getNumberOfAttendanceResult('rest', item)}}
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
            '出勤': 'normalCnt',
            '迟到': 'lateCnt',
            '缺勤': 'missCnt',
            '请假': 'restCnt',
        },

        json_meta: [
            [
                {
                    'key': 'charset',
                    'value': 'utf-8'
                }
            ]
        ],

        attendanceDataForExcel:[],

        dialogHeaders: [
            { text: '考勤人员', value: 'studentName',sortable: false, align: 'start',},
            { text: '考勤结果', value: 'attendanceResult', sortable: false ,},
            { text: '考勤备注', value: 'other', },
        ],
        lessonTimeItem : [
          
        ],
        attendanceResultItem : [
          {
            resultType : "正常出勤", // normal
            resultValue : "正常出勤",
          },
          {
            resultType : "出勤(带病)", // 
            resultValue : "出勤(带病)",
          },
          {
            resultType : "迟到",
            resultValue : "迟到",
          },
          {
            resultType : "病假",
            resultValue : "病假",
          },
          {
            resultType : "事假",
            resultValue : "事假",
          },
          {
            resultType : "缺勤",
            resultValue : "缺勤",
          },
          {
            resultType : "其他",
            resultValue : "其他",
          },
        ],
        attendanceData: [],
        
        editedIndex: -1,
        editedItem: {
          attendanceDay:  new Date().toISOString().substr(0, 10),
          attendanceTime: '第一节',
          resultArr:[
          ]
        },
        defaultItem: {
          attendanceDay: new Date().toISOString().substr(0, 10),
          attendanceTime: '第一节',
          resultArr:[
          ]
        },
        baseUrl:window.Laravel.base_url,
        isCreatingSchool : false,
        isLoadingSchoolData : false,
        isDeleteSchool : false,
        vacationReasonData : '',

        addAttendenceData: {
          lessonTime: '',
          lessonTimeValue: ''
        }
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
        getLessonAttendanceData({attDate:this.attendanceDate}).then(res=>{
          res.data.map(item=>{
            item.resultArr = JSON.parse(item.resultArr)
          })
          this.attendanceData = res.data
          this.convertForExcel(this.attendanceData);
          console.log("this.attendanceData", this.attendanceData);
        }).catch(err=>{
          console.log(err.response)
        })

        getLessonUserList({lessonId:this.currentPath.params.lessonId}).then(res=>{
          res.data.map(data=>{
            let element = {}
            element.studentName = data.name
            element.attendanceResult = '正常出勤'
            element.other = ''
            this.editedItem.resultArr.push(element)
          })
          this.defaultItem = this.editedItem
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

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
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
                  this.isCreatingSchool = false;
                  this.attendanceData.push(this.editedItem)
                }).catch(err=>{
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
                if(x.attendanceResult == '缺勤'){
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

          await getLessonAttendanceData({attDate:val}).then(res=>{
            res.data.map(item=>{
              item.resultArr = JSON.parse(item.resultArr)
            })
            this.isLoadingSchoolData = false
            this.attendanceData = res.data
            this.convertForExcel(this.attendanceData);
          }).catch(err=>{
            console.log(err.response)
          })
        },

        viewItem(item){
          this.editedItem = item;
          this.viewDialog = true
        },

        convertForExcel(attendanceDataArr){
          var convertedData = [];
          attendanceDataArr.map(attendanceData => {
            var normalCnt, lateCnt, missCnt, restCnt = 0;
            attendanceData.resultArr.map(result => {
              if(result.attendanceResult == '正常出勤' || result.attendanceResult == '出勤(带病)'){
                normalCnt ++;
              }
              if(result.attendanceResult == '迟到'){
                lateCnt ++;
              }
              if(result.attendanceResult == '缺勤'){
                missCnt ++;
              }
              if(result.attendanceResult == '病假' || result.attendanceResult == '事假'){
                restCnt ++;
              }
            })
            var obj = {
              attendanceDay: attendanceData.attendanceDay,
              attendanceTime: attendanceData.attendanceTime,
              normalCnt: normalCnt,
              lateCnt: lateCnt,
              missCnt: missCnt,
              restCnt: restCnt
            }
            this.attendanceDataForExcel = [...this.attendanceDataForExcel, obj];
            console.log("this.attendanceDataForExcel", this.attendanceDataForExcel);
          })
        }
    },
}
</script>
<style>

</style>