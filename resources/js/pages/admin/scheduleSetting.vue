<template>
    <v-container>
        <v-row>
            <v-tabs
                background-color="transparent"
                color="primary"
                grow
                class="my-7"
            >
                <v-tab v-for="(gradeData) in schoolData.grades" :key="gradeData.id" @click="triggerGrade(gradeData)">
                    <v-icon class="mr-2">mdi-bookmark</v-icon>{{gradeData.gradeName}}
                </v-tab>
            </v-tabs>
        </v-row>
        <transition name="fade" mode="out-in">
            <v-data-table
            :headers="headers"
            :items="scheduleSettingData"
            :loading="isLoadingSchoolData"
            loading-text="等一下..."
            sort-by="calories"
            class="elevation-1"
            >
            <template v-slot:top>
                <v-toolbar
                    flat
                >
                    <v-toolbar-title><strong>{{currentSelectedGrade.gradeName}} 课程安排</strong></v-toolbar-title>
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
                                        :items="teacherNameItem"
                                        :menu-props="{ top: false, offsetY: true }"
                                        item-text="label"
                                        v-model="editedItem.subjectName"
                                        label="课时类型"
                                        hide-details
                                    ></v-select>
                                </v-col>
                                <v-col cols="12">
                                    <v-select
                                        solo
                                        :items="subjectNameItem"
                                        :menu-props="{ top: false, offsetY: true }"
                                        item-text="label"
                                        v-model="editedItem.teacherName"
                                        label="课时类型"
                                        hide-details
                                    ></v-select>
                                </v-col>
                                <v-col cols="12">
                                    <v-select
                                        solo
                                        :items="classItem"
                                        :menu-props="{ top: false, offsetY: true }"
                                        item-text="label"
                                        v-model="editedItem.class"
                                        label="课时类型"
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
                            @click="close"
                            >
                            取消
                            </v-btn>
                            <v-btn
                            color="blue darken-1"
                            text
                            :loading="isCreatingSchool"
                            @click="save"
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
                    <router-link :to="{ name : 'admin.schedule'}">
                        <v-btn
                            color="light-blue accent-4"
                            dark
                            class="mb-2 ml-2"
                            tile
                            >
                            课时维护
                            <v-icon right> 
                                mdi-arrow-right-thick 
                            </v-icon>
                        </v-btn>
                    </router-link>
                </v-toolbar>
            </template>
            
            <template v-slot:[`item.actions`]="{ item }">
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
            </template>
            <template v-slot:no-data>
                <p>没有学习资料</p>
            </template>
            </v-data-table>
        </transition>
    </v-container>
</template>

<script>
import { mapGetters } from 'vuex'
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
        currentSelectedGrade : null,
        teacherNameItem : [
            { 
                label : "outsidePlay", 
                value : "outsidePlay" 
            },
            { 
                label : "insidePlay", 
                value : "insidePlay" 
            },
        ],
        subjectNameItem : [
            { 
                label : "outsidePlay", 
                value : "outsidePlay" 
            },
            { 
                label : "insidePlay", 
                value : "insidePlay" 
            },
        ],
        classItem : [
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
            { text: '课程名称', value: 'subjectName', align: 'start'},
            { text: '任课教师', value: 'teacherName', sortable: false },
            { text: '任课班级', value: 'class', sortable: false },
            { text: '行动', value: 'actions', sortable: false },
        ],
        scheduleSettingData: [
            {
                subjectName: 'math',
                teacherName: 'outsidePlay',
                class: '00:00',
            },
            {
                subjectName: 'math',
                teacherName: 'outsidePlay',
                class: '00:00',
            },
            {
                subjectName: 'math',
                teacherName: 'outsidePlay',
                class: '00:00',
            },
            {
                subjectName: 'math',
                teacherName: 'outsidePlay',
                class: '00:00',
            },
            {
                subjectName: 'math',
                teacherName: 'outsidePlay',
                class: '00:00',
            },
            {
                subjectName: 'math',
                teacherName: 'outsidePlay',
                class: '00:00',
            },
            {
                subjectName: 'math',
                teacherName: 'outsidePlay',
                class: '00:00',
            },
            {
                subjectName: 'math',
                teacherName: 'outsidePlay',
                class: '00:00',
            },
            {
                subjectName: 'math',
                teacherName: 'outsidePlay',
                class: '00:00',
            },
            {
                subjectName: 'math',
                teacherName: 'outsidePlay',
                class: '00:00',
            },
            {
                subjectName: 'math',
                teacherName: 'outsidePlay',
                class: '00:00',
            },
        ],
        editedIndex: -1,
        editedItem: {
            subjectName: '',
            teacherName: '',
            class: null,
        },
        defaultItem: {
            subjectName: '',
            teacherName: '',
            class: null,
        },
        
        baseUrl:window.Laravel.base_url,
        isCreatingSchool : false,
        isLoadingSchoolData : false,
        isDeleteSchool : false,
        schoolIntroduceData : '',
    }),

    computed:{
        ...mapGetters({
            schoolData : 'schooltree/schoolData'
        }),
        formTitle () {
            return this.editedIndex === -1 ? '新增课程安排' : '编辑课程安排'
        },
    },
    async created(){
        this.isLoadingSchoolData = true;
        getSchool()
        .then((res) => {
            
        }).catch((err) => {
            
        });
        this.isLoadingSchoolData = false;
        console.log("this.schoolData", this.schoolData);
        this.currentSelectedGrade = this.schoolData.grades[0];
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
            this.editedIndex = this.scheduleSettingData.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
      },

      deleteItem (item) {
            this.editedIndex = this.scheduleSettingData.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
      },

        async deleteItemConfirm () {
            this.scheduleSettingData.splice(this.editedIndex, 1)
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

        async save () {
            //update scheduleSettingData
            if (this.editedIndex > -1) {
                Object.assign(this.scheduleSettingData[this.editedIndex], this.editedItem)
            } 
            //save scheduleSettingData
            else {

                this.scheduleSettingData.push(this.editedItem)
            }
            this.close()
        },
        triggerGrade(gradeData){
            this.currentSelectedGrade = gradeData;
        }
    },
}
</script>

