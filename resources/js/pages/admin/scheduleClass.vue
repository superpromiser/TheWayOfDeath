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
                <v-toolbar-title><strong>1-1 : 2021学下学期课程表</strong></v-toolbar-title>
                <v-divider
                class="mx-4"
                inset
                vertical
                ></v-divider>
                <v-spacer></v-spacer>

                <v-dialog
                v-model="dialog"
                max-width="500px"
                >
                    <template v-slot:activator="{ on, attrs }">
                    <v-btn
                    color="primary"
                    dark
                    tile
                    class="mb-2"
                    v-bind="attrs"
                    v-on="on"
                    :disabled="!isEditable"
                    >
                    添加
                    </v-btn>
                    </template>
                    <v-card>
                    <v-card-title>
                        <span class="headline">{{ formTitle }}</span>
                    </v-card-title>

                    <v-card-text>
                        <v-container>
                        <v-row>
                                <v-col cols="12">
                                    <v-select
                                        solo
                                        :items="subjectItem"
                                        :menu-props="{ top: false, offsetY: true }"
                                        item-text="label"
                                        v-model="editedItem.mon"
                                        label="星期一"
                                        hide-details
                                    ></v-select>
                                </v-col>
                                <v-col cols="12">
                                    <v-select
                                        solo
                                        :items="subjectItem"
                                        :menu-props="{ top: false, offsetY: true }"
                                        item-text="label"
                                        v-model="editedItem.tue"
                                        label="星期二"
                                        hide-details
                                    ></v-select>
                                </v-col>
                                <v-col cols="12">
                                    <v-select
                                        solo
                                        :items="subjectItem"
                                        :menu-props="{ top: false, offsetY: true }"
                                        item-text="label"
                                        v-model="editedItem.wed"
                                        label="星期三"
                                        hide-details
                                    ></v-select>
                                </v-col>
                                <v-col cols="12">
                                    <v-select
                                        solo
                                        :items="subjectItem"
                                        :menu-props="{ top: false, offsetY: true }"
                                        item-text="label"
                                        v-model="editedItem.thu"
                                        label="星期四"
                                        hide-details
                                    ></v-select>
                                </v-col>
                                <v-col cols="12">
                                    <v-select
                                        solo
                                        :items="subjectItem"
                                        :menu-props="{ top: false, offsetY: true }"
                                        item-text="label"
                                        v-model="editedItem.fri"
                                        label="星期五"
                                        hide-details
                                    ></v-select>
                                </v-col>
                                <v-col cols="12">
                                    <v-select
                                        solo
                                        :items="subjectItem"
                                        :menu-props="{ top: false, offsetY: true }"
                                        item-text="label"
                                        v-model="editedItem.sat"
                                        label="星期六"
                                        hide-details
                                    ></v-select>
                                </v-col>
                                <v-col cols="12">
                                    <v-select
                                        solo
                                        :items="subjectItem"
                                        :menu-props="{ top: false, offsetY: true }"
                                        item-text="label"
                                        v-model="editedItem.sun"
                                        label="星期日"
                                        hide-details
                                    ></v-select>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                        color="blue darken-1"
                        text
                        @click="closeRow"
                        >
                        取消
                        </v-btn>
                        <v-btn
                        color="blue darken-1"
                        text
                        :loading="isCreatingSchool"
                        @click="saveRow"
                        >
                        保存
                        </v-btn>
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
            </v-toolbar>
          </template>

          <template v-slot:body="{ items, headers }">
                <tbody>
                    <tr v-for="(item,idx) in items" :key="idx">
                        <td v-for="(header,key) in headers" :key="key" >
                            <div v-if="key == 7">
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
                            <!-- <v-edit-dialog
                                v-else
                                :return-value.sync="item[header.value]"
                                @save="save"
                                @cancel="cancel"
                                @open="open"
                                @close="close"
                                large
                                :cancel-text="lang.cancel"
                                :save-text="lang.ok"
                            > {{item[header.value]}}
                                <template v-slot:input>
                                    <v-select
                                        solo
                                        :items="subjectItem"
                                        :menu-props="{ top: false, offsetY: true }"
                                        item-text="label"
                                        v-model="item[header.value]"
                                        label="课时类型"
                                        single-line
                                        hide-details
                                        class="mt-3"
                                        :disabled="!isEditable"
                                    ></v-select>
                                </template>
                            </v-edit-dialog> -->
                            <v-select v-else
                                :items="subjectItem"
                                :menu-props="{ top: false, offsetY: true }"
                                item-text="label"
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
import { createSchool, updateSchool, getSchool, deleteSchool } from '~/api/school'
import { createSubject, updateSubject, getSubject, deleteSubject } from '~/api/managersubject'
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
        subjectItem : [
            { 
                label : "outsidePlay", 
                value : "outsidePlay" 
            },
            { 
                label : "insidePlay", 
                value : "insidePlay" 
            },
        ],
        headers: [
            { text: "星期一", value: "mon", sortable: false, align: "left" },
            { text: "星期二", value: "tue", sortable: false, },
            { text: "星期三", value: "wed", sortable: false, },
            { text: "星期四", value: "thu", sortable: false, },
            { text: "星期五", value: "fri", sortable: false, },
            { text: "星期六", value: "sat", sortable: false, },
            { text: "星期日", value: "sun", sortable: false, },
            { text: '操作', value: 'actions', sortable: false },
        ],
        scheduleData: [
            {
                id: 1,
                mon: "",
                tue: "",
                wed: "",
                thu: "",
                fri: "",
                sat: "",
                sun: ""
            },
            {
                id: 2,
                mon: "",
                tue: "",
                wed: "",
                thu: "",
                fri: "",
                sat: "",
                sun: ""
            },
            {
                id: 3,
                mon: "",
                tue: "",
                wed: "",
                thu: "",
                fri: "",
                sat: "",
                sun: ""
            },
            {
                id: 4,
                mon: "",
                tue: "",
                wed: "",
                thu: "",
                fri: "",
                sat: "",
                sun: ""
            },
            {
                id: 5,
                mon: "",
                tue: "",
                wed: "",
                thu: "",
                fri: "",
                sat: "",
                sun: ""
            },
            {
                id: 6,
                mon: "",
                tue: "",
                wed: "",
                thu: "",
                fri: "",
                sat: "",
                sun: ""
            },
            {
                id: 7,
                mon: "",
                tue: "",
                wed: "",
                thu: "",
                fri: "",
                sat: "",
                sun: ""
            },
            {
                id: 8,
                mon: "",
                tue: "",
                wed: "",
                thu: "",
                fri: "",
                sat: "",
                sun: ""
            },
            {
                id: 9,
                mon: "",
                tue: "",
                wed: "",
                thu: "",
                fri: "",
                sat: "",
                sun: ""
            },
            {
                id: 10,
                mon: "",
                tue: "",
                wed: "",
                thu: "",
                fri: "",
                sat: "",
                sun: ""
            }
        ],
        schoolListRaw : [],
        editedIndex: -1,
        editedItem: {
            mon: "",
            tue: "",
            wed: "",
            thu: "",
            fri: "",
            sat: "",
            sun: ""
        },
        defaultItem: {
            mon: "",
            tue: "",
            wed: "",
            thu: "",
            fri: "",
            sat: "",
            sun: ""
        },
        
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
        getSchool()
        .then((res) => {
            
        }).catch((err) => {
            
        });
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
            //     console.log(err)
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
            console.log(this.classScheduleData)
        },
        cancel() {

        },
        open() {

        },
        close() {

        },
    },
}
</script>
<style>

</style>