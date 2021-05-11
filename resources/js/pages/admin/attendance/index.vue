<template>
  <v-container class="pa-0">
    <!-- <v-container class="px-10 z-index-2 banner-custom">
        <v-row>
            <v-col cols="6" md="4" class="d-flex align-center position-relative">
                <a @click="$router.go(-1)">
                    <v-icon size="70" class="left-24p">
                        mdi-chevron-left
                    </v-icon>
                </a>
            </v-col>
            <v-col cols="6" md="4" class="d-flex align-center justify-start justify-md-center">
                <h2>进离校</h2>
            </v-col>
            <v-col cols="12" md="4" class="d-flex align-center justify-end">
                <div class="d-flex align-center">
                    <p class="mb-0">考勤日期</p>
                    <v-menu
                        v-model="menu"
                        :close-on-content-click="false"
                        :nudge-right="40"
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
                            @input="selDate"
                            locale="zh-cn"
                        ></v-date-picker>
                    </v-menu>
                </div>
                <v-btn
                    dark
                    color="#7879ff"
                    tile
                    large
                    class="mx-1"
                >
                    导出
                    <v-icon right>
                        mdi-export 
                    </v-icon>
                </v-btn>
            </v-col>
        </v-row>
    </v-container> -->
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
                <h2>进离校</h2>
            </v-col>
            <v-col cols="12" md="4" class="d-flex align-center justify-end">
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
            </v-col>
        </v-row>
    </v-container>
    <v-row class="px-10 mt-5">
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
                        v-model="menu"
                        :close-on-content-click="false"
                        :nudge-right="40"
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
                            @input="selDate"
                            locale="zh-cn"
                        ></v-date-picker>
                    </v-menu>
                </div>
                
               
            </v-toolbar>
          </template>
          <template v-slot:[`item.other`]="{ item }">
            <div v-if="item.other == null"> - </div>
            <div v-else> 
                <v-btn v-if="item.other.type == 1" color="primary" text>
                    病假
                </v-btn>    
                <v-btn v-else-if="item.other.type == 2" color="primary" text>
                    事假
                </v-btn>    
            </div>
          </template>
          <template v-slot:no-data>
            <p>没有进离校记录</p>
          </template>
        </v-data-table>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import {getAttendanceData} from '~/api/attendance'
import lang from '~/helper/lang.json'
export default {
    components:{
    },

    data: () => ({
        lang,
        menu:false,
        attendanceDate : new Date().toISOString().substr(0, 10),
        headers: [
            { text: '姓名', value: 'user.name', align: 'start'},
            { text: '进校', value: 'startTime', sortable: false },
            { text: '离校', value: 'endTime', sortable: false },
            { text: '请假', value: 'type', sortable: false, align: 'center' },
        ],
        attendanceData: [
            // {
            //     studentName: 'sammie',
            //     inTime: '00:00',
            //     outTime: '00:01',
            //     other: null,
            // },
            // {
            //     studentName: 'tommy',
            //     inTime: '00:00',
            //     outTime: '00:01',
            //     other: null,
            // },
            // {
            //     studentName: 'hommey',
            //     inTime: '00:00',
            //     outTime: '00:01',
            //     other: null,
            // },
            // {
            //     studentName: 'gommey',
            //     inTime: '00:00',
            //     outTime: '00:01',
            //     other: {
            //         type : 1
            //     },
            // },
            // {
            //     studentName: 'Jemmey',
            //     inTime: '00:00',
            //     outTime: '00:01',
            //     other: {
            //         type : 2
            //     },
            // },
        ],
        
        baseUrl:window.Laravel.base_url,
        isCreatingSchool : false,
        isLoadingSchoolData : false,
        isDeleteSchool : false,
        vacationReasonData : '',
    }),

    computed: {
    },

    async created(){
        this.isLoadingSchoolData = true;
        await getAttendanceData().then(res=>{
            console.log(res.data)
            this.attendanceData = res.data
            this.isLoadingSchoolData = false;
        }).catch(err=>{
            console.log(err.response)
            this.isLoadingSchoolData = false;
        })
    },

    watch: {
       
    },

    methods: {

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
            //     //console.log(err)
            //     this.isDeleteSchool = false;
            // });
            this.closeDelete()
        },

        async save () {
            //update attendanceData
            if (this.editedIndex > -1) {
                Object.assign(this.attendanceData[this.editedIndex], this.editedItem)
            } 
            //save attendanceData
            else {

                this.attendanceData.push(this.editedItem)
            }
            this.close()
        },

        chooseDate(date){
            console.log(date)
        },
        async selDate(){
            console.log(this.attendanceDate)
            this.menu = false
            this.isLoadingSchoolData = true
            await getAttendanceData({selDate:this.attendanceDate}).then(res=>{
                console.log(res.data)
                this.attendanceData = res.data
                this.isLoadingSchoolData = false;
            }).catch(err=>{
                console.log(err.response)
                this.isLoadingSchoolData = false;
            })
        }
    },
}
</script>
<style>

</style>