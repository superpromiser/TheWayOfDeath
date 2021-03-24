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
                <v-toolbar-title><strong>进离校</strong></v-toolbar-title>
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
                        >
                        <v-spacer></v-spacer>
                        <v-btn
                            text
                            color="primary"
                            @click="menu = false"
                        >
                            {{lang.cancel}}
                        </v-btn>
                        <v-btn
                            text
                            color="primary"
                            @click="$refs.menu.save(attendanceDate)"
                        >
                            {{lang.ok}}
                        </v-btn>
                        </v-date-picker>
                    </v-menu>
                </div>
                
                <v-btn
                    dark
                    color="green lighten-1"
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
            <p>没有学习资料</p>
          </template>
        </v-data-table>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { createSchool, updateSchool, getSchool, deleteSchool } from '~/api/school'
import { createSubject, updateSubject, getSubject, deleteSubject } from '~/api/managersubject'
import lang from '~/helper/lang.json'
export default {
    components:{
    },

    data: () => ({
        lang,
        menu:false,
        attendanceDate : '',
        headers: [
            { text: '姓名', value: 'studentName', align: 'start'},
            { text: '进校', value: 'inTime', sortable: false },
            { text: '离校', value: 'outTime', sortable: false },
            { text: '请假', value: 'other', sortable: false, align: 'center' },
        ],
        attendanceData: [
            {
                studentName: 'sammie',
                inTime: '00:00',
                outTime: '00:01',
                other: null,
            },
            {
                studentName: 'tommy',
                inTime: '00:00',
                outTime: '00:01',
                other: null,
            },
            {
                studentName: 'hommey',
                inTime: '00:00',
                outTime: '00:01',
                other: null,
            },
            {
                studentName: 'gommey',
                inTime: '00:00',
                outTime: '00:01',
                other: {
                    type : 1
                },
            },
            {
                studentName: 'Jemmey',
                inTime: '00:00',
                outTime: '00:01',
                other: {
                    type : 2
                },
            },
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
        getSchool()
        .then((res) => {
            
        }).catch((err) => {
            
        });
        this.isLoadingSchoolData = false;
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
            //     console.log(err)
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
    },
}
</script>
<style>

</style>