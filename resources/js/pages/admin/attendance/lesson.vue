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
                    :dark="attendanceDate !== ''"
                    color="purple lighten-1"
                    tile
                    class="ml-4"
                    large
                    :disabled="attendanceDate == ''"
                >
                    新增考勤
                    <v-icon right>
                        mdi-plus
                    </v-icon>
                </v-btn>
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
            { text: '考勤日期', value: 'attendanceDay',sortable: false, align: 'start',},
            { text: '考勤时间', value: 'attendanceTime', sortable: false ,},
            { text: '出勤', value: 'resultNormal', },
            { text: '迟到', value: 'resultLate', },
            { text: '缺勤', value: 'resultMiss', },
            { text: '请假', value: 'resultRest', },
            { text: '操作', value: 'actions', sortable: false, align:'center',},
        ],
        attendanceData: [
            {
                attendanceDay: '2021年3月15日',
                attendanceTime: '第一节',
                resultNormal: 12,
                resultLate: 22,
                resultMiss: 33,
                resultRest: 22,
            },
            {
                attendanceDay: '2021年3月15日',
                attendanceTime: '第二节',
                resultNormal: 12,
                resultLate: 22,
                resultMiss: 33,
                resultRest: 22,
            },
            {
                attendanceDay: '2021年3月15日',
                attendanceTime: '第三节',
                resultNormal: 12,
                resultLate: 22,
                resultMiss: 33,
                resultRest: 22,
            },
            {
                attendanceDay: '2021年3月15日',
                attendanceTime: '第四节',
                resultNormal: 12,
                resultLate: 22,
                resultMiss: 33,
                resultRest: 22,
            },
            {
                attendanceDay: '2021年3月15日',
                attendanceTime: '第五节',
                resultNormal: 12,
                resultLate: 22,
                resultMiss: 33,
                resultRest: 22,
            },
        ],
        editedIndex: -1,
        editedItem: {
          attendanceDay: '',
          attendanceTime: '',
          resultNormal: 0,
          resultLate: 0,
          resultMiss: 0,
          resultRest: 0,
        },
        defaultItem: {
          attendanceDay: '',
          attendanceTime: '',
          resultNormal: 0,
          resultLate: 0,
          resultMiss: 0,
          resultRest: 0,
        },
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
      dialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
    },

    methods: {
      editItem (item) {
        this.editedIndex = this.schoolManagerData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.editedItem.familyAddress = JSON.parse(this.schoolManagerListRaw[this.editedIndex].familyAddress)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.schoolManagerData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
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