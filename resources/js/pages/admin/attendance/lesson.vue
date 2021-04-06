<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-data-table
          :headers="headers"
          :items="attendanceData"
          :loading="isLoadingSchoolData"
          loading-text="等一下..."
          sort-by="calories"
          class="elevation-1"
        >
          <template v-slot:top>
            <v-toolbar
                flat
            >
                <v-toolbar-title><strong>课堂考勤</strong></v-toolbar-title>
                <v-divider
                class="mx-4"
                inset
                vertical
                ></v-divider>
                <v-spacer></v-spacer>
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
                
                <v-dialog
                  v-model="dialog"
                  max-width="800px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-btn
                      :dark="attendanceDate !== ''"
                      color="purple lighten-1"
                      tile
                      class="ml-4"
                      large
                      :disabled="attendanceDate == ''"
                      v-bind="attrs"
                      v-on="on"
                    >
                      新增考勤
                    <v-icon right>
                        mdi-plus
                    </v-icon>
                  </v-btn>
                  </template>
                  <v-card>
                    <v-card-title>
                      <span class="headline">{{ formTitle }}</span>
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
                                label="人员姓名"
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
                <v-dialog
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
                    </v-btn>
                    <v-btn
                      color="blue darken-1"
                      text
                      :loading="isCreatingSchool"
                      @click="save"
                    >
                      {{lang.save}}
                    </v-btn> -->
                  </v-card-actions>
                </v-card>
              </v-dialog>
              <v-dialog v-model="dialogDelete" max-width="500px">
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
                <v-btn
                    dark
                    color="#49d29e"
                    tile
                    class="ml-4"
                    large
                >
                    导出
                    <v-icon right>
                        mdi-export 
                    </v-icon>
                </v-btn>
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
            <p>没有学习资料</p>
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
        deleteLessonAttendanceData}
  from '~/api/attendance';
import lang from '~/helper/lang.json'
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
        dialogHeaders: [
            { text: '考勤人员', value: 'studentName',sortable: false, align: 'start',},
            { text: '考勤结果', value: 'attendanceResult', sortable: false ,},
            { text: '考勤备注', value: 'other', },
        ],
        lessonTimeItem : [
          {
            lessonTimeName: "早自习",
            lessonTimeValue: "早自习"
          },
          {
            lessonTimeName: "第一节",
            lessonTimeValue: "第一节"
          },
          {
            lessonTimeName: "第二节",
            lessonTimeValue: "第二节"
          },
          {
            lessonTimeName: "第三节",
            lessonTimeValue: "第三节"
          },
          {
            lessonTimeName: "第四节",
            lessonTimeValue: "第四节"
          },
          {
            lessonTimeName: "第五节",
            lessonTimeValue: "第五节"
          },
          {
            lessonTimeName: "第六节",
            lessonTimeValue: "第六节"
          },
          {
            lessonTimeName: "第七节",
            lessonTimeValue: "第七节"
          },
          {
            lessonTimeName: "晚自习",
            lessonTimeValue: "晚自习"
          },
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
        attendanceData: [
            // {
            //     attendanceDay: '2021年3月15日',
            //     attendanceTime: '早自习',
            //     resultArr:[
            //       {
            //         studentName: 'sammie',
            //         attendanceResult: '正常出勤',
            //         other: '',
            //       },
            //       {
            //         studentName: 'tommy',
            //         attendanceResult: '出勤(带病)',
            //         other: '',
            //       },
            //       {
            //         studentName: 'hommy',
            //         attendanceResult: '正常出勤',
            //         other: '',
            //       },
            //       {
            //         studentName: 'gammy',
            //         attendanceResult: '正常出勤',
            //         other: '',
            //       },
            //       {
            //         studentName: 'gammy',
            //         attendanceResult: '出勤(带病)',
            //         other: '',
            //       },
            //       {
            //         studentName: 'ummy',
            //         attendanceResult: '迟到',
            //         other: 'something',
            //       },
            //       {
            //         studentName: 'ommy',
            //         attendanceResult: '迟到',
            //         other: '',
            //       },
            //       {
            //         studentName: 'vammy',
            //         attendanceResult: '病假',
            //         other: '',
            //       },
            //       {
            //         studentName: 'zemmy',
            //         attendanceResult: '事假',
            //         other: '',
            //       },
            //       {
            //         studentName: 'hommy',
            //         attendanceResult: '缺勤',
            //         other: '',
            //       },
            //       {
            //         studentName: 'ammy',
            //         attendanceResult: '其他',
            //         other: '',
            //       },
            //       {
            //         studentName: 'lommy',
            //         attendanceResult: '缺勤',
            //         other: '',
            //       },
            //       {
            //         studentName: 'pummy',
            //         attendanceResult: '事假',
            //         other: '',
            //       },
            //     ]
            // },
        ],
        
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
    },


    async created(){

        //we have to make result array for editedItem from student list
        // this needs very high skill...
          // this.isLoadingSchoolData = true;
        getLessonAttendanceData({attDate:this.attendanceDate}).then(res=>{
          console.log("res.data1",res.data)
          res.data.map(item=>{
            item.resultArr = JSON.parse(item.resultArr)
          })
          this.attendanceData = res.data
        }).catch(err=>{
          console.log(err.response)
        })

        getLessonUserList().then(res=>{
          console.log("res.data2",res.data)
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
            this.attendanceData.splice(this.editedIndex, 1)
            // let payload = {
            //     id : this.editedItem.id
            // }
            // this.isDeleteSchool = true;
            // await deleteSchool(payload)
            // .then((res) => {
            //     if(res.data.msg == 1){
                    
            //     }
            //     this.isDeleteSchool = false;
            // }).catch((err) => {
            //     console.log(err)
            //     this.isDeleteSchool = false;
            // });
            this.closeDelete()
        },

        async save () {
          console.log("this.editedItem",this.editedItem)
            //update attendanceData
            this.isCreatingSchool = true;
            if (this.editedIndex > -1) {
              this.isCreatingSchool = false;
              Object.assign(this.attendanceData[this.editedIndex], this.editedItem)
            } 
            //save attendanceData
            else {
                await createLessonAttendanceData(this.editedItem).then(res=>{
                  this.isCreatingSchool = false;
                  console.log(res.data)
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