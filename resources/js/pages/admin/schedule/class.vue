<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-data-table
          :headers="headers"
          :items="scheduleData"
          :loading="isLoadingSchoolData"
          loading-text="等一下..."
          sort-by="calories"
          class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar
                    flat
                >
                    <!-- <v-toolbar-title><strong>{{someData.grade.className}}2021学下学期课程表</strong></v-toolbar-title> -->
                    <v-toolbar-title><strong>{{sessionName}}</strong></v-toolbar-title>
                    <v-divider
                    class="mx-4"
                    inset
                    vertical
                    ></v-divider>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="green accent-4"
                        dark
                        class="mb-2 ml-2"
                        tile
                        v-if="isEditable == false"
                        @click="isEditable = !isEditable"
                        >
                        <v-icon left>
                            mdi-check
                        </v-icon>
                        修改
                    </v-btn>
                    <v-btn
                        color="orange accent-4"
                        dark
                        class="mb-2 ml-2"
                        tile
                        v-if="isEditable == true"
                        @click="isEditable = !isEditable"
                        >
                        <v-icon left>
                            mdi-alert-circle-outline
                        </v-icon>
                        无法修改
                    </v-btn>
                    <v-btn
                        color="#49d29e"
                        dark
                        class="mb-2 ml-2"
                        tile
                        @click="onSubmit"
                        >
                        <v-icon left>
                            mdi-alert-circle-outline
                        </v-icon>
                        无法修改
                    </v-btn>
                </v-toolbar>
            </template>

            <template v-slot:body="{ items, headers }">
                <tbody>
                    <tr v-for="(item,idx) in items" :key="idx">
                        <td v-for="(header,key) in headers" :key="key" >
                            <div v-if="key == 0">
                                {{item[idx]}}
                            </div>
                            <div v-else-if="key == 8">
                                <v-icon
                                    small
                                    color="success"
                                    class="mr-2"
                                    :disabled="!isEditable"
                                    @click="editItem(item)"
                                >
                                    mdi-pencil
                                </v-icon>
                                <v-icon
                                    small
                                    color="error"
                                    :disabled="!isEditable"
                                    @click="deleteItem(item)"
                                >
                                    mdi-delete
                                </v-icon>
                            </div>
                            <v-select v-else
                                :items="subjectItem"
                                :menu-props="{ top: false, offsetY: true }"
                                item-text="subjectName"
                                item-value="id"
                                v-model="item[header.value]"
                                hide-details
                                :disabled="!isEditable"
                            >
                            </v-select>
                        </td>
                    </tr>
                </tbody>
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
import {getScheduleClass} from '~/api/teacherSubject'
import lang from '~/helper/lang.json'
export default {
    components:{
    },

    data: () => ({
        lang,
        dialog: false,
        dialogDelete: false,
        time: null,
        startTimeMenu: false,
        endTimeMenu: false,
        isEditable : false,
        subjectItem : [],
        headers: [
            { text: "演讲顺序", value: "ord", sortable: false, align: "left" },
            { text: "星期一", value: "mon", sortable: false, align: "left" },
            { text: "星期二", value: "tue", sortable: false, },
            { text: "星期三", value: "wed", sortable: false, },
            { text: "星期四", value: "thu", sortable: false, },
            { text: "星期五", value: "fri", sortable: false, },
            { text: "星期六", value: "sat", sortable: false, },
            { text: "星期日", value: "sun", sortable: false, },
        ],
        sessionName: '',
        scheduleData: [
            {
                ord: "第一节",
                mon: "",
                tue: "",
                wed: "",
                thu: "",
                fri: "",
                sat: "",
                sun: ""
            },
            {
                ord: "第二节",
                mon: "",
                tue: "",
                wed: "",
                thu: "",
                fri: "",
                sat: "",
                sun: ""
            },
            {
                ord: "第三节",
                mon: "",
                tue: "",
                wed: "",
                thu: "",
                fri: "",
                sat: "",
                sun: ""
            },
            {
                ord: "第四节",
                mon: "",
                tue: "",
                wed: "",
                thu: "",
                fri: "",
                sat: "",
                sun: ""
            },
            {
                ord: "第五节",
                mon: "",
                tue: "",
                wed: "",
                thu: "",
                fri: "",
                sat: "",
                sun: ""
            },
            {
                ord: "第六节",
                mon: "",
                tue: "",
                wed: "",
                thu: "",
                fri: "",
                sat: "",
                sun: ""
            },
            {
                ord: "第七节",
                mon: "",
                tue: "",
                wed: "",
                thu: "",
                fri: "",
                sat: "",
                sun: ""
            },
        ],
        schoolListRaw : [],
        
        editedIndex: -1,
        editedItem: {
            ord:"",
            mon: "",
            tue: "",
            wed: "",
            thu: "",
            fri: "",
            sat: "",
            sun: ""
        },
        defaultItem: {
            ord:"",
            mon: "",
            tue: "",
            wed: "",
            thu: "",
            fri: "",
            sat: "",
            sun: ""
        },
        subjectOrderItem: [
            "第一节",
            "第二节",
            "第三节",
            "第四节",
            "第五节",
            "第六节",
            "第七节",
        ],
        baseUrl:window.Laravel.base_url,
        isCreatingSchool : false,
        isLoadingSchoolData : false,
        isDeleteSchool : false,
        schoolIntroduceData : '',
    }),

    computed: {
        formTitle () {
            return this.editedIndex === -1 ? '新增课' : '编辑课'
        },
    },

    async created(){
        this.isLoadingSchoolData = true;
        await getScheduleClass().then(res=>{
            console.log("----res.data",res.data)
            this.sessionName = res.data.lastSession.sessionName;
            let selfStudy = {
                id: -1,
                subjectName: "自习"
            }
            this.subjectItem.push(selfStudy);
            res.data.scheduleTeacherDataArr.map(data=>{
                data.subjectName = data.subjectName + ' - ' + data.teacherName
                this.subjectItem.push(data);
            })
        }).catch(err=>{
            console.log(err.response)
        })
        this.isLoadingSchoolData = false;
    },

    watch: {
        dialog (val) {
            val || this.closeRow()
        },
        dialogDelete (val) {
            val || this.closeDelete()
        },
    },

    methods: {

      editItem (item) {
            this.editedIndex = this.scheduleData.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
      },

      deleteItem (item) {
            this.editedIndex = this.scheduleData.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
      },

        async deleteItemConfirm () {
            this.scheduleData.splice(this.editedIndex, 1)
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

        closeRow () {
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

        async saveRow () {
            //update scheduleData
            if (this.editedIndex > -1) {
                Object.assign(this.scheduleData[this.editedIndex], this.editedItem)
            } 
            //saveRow scheduleData
            else {

                this.scheduleData.push(this.editedItem)
            }
            this.closeRow()
        },

        //actions with cells
        save() {
            //console.log(this.classScheduleData)
        },
        cancel() {

        },
        open() {

        },
        close() {

        },
        onSubmit(){
            console.log(this.scheduleData);
        }
    },
}
</script>
<style>

</style>